<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_user_profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_profil_user');
        $this->load->model('model_konfigurasi_user');
        $cek    = $this->session->userdata('username');
        $level  = $this->session->userdata('id_profil');
        if (!empty($cek) || $this->model_konfigurasi_user->tes($level)); {
        }
    }

    public function index()
    {
        $d['data_profil']   = $this->model_profil_user->get_data_profil();
        $d['edit_data_profil']   = $this->model_profil_user->edit_data_profil();
        $d['content'] = 'konfigurasi_user/porfil_user';
        $this->load->view('home', $d);
    }

    public function simpan()
    {

        $this->model_profil_user->simpan_data_profil();
    }

    public function edit()
    {
        $d['data_profil']   = $this->model_profil_user->get_data_profil();
        $d['edit_data_profil']   = $this->model_profil_user->edit_data_profil();
        $d['content'] = 'konfigurasi_user/porfil_user';
        $this->load->view('home', $d);
    }
}
