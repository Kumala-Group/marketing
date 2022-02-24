<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller
{
    public $id_perusahaan;
    public $nama_lengkap;
    public $coverage;
    public $username;
    public $id_user;
    public $level;
    public $nik;

    public function __construct()
    {
        parent::__construct();
        // untuk variabel global
        $this->id_perusahaan = $this->session->userdata('id_perusahaan');
        $this->nama_lengkap  = $this->session->userdata('nama_lengkap');
        $this->coverage      = $this->session->userdata('coverage');
        $this->username      = $this->session->userdata('username');
        $this->id_user       = $this->session->userdata('id_user');
        $this->level         = $this->session->userdata('level');
        $this->nik           = $this->session->userdata('nik');
    }

    public function _response($data)
    {
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit();
    }
}
