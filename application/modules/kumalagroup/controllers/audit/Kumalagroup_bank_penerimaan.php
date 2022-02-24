<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_bank_penerimaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_audit_bank_penerimaan');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }

    // PENERIMAAN UNIT
    public function unit()
    {
        $d['judul']     = 'Penerimaan Unit';
        $d['cabang']    = $this->model_audit_bank_penerimaan->cabang();
        $d['content']   = 'bank_penerimaan/unit/unit_view';
        $this->load->view('home', $d);
    }

    // GET DATA PENERIMAAN UNIT
    public function get_penerimaan_unit()
    {
        echo  $this->model_audit_bank_penerimaan->get_penerimaan_unit();
    }

    // UPDATE STATUS PENERIMAAN UNIT
    public function set_status_cek_penerimaan_unit_for_audit()
    {
        $this->model_audit_bank_penerimaan->update_status_penerimaan_unit_for_audit();
    }

    // --------------------------------------------------------------------------------------------------------
    // PENERIMAAN AFTER SALES
    public function after_sales()
    {
        $d['judul']     = 'Penerimaan After Sales';
        $d['cabang']    = $this->model_audit_bank_penerimaan->cabang();
        $d['content']   = 'bank_penerimaan/after_sales/after_sales_view';
        $this->load->view('home', $d);
    }

    // GET DATA PENERIMAAN AFTER SALES
    public function get_penerimaan_after_sales()
    {
        echo  $this->model_audit_bank_penerimaan->get_penerimaan_after_sales();
    }

    // UPDATE STATUS PENERIMAAN AFTER SALES
    public function set_status_cek_penerimaan_after_sales_for_audit()
    {
        $this->model_audit_bank_penerimaan->update_status_penerimaan_after_sales_for_audit();
    }

    // --------------------------------------------------------------------------------------------------------
    // PENERIMAAN AFTER SALES
    public function operasional()
    {
        $d['judul']     = 'Penerimaan Operasional';
        $d['cabang']    = $this->model_audit_bank_penerimaan->cabang();
        $d['content']   = 'bank_penerimaan/operasional/operasional_view';
        $this->load->view('home', $d);
    }

    // GET DATA PENERIMAAN AFTER SALES
    public function get_penerimaan_operasional()
    {
        echo  $this->model_audit_bank_penerimaan->get_penerimaan_operasional();
    }

    // UPDATE STATUS PENERIMAAN AFTER SALES
    public function set_status_cek_penerimaan_operasional_for_audit()
    {
        $this->model_audit_bank_penerimaan->update_status_penerimaan_operasional_for_audit();
    }
}
