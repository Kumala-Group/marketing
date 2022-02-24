<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Media_motivator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "wuling_media_motivator";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
                elseif (!empty($post['datatable']))
                    echo q_datatable("id_media,media", 'db_wuling.p_media', []);
            } else {
                $d['content'] = "pages/marketing_support/wuling/media_motivator";
                $d['index'] = $index;
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id_media'] = $post['id'];
        $data['media'] = $post['media'];
        $q_level = q_data("*", 'db_wuling.p_media', $where);
        if ($q_level->num_rows() == 0) {
            $this->db_wuling->insert("p_media", $data);
            $status = 1;
        } elseif ($q_level->num_rows() > 0 && !empty($where)) {
            $this->db_wuling->update("p_media", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id_media'] = $post['id'];
        $data = q_data("*", 'db_wuling.p_media', $where)->row();
        $d['media'] = $data->media;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id_media'] = $post['id'];
        echo $this->db_wuling->delete('p_media', $where) ? 1 : 0;
    }
}
