<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class G_wuling_after_sales_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('wuling_as_models/model_buku_besar_u');
        $this->load->model('honda_as_models/model_kmg_u');
    }


    public function index()
    {
        $cek = $this->session->userdata('status');
        $level = $this->session->userdata('level');
        if ($cek == 'login' && $level == 'group') {
            $d['mekanik'] = $this->load->model_kmg_u->karyawan("where status_aktif='Aktif' and id_jabatan in ('38', '39', '156', '73') and id_brand=5")->num_rows();
            $d['service_advisor'] = $this->load->model_kmg_u->karyawan("where status_aktif='Aktif' and id_jabatan in ('69') and id_brand=5")->num_rows();
            $d['foreman'] = $this->load->model_kmg_u->karyawan("where status_aktif='Aktif' and id_jabatan in ('88') and id_brand=5")->num_rows();
            $d['admin'] = $this->load->model_kmg_u->karyawan("where status_aktif='Aktif' and id_jabatan in ('6', '37', '68', '112', '137', '150') and id_brand=5")->num_rows();
            $this->load->view('wuling/after_sales_report', $d);
        } else {
            redirect('group/logout');
        }
    }

    function data()
    {
        $cek = $this->session->userdata('status');
        $level = $this->session->userdata('level');
        if ($cek == 'login' && $level == 'group') {
            $tahun = $this->input->post('year');
            $d['nama_bln'] = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            for ($bln = 1; $bln <= 12; $bln++) {
                $sql = "WHERE MONTH(buku_besar.tgl)= '$bln' AND YEAR(buku_besar.tgl) = '$tahun' AND kode_akun = '110404' AND dk = 'D' AND journal = 'faktur_part_counter'";
                $part_counter = $this->model_buku_besar_u->buku_besar($sql)->result();
                $total = [];
                foreach ($part_counter as $r) $total[] = $r->jumlah;
                $d['part_counter'][$bln] = array_sum($total);
                $sql = "WHERE MONTH(buku_besar.tgl)= '$bln' AND YEAR(buku_besar.tgl) = '$tahun' AND kode_akun = '110403' AND dk = 'D' AND journal = 'faktur_service'";
                $service = $this->model_buku_besar_u->buku_besar($sql)->result();
                $total = [];
                foreach ($service as $r) $total[] = $r->jumlah;
                $d['service'][$bln] = array_sum($total);
            }
            $this->load->view('wuling/after_sales_report_isi', $d);
        } else {
            redirect('group/logout');
        }
    }
}
