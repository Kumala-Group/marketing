<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_website extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        header('Content-Type: application/json');
    }
    public function slider()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(4)) {
                $d = q_data("*", 'kumalagroup.sliders', "kategori like '%" . $this->uri->segment(4) . "%'", "updated_at")->result();
            } else $d = q_data("*", 'kumalagroup.sliders', "kategori like '%beranda%'", "updated_at")->result();
            echo json_encode($d);
        }
    }
    public function berita()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(4)) $d =  q_data("*", 'kumalagroup.beritas', ['id' => $this->uri->segment(4)])->row();
            else $d =  q_data("*", 'kumalagroup.beritas', "website='kumalagroup' and type in('berita','tips')", "created_at")->result();
            echo json_encode($d);
        }
    }
    public function partner()
    {
        if ($this->m_marketing->auth_api()) echo json_encode(q_data("*", 'kumalagroup.partners', [])->result());
    }
    public function tentang()
    {
        if ($this->m_marketing->auth_api()) echo json_encode(q_data("*", 'kumalagroup.bods', [])->result());
    }
    public function otomotif()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(5)) {
                // $d['brand'] = q_data("*",'kumalagroup.brands',[])->result();
                $d['warna'] = q_data("*", 'kumalagroup.units_detail', ['unit' => $this->uri->segment(5), 'detail' => "warna"])->result();
                $d['detail'] = q_data("*", 'kumalagroup.units_detail', ['unit' => $this->uri->segment(5), 'detail' => "detail"])->result();
                $otomotif = q_data("*", 'kumalagroup.units', ['id' => $this->uri->segment(5)])->row();
                $arr['id'] = $otomotif->id;
                $arr['kode_produk'] = $otomotif->kode_unit;
                $arr['brand'] = $otomotif->brand;
                $arr['model'] = q_data("*", 'kumalagroup.models', ['id' => $otomotif->model])->row()->nama_model;
                $arr['gambar'] = $otomotif->gambar;
                $arr['harga'] = $otomotif->harga;
                $arr['deskripsi'] = $otomotif->deskripsi;
                $arr['brosur'] = $otomotif->brosur;
                $arr['video'] = $otomotif->video;
                $d['otomotif'] = $arr;
                // $id_brand = q_data("*",'kumalagroup.brands', ['jenis' => $this->uri->segment(4)])->row()->id;
                // $d['dealer'] = q_data("*",'kumalagroup.dealers', ['brand' => $id_brand])->result();
                // $arr = [];
                // $provinsi = q_data("*",'kmg.perusahaan', ['id_brand' => $id_brand],[], "id_provinsi")->result();
                // foreach ($provinsi as $v) {
                //     $arr['id'] = $v->id_provinsi;
                //     $arr['provinsi'] = q_data("*",'db_honda.provinsi', ['id_provinsi' => $v->id_provinsi])->row()->nama;
                //     $d['provinsi'][] = $arr;
                // }
            } elseif ($this->uri->segment(4)) {
                $id_brand = q_data("*", 'kumalagroup.brands', ['jenis' => $this->uri->segment(4)])->row()->id;
                $d['head'] =  q_data("*", 'kumalagroup.heads', ['jenis' => $this->uri->segment(4)])->row();
                $d['dealer'] = q_data("*", 'kumalagroup.dealers', ['brand' => $id_brand], [], "area")->result();
                $otomotif = q_data("*", 'kumalagroup.units', ['brand' => $id_brand], "created_at")->result();
                foreach ($otomotif as $v) {
                    $arr['id'] = $v->id;
                    $arr['model'] = q_data("*", 'kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['gambar'] = $v->gambar;
                    $arr['harga'] = $v->harga;
                    $arr['deskripsi'] = $v->deskripsi;
                    $d['otomotif'][] = $arr;
                }
            } else $d = q_data("*", 'kumalagroup.brands', [])->result();
            echo json_encode($d);
        }
    }
    public function dealer()
    {
        if ($this->m_marketing->auth_api()) {
            $id_brand = q_data("*", 'kumalagroup.brands', ['jenis' => $this->uri->segment(4)])->row()->id;
            echo json_encode(q_data("*", 'kumalagroup.dealers', ['brand' => $id_brand, 'area' => $this->uri->segment(5)])->result());
        }
    }
    public function model()
    {
        if ($this->m_marketing->auth_api()) echo json_encode(q_data("*", 'kumalagroup.models', ['brand' => $this->uri->segment(4)])->result());
    }
    public function property()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(5)) {
                $d['detail'] = q_data("*", 'kumalagroup.property', ['id' => $this->uri->segment(5)])->row();
                $d['galeri'] = q_data("img", 'kumalagroup.image_galeri', ['id_ref' => $this->uri->segment(5), 'jenis' => "property"])->result();
            } else $d = q_data("*", 'kumalagroup.property', ['jenis' => $this->uri->segment(4)])->result();
            echo json_encode($d);
        }
    }
    public function mining()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(4)) $d = q_data("*", 'kumalagroup.minings', ['id' => $this->uri->segment(4)])->row();
            else $d = q_data("*", 'kumalagroup.minings', [])->result();
            echo json_encode($d);
        }
    }
    public function karir()
    {
        if ($this->m_marketing->auth_api()) echo json_encode(q_data("*", 'kumalagroup.karirs', ['status'=>'1'])->result());
    }


    //Api website honda
    public function slider_honda()
    {
        if ($this->m_marketing->auth_api()) {
            $d = q_data("*", 'kumalagroup.sliders', "kategori like '%honda%'", "created_at", [], 5)->result();
            echo json_encode(empty($d) ? [] : $d);
        }
    }
    public function produk_honda()
    {
        if ($this->m_marketing->auth_api()) {
            $id_brand_honda = 17;
            if ($this->uri->segment(4)) {
                if (is_numeric($this->uri->segment(4)))
                    $d = q_data_join(
                        ["km.nama_model", "ku.gambar", "ku.harga", "ku.deskripsi"],
                        'kumalagroup.units ku',
                        ['kumalagroup.models km' => "km.id=ku.model"],
                        ['ku.brand' => $id_brand_honda],
                        "ku.updated_at",
                        [],
                        $this->uri->segment(4)
                    )->result();
                else {
                    $id_produk = q_data_join(
                        ["ku.id"],
                        'kumalagroup.units ku',
                        ['kumalagroup.models km' => "km.id=ku.model"],
                        "km.nama_model like '" . $this->uri->segment(4) . "%' and ku.brand = $id_brand_honda"
                    )->row('id');
                    $d['warna'] = q_data_join(
                        ["kc.nama_warna", "ku.deskripsi", "ku.gambar"],
                        'kumalagroup.units_detail ku',
                        ['kumalagroup.colors kc' => "kc.id=ku.nama_detail"],
                        ['ku.unit' => $id_produk, 'ku.detail' => "warna"]
                    )->result();
                    $d['detail'] = q_data("*", 'kumalagroup.units_detail', ['unit' => $id_produk, 'detail' => "detail"])->result();
                    $d['produk'] = q_data_join(
                        ["km.nama_model", "ku.*"],
                        'kumalagroup.units ku',
                        ['kumalagroup.models km' => "km.id=ku.model"],
                        ['ku.id' => $id_produk]
                    )->row();
                }
            } else
                $d = q_data_join(
                    ["km.nama_model", "ku.gambar", "ku.harga", "ku.deskripsi"],
                    'kumalagroup.units ku',
                    ['kumalagroup.models km' => "km.id=ku.model"],
                    ['ku.brand' => $id_brand_honda,'is_deleted'=>'0'],
                    "ku.updated_at"
                )->result();
            echo json_encode(empty($d) ? [] : $d);
        }
    }
    public function berita_honda()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(4)) {
                $d = is_numeric($this->uri->segment(4)) ? q_data("*", 'kumalagroup.beritas', "website='honda' and type in('berita','tips')", "created_at", [], $this->uri->segment(4))->result()
                    : q_data("*", 'kumalagroup.beritas', "website='honda' and judul like '" . $this->uri->segment(4) . "%'")->row();
            } else
                $d = q_data("*", 'kumalagroup.beritas', "website='honda' and type in('berita','tips')", "created_at")->result();
            echo json_encode(empty($d) ? [] : $d);
        }
    }
    public function promo_honda()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(4)) {
                $d = q_data("*", 'kumalagroup.beritas', "website='honda' and judul like '" . $this->uri->segment(4) . "%'")->row();
            } else
                $d = q_data("*", 'kumalagroup.beritas', ['website' => "honda", 'type' => "promo"], "created_at")->result();
            echo json_encode(empty($d) ? [] : $d);
        }
    }
}
