<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activity extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_marketing_support');
    }
    public function index()
    {
        $index = "wuling_activity";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
                elseif (!empty($post['hapus_biaya'])) $this->hapus_biaya($post);
                elseif (!empty($post['datatable']))
                    echo $this->m_wuling_marketing_support->activity();
                elseif (!empty($post['kabupaten'])) $this->_kabupaten($post);
                elseif (!empty($post['kecamatan'])) $this->_kecamatan($post);
            } else {
                $d['content'] = "pages/marketing_support/wuling/activity";
                $d['index'] = $index;
                $d['activity'] = q_data("*", 'db_wuling.event_jenis', [])->result();
                $where['nik'] = $this->session->userdata('nik');
                $coverage = q_data("*", 'kumk6797_kumalagroup.users', $where)->row('coverage');
                if (!empty($coverage)) {
                    $d['lokasi'] = q_data_join(
                        "l.id_event_lokasi,a.event_area,l.lokasi",
                        'db_wuling.event_lokasi l',
                        ['db_wuling.event_area a' => "a.id_event_area=l.id_event_area"],
                        "l.id_perusahaan in($coverage)"
                    )->result();
                    $d['provinsi'] = q_data("*", 'db_wuling.provinsi', [])->result();
                } else {
                    $d['content'] = "pages/marketing_support/wuling/activity";
                    $d['index'] = $index;
                }
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $date  = new DateTime($post['tanggal_awal']);
        $now   = new DateTime($post['tanggal_akhir']);
        $total_display = (empty($post['display_1']) ? 0 : 1)
            + (empty($post['display_2']) ? 0 : 1)
            + (empty($post['display_3']) ? 0 : 1)
            + (empty($post['display_4']) ? 0 : 1);
        $id_event = empty($post['id_event'])
            ? str_pad(rand(0, '9' . round(microtime(true))), 11, "0", STR_PAD_LEFT)
            : $post['id_event'];

        $data = [
            'id_event'                => $id_event,
            'id_event_jenis'          => $post['jenis'],
            'event'                   => $post['activity'],
            'id_event_lokasi'         => $post['lokasi'],
            'id_provinsi'             => $post['provinsi'],
            'id_kabupaten'            => $post['kabupaten'],
            'id_kecamatan'            => $post['kecamatan'],
            'booth_size'              => $post['booth_size'],
            'tgl_mulai'               => tgl_sql($post['tanggal_awal']),
            'tgl_selesai'             => tgl_sql($post['tanggal_akhir']),
            'jumlah_hari'             => $date->diff($now)->days + 1,
            't_visitor'               => $post['visitor'],
            't_prospect'              => $post['prospect'],
            't_spk'                   => $post['spk'],
            'proposal_biaya'          => remove_separator($post['proposal_biaya']),
            'display_1'               => $post['display_1'],
            'display_2'               => $post['display_2'],
            'display_3'               => $post['display_3'],
            'display_4'               => $post['display_4'],
            'total_display'           => $total_display,
            'proposal_biaya_internal' => remove_separator($post['proposal_biaya_internal']),
            'alasan_memilih_lokasi'   => $post['alasan'],
            'market_size'             => $post['market_size'],
            'market_share'            => $post['market_share'],
            'spk_taking'              => $post['spk_taking'],
            'analisis'                => $post['analisis'],
            'rekomendasi'             => $post['rekomendasi'],
            'notes'                   => $post['notes'],
            'total_biaya'             => remove_separator($post['biaya_actual']),
            'sisa_biaya_internal'     => remove_separator($post['sisa_biaya_internal']),
            'r_visitor'               => $post['r_visitor'],
            'r_prospect'              => $post['r_prospect'],
            'r_spk'                   => $post['r_spk'],
            'cost_per_prospect'       => remove_separator($post['cost_per_prospect']),
            'cost_per_spk'            => remove_separator($post['cost_per_spk']),
            'keterangan'              => $post['keterangan'],
            'id_perusahaan'           => $this->session->userdata('id_perusahaan'),
            'admin'                   => $this->session->userdata('username')
        ];

        $q_event = q_data("*", 'db_wuling.event',  "id_event=$id_event");
        if ($q_event->num_rows() == 0) {
            $this->db_wuling->trans_start();
            $this->db_wuling->insert("event", $data);
            if (!empty($post['biaya'])) foreach ($post['biaya'] as $i => $v) {
                $data_biaya = [
                    'id_event' => $id_event,
                    'jenis_biaya' => $post['jenis_biaya'][$i],
                    'biaya' => remove_separator($post['biaya'][$i]),
                    'keterangan' => $post['keterangan_biaya'][$i],
                    'user' => $this->session->userdata('username')
                ];
                $this->db_wuling->insert("event_biaya", $data_biaya);
            }
            $this->db_wuling->trans_complete();
            echo $this->db_wuling->trans_status() ? 1 : 0;
        } else if ($q_event->num_rows() > 0) {
            $this->db_wuling->trans_start();
            $this->db_wuling->update("event", $data,  "id_event=$id_event");
            if (!empty($post['biaya'])) foreach ($post['biaya'] as $i => $v) {
                $data_biaya = [
                    'id_event' => $id_event,
                    'jenis_biaya' => $post['jenis_biaya'][$i],
                    'biaya' => remove_separator($post['biaya'][$i]),
                    'keterangan' => $post['keterangan_biaya'][$i],
                    'user' => $this->session->userdata('username')
                ];
                $q_biaya = q_data("*", 'db_wuling.event_biaya', ['id' => $post['id_biaya'][$i]]);
                if ($q_biaya->num_rows() > 0)
                    $this->db_wuling->update("event_biaya", $data_biaya, ['id' => $post['id_biaya'][$i]]);
                else $this->db_wuling->insert("event_biaya", $data_biaya);
            }
            $this->db_wuling->trans_complete();
            echo $this->db_wuling->trans_status() ? 2 : 0;
        }
    }
    function edit($post)
    {
        $id_event = $post['id'];
        $data = q_data_join(
            "e.*,pro.nama as provinsi,kab.nama as kabupaten,kec.nama as kecamatan",
            'db_wuling.event e',
            [
                'db_wuling.provinsi pro' => "pro.id_provinsi=e.id_provinsi",
                'db_wuling.kabupaten kab' => "kab.id_kabupaten=e.id_kabupaten",
                'db_wuling.kecamatan kec' => "kec.id_kecamatan=e.id_kecamatan",
            ],
            "e.id_event=$id_event"
        )->row();
        $q_biaya = q_data("*", 'db_wuling.event_biaya', "id_event=$id_event")->result();
        foreach ($q_biaya as $v) $data_biaya[] = [
            'id_biaya'         => $v->id,
            'jenis_biaya'      => $v->jenis_biaya,
            'biaya'            => separator_harga($v->biaya),
            'keterangan_biaya' => $v->keterangan
        ];
        $d = [
            'id_event_jenis'          => $data->id_event_jenis,
            'event'                   => $data->event,
            'id_event_lokasi'         => $data->id_event_lokasi,
            'id_provinsi'             => $data->id_provinsi,
            'provinsi'                => $data->provinsi,
            'id_kabupaten'            => $data->id_kabupaten,
            'kabupaten'               => $data->kabupaten,
            'id_kecamatan'            => $data->id_kecamatan,
            'kecamatan'               => $data->kecamatan,
            'booth_size'              => $data->booth_size,
            'tgl_mulai'               => tgl_sql($data->tgl_mulai),
            'tgl_selesai'             => tgl_sql($data->tgl_selesai),
            'jumlah_hari'             => $data->jumlah_hari,
            't_visitor'               => $data->t_visitor,
            't_prospect'              => $data->t_prospect,
            't_spk'                   => $data->t_spk,
            'proposal_biaya'          => separator_harga($data->proposal_biaya),
            'display_1'               => $data->display_1,
            'display_2'               => $data->display_2,
            'display_3'               => $data->display_3,
            'display_4'               => $data->display_4,
            'total_display'           => $data->total_display,
            'proposal_biaya_internal' => separator_harga($data->proposal_biaya_internal),
            'alasan_memilih_lokasi'   => $data->alasan_memilih_lokasi,
            'market_size'             => $data->market_size,
            'market_share'            => $data->market_share,
            'spk_taking'              => $data->spk_taking,
            'analisis'                => $data->analisis,
            'rekomendasi'             => $data->rekomendasi,
            'notes'                   => $data->notes,
            'total_biaya'             => separator_harga($data->total_biaya),
            'sisa_biaya_internal'     => separator_harga($data->sisa_biaya_internal),
            'r_visitor'               => $data->r_visitor,
            'r_prospect'              => $data->r_prospect,
            'r_spk'                   => $data->r_spk,
            'cost_per_prospect'       => separator_harga($data->cost_per_prospect),
            'cost_per_spk'            => separator_harga($data->cost_per_spk),
            'keterangan'              => $data->keterangan,
            'biaya'                   => empty($data_biaya) ? [] : $data_biaya
        ];
        echo json_encode($d);
    }
    function hapus($post)
    {
        $id_event = $post['id'];
        $this->db_wuling->delete("event", "id_event=$id_event");
        $this->db_wuling->delete("event_picture", "id_event=$id_event");
        $this->db_wuling->delete("event_biaya", "id_event=$id_event");
    }
    function hapus_biaya($post)
    {
        $id_event = $post['id'];
        $this->db_wuling->delete('event_biaya', ['id' => $post['id']]);
        $this->db_wuling->update(
            'event',
            ['total_biaya' => remove_separator($post['biaya'])],
            "id_event=$id_event"
        );
    }
    function _kabupaten($post)
    {
        $data = q_data("*", 'db_wuling.kabupaten', ['id_provinsi' => $post['id']])->result(); ?>
        <option value="" selected disabled>-- Silahkan Pilih Kabupaten --</option>
        <?php foreach ($data as $v) { ?>
            <option value="<?= $v->id_kabupaten ?>"><?= $v->nama ?></option>
        <?php }
    }
    function _kecamatan($post)
    {
        $data = q_data("*", 'db_wuling.kecamatan', ['id_kabupaten' => $post['id']])->result(); ?>
        <option value="" selected disabled>-- Silahkan Pilih Kecamatan --</option>
        <?php foreach ($data as $v) { ?>
            <option value="<?= $v->id_kecamatan ?>"><?= $v->nama ?></option>
<?php }
    }
}
