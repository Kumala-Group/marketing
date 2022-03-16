<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "user_profil";
        if ($this->m_marketing->auth_login('admin_it', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/user_profil";
                $d['index'] = $index;
                $d['profil'] = q_data("*", 'kumk6797_kumalagroup.p_level', [])->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['nama_level'] = $post['nama_level'];
        $data['level'] = $post['level'];
        $data['deskripsi'] = $post['deskripsi'];
        $data['url'] = $post['url'];
        $q_level = q_data("*", 'kumk6797_kumalagroup.p_level', $where);
        if ($q_level->num_rows() == 0) {
            $this->kumalagroup->insert("p_level", $data);
            $status = 1;
        } elseif ($q_level->num_rows() > 0 && !empty($where)) {
            $this->kumalagroup->update("p_level", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumk6797_kumalagroup.p_level', $where)->row();
        $d['nama_level'] = $data->nama_level;
        $d['level'] = $data->level;
        $d['deskripsi'] = $data->deskripsi;
        $d['url'] = $data->url;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        echo $this->kumalagroup->delete('p_level', $where) ? 1 : 0;
    }
}
