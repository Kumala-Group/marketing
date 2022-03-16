<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_ctrl_survey_do extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }

    public function index()
    {
        $index = 'wuling_ctrl_survey_do';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup,SDIGM,tm_w', $index)) {
            $d['judul'] = "Dashboard Controlling Survey DO Wuling";
            $d['content'] = "pages/dashboard/wuling_ctrl_survey_do";
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }
    public function data_customer()
    {
        $index = 'wuling_ctrl_survey_do';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup,SDIGM,tm_w', $index)) {
            $this->load->library('datatables');
            $this->datatables->select(
                'prospek.id_prospek,
            customer.nama AS nama_customer,
            sales.nama_karyawan AS nama_sales,
            dealer.lokasi AS dealer,
            sdo.tgl_do AS tgl_do'
            )
                ->from('db_wuling.s_prospek AS prospek')
                ->join('db_wuling.s_customer AS customer', 'prospek.id_prospek = customer.id_prospek', 'LEFT')
                ->join('kumk6797_kmg.karyawan AS sales', 'customer.sales = sales.id_karyawan', 'LEFT')
                ->join('db_wuling.s_do AS sdo', 'prospek.id_prospek = sdo.id_prospek', 'LEFT')
                ->join('kumk6797_kmg.perusahaan AS dealer', 'prospek.id_perusahaan = dealer.id_perusahaan', 'LEFT')
                ->where("sdo.tgl_do != 'null'")
                ->where("prospek.status_survei = 0");

            if ($this->input->post('dealer')) {
                $this->datatables->where_in('prospek.id_perusahaan', $this->input->post('dealer'));
            }
            if ($this->input->post('thn_bln')) {
                $this->datatables->where_in('EXTRACT( YEAR_MONTH FROM sdo.tgl_do )', $this->input->post('thn_bln'));
            }
            echo $this->datatables->generate();
        }
    }

    public function jumlah_survei()
    {
        $index = 'wuling_ctrl_survey_do';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup,SDIGM,tm_w', $index)) {
            $dealer = $this->input->post('dealer');
            $thn_bln = $this->input->post('thn_bln');
            $q_dealer = $dealer ? 'AND prospek.id_perusahaan IN(' . implode(',', $dealer) . ')' : '';
            $q_thn_bln = $thn_bln ? 'AND EXTRACT( YEAR_MONTH FROM sdo.tgl_do ) IN(' . implode(',', $thn_bln) . ')' : '';
            $q_awal = "SELECT prospek.id_prospek FROM db_wuling.s_prospek AS prospek
                            LEFT JOIN db_wuling.s_do AS sdo ON prospek.id_prospek = sdo.id_prospek
                        WHERE sdo.tgl_do != 'null' $q_dealer $q_thn_bln ";

            $jumlah_belum   = $this->db_wuling->query("$q_awal AND prospek.status_survei = 0")->num_rows();
            $jumlah_selesai = $this->db_wuling->query("$q_awal AND prospek.status_survei = 1")->num_rows();

            $data_jumlah['belum'] = $jumlah_belum;
            $data_jumlah['selesai'] = $jumlah_selesai;

            echo json_encode($data_jumlah);
        }
    }

    public function data_survei_dealer()
    {
        $index = 'wuling_ctrl_survey_do';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup,SDIGM,tm_w', $index)) {
            $dealer = $this->input->post('dealer');
            $thn_bln = $this->input->post('thn_bln');
            $q_thn_bln = $thn_bln ? 'AND EXTRACT( YEAR_MONTH FROM sdo.tgl_do ) IN(' . implode(',', $thn_bln) . ')' : '';
            $q_awal = "SELECT prospek.id_prospek, p.lokasi FROM db_wuling.s_prospek AS prospek
                            LEFT JOIN db_wuling.s_do AS sdo ON prospek.id_prospek = sdo.id_prospek
                            LEFT JOIN kmg.perusahaan AS p ON prospek.id_perusahaan = p.id_perusahaan
                        WHERE sdo.tgl_do != 'null' AND prospek.status_survei = 0 $q_thn_bln ";

            $nama_dealer = [];
            $jumlah_survei = [];
            foreach ($dealer as $d) {
                array_push($nama_dealer, $this->db->get_where('perusahaan', ['id_perusahaan' => $d])->result()[0]->lokasi);
                array_push($jumlah_survei, $this->db_wuling->query("$q_awal AND prospek.id_perusahaan = $d ORDER BY p.lokasi DESC")->num_rows());
            }

            $data_jumlah['nama_dealer'] = $nama_dealer;
            $data_jumlah['jumlah_survei'] = $jumlah_survei;
            echo json_encode($data_jumlah);
        }
    }

    public function get_dealer()
    {
        $index = 'wuling_ctrl_survey_do';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup,SDIGM,tm_w', $index)) {
            echo json_encode($this->db->query(
                "SELECT id_perusahaan, lokasi FROM perusahaan WHERE id_brand='5'
            AND kode_perusahaan NOT IN ('0') ORDER BY lokasi ASC"
            )->result());
        }
    }

    public function get_thn_bln_do()
    {
        $index = 'wuling_ctrl_survey_do';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup,SDIGM,tm_w', $index)) {
            $dealer = $this->input->post('dealer');
            $q_dealer = $dealer ? 'AND prospek.id_perusahaan IN(' . implode(',', $dealer) . ')' : '';
            $q_awal = "SELECT DISTINCT
                    EXTRACT( YEAR_MONTH FROM sdo.tgl_do ) AS tahun_bulan,
                    EXTRACT( YEAR FROM sdo.tgl_do ) AS tahun,
                    EXTRACT( MONTH FROM sdo.tgl_do ) AS bulan 
                FROM
                    s_prospek AS prospek
                    LEFT JOIN s_do AS sdo ON prospek.id_prospek = sdo.id_prospek 
                WHERE
                    sdo.tgl_do <> 'null' 
                    AND prospek.status_survei = 0 
                ORDER BY
                    sdo.tgl_do ASC
                $q_dealer ";

            $thn_bln_do   = $this->db_wuling->query($q_awal)->result();

            $data_thn = [];
            foreach ($thn_bln_do as $t) {
                $d = [];
                $d['tahun_bulan'] = $t->tahun_bulan;
                $d['tahun'] = $t->tahun;
                $d['bulan'] = getBulan($t->bulan);
                array_push($data_thn, $d);
            }

            echo json_encode($data_thn);
        }
    }
}
