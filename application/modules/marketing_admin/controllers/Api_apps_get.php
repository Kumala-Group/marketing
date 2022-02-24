<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_apps_get extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_service');
        header('Content-Type: application/json');
    }
    public function m_berita()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(3) == "m_promo") $type = "promo";
            elseif ($this->uri->segment(3) == "m_tips") $type = "tips";
            else $type = "berita";
            echo json_encode(q_data("*", 'kumalagroup.beritas', ['type' => $type], "created_at")->result());
        }
    }
    public function m_brand()
    {
        if ($this->m_marketing->auth_api()) echo json_encode(q_data("*", 'kumalagroup.brands', [])->result());
    }
    public function m_dealer()
    {
        if ($this->m_marketing->auth_api()) {
            $d = [];
            if ($this->uri->segment(5)) $d = q_data("*", 'kumalagroup.dealers', ['brand' => $this->uri->segment(4), 'area' => $this->uri->segment(5)])->result();
            elseif (is_numeric($this->uri->segment(4))) {
                $area = q_data("*", 'kumalagroup.dealers', ['brand' => $this->uri->segment(4)], [], "area")->result();
                foreach ($area as $v) {
                    $arr['id'] = $v->id;
                    $arr['brand'] = $v->brand;
                    $arr['area'] = $v->area;
                    $d[] = $arr;
                }
            } elseif (!empty($this->uri->segment(4)) && !is_numeric($this->uri->segment(4))) {
                $uri = explode("-", $this->uri->segment(4));
                if ($uri[0] == "detail") $d = q_data("*", 'kumalagroup.dealers', ['id' => end($uri)])->row();
                else $d = q_data("*", 'kumalagroup.dealers', ['brand' => end($uri)])->result();
            } else $d = q_data("*", 'kumalagroup.dealers', [])->result();
            echo json_encode($d);
        }
    }
    public function m_acara()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(4)) $d = q_data("*", 'kumalagroup.events', ['id' => $this->uri->segment(4)])->row();
            else $d = q_data("*", 'kumalagroup.events', [], "updated_at")->result();
            echo json_encode($d);
        }
    }
    public function m_voucher()
    {
        if ($this->m_marketing->auth_api()) echo json_encode(q_data("*", 'kumalagroup.vouchers', [], "updated_at")->result());
    }
    public function m_produk()
    {
        if ($this->m_marketing->auth_api()) {
            $d = [];
            if ($this->uri->segment(5)) {
                $warna = q_data("*", 'kumalagroup.units_detail', ['unit' => $this->uri->segment(5), 'detail' => "warna", 'gambar!=' => ""])->result();
                foreach ($warna as $v) {
                    $arr['id'] = $v->id;
                    $arr['nama_detail'] = q_data("*", 'kumalagroup.colors', ['id' => $v->nama_detail])->row()->nama_warna;
                    $arr['deskripsi'] = "0xFF" . $v->deskripsi;
                    $d['warna'][] = $arr;
                }
                $arr = [];
                $spek = q_data("*", 'kumalagroup.units_detail', ['unit' => $this->uri->segment(5), 'detail' => "spek"])->result();
                foreach ($spek as $v) {
                    $arr['nama_detail'] = $v->nama_detail;
                    $arr['deskripsi'] = $v->deskripsi;
                    $d['spek'][] = $arr;
                }
                $arr = [];
                $detail = q_data("*", 'kumalagroup.units_detail', ['unit' => $this->uri->segment(5), 'detail' => "detail"])->result();
                foreach ($detail as $v) $d['gambar'][]['gambar'] = $v->gambar;
                $arr = [];
                $otomotif = q_data("*", 'kumalagroup.units', ['id' => $this->uri->segment(5)])->row();
                $arr['id'] = $otomotif->id;
                $arr['kode_produk'] = $otomotif->kode_unit;
                $arr['model'] = q_data("*", 'kumalagroup.models', ['id' => $otomotif->model])->row()->nama_model;
                $arr['gambar'] = $otomotif->gambar;
                $arr['harga'] = $otomotif->harga;
                $arr['deskripsi'] = $otomotif->deskripsi;
                $arr['brosur'] = $otomotif->brosur;
                $arr['video'] = $otomotif->video;
                $d['otomotif'] = $arr;
            } else {
                $data = q_data("*", 'kumalagroup.units', ['brand' => $this->uri->segment(4)], "updated_at")->result();
                foreach ($data as $v) {
                    $arr['id'] = $v->id;
                    $arr['model'] = q_data("*", 'kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['gambar'] = $v->gambar;
                    $arr['harga'] = $v->harga;
                    $d[] = $arr;
                }
            }
            echo json_encode($d);
        }
    }
    public function m_warna()
    {
        if ($this->m_marketing->auth_api()) echo json_encode(q_data("*", 'kumalagroup.units_detail', ['id' => $this->uri->segment(4)])->row());
    }
    public function m_sparepart()
    {
        if ($this->m_marketing->auth_api()) {
            $d = [];
            if ($this->uri->segment(5)) $d = q_data("*", 'kumalagroup.spareparts', ['id' => $this->uri->segment(5)], "updated_at")->row();
            else {
                $data = q_data("*", 'kumalagroup.spareparts', ['brand' => $this->uri->segment(4)], "updated_at")->result();
                foreach ($data as $v) {
                    $arr['id'] = $v->id;
                    $arr['nama'] = $v->nama;
                    $arr['harga'] = $v->harga;
                    $arr['gambar'] = $v->gambar;
                    $d[] = $arr;
                }
            }
            echo json_encode($d);
        }
    }
    public function m_customer()
    {
        if ($this->m_marketing->auth_api()) {
            $data = q_data("*", 'kumalagroup.customer', ['id' => $this->uri->segment(4)])->row();
            if ($data) {
                $reg = q_data("*", 'kumalagroup.reg_customer', ['id' => $data->customer])->row();
                $d['nama'] = $reg->nama;
                $d['email'] = $reg->email;
                $d['tanggal_lahir'] = $data->tanggal_lahir;
                $d['jenis_kelamin'] = $data->jenis_kelamin;
                $d['agama'] = $data->agama;
                $d['alamat'] = $data->alamat;
                $d['telepon'] = $data->telepon;
                $d['no_npwp'] = $data->no_npwp;
                $d['foto'] = $data->gambar;
            }
            echo json_encode($d);
        }
    }
    public function m_provinsi()
    {
        if ($this->m_marketing->auth_api()) {
            $data = q_data("*", 'kmg.perusahaan', ['id_brand' => $this->uri->segment(4)], [], "id_provinsi")->result();
            foreach ($data as $v) {
                $arr['id'] = $v->id_provinsi;
                $arr['provinsi'] = q_data("*", 'db_honda.provinsi', ['id_provinsi' => $v->id_provinsi])->row()->nama;
                $d[] = $arr;
            }
            echo json_encode($d);
        }
    }
    public function m_pricelist()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(4) == 3) {
                $data = q_data("*", 'db_hino.pricelist', ['id_pricelist' => $this->uri->segment(5)])->row();
                $d['id'] = $data->id_pricelist;
                $d['tipe'] = q_data("*", 'db_hino.p_varian', ['id_varian' => $data->id_varian])->row()->varian;
                $d['harga_otr'] = $data->harga_otr;
            } elseif ($this->uri->segment(4) == 17) {
                $data = q_data("*", 'db_honda.pricelist', ['id_pricelist' => $this->uri->segment(5)])->row();
                $d['id'] = $data->id_pricelist;
                $d['tipe'] = q_data("*", 'db_honda.p_varian', ['id_varian' => $data->id_varian])->row()->varian;
                $d['harga_otr'] = $data->harga_otr;
            } elseif ($this->uri->segment(4) == 5) {
                $data = q_data("*", 'db_wuling.pricelist', ['id_pricelist' => $this->uri->segment(5)])->row();
                $d['id'] = $data->id_pricelist;
                $d['tipe'] = q_data("*", 'db_wuling.p_varian', ['id_varian' => $data->id_varian])->row()->varian;
                $d['harga_otr'] = $data->harga_otr;
            }
            echo json_encode($d);
        }
    }
    public function tipe()
    {
        if ($this->m_marketing->auth_api()) {
            $d = [];
            $cek = q_data("*", 'kmg.perusahaan', ['id_brand' => $this->uri->segment(4), [], 'id_provinsi' =>  $this->uri->segment(5)], "id_perusahaan")->result();
            foreach ($cek as $v) $id[] = $v->id_perusahaan;
            if ($this->uri->segment(4) == 3) {
                $tipe = q_data("*", 'db_hino.p_varian', "varian LIKE '%" . $this->uri->segment(6) . "%'")->result();
                foreach ($tipe as $v) $id_tipe[] = $v->id_varian;
                $data = q_data("*", 'db_hino.pricelist', "id_perusahaan in(" . implode(',', $id) . ") and id_varian in(" . implode(',', $id_tipe) . ") and harga_otr!=0", [], "id_varian")->result();
                foreach ($data as $v) {
                    $arr['id'] = $v->id_pricelist;
                    $arr['tipe'] = q_data("*", 'db_hino.p_varian', ['id_varian' => $v->id_varian])->row()->varian;
                    $arr['harga_otr'] = $v->harga_otr;
                    $d[] = $arr;
                }
            } elseif ($this->uri->segment(4) == 17) {
                $tipe = q_data("*", 'db_honda.p_varian', "varian LIKE '%" . $this->uri->segment(6) . "%'")->result();
                foreach ($tipe as $v) $id_tipe[] = $v->id_varian;
                $data = q_data("*", 'db_honda.pricelist', "id_perusahaan in(" . implode(',', $id) . ") and id_varian in(" . implode(',', $id_tipe) . ") and harga_otr!=0", [], "id_varian")->result();
                foreach ($data as $v) {
                    $arr['id'] = $v->id_pricelist;
                    $arr['tipe'] = q_data("*", 'db_honda.p_varian', ['id_varian' => $v->id_varian])->row()->varian;
                    $arr['harga_otr'] = $v->harga_otr;
                    $d[] = $arr;
                }
            } elseif ($this->uri->segment(4) == 5) {
                $tipe = q_data("*", 'db_wuling.p_varian', "varian LIKE '%" . $this->uri->segment(6) . "%'")->result();
                foreach ($tipe as $v) $id_tipe[] = $v->id_varian;
                $data = q_data("*", 'db_wuling.pricelist', "id_perusahaan in(" . implode(',', $id) . ") and id_varian in(" . implode(',', $id_tipe) . ") and harga_otr!=0", [], "id_varian")->result();
                foreach ($data as $v) {
                    $arr['id'] = $v->id_pricelist;
                    $arr['tipe'] = q_data("*", 'db_wuling.p_varian', ['id_varian' => $v->id_varian])->row()->varian;
                    $arr['harga_otr'] = $v->harga_otr;
                    $d[] = $arr;
                }
            }
            echo json_encode($d);
        }
    }
    public function tipe_unit()
    {
        if ($this->m_marketing->auth_api()) {
            $result = [];

            if ($this->uri->segment(4) == 3) {
                $result = $this->m_service->get_all_tipe_unit('db_hino');
            } else if ($this->uri->segment(4) == 5) {
                $result = $this->m_service->get_all_tipe_unit('db_wuling');
            } else if ($this->uri->segment(4) == 17) {
                $result = $this->m_service->get_all_tipe_unit('db_honda');
            } else if ($this->uri->segment(4) == 18) {
                $result = $this->m_service->get_all_tipe_unit('db_mercedes');
            }

            echo json_encode($result);
        }
    }
    public function data_daerah()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(5)) $d = q_data("*", 'db_honda.kecamatan', ['id_kabupaten' => $this->uri->segment(5)])->result();
            else if ($this->uri->segment(4)) $d = q_data("*", 'db_honda.kabupaten', ['id_provinsi' => $this->uri->segment(4)])->result();
            else $d = q_data("*", 'db_honda.provinsi', [])->result();
            echo json_encode($d);
        }
    }
}
