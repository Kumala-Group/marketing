<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_wuling_dl_customer extends CI_Model
{
    public function data_customer($status = '1')
    {
        $this->load->library('datatables');
        $this->datatables->select('dl.id_dl_customer,
                                    dl.id_customer_digital,
                                    dl.tgl_masuk_leads,
                                    dl.tgl_bagi_leads,
                                    p.lokasi,
                                    dl.lead_source,
                                    dl.komunikasi,
                                    dl.nama,
                                    dl.no_telp,
                                    dl.keterangan,
                                    dl.alamat,
                                    dl.kota,
                                    r.regional,
                                    dl.email,
                                    dl.pekerjaan,
                                    dl.rencana_pembelian,
                                    dl.info_yg_dibutuhkan,
                                    dl.tipe_mobil,
                                    dl.brand_lain,
                                    sc.nama_status_customer');
        $this->datatables->from('db_wuling.digital_leads_customer as dl');
        $this->datatables->join('kumk6797_kmg.perusahaan p', 'dl.id_perusahaan = p.id_perusahaan', 'LEFT');
        $this->datatables->join('db_wuling.regional r', 'dl.id_perusahaan = r.id_perusahaan', 'LEFT');
        $this->datatables->join('db_wuling.dl_status_customer sc', 'dl.id_status_customer = sc.id_status_customer', 'LEFT');

        if ($this->input->post('xylo')) $this->datatables->where('dl.lead_source', 'xylo');
        $this->datatables->where_in('dl.id_status_customer', $status);
        echo $this->datatables->generate();
    }

    public function get_data_customer($id)
    {
        $results = $this->db_wuling->get_where('digital_leads_customer', ['id_dl_customer' => $id]);
        return $results->result()[0];
    }

    public function hapus_data_customer($id)
    {
        $this->db_wuling->delete('digital_leads_customer', ['id_dl_customer' => $id]);
    }

    public function simpan_data_customer($data)
    {
        $this->db_wuling->update("digital_leads_customer", $data, ['id_dl_customer' => $data['id_dl_customer']]);
    }
}
