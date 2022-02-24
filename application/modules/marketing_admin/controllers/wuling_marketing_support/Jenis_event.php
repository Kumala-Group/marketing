<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_event extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "wuling_jenis_event";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
                elseif (!empty($post['datatable']))
                    echo q_datatable("id_event_jenis,event_jenis", 'db_wuling.event_jenis', []);
            } else {
                $d['content'] = "pages/marketing_support/wuling/jenis_event";
                $d['index'] = $index;
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id_event_jenis'] = $post['id'];
        $data['event_jenis'] = $post['event_jenis'];
        $q_level = q_data("*", 'db_wuling.event_jenis', $where);
        if ($q_level->num_rows() == 0) {
            $this->db_wuling->insert("event_jenis", $data);
            $status = 1;
        } elseif ($q_level->num_rows() > 0 && !empty($where)) {
            $this->db_wuling->update("event_jenis", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id_event_jenis'] = $post['id'];
        $data = q_data("*", 'db_wuling.event_jenis', $where)->row();
        $d['event_jenis'] = $data->event_jenis;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id_event_jenis'] = $post['id'];
        echo $this->db_wuling->delete('event_jenis', $where) ? 1 : 0;
    }
}
