<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_konfigurasi_user');
        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }


    public function index()
    {
        $d['content'] = 'content';
        $this->load->view('home', $d);
    }

    public function update_id_brand_view()
    {
        $this->model_konfigurasi_user->update_id_brand_view();
    }
}
