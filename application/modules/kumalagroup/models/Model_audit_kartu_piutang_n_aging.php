<?php

use phpDocumentor\Reflection\Types\This;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_audit_kartu_piutang_n_aging extends CI_Model
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

    // --------------------------------------------------------------------------------------------------------
    // GET DETAIL PEMBAYARAN SPK
    public function get_detail_pembayaran_spk()
    {
        $nama_tabel = $this->nama_database_brand();
        $post = $this->input->post();
        $cabang = $post['cabang'];

        if ($nama_tabel == 'db_hino') {
            $select = [null, "spk.no_spk", "spk.id_perusahaan", "spk.tgl_spk", "tp.id_customer", "tp.status_c", "tp.cara_bayar", "spk.id_prospek"];
            $table  = $nama_tabel . '.s_spk spk';
            $join   = [
                // $nama_tabel . '.s_spk sspk' => 'sspk.no_spk = pu.no_spk',
                $nama_tabel . '.tahapan_prospek tp' => 'spk.id_prospek = tp.id_prospek',
            ];
            // $where = "(spk.no_spk <> '' and spk.no_spk IS NOT NULL) and spk.id_perusahaan IN ($cabang) and spk.batal = 'n' and spk.batal = 'n' group by spk.no_spk";
        } else {
            $select = [null, "spk.no_spk", "spk.id_perusahaan", "spk.tgl_spk", "nama", "alamat", "sc.cara_bayar", "spk.id_prospek"];
            $table  = $nama_tabel . '.s_spk spk';
            $join   = [
                $nama_tabel . '.s_customer sc' => 'sc.id_prospek = spk.id_prospek',
            ];
        }

        $where = "(spk.no_spk <> '' and spk.no_spk IS NOT NULL) and spk.id_perusahaan IN ($cabang) and spk.batal = 'n' and spk.batal = 'n' group by spk.no_spk";
        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where
        );
        // debug($list);
        foreach ($list as $i => $dt) {
            $nama_tabel = $this->nama_database_brand();
            // GET NAMA CUSTOMER
            if ($nama_tabel == "db_hino") {
                $nama_ = $this->GetNamaCustomer($dt->status_c, $dt->id_customer)->row('nama');
                $alamat_ = $this->GetNamaCustomer($dt->status_c, $dt->id_customer)->row('alamat');
            } else {
                $nama_ = $dt->nama;
                $alamat_ = $dt->alamat;
            }
            // // GET ALAMAT CUSTOMER
            // if ($nama_tabel == "db_hino") {
            //     $alamat_ = $this->GetNamaAlamatCustomer($dt->status_c, $dt->id_customer);
            // } else {
            //     $alamat_ = $dt->alamat;
            // }

            $data_array[] = [
                'no_spk' => $dt->no_spk,
                'cabang' => $this->GetPerusahaan($dt->id_perusahaan),
                'tanggal' => tgl_sql($dt->tgl_spk),
                'nama_customer' => $nama_,
                'alamat_customer' => $alamat_,
                'jenis_penjualan' => $dt->cara_bayar == 'k' ? 'Leasing' : 'Chas',
                'type' => $this->type_unit($dt->id_prospek),
            ];
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array);
    }

    // private function GetClearXNoSPK($no_spk)
    // {
    //     $x = (string)$no_spk;
    //     if (strpos($x, 'x') == true) {
    //         $no_spk_ = substr($x, 0, strpos($x, "x"));
    //     } else {
    //         $no_spk_ = $x;
    //     }
    //     return $no_spk_;
    // }

    // PERUSAHAAN
    private function GetPerusahaan($id_perusahaan)
    {
        $data = $this->db->select('lokasi')
            ->from('perusahaan')
            ->where('id_perusahaan', $id_perusahaan)
            ->get()->row('lokasi');
        return $data;
    }

    public function GetNamaCustomer($status_c, $id_customer)
    {
        $nama_tabel = $this->nama_database_brand();
        if ($status_c == 's') {
            $table_c = 't_customer';
        } else {
            $table_c = 'customer';
        }
        $nama = $this->$nama_tabel->get_where($table_c, array('id_customer' => $id_customer));
        // $nama = $this->$nama_tabel->query("SELECT nama FROM $table_c WHERE id_customer = '$id_customer'")->row('nama');
        return $nama;
    }

    // public function GetNamaAlamatCustomer($status_c, $id_customer)
    // {
    //     $nama_tabel = $this->nama_database_brand();
    //     if ($status_c == 's') {
    //         $table_c = 't_customer';
    //     } else {
    //         $table_c = 'customer';
    //     }
    //     $nama = $this->$nama_tabel->query("SELECT alamat FROM $table_c WHERE id_customer = '$id_customer'")->row('alamat');
    //     return $nama;
    // }

    private function type_unit($id_prospek)
    {
        $nama_tabel = $this->nama_database_brand();
        if ($nama_tabel == 'db_hino') {
            $this->$nama_tabel->select('u.varian');
            $this->$nama_tabel->from('s_spk spk');
            $this->$nama_tabel->join('unit u', 'u.kode_unit = spk.kode_unit');
            $this->$nama_tabel->where('spk.id_prospek', $id_prospek);
            $data = $this->$nama_tabel->get()->row('varian');
            return $data;
        } else {
            $this->$nama_tabel->select('u.varian');
            $this->$nama_tabel->from('s_prospek sp');
            $this->$nama_tabel->join('unit u', 'u.kode_unit = sp.kode_unit');
            $this->$nama_tabel->where('sp.id_prospek', $id_prospek);
            $data = $this->$nama_tabel->get()->row('varian');
            return $data;
        }
    }

    public function detail_pembayaran_spk()
    {

        $nama_tabel = $this->nama_database_brand();
        $no_spk = $this->input->get('no_spk');
        $where = array("pu.no_ref" => $no_spk, "pu.posting" => '1', "pu.batal" => "n", "bb.jb" => "0");
        $penerimaan = array();
        $this->$nama_tabel->select('*');
        $this->$nama_tabel->from('penerimaan_unit pu');
        $this->$nama_tabel->join('buku_besar bb', 'bb.no_transaksi = pu.no_penerimaan');
        $this->$nama_tabel->where($where);
        $this->$nama_tabel->group_by('bb.no_transaksi');
        $data = $this->$nama_tabel->get()->result();
        foreach ($data as $key => $dt) {
            $saldo[] = $dt->total;
            $penerimaan[] = array(
                'tanggal' => tgl_sql($dt->tgl),
                'no_penerimaan' => $dt->no_penerimaan,
                'keterangan' => $dt->keterangan,
                'jenis_bayar' => $dt->jenis_bayar == 'tf' ? 'Bank' : 'Kas',
                'debit' => '0',
                'kredit' => separator_harga($dt->total),
                'saldo' => separator_harga(array_sum($saldo)),

            );
        }
        return $penerimaan;
    }

    public function penerimaan_buku_besar()
    {
        $nama_tabel = $this->nama_database_brand();
        $no_transaksi = $this->input->get('no_penerimaan');
        $buku_besar = array();
        $this->$nama_tabel->select('*');
        $this->$nama_tabel->from('buku_besar');
        $this->$nama_tabel->where('no_transaksi', $no_transaksi);
        $data = $this->$nama_tabel->get();
        foreach ($data->result() as $key => $dt) {
            $total_debit[] = $dt->dk == 'D' ? $dt->jumlah : '';
            $total_kredit[] = $dt->dk == 'K' ? $dt->jumlah : '';
            $buku_besar[] = array(
                'tanggal' => tgl_sql($dt->tgl),
                'no_transaksi' => $dt->no_transaksi,
                'cabang' => $this->GetPerusahaan($dt->id_perusahaan),
                'keterangan' => $dt->keterangan,
                'nama_akun' => $this->nama_akun($dt->kode_akun),
                'kode_akun' => $dt->kode_akun,
                'debit' => $dt->dk == 'D' ? separator_harga($dt->jumlah) : '',
                'kredit' => $dt->dk == 'K' ? separator_harga($dt->jumlah) : '',
                'total_debit' => separator_harga(array_sum($total_debit)),
                'total_kredit' => separator_harga(array_sum($total_kredit)),
            );
        }
        // debug($buku_besar);
        return $buku_besar;
    }

    private function nama_akun($kode_akun)
    {
        $nama_tabel = $this->nama_database_brand();
        $nama_akun = $this->$nama_tabel->get_where('akun', array('kode_akun' => $kode_akun))->row('nama_akun');
        return $nama_akun;
    }

    // --------------------------------------------------------------------------------------------------------
    // GET PIUTANG INVOICE
    public function get_piutang_invoice()
    {
        $nama_tabel = $this->nama_database_brand();
        $post = $this->input->post();
        $cabang = $post['cabang'];
        $data = array();
        if ($nama_tabel == 'db_hino') {
            $this->$nama_tabel->select('pu.no_transaksi, pu.tgl, pu.no_rangka, pu.no_spk, pu.cara_bayar, spk.diskon as spk_diskon, spk.harga_otr as harga_otr, spk.id_leasing, thp.id_customer, thp.status_c, spk.id_prospek');
            $this->$nama_tabel->from('penjualan_unit pu');
            $this->$nama_tabel->join('s_spk spk', 'spk.no_spk = pu.no_spk');
            $this->$nama_tabel->join('tahapan_prospek thp', 'thp.id_prospek = spk.id_prospek');
            $this->$nama_tabel->where('pu.id_perusahaan', $cabang);
            $this->$nama_tabel->where('pu.batal', 'n');
            $data1 = $this->$nama_tabel->get_compiled_select();

            $this->$nama_tabel->select("pur.no_inv as no_transaksi, pur.tgl, pur.no_rangka, 'null', pur.cara_bayar, pur.diskon as spk_diskon, pur.harga as harga_otr, 'null', 'null', 'null', 'null");
            $this->$nama_tabel->from('penjualan_unit_2019 pur');
            $this->$nama_tabel->where('pur.id_perusahaan', $cabang);
            $data2 = $this->$nama_tabel->get_compiled_select();

            $data_all = $this->$nama_tabel->query($data1 . ' UNION ' . $data2)->result();
        } else {
            $this->$nama_tabel->select('pu.no_transaksi, pu.tgl, pu.no_rangka, pu.no_spk, pu.cara_bayar, spk.diskon as spk_diskon, spk.harga_otr as harga_otr, spk.id_leasing, sc.nama, sc.alamat, spk.id_prospek');
            $this->$nama_tabel->from('penjualan_unit pu');
            $this->$nama_tabel->join('s_spk spk', 'spk.no_spk = pu.no_spk');
            $this->$nama_tabel->join('s_customer sc', 'sc.id_prospek = spk.id_prospek');
            $this->$nama_tabel->where('pu.id_perusahaan', $cabang);
            $this->$nama_tabel->where('pu.batal', 'n');
            $this->$nama_tabel->order_by('pu.id_perusahaan');
            $data_all = $this->$nama_tabel->get()->result();
        }


        foreach ($data_all as $key => $row) {
            if ($nama_tabel == 'db_hino') {
                $nama_customer = $this->GetNamaCustomer($row->status_c, $row->id_customer)->row('nama');
                $alamat_customer = $this->GetNamaCustomer($row->status_c, $row->id_customer)->row('alamat');
            } else {
                $nama_customer = $row->nama;
                $alamat_customer = $row->alamat;
            }
            $total_piutang = $this->get_piutang($row->no_spk, $row->no_transaksi, $row->harga_otr, $row->spk_diskon);
            if ($total_piutang <= 0) {
                continue;
            }
            if ($total_piutang != 1.2) {
                $data[] = array(
                    'no_transaksi'      => $row->no_transaksi,
                    'tgl'               => tgl_sql($row->tgl),
                    'no_spk'            => $row->no_spk == 'null' ? '' : $row->no_spk,
                    'no_rangka'         => $row->no_rangka,
                    'no_mesin'          => $this->get_detail_unit_masuk($row->no_rangka)->row('no_mesin'),
                    'nama_customer'     => $nama_customer,
                    'alamat_customer'   => $alamat_customer,
                    'harga_otr'         => $row->harga_otr,
                    'spk_diskon'        => $row->spk_diskon,
                    'leasing'           => $this->get_leasing($row->id_leasing)->row('leasing'),
                    'piutang'           => separator_harga($total_piutang),
                    'cara_bayar'        => $row->cara_bayar,
                    'type'              => $this->type_unit($row->id_prospek),
                );
            }
        }
        // debug($data);
        return $data;
    }

    private function get_detail_unit_masuk($no_rangka)
    {
        $nama_tabel = $this->nama_database_brand();
        $unit_masuk = $this->$nama_tabel->get_where('detail_unit_masuk', array('no_rangka' => $no_rangka));
        return $unit_masuk;
    }

    private function get_leasing($id_leasing)
    {
        $nama_tabel = $this->nama_database_brand();
        $leasing = $this->$nama_tabel->get_where('leasing', array('id_leasing' => $id_leasing));
        return $leasing;
    }

    private function get_piutang($no_spk, $no_transaksi, $harga_otr, $diskon)
    {
        $nama_tabel = $this->nama_database_brand();
        $ar_pembayar = $this->arpembayaran($no_spk, $nama_tabel);
        $pl_bayar = $this->plbayar($no_transaksi, $nama_tabel);
        $koreksibayar = $this->koreksibayar($no_spk, $no_transaksi, $nama_tabel);
        $piutang = $harga_otr - $diskon - $pl_bayar - $ar_pembayar + $koreksibayar;
        return $piutang;
    }

    function arpembayaran($nospk)
    {
        $nama_tabel = $this->nama_database_brand();
        $where = array("pu.no_ref" => $nospk, "pu.posting" => '1', "pu.batal" => "n", "bb.jb" => "0");
        $this->$nama_tabel->select('*');
        $this->$nama_tabel->from('penerimaan_unit pu');
        $this->$nama_tabel->join('buku_besar bb', 'bb.no_transaksi = pu.no_penerimaan', 'left');
        $this->$nama_tabel->where($where);
        $this->$nama_tabel->group_by('bb.no_transaksi');
        $data = $this->$nama_tabel->get();
        foreach ($data->result() as $row) {
            $plbayar[] = $row->total;
        }
        if (empty($plbayar)) {
            $plbayarsum = "0";
        } else {
            $plbayarsum = array_sum($plbayar);
        }

        return $plbayarsum;
    }


    function plbayar($noinvoice)
    {
        $nama_tabel = $this->nama_database_brand();
        $where = array("pu.no_ref" => $noinvoice, "pu.posting" => '1', "pu.batal" => "n", "bb.jb" => "0");
        $this->$nama_tabel->select('total');
        $this->$nama_tabel->from('penerimaan_unit pu');
        $this->$nama_tabel->join('buku_besar bb', 'bb.no_transaksi = pu.no_penerimaan', 'left');
        $this->$nama_tabel->where($where);
        $this->$nama_tabel->group_by('bb.no_transaksi');
        $data = $this->$nama_tabel->get();
        foreach ($data->result() as $row) {
            $plbayar[] = $row->total;
        }
        if (empty($plbayar)) {
            $plbayarsum = "0";
        } else {
            $plbayarsum = array_sum($plbayar);
        }

        return $plbayarsum;
    }

    function koreksibayar($nospk, $noinvoice)
    {
        $nama_tabel = $this->nama_database_brand();
        $where = array("pu.posting" => '1', "pu.batal" => "n", "bb.jb" => "0");
        $this->$nama_tabel->select('*');
        $this->$nama_tabel->from('pengeluaran_unit pu');
        $this->$nama_tabel->join('buku_besar bb', 'bb.no_transaksi = pu.no_bukti_bku', 'left');
        $this->$nama_tabel->where("(pu.no_ref='$nospk' OR pu.no_ref='$noinvoice') AND pu.posting='1' AND bb.jb<>'1'")->group_by('bb.no_transaksi');
        $this->$nama_tabel->where($where);
        $this->$nama_tabel->group_start();
        $this->$nama_tabel->where('pu.no_ref', $nospk);
        $this->$nama_tabel->or_where('pu.no_ref', $noinvoice);
        $this->$nama_tabel->group_end();
        $this->$nama_tabel->group_by('bb.no_transaksi');
        $data = $this->$nama_tabel->get();
        foreach ($data->result() as $row) {
            $hasil[] = $row->total;
        }
        if (empty($hasil)) {
            $hasilsum = "0";
        } else {
            $hasilsum = array_sum($hasil);
        }

        return $hasilsum;
    }

    public function GetDetailData()
    {
        $post = $this->input->post();
        $no_transaksi = $post['no_transaksi'];
        $no_spk = $post['no_spk'];
        $cara_bayar = $post['cara_bayar'];
        $nama_tabel = $this->nama_database_brand();
        // DATA
        $this->$nama_tabel->select('*, spk.diskon as disc_spk');
        $this->$nama_tabel->from('penjualan_unit pu');
        $this->$nama_tabel->join('s_spk spk', 'spk.no_spk = pu.no_spk');
        $this->$nama_tabel->where('no_transaksi', $no_transaksi)->group_by('pu.no_transaksi');
        $data = $this->$nama_tabel->get()->result();

        // DATA1
        $this->$nama_tabel->select('*');
        $this->$nama_tabel->from('penerimaan_unit pu')->join('buku_besar bb', 'bb.no_transaksi=pu.no_penerimaan', 'left');
        $this->$nama_tabel->where("pu.no_ref= '$no_spk' AND pu.posting='1' AND bb.jb<>'1'")->group_by('bb.no_transaksi');
        $data1 = $this->$nama_tabel->get()->result();

        // DATA2
        $this->$nama_tabel->select('*');
        $this->$nama_tabel->from('penerimaan_unit pu')->join('buku_besar bb', 'bb.no_transaksi=pu.no_penerimaan', 'left');
        $this->$nama_tabel->where("pu.no_ref= '$no_transaksi' AND pu.posting='1' AND bb.jb<>'1'")->group_by('bb.no_transaksi');
        $data2 = $this->$nama_tabel->get()->result();

        // DATA5
        $this->$nama_tabel->select('*');
        $this->$nama_tabel->from('pengeluaran_unit pu')->join('buku_besar bb', 'bb.no_transaksi=pu.no_bukti_bku', 'left');
        $this->$nama_tabel->where("(pu.no_ref='$no_spk' OR pu.no_ref='$no_transaksi') AND pu.posting='1' AND bb.jb<>'1'")->group_by('bb.no_transaksi');
        $data5 = $this->$nama_tabel->get()->result();

        if ($cara_bayar == "c") {
            foreach ($data as $row) {
                $result[] = [
                    'no_transaksi' => $row->no_transaksi,
                    'tgl' => tgl_sql($row->tgl),
                    'ket' => 'Buka Invoice',
                    'debet' => $row->harga_otr - $row->disc_spk,
                    'kredit' => 0,
                    'jenis_bayar' => '',

                ];
            }
            foreach ($data1 as $row) {
                $result[] = [
                    'no_transaksi' => $row->no_transaksi,
                    'tgl' => tgl_sql($row->tgl),
                    'ket' => $row->keterangan,
                    'debet' => 0,
                    'kredit' => $row->total,
                    'jenis_bayar' => $row->jenis_bayar == 'tf' ? 'Bank' : 'Kas',
                ];
            }
            foreach ($data2 as $row) {
                $result[] = [
                    'no_transaksi' => $row->no_transaksi,
                    'tgl' => tgl_sql($row->tgl),
                    'ket' => $row->keterangan,
                    'debet' => 0,
                    'kredit' => $row->total,
                    'jenis_bayar' => $row->jenis_bayar == 'tf' ? 'Bank' : 'Kas',
                ];
            }
            foreach ($data5 as $row) {
                $result[] = [
                    'no_transaksi' => $row->no_transaksi,
                    'tgl' => tgl_sql($row->tgl),
                    'ket' => $row->keterangan,
                    'debet' => $row->total,
                    'kredit' => 0,
                    'jenis_bayar' => $row->jenis_bayar == 'tf' ? 'Bank' : 'Kas',
                ];
            }
        } else {
            foreach ($data as $row) {
                $result[] = [
                    'no_transaksi' => $row->no_transaksi,
                    'tgl' => tgl_sql($row->tgl),
                    'ket' => 'Buka Invoice',
                    'debet' => $row->harga_otr - $row->disc_spk,
                    'kredit' => 0,
                    'jenis_bayar' => '',

                ];
            }
            foreach ($data1 as $row) {
                $result[] = [
                    'no_transaksi' => $row->no_transaksi,
                    'tgl' => tgl_sql($row->tgl),
                    'ket' => $row->keterangan,
                    'debet' => 0,
                    'kredit' => $row->total,
                    'jenis_bayar' => $row->jenis_bayar == 'tf' ? 'Bank' : 'Kas',
                ];
            }
            foreach ($data2 as $row) {
                $result[] = [
                    'no_transaksi' => $row->no_transaksi,
                    'tgl' => tgl_sql($row->tgl),
                    'ket' => $row->keterangan,
                    'debet' => 0,
                    'kredit' => $row->total,
                    'jenis_bayar' => $row->jenis_bayar == 'tf' ? 'Bank' : 'Kas',
                ];
            }
            foreach ($data5 as $row) {
                $result[] = [
                    'no_transaksi' => $row->no_transaksi,
                    'tgl' => tgl_sql($row->tgl),
                    'ket' => $row->keterangan,
                    'debet' => $row->total,
                    'kredit' => 0,
                    'jenis_bayar' => $row->jenis_bayar == 'tf' ? 'Bank' : 'Kas',
                ];
            }
        }
        // debug($result);
        return $result;
    }

    private function saldo()
    {
    }
    // --------------------------------------------------------------------------------------------------------
    // GET DATA AGING SCHEDULE
    public function get_data_aging_schedule()
    {
        $nama_tabel = $this->nama_database_brand();
        $post = $this->input->post();
        $cabang = $post['cabang'];
        $tgl_current = tgl_sql($post['tanggal']);
        if ($nama_tabel == 'db_hino') {
            $select = ["sspk.no_spk", "sspk.tgl_spk", "pu.no_transaksi", "pu.tgl", "sspk.nama_stnk", "tp.id_customer", "tp.status_c", "tp.cara_bayar", "sspk.harga_otr", "sspk.diskon"];
            $table  = $nama_tabel . '.penjualan_unit pu';
            $join   = [
                $nama_tabel . '.s_spk sspk' => 'pu.no_spk = sspk.no_spk',
                $nama_tabel . '.tahapan_prospek tp' => 'sspk.id_prospek = tp.id_prospek',
            ];
        } else {
            $select = ["sspk.no_spk", "sspk.tgl_spk", "pu.no_transaksi", "pu.tgl", "sspk.nama_stnk", "sc.nama", "sc.cara_bayar", "sspk.harga_otr", "sspk.diskon"];
            $table  = $nama_tabel . '.penjualan_unit pu';
            $join   = [
                $nama_tabel . '.s_spk sspk' => 'pu.no_spk = sspk.no_spk',
                $nama_tabel . '.s_customer sc' => 'sc.id_prospek = sspk.id_prospek',
            ];
        }

        $where = "pu.batal = 'n' and pu.id_perusahaan = '$cabang' pu.tgl <= '$tgl_current' group by pu.no_transaksi";
        $list = q_data_datatable(
            $select,
            $table,
            $join,
            $where
        );
        debug($list);
        foreach ($list as $i => $row) {
            // $nama_tabel = $this->nama_database_brand();
            // GET NAMA CUSTOMER
            if ($nama_tabel == "db_hino") {
                $nama_ = $this->GetNamaCustomer($row->status_c, $row->id_customer);
            } else {
                $nama_ = $row->nama;
            }

            // if ($this->_menghitung_hari($row->tgl, $tgl_current) == 0) {
            //     $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
            //     if ($sisa_ar == 0) {
            //         null;
            //     } else {
            //         $data_array[] = [
            //             "jenis_penjualan"    => $row->cara_bayar,
            //             "no_spk"        => $row->no_spk,
            //             "tanggal_spk"       => $row->tgl_spk,
            //             "no_invoice"    => $row->no_transaksi,
            //             "tanggal_invoice"   => $row->tgl,
            //             // "nama_team"     => $row->nama_team,
            //             'nama_cutomer_stnk' => $nama_ . " / " . $row->nama_stnk,
            //             "hg_unit" => $row->harga_otr,
            //             "disc"   => $row->diskon,
            //             "current"      => $sisa_ar,
            //             "1_30hr"           => null,
            //             "31_60hr"          => null,
            //             "61_90hr"           => null,
            //             "90hr_"         => null,
            //         ];
            //     }
            // }
            // if ($this->_menghitung_hari($row->tgl, $tgl_current) >= 1 && $this->_menghitung_hari($row->tgl, $tgl_current) <= 30) {
            //     $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
            //     if ($sisa_ar == 0) {
            //         null;
            //     } else {
            //         $data_array[] = [
            //             "jenis_penjualan"    => $row->cara_bayar,
            //             "no_spk"        => $row->no_spk,
            //             "tanggal_spk"       => $row->tgl_spk,
            //             "no_invoice"    => $row->no_transaksi,
            //             "tanggal_invoice"   => $row->tgl,
            //             // "nama_team"     => $row->nama_team,
            //             'nama_cutomer_stnk' => $nama_ . " / " . $row->nama_stnk,
            //             "hg_unit" => $row->harga_otr,
            //             "disc"   => $row->diskon,
            //             "current"      => null,
            //             'nilai_invoice' => "Rp. " . separator_harga($row->harga_otr - $row->diskon),
            //             "1_30hr"           => $sisa_ar,
            //             "31_60hr"          => null,
            //             "61_90hr"           => null,
            //             "90hr_"         => null,
            //         ];
            //     }
            // }
            // if ($this->_menghitung_hari($row->tgl, $tgl_current) >= 31 && $this->_menghitung_hari($row->tgl, $tgl_current) <= 60) {
            //     $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
            //     if ($sisa_ar == 0) {
            //         null;
            //     } else {
            //         $data_array[] = [
            //             "jenis_penjualan"    => $row->cara_bayar,
            //             "no_spk"        => $row->no_spk,
            //             "tanggal_spk"       => $row->tgl_spk,
            //             "no_invoice"    => $row->no_transaksi,
            //             "tanggal_invoice"   => $row->tgl,
            //             // "nama_team"     => $row->nama_team,
            //             'nama_cutomer_stnk' => $nama_ . " / " . $row->nama_stnk,
            //             "hg_unit" => $row->harga_otr,
            //             "disc"   => $row->diskon,
            //             "current"      => null,
            //             'nilai_invoice' => "Rp. " . separator_harga($row->harga_otr - $row->diskon),
            //             "1_30hr"           => null,
            //             "31_60hr"          => $sisa_ar,
            //             "61_90hr"           => null,
            //             "90hr_"         => null,
            //         ];
            //     }
            // }
            // if ($this->_menghitung_hari($row->tgl, $tgl_current) >= 61 && $this->_menghitung_hari($row->tgl, $tgl_current) <= 90) {
            //     $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
            //     if ($sisa_ar == 0) {
            //         null;
            //     } else {
            //         $data_array[] = [
            //             "jenis_penjualan"    => $row->cara_bayar,
            //             "no_spk"        => $row->no_spk,
            //             "tanggal_spk"       => $row->tgl_spk,
            //             "no_invoice"    => $row->no_transaksi,
            //             "tanggal_invoice"   => $row->tgl,
            //             // "nama_team"     => $row->nama_team,
            //             'nama_cutomer_stnk' => $nama_ . " / " . $row->nama_stnk,
            //             "hg_unit" => $row->harga_otr,
            //             "disc"   => $row->diskon,
            //             "current"      => null,
            //             'nilai_invoice' => "Rp. " . separator_harga($row->harga_otr - $row->diskon),
            //             "1_30hr"           => null,
            //             "31_60hr"          => null,
            //             "61_90hr"           => $sisa_ar,
            //             "90hr_"         => null,
            //         ];
            //     }
            // }
            // if ($this->_menghitung_hari($row->tgl, $tgl_current) >= 91) {
            //     $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
            //     if ($sisa_ar == 0) {
            //         null;
            //     } else {
            //         $data_array[] = [
            //             "jenis_penjualan"    => $row->cara_bayar == 'c' ? 'Chas' : 'Kredit',
            //             "no_spk"        => $row->no_spk,
            //             "tanggal_spk"       => $row->tgl_spk,
            //             "no_invoice"    => $row->no_transaksi,
            //             "tanggal_invoice"   => $row->tgl,
            //             // "nama_team"     => $row->nama_team,
            //             'nama_cutomer_stnk' => $nama_ . " / " . $row->nama_stnk,
            //             "hg_unit" => $row->harga_otr,
            //             "disc"   => $row->diskon,
            //             "current"      => null,
            //             'nilai_invoice' => "Rp. " . separator_harga($row->harga_otr - $row->diskon),
            //             "1_30hr"           => null,
            //             "31_60hr"          => null,
            //             "61_90hr"           => null,
            //             "90hr_"         => $sisa_ar,
            //         ];
            //     }
            // }
            // }
            if ($this->_menghitung_hari($row->tgl, $tgl_current) == 0) {
                $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
                $current = $sisa_ar;
                $od1 = 0;
                $od2 = 0;
                $od3 = 0;
                $od4 = 0;
            }
            if ($this->_menghitung_hari($row->tgl, $tgl_current) >= 1 && $this->_menghitung_hari($row->tgl, $tgl_current) <= 30) {
                $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
                $current = 0;
                $od1 = $sisa_ar;
                $od2 = 0;
                $od3 = 0;
                $od4 = 0;
            }
            if ($this->_menghitung_hari($row->tgl, $tgl_current) >= 31 && $this->_menghitung_hari($row->tgl, $tgl_current) <= 60) {
                $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
                $current = 0;
                $od1 = 0;
                $od2 = $sisa_ar;
                $od3 = 0;
                $od4 = 0;
            }
            if ($this->_menghitung_hari($row->tgl, $tgl_current) >= 61 && $this->_menghitung_hari($row->tgl, $tgl_current) <= 90) {
                $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
                $current = 0;
                $od1 = 0;
                $od2 = 0;
                $od3 = $sisa_ar;
                $od4 = 0;
            }
            if ($this->_menghitung_hari($row->tgl, $tgl_current) >= 91) {
                $sisa_ar = ($row->harga_otr - $row->diskon) - ($this->_total_penerimaan($row->no_transaksi, $row->no_spk, $tgl_current) - $this->_total_pengeluaran($row->no_transaksi, $row->no_spk, $tgl_current));
                $current = 0;
                $od1 = 0;
                $od2 = 0;
                $od3 = 0;
                $od4 = $sisa_ar;
            }

            $data_array[] = [
                'no_spk'            => $row->no_spk,
                'tanggal_spk'       => tgl_sql($row->tgl_spk),
                'no_invoice'        => $row->no_transaksi,
                'tanggal_invoice'   => tgl_sql($row->tgl),
                'nama_cutomer_stnk' => $nama_ . " / " . $row->nama_stnk,
                'jenis_penjualan'   => ($row->cara_bayar == "c") ? "Cash" : "Kredit",
                'hg_unit'           => "Rp. " . separator_harga($row->harga_otr),
                'disc'              => "Rp. " . separator_harga($row->diskon),
                'nilai_invoice'     => "Rp. " . separator_harga($row->harga_otr - $row->diskon),
                'current'           => "Rp. " . $current,
                '1_30hr'            => "Rp. " . $od1,
                '31_60hr'           => "Rp. " . $od2,
                '61_90hr'           => "Rp. " . $od3,
                '90hr_'             => "Rp. " . $od4,
            ];
        }
        // debug($data_array);
        return q_result_datatable($select, $table, $join, $where, empty($data_array) ? [] : $data_array);
    }



    // untuk menghitung total penerimaan
    function _total_penerimaan($no_invoice, $no_spk, $tgl_current)
    {
        $nama_tabel = $this->nama_database_brand();
        $where_in = array("$no_spk", "$no_invoice");
        $data = $this->$nama_tabel->select("SUM(total) AS total_penerimaan")
            ->from("penerimaan_unit pu")
            ->join('buku_besar bb', 'pu.no_penerimaan  = bb.no_transaksi', 'left')
            ->where_in("pu.no_ref", $where_in)
            ->where("pu.batal", "n")
            ->where('bb.jb', '0')
            ->where('bb.dk', 'K')
            ->where('pu.tgl <=', $tgl_current)
            ->get();

        $result = $data->row('total_penerimaan');
        return $result;
    }

    // untuk menghitung total pengeluaran
    function _total_pengeluaran($no_invoice, $no_spk, $tgl_current)
    {
        $nama_tabel = $this->nama_database_brand();
        $where_in = array("$no_spk", "$no_invoice");
        $data = $this->$nama_tabel->select('SUM(total) as total_pengeluaran')
            ->from('pengeluaran_unit pu')
            ->join('buku_besar bb', 'bb.no_transaksi = pu.no_bukti_bku', 'left')
            ->where_in("pu.no_ref", $where_in)
            ->where("pu.batal", "n")
            ->where('bb.jb', '0')
            ->where('bb.dk', 'K')
            ->where('pu.tgl <=', $tgl_current)
            ->get();

        $result = $data->row('total_pengeluaran');
        return $result;
    }

    // untuk menghitung hari
    function _menghitung_hari($tgl_penjualan, $tgl_current)
    {
        $start_date = new DateTime($tgl_penjualan);
        $end_date   = new DateTime($tgl_current);
        $interval   = $start_date->diff($end_date);
        return $interval->days;
    }


    // // MENGHITUNG HARI
    // function menghitung_hari($tgl_pembayaran_terakhir)
    // {
    //     $post = $this->input->post();
    //     $date1 = $post['tanggal'];
    //     $date2 = $tgl_pembayaran_terakhir;
    //     $datetime1 = new DateTime($date1);
    //     $datetime2 = new DateTime($date2);
    //     $difference = $datetime1->diff($datetime2);
    //     return $difference->days;
    // }

    // // Penerimaan Unit
    // function penerimaan_unit($no_spk, $no_invoice)
    // {
    //     $where_in = array("$no_spk", "$no_invoice");
    //     $nama_tabel = $this->nama_database_brand();
    //     $this->$nama_tabel->select("SUM(total) AS total_penerimaan");
    //     $this->$nama_tabel->from("penerimaan_unit");
    //     $this->$nama_tabel->where_in("no_ref", $where_in);
    //     $this->$nama_tabel->where("batal", "n");
    //     $data = $this->$nama_tabel->get();
    //     return $data->row("total_penerimaan");
    // }

    // // Kapan Terakhir Bayar
    // function kapan_terakhir_membayar($no_spk, $no_invoice)
    // {
    //     $where_in = array("$no_spk", "$no_invoice");
    //     $nama_tabel = $this->nama_database_brand();
    //     $this->$nama_tabel->select("tgl");
    //     $this->$nama_tabel->from("penerimaan_unit");
    //     $this->$nama_tabel->where_in("no_ref", $where_in);
    //     $this->$nama_tabel->order_by("tgl", "DESC");
    //     $this->$nama_tabel->limit(1);
    //     $data = $this->$nama_tabel->get();
    //     return $data->row("tgl");
    // }
}
