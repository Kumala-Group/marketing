<?php

use Illuminate\Support\Str;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Berita extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }

    public function index()
    {
        $index = "berita";
        if ($this->m_marketing->auth_login('admin_it, adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content']            = "pages/master_app/berita";
                $d['index']              = $index;
                $d['img_server']         = $this->m_marketing->img_server;
                $d['berita']             = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "kumalagroup", 'type' => "berita"], "created_at")->result();
                $d['promo']              = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "kumalagroup", 'type' => "promo"], "created_at")->result();
                $d['tips']               = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "kumalagroup", 'type' => "tips"], "created_at")->result();
                $d['honda_berita']       = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "honda", 'type' => "berita"], "created_at")->result();
                $d['honda_promo']        = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "honda", 'type' => "promo"], "created_at")->result();
                $d['honda_tips']         = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "honda", 'type' => "tips"], "created_at")->result();
                $d['mazda_berita']       = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "mazda", 'type' => "berita"], "created_at")->result();
                $d['mazda_promo']        = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "mazda", 'type' => "promo"], "created_at")->result();
                $d['mazda_tips']         = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "mazda", 'type' => "tips"], "created_at")->result();
                $d['carimobilku_berita'] = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "carimobilku", 'type' => "berita"], "created_at")->result();
                $d['carimobilku_promo']  = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "carimobilku", 'type' => "promo"], "created_at")->result();
                $d['carimobilku_tips']   = q_data("*", 'kumk6797_kumalagroup.beritas', ['website' => "carimobilku", 'type' => "tips"], "created_at")->result();

                $this->load->view('index', $d);
            }
        }
    }


    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['website'] = $post['website'];
        $data['judul'] = $post['judul'];
        $data['slug'] = Str::slug($post['judul']);
        $data['type'] = $post['tipe'];
        $data['deskripsi'] = $post['deskripsi'];
        // $data['heading'] = $post['title'];
        // $data['desc'] = $post['description'];

        if (!empty($_FILES['thumb'])) {
            $ext = explode(".", $_FILES['thumb']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['thumb']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/berita/thumb/";
            $nama_thumb = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }
        if (!empty($_FILES['gambar'])) {
            $ext = explode(".", $_FILES['gambar']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/berita/";
            $nama_gambar = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }

        $q_brand = q_data("*", 'kumk6797_kumalagroup.beritas', $where);
        if ($q_brand->num_rows() == 0) {
            $data['thumb'] = $nama_thumb;
            $data['gambar'] = $nama_gambar;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("beritas", $data);
            $status = 1;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            $file = q_data("*", 'kumk6797_kumalagroup.beritas', $where)->row();
            if (!empty($_FILES['thumb'])) {
                $data['thumb'] = $nama_thumb;
                $data_post['name'] = $file->thumb;
                $data_post['path'] = "./assets/img_marketing/berita/thumb/";
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            if (!empty($_FILES['gambar'])) {
                $data['gambar'] = $nama_gambar;
                $data_post['name'] = $file->gambar;
                $data_post['path'] = "./assets/img_marketing/berita/";
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("beritas", $data, $where);
            $status = 2;
        }
        echo $status;
    }

    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumk6797_kumalagroup.beritas', $where)->row();
        $d['website'] = $data->website;
        $d['judul'] = $data->judul;
        $d['tipe'] = $data->type;
        $d['deskripsi'] = $data->deskripsi;
        // $d['title'] = $data->heading;
        // $d['description'] = $data->desc;
        echo json_encode($d);
    }

    function hapus($post)
    {
        $where['id'] = $post['id'];
        $file = q_data("*", 'kumk6797_kumalagroup.beritas', $where)->row();
        $data_post['name'] = $file->thumb;
        $data_post['path'] = "./assets/img_marketing/berita/thumb/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $data_post['name'] = $file->gambar;
        $data_post['path'] = "./assets/img_marketing/berita/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $this->kumalagroup->delete('beritas', $where);
    }
}
