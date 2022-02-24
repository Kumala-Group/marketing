<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_konfigurasi_user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_konfigurasi_user');
        // $cek        = $this->session->userdata('username');
        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');
        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }

    public function index()
    {
        $index = "konfigurasi_user";
        $d['content'] = 'konfigurasi_user/manajeman_user';
        $d['brand_hino'] = $this->model_konfigurasi_user->brand_hino();
        $d['brand_honda'] = $this->model_konfigurasi_user->brand_honda();
        $d['brand_mazda'] = $this->model_konfigurasi_user->brand_mazda();
        $d['brand_mercy'] = $this->model_konfigurasi_user->brand_mercy();
        $d['brand_wuling'] = $this->model_konfigurasi_user->brand_wuling();
        $d['coverage_hino'] = $this->model_konfigurasi_user->coverage_hino();
        $d['coverage_honda'] = $this->model_konfigurasi_user->coverage_honda();
        $d['coverage_mazda'] = $this->model_konfigurasi_user->coverage_mazda();
        $d['coverage_marcy'] = $this->model_konfigurasi_user->coverage_marcy();
        $d['coverage_wuling'] = $this->model_konfigurasi_user->coverage_wuling();
        $d['data_profil'] = $this->model_konfigurasi_user->data_profil();
        // $d['data_user'] = $this->model_konfigurasi_user->data_user();
        $this->load->view('home', $d);
    }

    public function simpan()
    {
        $this->model_konfigurasi_user->simpan_data_user();
    }

    public function data_user()
    {
        $this->model_konfigurasi_user->data_user();
    }

    public function update_status()
    {
        $this->model_konfigurasi_user->update_status();
    }
}
