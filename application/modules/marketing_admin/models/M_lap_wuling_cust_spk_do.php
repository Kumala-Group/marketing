<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_lap_wuling_cust_spk_do extends CI_Model
{
    public function _query_awal()
    {
        $q = '';
        $q_spk_join = '';
        $q_spk_tanpa_do = '';
        $q_do = '';

        $spk = $this->input->post('spk') ?? $this->input->get('spk');
        $do = $this->input->post('do') ?? $this->input->get('do');

        if (!empty($spk) && empty($do)) {
            $q_spk_tanpa_do .= " WHERE pu.tgl IS NULL ";
        }
        if (!empty($spk)) {
            $q_spk_join .= " INNER ";
        } else {
            $q_spk_join .= " LEFT ";
        }
        if (!empty($do)) {
            $q_do .= " INNER ";
        } else {
            $q_do .= " LEFT ";
        }


        $q .=
            "SELECT
                digital_leads_customer.id_dl_customer,
                digital_leads_customer.id_customer_digital,
                digital_leads_customer.nama AS nama_customer_digital,
                s_customer.id_prospek,
                s_customer.nama AS nama_customer_cabang,
                pu.tgl AS tgl_do,
                s_spk.tgl_spk,
                kmg.perusahaan.lokasi 
            FROM
                s_customer
            $q_spk_join JOIN s_spk ON s_customer.id_prospek = s_spk.id_prospek
            $q_do JOIN db_wuling.penjualan_unit AS pu ON s_spk.no_spk = pu.no_spk
            INNER JOIN digital_leads_customer ON digital_leads_customer.id_customer_digital = s_customer.id_cus_digital
            INNER JOIN kmg.perusahaan ON db_wuling.digital_leads_customer.id_perusahaan = kmg.perusahaan.id_perusahaan
            $q_spk_tanpa_do ";

        return $q;
    }

    public function _query_search($search)
    {
        $q_where = '';
        $spk = $this->input->post('spk') ?? $this->input->get('spk');
        $do = $this->input->post('do') ?? $this->input->get('do');

        if (!empty($spk) && empty($do)) {
            $q_where .= " AND ";
        } else {
            $q_where .= " WHERE ";
        }
        return
            " $q_where ( digital_leads_customer.id_dl_customer LIKE '%$search%' ESCAPE '!' 
            OR digital_leads_customer.id_customer_digital LIKE '%$search%' ESCAPE '!' 
            OR digital_leads_customer.nama LIKE '%$search%' ESCAPE '!' 
            OR pu.tgl LIKE '%$search%' ESCAPE '!' 
            OR s_spk.tgl_spk LIKE '%$search%' ESCAPE '!' 
            OR s_customer.id_prospek LIKE '%$search%' ESCAPE '!' 
            OR kmg.perusahaan.lokasi LIKE '%$search%' ESCAPE '!' 
            ) ";
    }

    public function _query_order_by($order_field, $order_ascdesc)
    {
        if ($order_field && $order_ascdesc) {
            return " ORDER BY $order_field $order_ascdesc ";
        }
    }

    public function _query_tgl()
    {
        $tgl_awal = $this->input->post('tgl_awal') ?? $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir') ?? $this->input->get('tgl_akhir');
        if ($tgl_awal && $tgl_akhir) {
            return " AND s_spk.tgl_spk BETWEEN '"
                . $tgl_awal . "' AND '" . $tgl_akhir . "' ";
        }
    }

    public function filter($search, $limit, $start, $order_field, $order_ascdesc)
    {
        $orderby = $this->_query_order_by($order_field, $order_ascdesc);
        return $this->db_wuling->query(
            $this->_query_awal() .
                $this->_query_search($search) .
                $this->_query_tgl() .
                $orderby .
                " LIMIT $start, $limit"
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
                $this->_query_search($search) .
                $this->_query_tgl()
        )->num_rows();
    }

    public function query_cetak()
    {
        return $this->db_wuling->query(
            $this->_query_awal() .
                $this->_query_search('') .
                $this->_query_tgl()
        );
    }
}
