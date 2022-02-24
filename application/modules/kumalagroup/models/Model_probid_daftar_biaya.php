<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH . 'third_party/vendor/autoload.php');

use Rakit\Validation\Validator;

class Model_probid_daftar_biaya extends CI_Model
{
    // public function detail_biaya()
    // {
    //     $id_user_ = $this->session->userdata('id_user');
    //     $id_brand_view = $this->db->get_where('users', "id_user = $id_user_")->row('id_brand_view');
    //     $this->load->library('datatables');
    //     $this->datatables->select_max('jb.nama_biaya, db.id_pelanggan, pr.lokasi, db.type_biaya, tb.tagihan, tb.tgl_tagihan');
    //     $this->datatables->from('kumalagroup.detail_biaya db');
    //     $this->datatables->join('kumalagroup.jenis_biaya jb', 'jb.kategori_biaya = db.detail_kategori');
    //     $this->datatables->join('kumalagroup.tagihan_biaya tb', 'tb.id_pelanggan = db.id_pelanggan', 'left');
    //     $this->datatables->join('kmg.perusahaan pr', 'pr.id_perusahaan = db.id_perusahaan');
    //     $this->datatables->where('db.id_brand', $id_brand_view);
    //     // $this->datatables->group_by('tb.id_pelanggan');
    //     echo $this->datatables->generate();
    // }

    private function nama_database_brand()
    {
        $id_user_ = $this->session->userdata('id_user');
        $id_brand_view = $this->db->get_where('users', "id_user = $id_user_")->row('id_brand_view');
        $data_tabel = array("3" => "db_hino", "4" => "", "5" => "db_wuling", "7" => "", "8" => "", "11" => "", "13" => "", "15" => "", "26" => "", "17" => "db_honda", "18" => "db_mercedes", "19" => "", "20" => "", "21" => "db_kuc");
        return $data_tabel[$id_brand_view];
    }

    public function detail_biaya()
    {
        // debug($_POST);
        $nama_tabel = $this->nama_database_brand();
        $id_user_ = $this->session->userdata('id_user');
        $id_brand_view = $this->db->get_where('users', "id_user = $id_user_")->row('id_brand_view');
        $select = [null, "jb.nama_biaya", "db.id_pelanggan", "db.type_biaya", "pr.lokasi"];
        $table = 'kumalagroup.detail_biaya db';
        $join = [
            'kumalagroup.jenis_biaya jb' => 'jb.kategori_biaya = db.detail_kategori',
            'kmg.perusahaan pr'          => 'pr.id_perusahaan = db.id_perusahaan',

        ];

        $where = "db.id_brand = '$id_brand_view'";

        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where,
            null,
            null,
            null
        );

        foreach ($list as $i => $row) {
            $data_array[] = [
                'nama_biaya'   => $row->nama_biaya,
                'id_pelanggan' => $row->id_pelanggan,
                'lokasi'       => $row->lokasi,
                'type_biaya'   => $row->type_biaya,
                'tagihan'      => $this->tagihan($row->id_pelanggan)->row('tagihan'),
                'tgl_tagihan'  => tgl_sql($this->tgl_tagihan($row->id_pelanggan)->row('tgl_tagihan')),
            ];
        }

        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array, null, null);
    }

    private function tagihan($id_pelanggan)
    {
        $this->kumalagroup->select_max('tagihan');
        $this->kumalagroup->from('tagihan_biaya');
        $this->kumalagroup->where('id_pelanggan', $id_pelanggan);
        $data = $this->kumalagroup->get();
        return $data;
    }

    private function tgl_tagihan($id_pelanggan)
    {
        $this->kumalagroup->select_max('tgl_tagihan');
        $this->kumalagroup->from('tagihan_biaya');
        $this->kumalagroup->where('id_pelanggan', $id_pelanggan);
        $data = $this->kumalagroup->get();
        return $data;
    }

    public function detail_tagihan()
    {
        $id_pelanggan = $this->input->post('id_pelanggan');
        $nama_tabel = $this->nama_database_brand();
        $select = [null, "tb.id_pelanggan", "tb.tgl_tagihan", "tb.tagihan", "po.no_pengeluaran", "po.tgl", "po.no_bukti_bku", "po.tgl_approve"];
        $table = ["kumalagroup.tagihan_biaya tb"];
        $join = [
            $nama_tabel . '.pengeluaran_operasional_detail pod' => 'pod.id_pelanggan = tb.id_pelanggan',
            $nama_tabel . '.pengeluaran_operasional po' => 'po.no_pengeluaran = pod.no_pengeluaran',
        ];
        $where = "tb.id_pelanggan ='$id_pelanggan'";

        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where,
            null,
            null,
            null
        );

        foreach ($list as $i => $row) {
            $data_array[] = [
                'id_pelanggan' => $row->id_pelanggan,
                'tgl_tagihan' => tgl_sql($row->tgl_tagihan),
                'no_transaksi' => $row->no_pengeluaran == '' ? 'Belum Proses Pembayaran' : $row->no_pengeluaran,
                'tgl_transaksi' => tgl_sql($row->tgl),
                'no_bku' => $row->no_bukti_bku == '' ? 'Belum Approve Pembayaran' : $row->no_bukti_bku,
                'tgl_approve' => tgl_sql($row->tgl_approve),
                'tagihan' => separator_harga($row->tagihan),
            ];
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array, null, null);
    }
}
