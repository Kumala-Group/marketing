<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "partner";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/master_app/partner";
                $d['index'] = $index;
                $d['img_server'] = $this->m_marketing->img_server;
                $d['data'] = q_data("*", 'kumalagroup.partners', [], "updated_at")->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];

        if (!empty($_FILES['gambar'])) {
            $ext = explode(".", $_FILES['gambar']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/partner/";
            $data['gambar'] = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }

        $q_brand = q_data("*", 'kumalagroup.partners', $where);
        if ($q_brand->num_rows() == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("partners", $data);
            $status = 1;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            $data_post['name'] = q_data("*", 'kumalagroup.partners', $where)->row()->gambar;
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("partners", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $data_post['name'] = q_data("*", 'kumalagroup.partners', $where)->row()->gambar;
        $data_post['path'] = "./assets/img_marketing/partner/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $this->kumalagroup->delete('partners', $where);
    }
}
