<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acara extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "acara";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/master_app/acara";
                $d['index'] = $index;
                $d['img_server'] = $this->m_marketing->img_server;
                $d['data'] = q_data("*", 'kumalagroup.events', [], "updated_at")->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['judul'] = $post['judul'];
        $data['tanggal'] = date("Y-m-d H:i:s",  strtotime(tgl_sql($post['tanggal']) . " " . $post['waktu']));
        $data['lokasi'] = $post['lokasi'];
        $data['harga'] = remove_separator($post['harga']);
        $data['deskripsi'] = $post['deskripsi'];
        $data['map_url'] = $post['map_url'];

        if (!empty($_FILES['gambar'])) {
            $ext = explode(".", $_FILES['gambar']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/acara/";
            $nama_gambar = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }

        $q_brand = q_data("*", 'kumalagroup.events', $where);
        if ($q_brand->num_rows() == 0) {
            $data['gambar'] = $nama_gambar;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("events", $data);
            $status = 1;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            if (!empty($_FILES['gambar'])) {
                $data['gambar'] = $nama_gambar;
                $data_post['name'] = q_data("*", 'kumalagroup.events', $where)->row()->gambar;
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("events", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumalagroup.events', $where)->row();
        $d['judul'] = $data->judul;
        $date = explode(" ", $data->tanggal);
        $d['tanggal'] = tgl_sql($date[0]);
        $d['waktu'] = $date[1];
        $d['lokasi'] = $data->lokasi;
        $d['harga'] = separator_harga($data->harga);
        $d['deskripsi'] = $data->deskripsi;
        $d['map_url'] = $data->map_url;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $data_post['name'] = q_data("*", 'kumalagroup.events', $where)->row()->gambar;
        $data_post['path'] = "./assets/img_marketing/acara/";
        if ($this->kumalagroup->delete('events', $where)) {
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            echo 1;
        } else echo 0;
    }
}
