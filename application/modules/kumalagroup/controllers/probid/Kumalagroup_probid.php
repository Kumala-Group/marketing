<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_probid extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_probid_master_biaya');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }


    public function master_biaya()
    {
        $d['judul']     = 'Master ID Biaya';
        $d['content']   = 'probid/jenis_biaya';
        $d['akun'] = $this->model_probid_master_biaya->akun();
        $d['perusahaan'] = $this->model_probid_master_biaya->perusahaan();
        $this->load->view('home', $d);
    }

    public function simpan_master_biaya()
    {
        $this->model_probid_master_biaya->simpan_master_biaya();
    }

    public function get_data_jenis_biaya()
    {
        $this->model_probid_master_biaya->data_jenis_biaya();
    }

    public function simpan_detail_biaya()
    {
        $this->model_probid_master_biaya->simpan_detail_biaya();
    }
}
