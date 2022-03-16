<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "brand";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/master_app/brand";
                $d['index'] = $index;
                $d['img_server'] = $this->m_marketing->img_server;
                $d['data'] = q_data("*", 'kumk6797_kumalagroup.brands', [])->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['jenis'] = $post['jenis'];
        $data['url'] = $post['url'];

        if (!empty($_FILES['gambar'])) {
            $ext = explode(".", $_FILES['gambar']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/head/";
            $nama_gambar = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }

        $q_brand = q_data("*", 'kumk6797_kumalagroup.brands', $where);
        if ($q_brand->num_rows() == 0) {
            $data['foto'] = $nama_gambar;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("brands", $data);
            $status = 1;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            if (!empty($_FILES['gambar'])) {
                $data['foto'] = $nama_gambar;
                $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.brands', $where)->row()->foto;
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("brands", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumk6797_kumalagroup.brands', $where)->row();
        $d['jenis'] = $data->jenis;
        $d['url'] = $data->url;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.brands', $where)->row()->foto;
        $data_post['path'] = "./assets/img_marketing/head/";
        if ($this->kumalagroup->delete('brands', $where)) {
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            echo 1;
        } else echo 0;
    }
}
