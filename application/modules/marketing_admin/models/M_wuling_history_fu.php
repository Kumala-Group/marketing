<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_wuling_history_fu extends CI_Model
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
                dlc.id_customer_digital,
                dlc.lead_source,
                dlc.nama,
                dlc.no_telp,
                dlc.alamat,
                scu.id_prospek,
                scu.nama AS nama_cust_cabang,
                dlf.tgl_fu,
                s_spk.tgl_spk,
                pu.tgl AS tgl_do,
                stat_cust.nama_status_customer,
                stat_fu.nama_status_fu,
                u.id AS id_sales_digital,
                u.nama_lengkap AS sales_digital,
                p.lokasi,
                k.id_karyawan AS id_sales_force,
                k.nama_karyawan AS sales_force
            FROM
                db_wuling.digital_leads_followup AS dlf
                LEFT JOIN db_wuling.digital_leads_customer AS dlc ON dlf.id_dl_customer = dlc.id_dl_customer
                LEFT JOIN db_wuling.s_customer AS scu ON dlc.id_customer_digital = scu.id_cus_digital
                $q_spk_join JOIN db_wuling.s_spk AS s_spk ON scu.id_prospek = s_spk.id_prospek
                LEFT JOIN kmg.karyawan AS k ON scu.sales = k.id_karyawan
                LEFT JOIN db_wuling.dl_status_customer AS stat_cust ON dlf.id_status_customer = stat_cust.id_status_customer
                LEFT JOIN db_wuling.dl_status_fu AS stat_fu ON dlf.id_status_fu = stat_fu.id_status_fu
                LEFT JOIN db_wuling.dl_sales AS dls ON dlf.id_perusahaan = dls.id_perusahaan
                LEFT JOIN kumalagroup.users AS u ON dls.id_sales = u.id
                LEFT JOIN kmg.perusahaan AS p ON dls.id_perusahaan = p.id_perusahaan
                $q_do JOIN db_wuling.penjualan_unit AS pu ON s_spk.no_spk = pu.no_spk
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
            " $q_where ( 
            s_spk.tgl_spk LIKE '%$search%' ESCAPE '!' 
            OR pu.tgl LIKE '%$search%' ESCAPE '!' 
            OR scu.id_prospek LIKE '%$search%' ESCAPE '!' 
            OR dlc.lead_source LIKE '%$search%' ESCAPE '!' 
            OR dlc.id_customer_digital LIKE '%$search%' ESCAPE '!' 
            OR dlc.nama LIKE '%$search%' ESCAPE '!' 
            OR dlc.alamat LIKE '%$search%' ESCAPE '!' 
            OR stat_cust.nama_status_customer LIKE '%$search%' ESCAPE '!' 
            OR stat_fu.nama_status_fu LIKE '%$search%' ESCAPE '!' 
            OR dlf.tgl_fu LIKE '%$search%' ESCAPE '!' 
            OR p.lokasi LIKE '%$search%' ESCAPE '!' 
            OR u.nama_lengkap LIKE '%$search%' ESCAPE '!' 
            OR k.nama_karyawan LIKE '%$search%' ESCAPE '!' 
            ) 
            ";
    }

    public function _query_filter_sales_digital()
    {
        $q = '';

        $sales_digital = $this->input->post('sales_digital') ?? $this->input->get('sales_digital');
        if (!empty($sales_digital)) {
            $sales_digital = is_array($sales_digital) ? implode(',', $sales_digital) : $sales_digital;
            $q .= " AND u.id IN($sales_digital) ";
        }

        return $q;
    }

    public function _query_filter_sales_force()
    {
        $q = '';

        $sales_force = $this->input->post('sales_force_id') ?? $this->input->get('sales_force_id');
        if (!empty($sales_force)) {
            $sales_force = is_array($sales_force) ? implode(',', $sales_force) : $sales_force;
            $q .= " AND k.id_karyawan IN($sales_force) ";
        }

        return $q;
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
            return " AND dlf.tgl_fu BETWEEN '"
                . $tgl_awal . "' AND '" . $tgl_akhir . "' ";
        }
    }

    public function filter($search, $limit, $start, $order_field, $order_ascdesc)
    {
        $orderby = $this->_query_order_by($order_field, $order_ascdesc);
        return $this->db_wuling->query(
            $this->_query_awal() .
                $this->_query_search($search) .
                $this->_query_filter_sales_digital() .
                $this->_query_filter_sales_force() .
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
                $this->_query_filter_sales_digital() .
                $this->_query_filter_sales_force() .
                $this->_query_tgl()
        )->num_rows();
    }

    public function query_cetak()
    {
        return $this->db_wuling->query(
            $this->_query_awal() .
                $this->_query_search('') .
                $this->_query_filter_sales_digital() .
                $this->_query_filter_sales_force() .
                $this->_query_tgl()
        );
    }
}
