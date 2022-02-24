<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_data_do extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_kumalagroup_data_do');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }

    public function data_do()
    {
        $d['judul']     = 'Data DO';
        $d['cabang']    = $this->model_kumalagroup_data_do->cabang();
        $d['content']   = 'data_do/data_do_view';
        $this->load->view('home', $d);
    }

    public function get_data_do()
    {
        echo  $this->model_kumalagroup_data_do->get_audit_data_do();
    }
}