<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_wuling_dl_followup extends CI_Model
{
    public function _ambil_coverage()
    {
        $id_user = $this->session->userdata('id_user');
        $this->db_wuling->select('id_perusahaan');
        $this->db_wuling->from('dl_sales');
        if ($this->session->userdata('id_jabatan') == 171) {
            $this->db_wuling->where('id_sales', $id_user);
            $data_cabang =  $this->db_wuling->get()->result_array();
            $id_perusahaan = '';
            foreach ($data_cabang as $cabang) {
                $id_perusahaan .= json_encode($cabang['id_perusahaan']) . ',';
            }
            $id_perusahaan = rtrim($id_perusahaan, ',');
            return "AND dlc.id_perusahaan IN ($id_perusahaan)";
        }
    }

    public function _query_awal()
    {
        $and_cabang_in = $this->_ambil_coverage();
        return
            "SELECT
                sfc.id_dl_customer,
                sfc.tgl_fu,
                sc.nama_status_customer,
                sfu.nama_status_fu,
                dlc.lead_source,
                dlc.id_customer_digital,
                dlc.nama,
                dlc.alamat,
                dlc.kota,
                dlc.no_telp,
                p.lokasi,
                u.nama_lengkap,
                dls.id_sales,
                dls.id,
                dlc.id_perusahaan
            FROM
                db_wuling.digital_leads_followup AS sfc
            LEFT JOIN db_wuling.digital_leads_customer AS dlc ON sfc.id_dl_customer = dlc.id_dl_customer
            LEFT JOIN kmg.perusahaan AS p ON dlc.id_perusahaan = p.id_perusahaan
            LEFT JOIN db_wuling.dl_sales AS dls ON dlc.id_perusahaan = dls.id_perusahaan
            LEFT JOIN kumalagroup.users AS u ON dls.id_sales = u.id
            LEFT JOIN db_wuling.dl_status_customer AS sc ON sfc.id_status_customer = sc.id_status_customer
            LEFT JOIN db_wuling.dl_status_fu AS sfu ON sfc.id_status_fu = sfu.id_status_fu
            INNER JOIN (
                SELECT
                    sfc.id_dl_customer,
                    max( sfc.tgl_fu ) AS tgl_max 
                FROM
                    db_wuling.digital_leads_followup AS sfc
                GROUP BY
                    sfc.id_dl_customer
                ) AS fu_join ON sfc.id_dl_customer = fu_join.id_dl_customer 
            WHERE sfc.tgl_fu = fu_join.tgl_max
            $and_cabang_in ";
    }

    public function _query_search($search)
    {
        return
            "dlc.nama LIKE '%$search%' ESCAPE '!' 
            OR dlc.lead_source LIKE '%$search%' ESCAPE '!' 
            OR dlc.no_telp LIKE '%$search%' ESCAPE '!' 
            OR dlc.alamat LIKE '%$search%' ESCAPE '!' 
            OR dlc.kota LIKE '%$search%' ESCAPE '!' 
            OR p.lokasi LIKE '%$search%' ESCAPE '!' 
            OR u.nama_lengkap LIKE '%$search%' ESCAPE '!' 
            OR sc.nama_status_customer LIKE '%$search%' ESCAPE '!' 
            OR sfu.nama_status_fu LIKE '%$search%' ESCAPE '!' ";
    }

    public function filter($search, $limit, $start, $order_field, $order_ascdesc)
    {
        return $this->db_wuling->query(
            $this->_query_awal() .
                "AND(" . $this->_query_search($search) . ")
                ORDER BY
                $order_field $order_ascdesc 
                LIMIT $start, $limit"
        )->result_array();
    }

    public function count_all()
    {
        return $this->db_wuling->query(
            $this->_query_awal()
        )->num_rows();
    }

    public function count_filter($search)
    {
        return $this->db_wuling->query(
            $this->_query_awal() .
                "AND(" . $this->_query_search($search) . ")"
        )->num_rows();
    }

    function data_followup($id)
    {
        $this->load->library('datatables');
        $this->datatables->select('fu.id_dl_customer,
                                    dl.nama,
                                    fu.id_followup,
                                    sfu.nama_status_fu,
                                    kfu.nama_keterangan_fu,
                                    sc.nama_status_customer,
                                    fu.tgl_fu
                                    ');
        $this->datatables->from('db_wuling.digital_leads_followup as fu');
        $this->datatables->join('db_wuling.digital_leads_customer dl', 'fu.id_dl_customer = dl.id_dl_customer', 'LEFT');
        $this->datatables->join('db_wuling.dl_status_fu sfu', 'fu.id_status_fu = sfu.id_status_fu', 'LEFT');
        $this->datatables->join('db_wuling.dl_keterangan_fu kfu', 'fu.id_keterangan_fu = kfu.id_keterangan_fu', 'LEFT');
        $this->datatables->join('db_wuling.dl_status_customer sc', 'fu.id_status_customer = sc.id_status_customer', 'LEFT');

        $this->datatables->where_in('fu.id_dl_customer', $id);
        echo $this->datatables->generate();
    }

    public function simpan_data_customer($data)
    {
        $this->db_wuling->update("digital_leads_customer", $data, ['id_dl_customer' => $data['id_dl_customer']]);
    }

    public function simpan_status_fu_cutomer($data)
    {
        if (empty($data['id_followup'])) {
            $this->db_wuling->insert("digital_leads_followup", $data);
        } else {
            $this->db_wuling->update("digital_leads_followup", $data, ['id_followup' => $data['id_followup']]);
        }
    }
}
