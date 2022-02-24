<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_kartu_piutang_n_aging extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_audit_kartu_piutang_n_aging');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }

    // DETAIL PEMBAYARAN SPK
    public function detail_pembayaran_spk()
    {
        $d['judul']     = 'Detail Pembayaran SPK';
        $d['cabang']    = $this->model_audit_kartu_piutang_n_aging->cabang();
        $d['content']   = 'kartu_piutang_n_aging/detail_pembayaran_spk/detail_pembayaran_spk_view';
        $this->load->view('home', $d);
    }

    // GET DETAIL PEMBAYARAN SPK
    public function get_detail_pembayaran_spk()
    {
        echo  $this->model_audit_kartu_piutang_n_aging->get_detail_pembayaran_spk();
    }

    // GET PEMBAYARAN SPK
    public function detail_penerimaan_unit()
    {
        echo json_encode($this->model_audit_kartu_piutang_n_aging->detail_pembayaran_spk());
    }

    public function penerimaan_buku_besar()
    {
        echo json_encode($this->model_audit_kartu_piutang_n_aging->penerimaan_buku_besar());
    }
    //CLOSE DETAIL PEMBAYARAN SPK


    //KARTU PIUTANG INVOICE
    public function kartu_piutang_invoice()
    {
        $d['judul']     = 'Laporan Piutang dan Aging schedule Invoice';
        $d['cabang']    = $this->model_audit_kartu_piutang_n_aging->cabang();
        // $d['piutang']    = $this->model_audit_kartu_piutang_n_aging->get_piutang_invoice();
        $d['content']   = 'kartu_piutang_n_aging/kartu_piutang_invoice/kartu_piutang_invoice_view';
        $this->load->view('home', $d);
    }

    // GET PIUTANG INVOICE
    public function piutang_invoice()
    {
        $data = $this->model_audit_kartu_piutang_n_aging->get_piutang_invoice();
        $total = count($data);
        if ($total != 0) {
            $response = ['success' => TRUE, 'recordsTotal' => $total, 'data' => $data];
        } else {
            $response = ['success' => TRUE, 'recordsTotal' => '0', 'data' => ''];
        }
        echo json_encode($response);
    }


    public function detail_piutang_invoice()
    {
        $data = $this->model_audit_kartu_piutang_n_aging->GetDetailData();
        // $total = count($data);
        // if ($total != 0) {
        //     $response = ['success' => TRUE, 'recordsTotal' => $total, 'data' => $data];
        // } else {
        //     $response = ['success' => TRUE, 'recordsTotal' => '0', 'data' => ''];
        // }
        echo json_encode($data);
    }


    //AGING SCHEDULE VIEW
    public function aging_schedule()
    {
        $d['judul']     = 'Aging Schedule Invoice';
        $d['cabang']    = $this->model_audit_kartu_piutang_n_aging->cabang();
        $d['content']   = 'kartu_piutang_n_aging/aging_schedule/aging_schedule_view';
        $this->load->view('home', $d);
    }

    // GET AGING SCHEDULE
    public function get_aging_schedule()
    {
        echo $this->model_audit_kartu_piutang_n_aging->get_data_aging_schedule();
    }
}
