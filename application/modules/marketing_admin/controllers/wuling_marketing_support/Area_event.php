<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Area_event extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "wuling_area_event";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
                elseif (!empty($post['datatable'])) {
                    $where['nik'] = $this->session->userdata('nik');
                    $coverage = q_data("*", 'kumalagroup.users', $where)->row('coverage');
                    echo q_datatable(
                        "id_event_area,event_area",
                        'db_wuling.event_area',
                        "id_perusahaan in($coverage)"
                    );
                }
            } else {
                $d['content'] = "pages/marketing_support/wuling/area_event";
                $d['index'] = $index;
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id_event_area'] = $post['id'];
        $data['event_area'] = $post['event_area'];
        $data['id_perusahaan'] = $this->session->userdata('id_perusahaan');
        $q_level = q_data("*", 'db_wuling.event_area', $where);
        if ($q_level->num_rows() == 0) {
            $this->db_wuling->insert("event_area", $data);
            $status = 1;
        } elseif ($q_level->num_rows() > 0 && !empty($where)) {
            $this->db_wuling->update("event_area", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id_event_area'] = $post['id'];
        $data = q_data("*", 'db_wuling.event_area', $where)->row();
        $d['event_area'] = $data->event_area;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id_event_area'] = $post['id'];
        echo $this->db_wuling->delete('event_area', $where) ? 1 : 0;
    }
}
