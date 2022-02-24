<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_kumalagroup_data_do extends CI_Model
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


    public function get_audit_data_do()
    {
        $nama_tabel = $this->nama_database_brand();
        $post = $this->input->post();
        $dari_tgl = tgl_sql($post['dari_tgl']);
        $sampai_tgl = tgl_sql($post['sampai_tgl']);
        $cabang = $post['cabang'];

        if ($nama_tabel == "db_hino") {
            $null = null;
            $select = [$null, "sspk.no_spk", "sdc.tgl_do", "sspk.tgl_spk", "tp.status_c", "tp.id_customer", "adm.id_leader", "tp.sales", "tp.cara_bayar", "sspk.keterangan", "sspk.no_rangka"];
            $table  = $nama_tabel . '.s_spk sspk';
            $join   = [
                $nama_tabel . '.tahapan_prospek tp' => 'tp.id_prospek = sspk.id_prospek',
                $nama_tabel . '.adm_sales adm' => 'adm.id_sales = tp.sales',
                $nama_tabel . '.s_do_child sdc' => 'sdc.no_spk = sspk.no_spk',
            ];
            $where = "(sdc.tgl_do IS NOT NULL or sdc.tgl_do <> '0000-00-00') and tp.lost = 'n' and sspk.id_perusahaan = '$cabang' and sdc.tgl_do >= '$dari_tgl' and sdc.tgl_do <= '$sampai_tgl'";
        } else {
            $select = [null, "sspk.no_spk", "sdo.tgl_do", "sspk.tgl_spk", "sc.nama", "adm.id_leader", "sc.sales", "sspk.no_rangka", "sc.cara_bayar", "sspk.keterangan"];
            $table  = $nama_tabel . '.s_spk sspk';
            $join   = [
                $nama_tabel . '.s_customer sc' => 'sc.id_prospek = sspk.id_prospek',
                $nama_tabel . '.s_do sdo' => 'sspk.id_prospek = sdo.id_prospek',
                $nama_tabel . '.adm_sales adm' => 'adm.id_sales = sc.sales',
            ];
            $where = "sspk.batal = 'n' and sdo.tgl_do >= '$dari_tgl' and sdo.tgl_do <= '$sampai_tgl' and sspk.id_perusahaan = '$cabang' and sc.status = 'do'";
        }
        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where
        );
        foreach ($list as $i => $dt) {
            $nama_tabel = $this->nama_database_brand();
            if ($nama_tabel == "db_hino") {
                $nama_ = $this->GetNamaCustomer($dt->status_c, $dt->id_customer);
            } else {
                $nama_ = $dt->nama;
            }

            $data_array[] = [
                'no_spk'            => $this->GetClearXNoSPK($dt->no_spk),
                'tgl_do'            => tgl_sql($dt->tgl_do),
                'tgl_spk'           => tgl_sql($dt->tgl_spk),
                'customer'          => $nama_,
                'no_rangka'         => $dt->no_rangka,
                'supervisor_sales'  => $this->GetNamaSupervisorSales($dt->id_leader, $dt->sales),
                'umur_spk'          => $this->GetUmurSPK($dt->tgl_spk),
                'cara_bayar'        => $this->GetCaraBayar($dt->cara_bayar),
                'status'            => $this->GetStatusTandaJadi($dt->no_spk, $cabang),
                'keterangan'        => $dt->keterangan,
            ];
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array);
    }

    private function GetClearXNoSPK($no_do)
    {
        $x = (string)$no_do;
        if (strpos($x, 'x') == true) {
            $no_do_ = substr($x, 0, strpos($x, "x"));
        } else {
            $no_do_ = $x;
        }
        return $no_do_;
    }

    public function GetNamaSupervisorSales($id_leader, $sales)
    {
        $nama_tabel = $this->nama_database_brand();
        $data = $this->$nama_tabel->select("nama_team")->from("adm_team_supervisor")->where("id_team_supervisor", $id_leader)->get();
        if ($data->num_rows() > 0) {
            $rows = $data->row("nama_team") . " - " . $this->model_data->get_nama_karyawan($sales);
        } else {
            $rows = "-";
        }
        return $rows;
    }

    public function GetUmurSPK($tgl_spk)
    {
        $masuk = $tgl_spk;
        $keluar = date('Y-m-d');
        $dt1 = new DateTime($masuk);
        $dt2 = new DateTime($keluar);
        $umur = date_diff($dt1, $dt2);
        return $umur->days;
    }

    public function GetCaraBayar($cara_bayar)
    {
        if ($cara_bayar == 'k') {
            $cara_bayar_ = 'Kredit';
        } else {
            $cara_bayar_ = 'Cash';
        }
        return $cara_bayar_;
    }

    public function GetStatusTandaJadi($no_spk, $cabang)
    {
        $nama_tabel = $this->nama_database_brand();

        $limit_tjd = $this->$nama_tabel->select('value')->where("id_perusahaan = '$cabang'")->get('setting_tanda_jadi')->row("value");

        // $select_distinct = "(SELECT DISTINCT no_transaksi,jb FROM buku_besar) bb";
        // $where = array("pu.no_ref" => $no_spk, "bb.jb <>" => "1", "pu.batal" => "n");
        // $tanda_jadi_penerimaan_unit = (int) $this->$nama_tabel->select("SUM(pu.total) as jumlah_tdj")->from("penerimaan_unit pu")->join($select_distinct, "pu.no_penerimaan = bb.no_transaksi")->where($where)->get()->row("jumlah_tdj");
        // $tanda_jadi_pengeluaran_unit = (int) $this->$nama_tabel->select("SUM(pu.total) as jumlah_tdj")->from("pengeluaran_unit pu")->join($select_distinct, "pu.no_bukti_bku = bb.no_transaksi")->where($where)->get()->row("jumlah_tdj");

        $tanda_jadi_penerimaan_unit = $this->penerimaan_unit($no_spk, $nama_tabel);
        $tanda_jadi_pengeluaran_unit = $this->pengeluaran_unit($no_spk, $nama_tabel);


        $tjd = $tanda_jadi_penerimaan_unit - $tanda_jadi_pengeluaran_unit;
        if ($tjd >= $limit_tjd) {
            $tanda_jadi = "<div class='tag tag-success'>Rp. " . separator_harga($tjd) . "</div>";
        } else {
            $tanda_jadi = "<div class='tag tag-danger'>Rp. " . separator_harga($tjd) . "</div>";
        }
        return $tanda_jadi;
    }

    public function GetNamaCustomer($status_c, $id_customer)
    {
        $nama_tabel = $this->nama_database_brand();
        if ($status_c == 's') {
            $table_c = 't_customer';
        } else {
            $table_c = 'customer';
        }
        $nama = $this->$nama_tabel->query("SELECT nama FROM $table_c WHERE id_customer = '$id_customer'")->row('nama');
        return $nama;
    }

    private function penerimaan_unit($no_spk, $nama_tabel)
    {
        $where = array("pu.no_ref" => $no_spk, "bb.jb <>" => "1", "pu.batal" => "n");

        $this->$nama_tabel->select('pu.no_penerimaan, pu.no_ref, pu.total');
        $this->$nama_tabel->from('penerimaan_unit pu');
        $this->$nama_tabel->join('buku_besar bb', 'pu.no_penerimaan = bb.no_transaksi');
        $this->$nama_tabel->where($where);
        $this->$nama_tabel->group_by('pu.no_penerimaan');

        $data = $this->$nama_tabel->get();
        foreach ($data->result() as $row) {
            $pu_penerimaan[] = $row->total;
        }
        if (empty($pu_penerimaan)) {
            return 0;
        } else {
            return  array_sum($pu_penerimaan);
        }
    }

    private function pengeluaran_unit($no_spk, $nama_tabel)
    {
        $where = array("pu.no_ref" => $no_spk, "bb.jb <>" => "1", "pu.batal" => "n");
        $this->$nama_tabel->select('pu.no_pengeluaran, pu.no_ref, pu.total');
        $this->$nama_tabel->from('pengeluaran_unit pu');
        $this->$nama_tabel->join('buku_besar bb', 'pu.no_pengeluaran = bb.no_transaksi');
        $this->$nama_tabel->where($where);
        $this->$nama_tabel->group_by('pu.no_pengeluaran');

        $data = $this->$nama_tabel->get();
        foreach ($data->result() as $row) {
            $pu_pengeluran[] = $row->total;
        }
        if (empty($pu_pengeluran)) {
            return 0;
        } else {
            return  array_sum($pu_pengeluran);
        }
    }
}
