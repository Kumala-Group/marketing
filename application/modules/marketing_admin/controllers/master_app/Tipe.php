<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tipe extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "tipe";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/master_app/tipe";
                $d['index'] = $index;
                $d['brand'] = q_data("*", 'kumk6797_kumalagroup.brands', [])->result();
                $hino = q_data("*", 'kumk6797_kumalagroup.types', ['brand' => 3])->result();
                foreach ($hino as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_tipe'] = $v->nama_tipe;
                    $d['hino'][] = $arr;
                }
                $arr = [];
                $honda = q_data("*", 'kumk6797_kumalagroup.types', ['brand' => 17])->result();
                foreach ($honda as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_tipe'] = $v->nama_tipe;
                    $d['honda'][] = $arr;
                }
                $arr = [];
                $mazda = q_data("*", 'kumk6797_kumalagroup.types', ['brand' => 4])->result();
                foreach ($mazda as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_tipe'] = $v->nama_tipe;
                    $d['mazda'][] = $arr;
                }
                $arr = [];
                $mercedes = q_data("*", 'kumk6797_kumalagroup.types', ['brand' => 18])->result();
                foreach ($mercedes as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_tipe'] = $v->nama_tipe;
                    $d['mercedes'][] = $arr;
                }
                $arr = [];
                $wuling = q_data("*", 'kumk6797_kumalagroup.types', ['brand' => 5])->result();
                foreach ($wuling as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['nama_tipe'] = $v->nama_tipe;
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
        $data['nama_tipe'] = $post['tipe'];
        $q_brand = q_data("*", 'kumk6797_kumalagroup.types', $where);
        if ($q_brand->num_rows() == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("types", $data);
            $status = 1;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("types", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumk6797_kumalagroup.types', $where)->row();
        $d['brand'] = $data->brand;
        $d['model'] = $data->model;
        $d['tipe'] = $data->nama_tipe;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $this->kumalagroup->delete('types', $where);
    }
}
