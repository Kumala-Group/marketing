<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_kas_penerimaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_audit_kas_penerimaan');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }

    public function unit()
    {
        $d['judul']     = 'Kas Penerimaan Unit';
        $d['cabang']    = $this->model_audit_kas_penerimaan->cabang();
        $d['content']   = 'kas_penerimaan/unit/unit_view';
        $this->load->view('home', $d);
    }

    public function get_penerimaan_unit()
    {
        echo  $this->model_audit_kas_penerimaan->get_penerimaan_unit();
    }

    public function set_status_cek_penerimaan_unit_for_audit()
    {
        $this->model_audit_kas_penerimaan->update_status_penerimaan_unit_for_audit();
    }



    public function after_sales()
    {
        $d['judul']     = 'Kas Penerimaan After Sales';
        $d['cabang']    = $this->model_audit_kas_penerimaan->cabang();
        $d['content']   = 'kas_penerimaan/after_sales/after_sales_view';
        $this->load->view('home', $d);
    }

    public function get_penerimaan_after_sales()
    {
        echo  $this->model_audit_kas_penerimaan->get_penerimaan_after_sales();
    }

    public function set_status_cek_penerimaan_after_sales_for_audit()
    {
        $this->model_audit_kas_penerimaan->update_status_penerimaan_after_sales_for_audit();
    }
}
