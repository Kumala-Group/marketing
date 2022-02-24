<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activity extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_honda_marketing_support');
    }
    public function index()
    {
        $index = "honda_activity";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
                elseif (!empty($post['datatable']))
                    echo $this->m_honda_marketing_support->activity();
            } else {
                $d['content'] = "pages/marketing_support/honda/activity";
                $d['index'] = $index;
                $d['activity'] = q_data("*", 'db_honda.event_jenis', [])->result();
                $where['nik'] = $this->session->userdata('nik');
                $coverage = q_data("*", 'kumalagroup.users', $where)->row('coverage');
                $d['lokasi'] = q_data_join(
                    "l.id_event_lokasi,a.event_area,l.lokasi",
                    'db_honda.event_lokasi l',
                    ['db_honda.event_area a' => "a.id_event_area=l.id_event_area"],
                    "l.id_perusahaan in($coverage)"
                )->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $id_event = $post['id_event']
            ?? str_pad(rand(0, '9' . round(microtime(true))), 11, "0", STR_PAD_LEFT);

        $data = [
            'id_event'                => $id_event,
            'id_event_jenis'          => $post['jenis'],
            'event'                   => $post['activity'],
            'tgl_mulai'               => tgl_sql($post['tanggal_awal']),
            'tgl_selesai'             => tgl_sql($post['tanggal_akhir']),
            'total_biaya'             => remove_separator($post['biaya_actual']),
            'id_event_lokasi'         => $post['lokasi'],
            'id_perusahaan'           => $this->session->userdata('id_perusahaan'),
            'admin'                   => $this->session->userdata('username')
        ];

        $q_event = q_data("*", 'db_honda.event',  "id_event=$id_event");
        if ($q_event->num_rows() == 0) {
            $this->db_honda->trans_start();
            $this->db_honda->insert("event", $data);
            if (!empty($post['biaya'])) foreach ($post['biaya'] as $i => $v) {
                $data_biaya = [
                    'id_event' => $id_event,
                    'jenis_biaya' => $post['jenis_biaya'][$i],
                    'biaya' => remove_separator($post['biaya'][$i]),
                    'keterangan' => $post['keterangan_biaya'][$i],
                    'user' => $this->session->userdata('username')
                ];
                $this->db_honda->insert("event_biaya", $data_biaya);
            }
            $this->db_honda->trans_complete();
            echo $this->db_honda->trans_status() ? 1 : 0;
        } else if ($q_event->num_rows() > 0) {
            $this->db_honda->trans_start();
            $this->db_honda->update("event", $data,  "id_event=$id_event");
            if (!empty($post['biaya'])) foreach ($post['biaya'] as $i => $v) {
                $data_biaya = [
                    'id_event' => $id_event,
                    'jenis_biaya' => $post['jenis_biaya'][$i],
                    'biaya' => remove_separator($post['biaya'][$i]),
                    'keterangan' => $post['keterangan_biaya'][$i],
                    'user' => $this->session->userdata('username')
                ];
                $q_biaya = q_data("*", 'db_honda.event_biaya', ['id' => $post['id_biaya'][$i]]);
                if ($q_biaya->num_rows() > 0)
                    $this->db_honda->update("event_biaya", $data_biaya, ['id' => $post['id_biaya'][$i]]);
                else $this->db_honda->insert("event_biaya", $data_biaya);
            }
            $this->db_honda->trans_complete();
            echo $this->db_honda->trans_status() ? 2 : 0;
        }
    }
    function edit($post)
    {
        $id_event = $post['id'];
        $data = q_data("*", 'db_honda.event', "id_event=$id_event")->row();
        $q_biaya = q_data("*", 'db_honda.event_biaya', "id_event=$id_event")->result();
        foreach ($q_biaya as $v) $data_biaya[] = [
            'id_biaya'         => $v->id,
            'jenis_biaya'      => $v->jenis_biaya,
            'biaya'            => separator_harga($v->biaya),
            'keterangan_biaya' => $v->keterangan
        ];
        $d = [
            'id_event_jenis'          => $data->id_event_jenis,
            'event'                   => $data->event,
            'tgl_mulai'               => tgl_sql($data->tgl_mulai),
            'tgl_selesai'             => tgl_sql($data->tgl_selesai),
            'id_event_lokasi'         => $data->id_event_lokasi,
            'total_biaya'             => separator_harga($data->total_biaya),
            'biaya'                   => $data_biaya ?? []
        ];
        echo json_encode($d);
    }
    function hapus($post)
    {
        $id_event = $post['id'];
        $this->db_honda->delete("event", "id_event=$id_event");
        $this->db_honda->delete("event_picture", "id_event=$id_event");
        $this->db_honda->delete("event_biaya", "id_event=$id_event");
    }
    function hapus_biaya($post)
    {
        $id_event = $post['id'];
        $this->db_honda->delete('event_biaya', ['id' => $post['id']]);
        $this->db_honda->update(
            'event',
            ['total_biaya' => remove_separator($post['biaya'])],
            "id_event=$id_event"
        );
    }
}
