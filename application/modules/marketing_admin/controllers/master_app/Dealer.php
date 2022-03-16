<?php

use app\modules\elo_models\kumalagroup\mBrand;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dealer extends \MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "dealer";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/master_app/dealer";
                $d['index'] = $index;
                $d['img_server'] = $this->m_marketing->img_server;
                // $d['brand'] = q_data("*", 'kumk6797_kumalagroup.brands', [])->result();
                $d['hino'] = q_data("*", 'kumk6797_kumalagroup.dealers', ['brand' => 3], "updated_at")->result();
                $d['honda'] = q_data("*", 'kumk6797_kumalagroup.dealers', ['brand' => 17], "updated_at")->result();
                $d['wuling'] = q_data("*", 'kumk6797_kumalagroup.dealers', ['brand' => 5], "updated_at")->result();
                $d['mazda'] = q_data("*", 'kumk6797_kumalagroup.dealers', ['brand' => 4], "updated_at")->result();
                $d['mercedes'] = q_data("*", 'kumk6797_kumalagroup.dealers', ['brand' => 18, "updated_at"])->result();
                $this->load->view('index', $d);
            }
        }
    }

    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['judul'] = $post['judul'];
        $data['area'] = $post['area'];
        $data['brand'] = $post['brand'];
        $data['alamat'] = $post['alamat'];
        $data['telp'] = $post['telepon'];
        $data['map'] = $post['map_url'];
        if (!empty($_FILES['gambar'])) {
            $ext = explode(".", $_FILES['gambar']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/dealer/";
            $nama_gambar = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }

        $q_brand = q_data("*", 'kumk6797_kumalagroup.dealers', $where);
        if ($q_brand->num_rows() == 0) {
            $data['gambar'] = $nama_gambar;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("dealers", $data);
            $status = 1;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            if (!empty($_FILES['gambar'])) {
                $data['gambar'] = $nama_gambar;
                $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.dealers', $where)->row()->gambar;
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("dealers", $data, $where);
            $status = 2;
        }
        echo $status;
    }

    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumk6797_kumalagroup.dealers', $where)->row();
        $d['judul'] = $data->judul;
        $d['area'] = $data->area;
        $d['brand'] = $data->brand;
        $d['alamat'] = $data->alamat;
        $d['telepon'] = $data->telp;
        $d['map_url'] = $data->map;
        echo json_encode($d);
    }

    function hapus($post)
    {
        $where['id'] = $post['id'];
        $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.dealers', $where)->row()->gambar;
        $data_post['path'] = "./assets/img_marketing/dealer/";
        if ($this->kumalagroup->delete('dealers', $where)) {
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            echo 1;
        } else echo 0;
    }

    function get_Area()
    {

        $kota        = array("Makassar","Gorontalo","Ternate","Mamuju","Samarinda","Balikpapan","Gowa",
                      "Sidrap","Bulukumba","Bau-Bau","Palu","Pare-pare","Manado","Kendari","Kolaka",
                      "Bali","Tomohon","Palopo","Bone","Bandung","Jakarta");
        $jumlah_kota = count($kota);
        sort($kota);
        $area = array();
        for($index = 0;$index < $jumlah_kota;$index++)
        {
            $area[] = ['id'=>$kota[$index],'text'=>$kota[$index]];
        }
        
        return responseJson($area);
        
    }

    function get_Brands()
    {
        $all_Brand = mBrand::orderBy('jenis','ASC')->get();
        $brands = array();
        foreach($all_Brand as $brand)
        {
            $brands[] = ['id'=>$brand->id,'text'=>ucfirst($brand->jenis)];
        }

        return responseJson($brands);
    }
}
