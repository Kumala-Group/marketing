<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_audit_kas_pengeluaran extends CI_Model
{

    private function nama_database_brand()
    {
        $id_user_ = $this->session->userdata('id_user');
        $id_brand_view = $this->db->select("id_brand_view")->get_where('users', "id_user = $id_user_")->row('id_brand_view');
        $data_tabel = array("3" => "db_hino", "4" => "", "5" => "db_wuling", "7" => "", "8" => "", "11" => "", "13" => "", "15" => "", "26" => "", "17" => "db_honda", "18" => "db_mercedes", "19" => "", "20" => "", "21" => "");
        return $data_tabel[$id_brand_view];
    }

    public function cabang()
    {
        $id_user_ = $this->session->userdata('id_user');
        $id_brand_view = $this->db->select("id_brand_view")->get_where('users', "id_user = $id_user_")->row('id_brand_view');
        $data =  $this->db->select('*')
            ->from('perusahaan')
            ->where('id_brand', $id_brand_view)
            ->get();
        return $data->result();
    }

    // PERUSAHAAN
    private function perusahaan($id_perusahaan)
    {
        $data = $this->db->select('lokasi')
            ->from('perusahaan')
            ->where('id_perusahaan', $id_perusahaan)
            ->get()->row('lokasi');
        return $data;
    }

    // BANK
    private function bank($id_bank)
    {
        $nama_tabel = $this->nama_database_brand();
        $data = $this->$nama_tabel->select('no_rekening')
            ->from('bank')
            ->where('id_bank', $id_bank)
            ->get()->row('no_rekening');
        return $data;
    }

    // NO BKU
    private function status_so_bku($no_bku)
    {
        if (!empty($no_bku)) {
            $staus_bku = $no_bku;
        } else {
            $staus_bku = "<div class='tag tag-danger'>Belum Approve</div>";
        }
        return $staus_bku;
    }

    // GET PENGELUARAN UNIT
    public function get_pengeluaran_unit()
    {
        $nama_tabel = $this->nama_database_brand();
        $post = $this->input->post();
        $tgl_awal = tgl_sql($post['tgl_awal']);
        $tgl_akhir = tgl_sql($post['tgl_akhir']);
        $cabang = $post['cabang'];
        $no_transaksi = $post['no_transaksi'];
        $kepada = $post['kepada'];

        $select = [null, "pu.no_pengeluaran", "pu.no_bukti_bku", "pu.id_perusahaan", "pu.tgl", "a.nama_akun", "pu.id_bank", "pu.total", "pu.keterangan", "pu.status_cek_audit"];
        $table  = $nama_tabel . '.pengeluaran_unit pu';
        $join   = [
            $nama_tabel . '.akun a' => 'a.kode_akun = pu.subgolongan',
        ];
        $where = "pu.subgolongan = '110100' and pu.tgl >= '$tgl_awal' and pu.tgl <= '$tgl_akhir' and pu.id_perusahaan = '$cabang' and (pu.no_pengeluaran LIKE '%$no_transaksi%' or pu.no_bukti_bku LIKE '%$no_transaksi%') and pu.kepada LIKE '%$kepada%'";

        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where
        );
        foreach ($list as $i => $dt) {
            $data_array[] = [
                'no_pengeluaran' => $dt->no_pengeluaran,
                'no_bukti_bku' => $this->status_so_bku($dt->no_bukti_bku),
                'lokasi' => $this->perusahaan($dt->id_perusahaan),
                'tgl' => tgl_sql($dt->tgl),
                'akun' => $dt->nama_akun,
                'rekening' => $this->bank($dt->id_bank),
                'total' => 'Rp. ' . separator_harga($dt->total),
                'keterangan' => $dt->keterangan,
                'status' => $dt->status_cek_audit,
            ];
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array);
    }

    // UPDATE STATUS CEK AUDIT PENGELUARAN UNIT
    public function update_status_pengeluaram_unit_for_audit()
    {
        $nama_tabel = $this->nama_database_brand();
        $status = $this->input->post('status');
        $no_pengeluaran = $this->input->post('no_pengeluaran');
        $data_update = array(
            'status_cek_audit' => $status,
        );
        $this->$nama_tabel->where('no_pengeluaran', $no_pengeluaran);
        $this->$nama_tabel->update('pengeluaran_unit', $data_update);
        if ($status == 2) {
            echo "updates";
        }
    }

    // GET PENGELUARAN AFTER SALES
    public function get_pengeluaran_after_sales()
    {
        $nama_tabel = $this->nama_database_brand();
        $post = $this->input->post();
        $tgl_awal = tgl_sql($post['tgl_awal']);
        $tgl_akhir = tgl_sql($post['tgl_akhir']);
        $cabang = $post['cabang'];
        $no_transaksi = $post['no_transaksi'];
        $kepada = $post['kepada'];

        $select = [null, "pb.no_pengeluaran", "pb.no_bukti_bku", "pb.id_perusahaan", "pb.tgl", "a.nama_akun", "pb.id_bank", "pb.total", "pb.keterangan", "pb.status_cek_audit"];
        $table  = $nama_tabel . '.pengeluaran_bengkel pb';
        $join   = [
            $nama_tabel . '.akun a' => 'a.kode_akun = pb.subgolongan',
        ];
        $where = "pb.subgolongan = '110100' and pb.tgl >= '$tgl_awal' and pb.tgl <= '$tgl_akhir' and pb.id_perusahaan = '$cabang' and (pb.no_pengeluaran LIKE '%$no_transaksi%' or pb.no_bukti_bku LIKE '%$no_transaksi%') and pb.kepada LIKE '%$kepada%'";

        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where
        );
        foreach ($list as $i => $dt) {
            $data_array[] = [
                'no_pengeluaran' => $dt->no_pengeluaran,
                'no_bukti_bku' => $this->status_so_bku($dt->no_bukti_bku),
                'lokasi' => $this->perusahaan($dt->id_perusahaan),
                'tgl' => tgl_sql($dt->tgl),
                'akun' => $dt->nama_akun,
                'rekening' => $this->bank($dt->id_bank),
                'total' => 'Rp. ' . separator_harga($dt->total),
                'keterangan' => $dt->keterangan,
                'status' => $dt->status_cek_audit,
            ];
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array);
    }

    // UPDATE STATUS CEK AUDIT PENGELUARAN AFTER SALES
    public function update_status_pengeluaram_after_sales_for_audit()
    {
        $nama_tabel = $this->nama_database_brand();
        $status = $this->input->post('status');
        $no_pengeluaran = $this->input->post('no_pengeluaran');
        $data_update = array(
            'status_cek_audit' => $status,
        );
        $this->$nama_tabel->where('no_pengeluaran', $no_pengeluaran);
        $this->$nama_tabel->update('pengeluaran_bengkel', $data_update);
        if ($status == 2) {
            echo "updates";
        }
    }
}
