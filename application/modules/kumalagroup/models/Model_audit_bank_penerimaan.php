<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_audit_bank_penerimaan extends CI_Model
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

    // --------------------------------------------------------------------------------------------------------
    // GET PENERIMAAN UNIT
    public function get_penerimaan_unit()
    {
        $nama_tabel = $this->nama_database_brand();
        $post = $this->input->post();
        $tgl_awal = tgl_sql($post['tgl_awal']);
        $tgl_akhir = tgl_sql($post['tgl_akhir']);
        $cabang = $post['cabang'];
        $no_transaksi = $post['no_transaksi'];
        $diterima = $post['diterima'];
        $select = [null, "pu.no_penerimaan", "pu.diterima", "pu.tgl", "ak.nama_akun", "pu.total", "pu.keterangan", "pu.id_perusahaan", "pu.id_bank", "pu.status_cek_audit"];

        $table  = $nama_tabel . '.penerimaan_unit pu';
        $join   = [
            $nama_tabel . '.akun ak' => 'ak.kode_akun = pu.subgolongan',
        ];
        $where = "pu.subgolongan = '110200' and pu.tgl >= '$tgl_awal' and pu.tgl <= '$tgl_akhir' and pu.id_perusahaan = '$cabang' and pu.no_penerimaan LIKE '%$no_transaksi%' and pu.diterima LIKE '%$diterima%'";

        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where
        );
        // debug($list);
        foreach ($list as $i => $dt) {
            $data_array[] = [
                'no_penerimaan'     => $dt->no_penerimaan,
                'diterima'          => $dt->diterima,
                'tgl'               => tgl_sql($dt->tgl),
                'akun'              => $dt->nama_akun,
                'total'             => 'Rp. ' . separator_harga($dt->total),
                'keterangan'        => $dt->keterangan,
                'lokasi'            => $this->perusahaan($dt->id_perusahaan),
                'rekening'          => $this->bank($dt->id_bank),
                'status'            => $dt->status_cek_audit,

            ];
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array);
    }

    // UPDATE STATUS CEK AUDIT PENERIMAAN UNIT
    public function update_status_penerimaan_unit_for_audit()
    {
        $nama_tabel = $this->nama_database_brand();
        $status = $this->input->post('status');
        $no_penerimaan = $this->input->post('no_penerimaan');
        $data_update = array(
            'status_cek_audit' => $status,
        );
        $this->$nama_tabel->where('no_penerimaan', $no_penerimaan);
        $this->$nama_tabel->update('penerimaan_unit', $data_update);
        if ($status == 2) {
            echo "updates";
        }
    }

    // --------------------------------------------------------------------------------------------------------
    // GET PENERIMAAN AFTER SALES
    public function get_penerimaan_after_sales()
    {
        $nama_tabel = $this->nama_database_brand();
        $post = $this->input->post();
        $tgl_awal = tgl_sql($post['tgl_awal']);
        $tgl_akhir = tgl_sql($post['tgl_akhir']);
        $cabang = $post['cabang'];
        $no_transaksi = $post['no_transaksi'];
        $diterima = $post['diterima'];
        $select = [null, "pb.no_penerimaan", "pb.diterima", "pb.tgl", "ak.nama_akun", "pb.total", "pb.keterangan", "pb.id_perusahaan", "pb.id_bank", "pb.status_cek_audit"];

        $table  = $nama_tabel . '.penerimaan_bengkel pb';
        $join   = [
            $nama_tabel . '.akun ak' => 'ak.kode_akun = pb.subgolongan',
        ];
        $where = "pb.subgolongan = '110200' and pb.tgl >= '$tgl_awal' and pb.tgl <= '$tgl_akhir' and pb.id_perusahaan = '$cabang' and pb.no_penerimaan LIKE '%$no_transaksi%' and pb.diterima LIKE '%$diterima%'";

        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where
        );
        // debug($list);
        foreach ($list as $i => $dt) {
            $data_array[] = [
                'no_penerimaan'     => $dt->no_penerimaan,
                'diterima'          => $dt->diterima,
                'tgl'               => tgl_sql($dt->tgl),
                'akun'              => $dt->nama_akun,
                'total'             => 'Rp. ' . separator_harga($dt->total),
                'keterangan'        => $dt->keterangan,
                'lokasi'            => $this->perusahaan($dt->id_perusahaan),
                'rekening'          => $this->bank($dt->id_bank),
                'status'            => $dt->status_cek_audit,

            ];
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array);
    }

    // UPDATE STATUS CEK AUDIT PENERIMAAN UNIT
    public function update_status_penerimaan_after_sales_for_audit()
    {
        $nama_tabel = $this->nama_database_brand();
        $status = $this->input->post('status');
        $no_penerimaan = $this->input->post('no_penerimaan');
        $data_update = array(
            'status_cek_audit' => $status,
        );
        $this->$nama_tabel->where('no_penerimaan', $no_penerimaan);
        $this->$nama_tabel->update('penerimaan_bengkel', $data_update);
        if ($status == 2) {
            echo "updates";
        }
    }

    // --------------------------------------------------------------------------------------------------------
    // GET PENERIMAAN OPERASIONAL
    public function get_penerimaan_operasional()
    {
        $nama_tabel = $this->nama_database_brand();
        $post = $this->input->post();
        $tgl_awal = tgl_sql($post['tgl_awal']);
        $tgl_akhir = tgl_sql($post['tgl_akhir']);
        $cabang = $post['cabang'];
        $no_transaksi = $post['no_transaksi'];
        $diterima = $post['diterima'];
        $select = [null, "po.no_penerimaan", "po.diterima", "po.tgl", "ak.nama_akun", "po.total", "po.keterangan", "po.id_perusahaan", "po.id_bank", "po.status_cek_audit"];

        $table  = $nama_tabel . '.penerimaan_operasional po';
        $join   = [
            $nama_tabel . '.akun ak' => 'ak.kode_akun = po.subgolongan',
        ];
        $where = "po.subgolongan = '110200' and po.tgl >= '$tgl_awal' and po.tgl <= '$tgl_akhir' and po.id_perusahaan = '$cabang' and po.no_penerimaan LIKE '%$no_transaksi%' and po.diterima LIKE '%$diterima%'";

        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where
        );
        // debug($list);
        foreach ($list as $i => $dt) {
            $data_array[] = [
                'no_penerimaan'     => $dt->no_penerimaan,
                'diterima'          => $dt->diterima,
                'tgl'               => tgl_sql($dt->tgl),
                'akun'              => $dt->nama_akun,
                'total'             => 'Rp. ' . separator_harga($dt->total),
                'keterangan'        => $dt->keterangan,
                'lokasi'            => $this->perusahaan($dt->id_perusahaan),
                'rekening'          => $this->bank($dt->id_bank),
                'status'            => $dt->status_cek_audit,

            ];
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array);
    }

    // UPDATE STATUS CEK AUDIT PENERIMAAN UNIT
    public function update_status_penerimaan_operasional_for_audit()
    {
        $nama_tabel = $this->nama_database_brand();
        $status = $this->input->post('status');
        $no_penerimaan = $this->input->post('no_penerimaan');
        $data_update = array(
            'status_cek_audit' => $status,
        );
        $this->$nama_tabel->where('no_penerimaan', $no_penerimaan);
        $this->$nama_tabel->update('penerimaan_operasional', $data_update);
        if ($status == 2) {
            echo "updates";
        }
    }
}
