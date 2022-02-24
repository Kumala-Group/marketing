<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sparepart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "sparepart";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/master_app/sparepart";
                $d['index'] = $index;
                $d['img_server'] = $this->m_marketing->img_server;
                $d['brand'] = q_data("*", 'kumalagroup.brands', [])->result();
                $d['hino'] = q_data("*", 'kumalagroup.spareparts', ['brand' => 3], "updated_at")->result();
                $d['honda'] = q_data("*", 'kumalagroup.spareparts', ['brand' => 17], "updated_at")->result();
                $d['mazda'] = q_data("*", 'kumalagroup.spareparts', ['brand' => 4], "updated_at")->result();
                $d['mercedes'] = q_data("*", 'kumalagroup.spareparts', ['brand' => 18], "updated_at")->result();
                $d['wuling'] = q_data("*", 'kumalagroup.spareparts', ['brand' => 5], "updated_at")->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['brand'] = $post['brand'];
        $data['nama'] = $post['nama'];
        $data['harga'] = remove_separator($post['harga']);
        $data['kategori'] = $post['kategori'];
        $data['berat'] = $post['berat'];
        $data['merek'] = $post['merek'];
        $data['asal'] = $post['asal'];
        $data['tahun'] = $post['tahun'];
        $data['status'] = $post['status'];
        $data['deskripsi'] = $post['deskripsi'];

        if (!empty($_FILES['gambar'])) {
            $ext = explode(".", $_FILES['gambar']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/sparepart/";
            $nama_gambar = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }

        $q_brand = q_data("*", 'kumalagroup.spareparts', $where);
        if ($q_brand->num_rows() == 0) {
            $data['gambar'] = $nama_gambar;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("spareparts", $data);
            $status = 1;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            if (!empty($_FILES['gambar'])) {
                $data['gambar'] = $nama_gambar;
                $data_post['name'] = q_data("*", 'kumalagroup.spareparts', $where)->row()->gambar;
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("spareparts", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumalagroup.spareparts', $where)->row();
        $d['brand'] = $data->brand;
        $d['nama'] = $data->nama;
        $d['harga'] = separator_harga($data->harga);
        $d['kategori'] = $data->kategori;
        $d['berat'] = $data->berat;
        $d['merek'] = $data->merek;
        $d['asal'] = $data->asal;
        $d['tahun'] = $data->tahun;
        $d['status'] = $data->status;
        $d['deskripsi'] = $data->deskripsi;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $data_post['name'] = q_data("*", 'kumalagroup.spareparts', $where)->row()->gambar;
        $data_post['path'] = "./assets/img_marketing/sparepart/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $this->kumalagroup->delete('spareparts', $where);
    }
}
