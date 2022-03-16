<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Karir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "karir";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/master_app/karir";
                $d['index'] = $index;
                $d['data'] = q_data("*", 'kumk6797_kumalagroup.karirs', [], "updated_at")->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['posisi'] = $post['posisi'];
        $data['jumlah'] = $post['jumlah'];
        $data['deskripsi'] = $post['deskripsi'];
        $q_level = q_data("*", 'kumk6797_kumalagroup.karirs', $where);
        if ($q_level->num_rows() == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("karirs", $data);
            $status = 1;
        } elseif ($q_level->num_rows() > 0 && !empty($where)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("karirs", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumk6797_kumalagroup.karirs', $where)->row();
        $d['posisi'] = $data->posisi;
        $d['jumlah'] = $data->jumlah;
        $d['deskripsi'] = $data->deskripsi;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $this->kumalagroup->delete('karirs', $where);
    }
}
