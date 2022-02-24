<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sumber_prospek extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "wuling_sumber_prospek";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
                elseif (!empty($post['datatable']))
                    echo q_datatable("id_sumber_prospek,sumber_prospek", 'db_wuling.p_sumber_prospek', []);
            } else {
                $d['content'] = "pages/marketing_support/wuling/sumber_prospek";
                $d['index'] = $index;
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id_sumber_prospek'] = $post['id'];
        $data['sumber_prospek'] = $post['sumber_prospek'];
        $q_level = q_data("*", 'db_wuling.p_sumber_prospek', $where);
        if ($q_level->num_rows() == 0) {
            $this->db_wuling->insert("p_sumber_prospek", $data);
            $status = 1;
        } elseif ($q_level->num_rows() > 0 && !empty($where)) {
            $this->db_wuling->update("p_sumber_prospek", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id_sumber_prospek'] = $post['id'];
        $data = q_data("*", 'db_wuling.p_sumber_prospek', $where)->row();
        $d['sumber_prospek'] = $data->sumber_prospek;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id_sumber_prospek'] = $post['id'];
        echo $this->db_wuling->delete('p_sumber_prospek', $where) ? 1 : 0;
    }
}
