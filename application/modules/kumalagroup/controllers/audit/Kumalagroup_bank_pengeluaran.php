<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_bank_pengeluaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_audit_bank_pengeluaran');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }

    // PENGELUARAN UNIT
    public function unit()
    {
        $d['judul']     = 'Pengeluaran Unit';
        $d['cabang']    = $this->model_audit_bank_pengeluaran->cabang();
        $d['content']   = 'bank_pengeluaran/unit/unit_view';
        $this->load->view('home', $d);
    }

    // GET DATA PENGELUARAN UNIT
    public function get_pengeluaran_unit()
    {
        echo $this->model_audit_bank_pengeluaran->get_pengeluaran_unit();
    }

    // UPDATE STATUS PENGELUARAN UNIT
    public function set_status_cek_pengeluaran_unit_for_audit()
    {
        $this->model_audit_bank_pengeluaran->update_status_pengeluaram_unit_for_audit();
    }

    // --------------------------------------------------------------------------------------------------------
    // PENGELUARAN AFTER SALES
    public function after_sales()
    {
        $d['judul']     = 'Pengeluaran After Sales';
        $d['cabang']    = $this->model_audit_bank_pengeluaran->cabang();
        $d['content']   = 'bank_pengeluaran/after_sales/after_sales_view';
        $this->load->view('home', $d);
    }

    // GET DATA PENGELUARAN AFTER SALES
    public function get_pengeluaran_after_sales()
    {
        echo $this->model_audit_bank_pengeluaran->get_pengeluaran_after_sales();
    }

    // UPDATE STATUS PENGELUARAN AFTER SALES
    public function set_status_cek_pengeluaran_after_sales_for_audit()
    {
        $this->model_audit_bank_pengeluaran->update_status_pengeluaram_after_sales_for_audit();
    }

    // -----------------------------------------------------------------------------------------
    // PENGELUARAN OPERASIONAL
    public function operasional()
    {
        $d['judul']     = 'Pengeluaran Operasional';
        $d['cabang']    = $this->model_audit_bank_pengeluaran->cabang();
        $d['content']   = 'bank_pengeluaran/operasional/operasional_view';
        $this->load->view('home', $d);
    }

    // GET DATA PENGELUARAN OPERASIONAL
    public function get_pengeluaran_operasional()
    {
        echo $this->model_audit_bank_pengeluaran->get_pengeluaran_operasional();
    }

    // UPDATE STATUS PENGELUARAN OPERASIONAL
    public function set_status_cek_pengeluaran_operasional_for_audit()
    {
        $this->model_audit_bank_pengeluaran->update_status_pengeluaram_operasional_for_audit();
    }
}
