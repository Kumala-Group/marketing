<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class G_honda_after_sales extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('honda_as_models/model_buku_besar_u');
        $this->load->model('honda_as_models/model_kmg_u');
        $this->load->model('honda_as_models/model_penerimaan_bengkel_u');
    }


    public function index()
    {
        $cek = $this->session->userdata('status');
        $level = $this->session->userdata('level');
        if ($cek == 'login' && $level == 'group') {
            $d['mekanik'] = $this->load->model_kmg_u->karyawan("where status_aktif='Aktif' and id_jabatan in ('38', '39', '156', '73') and id_brand=17")->num_rows();
            $d['service_advisor'] = $this->load->model_kmg_u->karyawan("where status_aktif='Aktif' and id_jabatan in ('69') and id_brand=17")->num_rows();
            $d['foreman'] = $this->load->model_kmg_u->karyawan("where status_aktif='Aktif' and id_jabatan in ('88') and id_brand=17")->num_rows();
            $d['admin'] = $this->load->model_kmg_u->karyawan("where status_aktif='Aktif' and id_jabatan in ('6', '37', '68', '112', '137', '150') and id_brand=17")->num_rows();
            $this->load->view('honda/after_sales_report', $d);
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
            // $tahun = '2020';
            $d['nama_bln'] = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            for ($bln = 1; $bln <= 12; $bln++) {
                $sql = "WHERE MONTH(buku_besar.tgl)= '$bln' AND YEAR(buku_besar.tgl) = '$tahun' AND kode_akun = '110404' AND dk = 'D' AND journal = 'faktur_part_shop'";
                $part_counter = $this->model_buku_besar_u->buku_besar_profil_custom($sql)->result();
                $total = [];
                foreach ($part_counter as $r) $total[] = $r->jumlah;
                $d['part_counter'][$bln] = array_sum($total);

                $sql = "WHERE MONTH(buku_besar.tgl)= '$bln' AND YEAR(buku_besar.tgl) = '$tahun' AND kode_akun = '110403' AND dk = 'D' AND journal = 'faktur_service'";
                $service = $this->model_buku_besar_u->buku_besar_profil_custom($sql)->result();
                $total = [];
                foreach ($service as $r) $total[] = $r->jumlah;
                $d['service'][$bln] = array_sum($total);

                $sql = "WHERE MONTH(penerimaan_bengkel.tgl)= '$bln' AND YEAR(penerimaan_bengkel.tgl) = '$tahun' AND kode_akun = '110404' AND dk = 'K'";
                $total_part_counter = $this->model_penerimaan_bengkel_u->list_penerimaan_custom($sql)->result();
                $total = [];
                foreach ($total_part_counter as $r) $total[] = $r->jumlah;
                $d['total_part_counter'][$bln] = array_sum($total);

                $sql = "WHERE MONTH(penerimaan_bengkel.tgl)= '$bln' AND YEAR(penerimaan_bengkel.tgl) = '$tahun' AND kode_akun = '110403' AND dk = 'K'";
                $total_service = $this->model_penerimaan_bengkel_u->list_penerimaan_custom($sql)->result();
                $total = [];
                foreach ($total_service as $r) $total[] = $r->jumlah;
                $d['total_service'][$bln] = array_sum($total);

                $sql = "WHERE MONTH(penerimaan_bengkel.tgl)='$bln' AND YEAR(penerimaan_bengkel.tgl)='$tahun' and (penerimaan_bengkel.no_ref is NULL or penerimaan_bengkel.no_ref='') and dk='K'";
                $total_lainnya = $this->model_penerimaan_bengkel_u->list_penerimaan_custom($sql)->result();
                $total = [];
                foreach ($total_lainnya as $r) $total[] = $r->jumlah;
                $d['total_lainnya'][$bln] = array_sum($total);
            }
            $this->load->view('honda/after_sales_report_isi', $d);
        } else {
            redirect('group/logout');
        }
    }
}
