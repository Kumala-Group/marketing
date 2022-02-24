<?php

namespace app\libraries\kumala;


class Akunting
{
    public $codeigniter;
    public $brand;
    public $tgl_awal;
    public $tgl_akhir;
    public $id_perusahaan;
    public $region;
    public $id_bank;
    public $kode_akun;
    public $coverage;
    public $saldo_awal;


    public function __construct()
    {
        $this->codeigniter = get_instance();
        $this->coverage = $this->codeigniter->session->userdata('coverage');
        $this->id_perusahaan = $this->codeigniter->session->userdata('id_perusahaan');
    }


    public function set_brand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    public function set_region($region)
    {
        $this->region = $region;
        return $this;
    }

    public function set_tgl_awal($tgl_awal)
    {
        $this->tgl_awal = $tgl_awal;
        return $this;
    }

    public function set_tgl_akhir($tgl_akhir)
    {
        $this->tgl_akhir = $tgl_akhir;
        return $this;
    }

    public function set_id_perusahaan($id_perusahaan)
    {
        $this->id_perusahaan = $id_perusahaan;
        return $this;
    }

    public function set_id_bank($id_bank)
    {
        $this->id_bank = $id_bank;
        return $this;
    }

    public function set_kode_akun($kode_akun)
    {
        $this->kode_akun = $kode_akun;
        return $this;
    }

    public function set_coverage($coverage)
    {
        $this->coverage = $coverage;
        return $this;
    }

    private function saldo_awal()
    {

        switch ($this->brand) {
            case 'honda':
                $database = $this->codeigniter->db_honda;
                break;
            case 'hino':
                $database = $this->codeigniter->db_hino;
                break;
            case 'mercedes':
                $database = $this->codeigniter->db_mercedes;
                break;
            default:
                die("Brand belum di set");
                break;
        }
        $saldo_awal_manual = 0;
        if (!empty($this->id_bank)) {
            $saldo_awal_manual = $database->query("SELECT saldo_awal FROM bank_saldo WHERE id_bank = '{$this->id_bank}'")->row("saldo_awal");
        } else {
            $region_or_coverage = $this->region ?? $this->coverage;
            $sql = "SELECT SUM(saldo_awal) AS  saldo_awal
            FROM akun_saldo 
            WHERE 1 
            AND " . $this->add_query_filter($this->kode_akun, "kode_akun = '{$this->kode_akun}'") . "
            AND " . $this->add_query_filter($this->id_perusahaan, "id_perusahaan = '{$this->id_perusahaan}'", "id_perusahaan IN ({$region_or_coverage})") . "";
            $saldo_awal_manual = $database->query($sql)->row("saldo_awal");
        }

        $qsa_t = $database->query(
            "SELECT no_transaksi, tgl, keterangan, jumlah as total, dk, kode_akun 
            FROM  buku_besar bb
            WHERE 1
            AND bb.tgl < '{$this->tgl_awal}' 
            AND " . $this->add_query_filter($this->id_bank, "bb.id_bank = '{$this->id_bank}'") . "
            AND " . $this->add_query_filter($this->kode_akun, "bb.kode_akun = '{$this->kode_akun}'") . "
            AND " . $this->add_query_filter($this->id_perusahaan, "bb.id_perusahaan = '{$this->id_perusahaan}'", "bb.id_perusahaan IN ({$region_or_coverage})") . "
        "
        );
        $saldo_awal = 0;
        foreach ($qsa_t->result() as $dat) {
            $jenis_akun = $database->select("SUBSTRING('$dat->kode_akun',1,1) as jenis_akun")->get('akun')->row()->jenis_akun;
            if ($dat->dk == 'D') {
                if ($jenis_akun == '1') {
                    $saldo_awal = $saldo_awal + ((int)$dat->total);
                } else {
                    $saldo_awal = $saldo_awal - ((int)$dat->total);
                }
            } else {
                if ($jenis_akun == '1') {
                    $saldo_awal = $saldo_awal - ((int)$dat->total);
                } else {
                    $saldo_awal = $saldo_awal + ((int)$dat->total);
                }
            }
        }

        $this->saldo_awal =  $saldo_awal + $saldo_awal_manual;
        return $this;
    }

    private function add_query_filter($filter, $query, $else = 1)
    {
        if (!empty($filter)) {
            return $query;
        } else {
            return $else;
        }
    }

    /**
     * get_saldo_awal mengambil saldo awal manual ditambah dengan saldo awal buku besar berdasarkan dari range tanggal yang dipilih
     * @return void
     */
    public function get_saldo_awal()
    {
        $this->saldo_awal();
        return $this->saldo_awal;
    }

    public function get_saldo_awal1($brand, $tgl_awal, $kode_akun, $id_perusahaan, $coverage, $region, $bank)
    {
        $this->brand = $brand;
        $this->tgl_awal = $tgl_awal;
        $this->id_perusahaan = $id_perusahaan;
        if ($region != null) {
            $this->region = $region;
        }
        $this->id_bank = $bank;
        $this->kode_akun = $kode_akun;
        if ($coverage != null) {
            $this->coverage = $coverage;
        }
        $this->saldo_awal();
        return $this->saldo_awal;
    }
}
