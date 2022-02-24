<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Warna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "warna";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/master_app/warna";
                $d['index'] = $index;
                $d['brand'] = q_data("*", 'kumalagroup.brands', [])->result();
                $hino = q_data("*", 'kumalagroup.colors', ['brand' => 3])->result();
                foreach ($hino as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_warna'] = $v->nama_warna;
                    $d['hino'][] = $arr;
                }
                $honda = q_data("*", 'kumalagroup.colors', ['brand' => 17])->result();
                foreach ($honda as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_warna'] = $v->nama_warna;
                    $d['honda'][] = $arr;
                }
                $mazda = q_data("*", 'kumalagroup.colors', ['brand' => 4])->result();
                foreach ($mazda as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_warna'] = $v->nama_warna;
                    $d['mazda'][] = $arr;
                }
                $mercedes = q_data("*", 'kumalagroup.colors', ['brand' => 18])->result();
                foreach ($mercedes as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_warna'] = $v->nama_warna;
                    $d['mercedes'][] = $arr;
                }
                $wuling = q_data("*", 'kumalagroup.colors', ['brand' => 5])->result();
                foreach ($wuling as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_warna'] = $v->nama_warna;
                    $d['wuling'][] = $arr;
                }
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['brand'] = $post['brand'];
        $data['model'] = $post['model'];
        $data['nama_warna'] = $post['warna'];
        $q_brand = q_data("*", 'kumalagroup.colors', $where);
        if ($q_brand->num_rows() == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("colors", $data);
            $status = 1;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("colors", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumalagroup.colors', $where)->row();
        $d['brand'] = $data->brand;
        $d['model'] = $data->model;
        $d['warna'] = $data->nama_warna;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where = $post['id'];
        $warna = q_data("*", 'kumalagroup.units_detail', ['nama_detail' => $where])->result();
        foreach ($warna as $v) {
            $data_post['name'] = $v->gambar;
            $data_post['path'] = "./assets/img_marketing/otomotif/warna/";
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        }
        $this->kumalagroup->delete('colors', ['id' => $where]);
        $this->kumalagroup->delete('units_detail', ['nama_detail' => $where]);
    }
}
