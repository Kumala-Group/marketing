<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH . 'third_party/vendor/autoload.php');

use Rakit\Validation\Validator;

class Model_probid_laporan_biaya extends CI_Model
{
    private function nama_database_brand()
    {
        $id_user_ = $this->session->userdata('id_user');
        $id_brand_view = $this->db->get_where('users', "id_user = $id_user_")->row('id_brand_view');
        $data_tabel = array("3" => "db_hino", "4" => "", "5" => "db_wuling", "7" => "", "8" => "", "11" => "", "13" => "", "15" => "", "26" => "", "17" => "db_honda", "18" => "db_mercedes", "19" => "", "20" => "", "21" => "db_kuc");
        return $data_tabel[$id_brand_view];
    }

    private function get_id_brand()
    {
        $id_user = $this->session->userdata('id_user');
        $id_brand = $this->db->get_where('users', "id_user = $id_user")->row('id_brand_view');
        return $id_brand;
    }

    public function cabang()
    {

        $id_brand_view = $this->get_id_brand();
        $cabang = $this->db->get_where('perusahaan', array('id_brand' => $id_brand_view));
        return $cabang->result();
    }

    public function jenis_biaya()
    {

        $this->kumalagroup->select('*');
        $this->kumalagroup->from('jenis_biaya');
        $data = $this->kumalagroup->get();
        return $data->result();
    }

    public function get_laporan_biaya()
    {

        $kategori_biaya = $this->input->post('jenis_biaya');
        $id_brand = $this->get_id_brand();
        $nama_tabel = $this->nama_database_brand();
        $tahun = $this->input->post('tahun');
        $bln = $this->input->post('bulan');
        if ($bln < 10) {
            $bulan_v = '0' . $bln;
        } else {
            $bulan_v = $bln;
        }
        $bulan =  $tahun . '-' . $bulan_v;
        $select = [null, "po.no_pengeluaran", "po.tgl", "db.id_pelanggan", "pod.jumlah", "po.keterangan", "db.id_perusahaan", "db.type_biaya", "po.no_bukti_bku"];
        $table = 'kumalagroup.detail_biaya db';
        $join = [
            $nama_tabel . '.pengeluaran_operasional_detail pod' => 'pod.id_pelanggan = db.id_pelanggan',
            $nama_tabel . '.pengeluaran_operasional po'         => 'po.no_pengeluaran = pod.no_pengeluaran',
        ];
        $where = "db.detail_kategori ='$kategori_biaya' and db.id_brand='$id_brand' and po.tgl like'%$bulan%' and po.tgl like '%$tahun%'";
        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where,
            null,
            'po.tgl desc'
        );
        foreach ($list as $dt) {
            $biaya[] = array(
                'perusahaan'        => $this->perusahaan($dt->id_perusahaan)[0]->singkat . '-' . $this->perusahaan($dt->id_perusahaan)[0]->lokasi,
                'no_transaksi'      => $dt->no_pengeluaran,
                'tgl_transaksi'     => tgl_sql($dt->tgl),
                'id_pelanggan'      => $dt->id_pelanggan,
                'biaya'             => 'Rp. ' . separator_harga($dt->jumlah),
                'keterangan'        => $dt->keterangan,
                'status'            => $dt->type_biaya == '1' ? 'Internal' : 'External',
                'no_bku'            => $dt->no_bukti_bku,
            );
        }
        return q_result_datatable($select, $table, $join, $where, empty($biaya) ? [] : $biaya);
    }

    private function perusahaan($id_perusahaan)
    {
        $perusahaan = $this->db->get_where('perusahaan', array('id_perusahaan' => $id_perusahaan));
        return $perusahaan->result();
    }

    public function get_export_excel()
    {
        $kategori_biaya = $this->input->get('jenis_biaya');
        $id_brand = $this->get_id_brand();
        $nama_tabel = $this->nama_database_brand();
        $tahun = $this->input->get('tahun');
        $bln = $this->input->get('bulan');
        $bln < 10 ? $bulan_v = '0' . $bln : $bulan_v = $bln;
        $bulan =  $tahun . '-' . $bulan_v;

        $this->db->select("br.nama_brand, pr.lokasi, db.id_pelanggan, po.no_pengeluaran, po.tgl, pod.jumlah, po.keterangan, if(db.type_biaya='1','Internal','External') as status, po.no_bukti_bku");
        $this->db->from('kumalagroup.detail_biaya db');
        $this->db->join($nama_tabel . '.pengeluaran_operasional_detail pod', 'pod.id_pelanggan = db.id_pelanggan');
        $this->db->join($nama_tabel . '.pengeluaran_operasional po', 'po.no_pengeluaran = pod.no_pengeluaran');
        $this->db->join('kmg.perusahaan pr', 'pr.id_perusahaan = db.id_perusahaan');
        $this->db->join('kmg.brand br', 'br.id_brand = db.id_brand');
        $this->db->where('db.detail_kategori', $kategori_biaya);
        $this->db->where('db.id_brand', $id_brand);
        $this->db->like('po.tgl', $bulan);
        $this->db->like('po.tgl', $tahun);
        $data = $this->db->get();
        return $data->result();
    }
}
