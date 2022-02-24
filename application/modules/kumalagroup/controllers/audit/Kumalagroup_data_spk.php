<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_data_spk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_kumalagroup_data_spk');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }

    public function data_spk()
    {
        $d['judul']     = 'Data SPK';
        $d['cabang']    = $this->model_kumalagroup_data_spk->cabang();
        $d['content']   = 'data_spk/data_spk_view';
        $this->load->view('home', $d);
    }

    public function get_data_spk()
    {
        echo  $this->model_kumalagroup_data_spk->get_audit_data_spk();
    }
}