<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Slider extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "slider";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content']     = "pages/master_app/slider";
                $d['index']       = $index;
                $d['img_server']  = $this->m_marketing->img_server;
                $d['brand']       = q_data("*", 'kumk6797_kumalagroup.brands', [])->result();
                $d['beranda']     = q_data("*", 'kumk6797_kumalagroup.sliders', "kategori like '%beranda%'", "updated_at")->result();
                $d['hino']        = q_data("*", 'kumk6797_kumalagroup.sliders', "kategori like '%hino%'", "updated_at")->result();
                $d['honda']       = q_data("*", 'kumk6797_kumalagroup.sliders', "kategori like '%honda%'", "updated_at")->result();
                $d['wuling']      = q_data("*", 'kumk6797_kumalagroup.sliders', "kategori like '%wuling%'", "updated_at")->result();
                $d['mazda']       = q_data("*", 'kumk6797_kumalagroup.sliders', "kategori like '%mazda%'", "updated_at")->result();
                $d['carimobilku'] = q_data("*", 'kumk6797_kumalagroup.sliders', "kategori like '%carimobilku%'", "updated_at")->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $where['id'] = $post['id'];
        $data['kategori'] = $post['kategori'];
        $data['aksi'] = $post['url'];

        if (!empty($_FILES['gambar'])) {
            $ext = explode(".", $_FILES['gambar']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/slider/";
            $nama_gambar = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }

        $q_brand = q_data("*", 'kumk6797_kumalagroup.sliders', $where);
        if ($q_brand->num_rows() == 0) {
            $data['gambar'] = $nama_gambar;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("sliders", $data);
            $status = "Data berhasil disimpan!";
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            if (!empty($_FILES['gambar'])) {
                $data['gambar'] = $nama_gambar;
                $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.sliders', $where)->row()->gambar;
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("sliders", $data, $where);
            $status = "Data berhasil diupdate!";
        }
        else $status = 0;
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumk6797_kumalagroup.sliders', $where)->row();
        $d['kategori'] = explode(",", $data->kategori);
        $d['url'] = $data->aksi;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.sliders', $where)->row()->gambar;
        $data_post['path'] = "./assets/img_marketing/slider/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $this->kumalagroup->delete('sliders', $where);
    }
}
