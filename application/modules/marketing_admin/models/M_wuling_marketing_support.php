<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_wuling_marketing_support extends CI_Model
{
    public function activity()
    {
        $nik['nik'] = $this->session->userdata('nik');
        $coverage   = q_data("*", 'kumalagroup.users', $nik)->row('coverage');

        $select = ["ej.event_jenis", "e.event", "e.tgl_mulai", "e.tgl_selesai", "el.lokasi", "concat('Rp. ',FORMAT(e.total_biaya, 0, 'de_DE')) as total_biaya", "e.id_event"];
        $tabel  = 'db_wuling.event e';
        $join   = [
            'db_wuling.event_jenis ej'  => "e.id_event_jenis=ej.id_event_jenis",
            'db_wuling.event_lokasi el' => "e.id_event_lokasi=el.id_event_lokasi",
            'db_wuling.event_area ea'   => "el.id_event_area=ea.id_event_area",
        ];
        $where = "e.id_perusahaan IN ($coverage)";
        $data  = q_data_datatable($select, $tabel, $join, $where);
        return q_result_datatable($select, $tabel, $join, $where, $data);
    }
    public function customer_spk($id_perusahaan)
    {
        $select = ["s.no_spk", "s.tgl_spk", "c.nama", "at.nama_team", "k.nama_karyawan", "concat(datediff(curdate(),s.tgl_spk), ' Hari') as umur", "if(c.cara_bayar='k','Kredit','Cash') as cara_bayar", "(select sum(total) from db_wuling.penerimaan_unit where no_spk = s.no_spk) as total", "s.no_rangka", "s.keterangan"];
        $table  = 'db_wuling.s_spk s';
        $join   = [
            'db_wuling.s_customer c'           => "c.id_prospek = s.id_prospek",
            'db_wuling.adm_sales as'           => "as.id_sales = c.sales",
            'db_wuling.adm_team_supervisor at' => "at.id_team_supervisor = as.id_leader",
            'kmg.karyawan k'                   => "c.sales = k.id_karyawan",
        ];
        $where = "as.status_aktif='A' and as.id_perusahaan='" . $id_perusahaan . "' and (c.status!='lost' and c.status in('spk'))";

        $list = q_data_datatable($select, $table, $join, $where);
        foreach ($list as $v) {
            $limit = q_data("value", 'db_wuling.setting_tanda_jadi', ['id_perusahaan' => $id_perusahaan])->row('value');

            $arr['no_spk']      = strpos($v->no_spk, 'x') ? substr($v->no_spk, 0, strpos($v->no_spk, 'x')) : $v->no_spk;
            $arr['tgl_spk']     = $v->tgl_spk;
            $arr['customer']    = $v->nama;
            $arr['supervisor']  = $v->nama_team;
            $arr['sales']       = $v->nama_karyawan;
            $arr['umur']        = $v->umur;
            $arr['cara_bayar']  = $v->cara_bayar;
            $arr['total_bayar'] = $v->total >= $limit ? '<div class="tag tag-success">Rp. ' . separator_harga($v->total) . '</div>'
                : '<div class="tag tag-danger">Rp. ' . separator_harga($v->total) . '</div>';
            $arr['status']      = $this->_status($v->no_rangka);
            $arr['keterangan']  = $v->keterangan;
            $d[] = $arr;
        }
        return q_result_datatable($select, $table, $join, $where, empty($d) ? [] : $d);
    }
    function _status($no_rangka)
    {
        if (!empty($no_rangka)) {
            $data = q_data_join(
                "su.status_request,srp.cco,srp.service_advisor,srp.foreman,srp.mekanik,srm.id_karyawan",
                'db_wuling.stok_unit su',
                [
                    'db_wuling.status_request_progress srp' => "srp.no_rangka = su.no_rangka",
                    'db_wuling.status_request_mekanik srm'  => "srp.id_status_request_progress = srm.id_status_request_progress"
                ],
                ['su.no_rangka' => $no_rangka]
            )->result();
            foreach ($data as $v) {
                $sr = $v->status_request;
                $sc = $v->cco;
                $ss = $v->service_advisor;
                $sf = $v->foreman;
                $sm = $v->mekanik;
                if ($sr == 'PDI 1') {
                    $pesan  = 'No. Rangka belum request PDI 2';
                    $follow = 'Admin Sales';
                } else if ($sr == '1' and $sc == '3' and $ss == '3' and $sf == '3' and $sm == '3') {
                    $pesan  = 'No. Rangka belum request PDI 2';
                    $follow = 'Admin Sales';
                } else if ($sr == '2' and $sc == '1') {
                    $pesan  = 'No. Rangka sedang dalam peninjauan PDI 2';
                    $follow = 'CCO';
                } else if ($sr == '2' and $sc == '2' and $ss == '1') {
                    $pesan  = 'No. Rangka sedang dalam peninjauan PDI 2';
                    $follow = 'Service Advisor';
                } else if ($sr == '2' and $sc == '2' and $ss == '2' and $sf == '1') {
                    $pesan  = 'No. Rangka sedang dalam peninjauan PDI 2';
                    $follow = 'Foreman';
                } else if ($sr == '2' and $sc == '2' and $ss == '2' and $sf == '2' and $sm == '1') {
                    $pesan   = 'No. Rangka sedang dalam peninjauan PDI 2';
                    $mekanik = q_data("*", 'kmg.karyawan', ['id_karyawan' => $v->id_karyawan])->row('nama_karyawan');
                    $follow  = 'Mechanic : ' . $mekanik;
                } else if ($sr == '2' and $sc == '0' and $ss == '0' and $sf == '0' and $sm == '0') {
                    $pesan  = 'No. Rangka sedang dalam peninjauan PDI 2';
                    $follow = 'Admin Stock';
                } else if ($sr == '2' and $sc == '3' and $ss == '3' and $sf == '3' and $sm == '3') {
                    $pesan  = 'SPK Menunggu Approval DO';
                    $follow = 'Admin Head';
                } else {
                    $pesan  = 'Error Logic';
                    $follow = 'IT';
                }
            }
        } else {
            $pesan  = 'No. Rangka Belum di Alokasikan';
            $follow = 'Admin sales';
        }
        if (empty($pesan)) {
            $pesan = 'No.Rangka Belum PDI 1';
        }
        return $pesan;
    }
    public function customer_do($id_perusahaan)
    {
        $select = ["s.no_spk", "s.tgl_spk", "c.nama", "at.nama_team", "k.nama_karyawan", "concat(datediff(curdate(),s.tgl_spk), ' Hari') as umur", "if(c.cara_bayar='k','Kredit','Cash') as cara_bayar", "d.tgl_do", "s.keterangan"];
        $table  = 'db_wuling.s_spk s';
        $join   = [
            'db_wuling.s_customer c'           => "c.id_prospek = s.id_prospek",
            'db_wuling.s_do d'                 => "d.id_prospek = s.id_prospek",
            'db_wuling.adm_sales as'           => "as.id_sales = c.sales",
            'db_wuling.adm_team_supervisor at' => "at.id_team_supervisor = as.id_leader",
            'kmg.karyawan k'                   => "c.sales = k.id_karyawan",
        ];
        $where  = ['as.status_aktif' => "A", 'as.id_perusahaan' => $id_perusahaan, 'c.status' => "do"];

        $list = q_data_datatable($select, $table, $join, $where);
        foreach ($list as $v) {
            $arr['no_spk']     = strpos($v->no_spk, 'x') ? substr($v->no_spk, 0, strpos($v->no_spk, 'x')) : $v->no_spk;
            $arr['tgl_spk']    = $v->tgl_spk;
            $arr['customer']   = $v->nama;
            $arr['supervisor'] = $v->nama_team;
            $arr['sales']      = $v->nama_karyawan;
            $arr['umur']       = $v->umur;
            $arr['cara_bayar'] = $v->cara_bayar;
            $arr['tgl_do']     = $v->tgl_do;
            $arr['keterangan'] = $v->keterangan;
            $d[] = $arr;
        }
        return q_result_datatable($select, $table, $join, $where, empty($d) ? [] : $d);
    }
    public function master_customer($id_perusahaan)
    {
        $select = ["c.no_ktp", "c.nama", "c.jenis_kelamin", "s.no_rangka", "um.no_mesin", "u.varian", "m.model", "w.warna", "d.tgl_do"];
        $table  = 'db_wuling.s_customer c';
        $join   = [
            'db_wuling.s_spk s'              => "s.id_prospek = c.id_prospek",
            'db_wuling.s_do d'               => "d.id_prospek = s.id_prospek",
            'db_wuling.detail_unit_masuk um' => "um.no_rangka = s.no_rangka",
            'db_wuling.unit u'               => "u.kode_unit = um.kode_unit",
            'db_wuling.p_varian v'           => "v.id_varian = u.id_varian",
            'db_wuling.p_model m'            => "m.id_model = v.id_model",
            'db_wuling.p_warna w'            => "w.id_warna = u.id_warna",
            'db_wuling.adm_sales as'         => "as.id_sales = c.sales",
            'kmg.karyawan k'                 => "c.sales = k.id_karyawan",
        ];
        $where = empty($id_perusahaan) ? ['as.status_aktif' => "A", 'um.no_mesin!=' => null]
            : ['as.status_aktif' => "A", 'as.id_perusahaan' => $id_perusahaan, 'um.no_mesin!=' => null];
        $group = "um.no_mesin";

        $data = q_data_datatable($select, $table, $join, $where, $group);
        return q_result_datatable($select, $table, $join, $where, $data, $group);
    }
    public function master_customer_export($id_perusahaan)
    {
        $select = "c.nama,c.jenis_kelamin,c.no_ktp,s.no_rangka,um.no_mesin,u.varian,m.model,w.warna,d.tgl_do,c.agama,c.pekerjaan,c.tgl_lahir,concat(timestampdiff(year, c.tgl_lahir, curdate()), ' Tahun') as usia,c.alamat,pro.nama as provinsi,kab.nama as kabupaten,kec.nama as kecamatan,kel.nama as kelurahan,c.telepone,c.email,p.lokasi";
        $table = 'db_wuling.s_customer c';
        $join = [
            'db_wuling.s_spk s'              => "s.id_prospek = c.id_prospek",
            'db_wuling.s_do d'               => "d.id_prospek = s.id_prospek",
            'db_wuling.detail_unit_masuk um' => "um.no_rangka = s.no_rangka",
            'db_wuling.unit u'               => "u.kode_unit = um.kode_unit",
            'db_wuling.p_varian v'           => "v.id_varian = u.id_varian",
            'db_wuling.p_model m'            => "m.id_model = v.id_model",
            'db_wuling.p_warna w'            => "w.id_warna = u.id_warna",
            'db_wuling.adm_sales as'         => "as.id_sales = c.sales",
            'kmg.karyawan k'                 => "c.sales = k.id_karyawan",
            'db_wuling.provinsi pro'         => "pro.id_provinsi = c.id_provinsi",
            'db_wuling.kabupaten kab'        => "kab.id_kabupaten = c.id_kabupaten",
            'db_wuling.kecamatan kec'        => "kec.id_kecamatan = c.id_kecamatan",
            'db_wuling.kelurahan kel'        => "kel.id_kelurahan = c.id_kelurahan",
            'kmg.perusahaan p'               => "p.id_perusahaan = s.id_perusahaan"
        ];
        $where = empty($id_perusahaan) ? ['as.status_aktif' => "A", 'um.no_mesin!=' => null]
            : ['as.status_aktif' => "A", 'as.id_perusahaan' => $id_perusahaan, 'um.no_mesin!=' => null];
        $group = "um.no_mesin";
        return q_data_join($select, $table, $join, $where, [], $group)->result();
    }

    public function master_survei_do($id_perusahaan)
    {
        $select = ["c.nama", "c.jenis_kelamin", "c.tgl_lahir", "concat(timestampdiff(year, c.tgl_lahir, curdate()), ' Tahun') as usia", "c.telepone", "c.email", "c.alamat"];
        $table  = 'db_wuling.s_customer c';
        $join   = [
            'db_wuling.s_prospek p'  => "p.id_prospek = c.id_prospek",
            'db_wuling.adm_sales as' => "as.id_sales = c.sales",
            'kmg.karyawan k'         => "c.sales = k.id_karyawan",
        ];
        $where = empty($id_perusahaan) ? ['as.status_aktif' => "A", 'c.status' => "do"]
            :  ['as.status_aktif' => "A", 'as.id_perusahaan' => $id_perusahaan, 'c.status' => "do"];

        $data = q_data_datatable($select, $table, $join, $where);
        return q_result_datatable($select, $table, $join, $where, $data);
    }

    public function get_survei_do($id_perusahaan, $tahun, $bulan)
    {
        $select = [
            null, 'c.id_prospek', 'c.nama', 'c.jenis_kelamin', 'c.tgl_lahir', 'c.telepone', 'c.email', 'c.alamat', 'c.id_kabupaten', 'c.id_sumber_prospek', 'c.cara_bayar', 'c.sales',
            'sp.jml_keluarga', 'sp.id_media', 'sp.kode_unit',
            'spk.id_leasing', 'spk.id_perusahaan',
            'sdo.tgl_do',
            'sv.status_nikah', 'sv.alamat_domisili', 'sv.pekerjaan', 'sv.pekerjaan_lain', 'sv.bidang_usaha', 'sv.pengeluaran', 'sv.pendapatan', 'sv.hobi', 'sv.hobi_lain', 'sv.tempat_favorit',
            'sv.tempat_favorit_lain', 'sv.tahu_kumala', 'sv.alasan_beli', 'sv.alasan_beli_lain', 'sv.dp', 'sv.atas_permintaan', 'sv.status_mobil_saat_ini', 'sv.detail_mobil_sebelumnya', 'sv.rating',
            'sv.tgl_survei'
        ];
        $table  = 'db_wuling.s_spk spk';
        $join   = [
            'db_wuling.s_customer c'    => 'c.id_prospek = spk.id_prospek',
            'db_wuling.s_prospek sp'    => 'sp.id_prospek = c.id_prospek',
            'db_wuling.s_do sdo'        => 'sdo.id_prospek = c.id_prospek',
            'db_wuling.s_survei sv'     => 'sv.id_prospek = c.id_prospek',
            'db_wuling.adm_sales as'   => 'as.id_sales = c.sales',
            'kmg.karyawan k'            => 'c.sales = k.id_karyawan',
        ];
        if (!empty($id_perusahaan)) {
            $where  = ['as.status_aktif' => "A", 'as.id_perusahaan' => $id_perusahaan, 'c.status' => "do", 'MONTH(sdo.tgl_do)' => $bulan, 'YEAR(sdo.tgl_do)' => $tahun];
        } else {
            $where  = ['as.status_aktif' => "A", 'c.status' => "do", 'MONTH(sdo.tgl_do)' => $bulan, 'YEAR(sdo.tgl_do)' => $tahun];
        }
        $query_survei = q_data_datatable($select, $table, $join, $where, null, null, true);

        foreach ($query_survei as $survei) {
            $nama_kota                 = $this->db_wuling->select('nama')->from('kabupaten')->where('id_kabupaten', $survei->id_kabupaten)->get()->row('nama');
            $sumber_prospek         = $this->db_wuling->select('sumber_prospek')->from('p_sumber_prospek')->where('id_sumber_prospek', $survei->id_sumber_prospek)->get()->row('sumber_prospek');
            $media_motivator        = $this->db_wuling->select('media')->from('p_media')->where('id_media', $survei->id_media)->get()->row('media');
            $tipe_unit              = $this->db_wuling->select('varian')->from('unit')->where('kode_unit', $survei->kode_unit)->get()->row('varian');
            if ($survei->cara_bayar == 'k') {
                $leasing            = $this->db_wuling->select('leasing')->from('leasing')->where('id_leasing', $survei->id_leasing)->get()->row('leasing');
                $angsuran           = $this->db_wuling->select('cicilan')->from('s_hot_prospek')->where('id_prospek', $survei->id_prospek)->get()->row('cicilan');
                $tenor              = $this->db_wuling->select('tenor')->from('s_hot_prospek')->where('id_prospek', $survei->id_prospek)->get()->row('tenor');
            } else {
                $leasing            = 'Pembelian Cash';
                $angsuran           = 0;
                $tenor              = 0;
            }
            $lokasi_dealer          = $this->db->select('lokasi')->from('perusahaan')->where('id_perusahaan', $survei->id_perusahaan)->get()->row('lokasi');
            $nama_sales             = $this->db->select('nama_karyawan')->from('karyawan')->where('id_karyawan', $survei->sales)->get()->row('nama_karyawan');
            if ($survei->status_nikah == 'l') {
                $status_nikah         = 'Lajang';
            } else {
                $status_nikah         = 'Menikah';
            };
            $data_survei[] = array(
                //'no'				=> $no++,                
                'nama'              => strtoupper($survei->nama),
                'alamat'            => $survei->alamat,
                'tgl_lahir'         => tgl_sql($survei->tgl_lahir),
                'usia'                => $this->_hitung_usia(tgl_sql($survei->tgl_lahir)),
                'jenis_kelamin'     => strtoupper($survei->jenis_kelamin),
                'status_nikah'      => $this->_get_status_nikah($survei->status_nikah),
                'jml_keluarga'      => $survei->jml_keluarga,
                'telepone'          => $survei->telepone,
                'email'              => $survei->email,
                'alamat'            => $survei->alamat,
                'alamat_domisili'   => $survei->alamat_domisili,
                'kota'              => $nama_kota,
                'pekerjaan'         => $this->_get_pekerjaan($survei->pekerjaan),
                'pekerjaan_lain'     => $survei->pekerjaan_lain,
                'bidang_usaha'        => $survei->bidang_usaha,
                'pengeluaran'       => $this->_get_pendapatan($survei->pengeluaran),
                'pendapatan'        => $this->_get_pendapatan($survei->pendapatan),
                'hobi'              => $this->_get_hobi($survei->hobi),
                'hobi_lain'         => $survei->hobi_lain,
                'tempat_favorit'    => $this->_get_tempat_favorit($survei->tempat_favorit),
                'tempat_favorit_lain' => $survei->tempat_favorit_lain,
                'sumber_prospek'     => $sumber_prospek,
                'media_motivator'     => $media_motivator,
                'tipe_unit'         => $tipe_unit,
                'tahu_kumala'         => ($survei->tahu_kumala == 'y') ? 'Ya' : 'Tidak',
                'alasan_beli'       => $this->_get_alasan_beli($survei->alasan_beli),
                'alasan_beli_lain'     => $survei->alasan_beli_lain,
                'cara_bayar'        => ($survei->cara_bayar == 'k') ? 'Kredit' : 'Cash',
                'dp'                => $this->_get_dp($survei->dp),
                'leasing'           => $leasing,
                'angsuran'          => 'Rp' . separator_harga($angsuran),
                'tenor'             => $tenor . ' bulan',
                'atas_permintaan'   => $this->_get_atas_permintaan($survei->atas_permintaan),
                'status_mobil_saat_ini' => $this->_get_status_mobil($survei->status_mobil_saat_ini),
                'detail_mobil_sebelumnya' => $survei->detail_mobil_sebelumnya,
                'dealer'            => 'Wuling Kumala ' . ucfirst(strtolower($lokasi_dealer)),
                'rating'            => $survei->rating,
                'tgl_do'            => tgl_sql($survei->tgl_do),
                'nama_sales'        => $nama_sales,
                'tgl_survei'         => tgl_sql($survei->tgl_survei),
            );
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_survei) ? [] : $data_survei, null, true);
    }

    public function get_nama_perusahaan($id_perusahaan)
    {
        if (!empty($id_perusahaan)) {
            $hasil = $this->db->select('lokasi')->from('kmg.perusahaan')->where("id_perusahaan", $id_perusahaan)->get()->row()->lokasi;
            return $hasil;
        }
    }

    public function get_survei_do_export($id_perusahaan, $tahun, $bulan)
    {
        $data_survei  = array();
        if (!empty($id_perusahaan)) {
            $this->db->where("as.status_aktif='A' AND as.id_perusahaan='$id_perusahaan' AND c.status='do' AND MONTH(sdo.tgl_do)=$bulan AND YEAR(sdo.tgl_do)=$tahun");
        } else {
            $this->db->where("as.status_aktif='A' AND c.status='do' AND MONTH(sdo.tgl_do)=$bulan AND YEAR(sdo.tgl_do)=$tahun");
        }
        $query_survei = $this->db
            ->select('c.id_prospek,c.nama,c.jenis_kelamin,c.tgl_lahir,c.telepone,c.email,c.alamat,c.id_kabupaten,c.id_sumber_prospek,c.cara_bayar,c.sales,
					sp.jml_keluarga,sp.id_media,sp.kode_unit,
					spk.id_leasing,spk.id_perusahaan,
					sdo.tgl_do,
					sv.status_nikah,sv.alamat_domisili,sv.pekerjaan,sv.pekerjaan_lain,sv.bidang_usaha,sv.pengeluaran,sv.pendapatan,sv.hobi,sv.hobi_lain,sv.tempat_favorit,
					sv.tempat_favorit_lain,sv.tahu_kumala,sv.alasan_beli,sv.alasan_beli_lain,sv.dp,sv.atas_permintaan,sv.status_mobil_saat_ini,sv.detail_mobil_sebelumnya,sv.rating,
					sv.tgl_survei')
            ->from('db_wuling.s_spk spk')
            ->join('db_wuling.s_customer c', 'c.id_prospek = spk.id_prospek')
            ->join('db_wuling.s_prospek sp', 'sp.id_prospek = c.id_prospek')
            ->join('db_wuling.s_do sdo', 'sdo.id_prospek = c.id_prospek')
            ->join('db_wuling.s_survei sv', 'sv.id_prospek = c.id_prospek')
            ->join('db_wuling.adm_sales as', 'as.id_sales = c.sales')
            ->join('kmg.karyawan k', 'c.sales = k.id_karyawan')
            ->get();

        if ($query_survei->num_rows() > 0) {
            $no = 1;
            foreach ($query_survei->result() as $survei) {
                $nama_kota                 = $this->db_wuling->select('nama')->from('kabupaten')->where('id_kabupaten', $survei->id_kabupaten)->get()->row('nama');
                $sumber_prospek         = $this->db_wuling->select('sumber_prospek')->from('p_sumber_prospek')->where('id_sumber_prospek', $survei->id_sumber_prospek)->get()->row('sumber_prospek');
                $media_motivator        = $this->db_wuling->select('media')->from('p_media')->where('id_media', $survei->id_media)->get()->row('media');
                $tipe_unit              = $this->db_wuling->select('varian')->from('unit')->where('kode_unit', $survei->kode_unit)->get()->row('varian');
                if ($survei->cara_bayar == 'k') {
                    $leasing            = $this->db_wuling->select('leasing')->from('leasing')->where('id_leasing', $survei->id_leasing)->get()->row('leasing');
                    $angsuran           = $this->db_wuling->select('cicilan')->from('s_hot_prospek')->where('id_prospek', $survei->id_prospek)->get()->row('cicilan');
                    $tenor              = $this->db_wuling->select('tenor')->from('s_hot_prospek')->where('id_prospek', $survei->id_prospek)->get()->row('tenor');
                } else {
                    $leasing            = 'Pembelian Cash';
                    $angsuran           = 0;
                    $tenor              = 0;
                }
                $lokasi_dealer          = $this->db->select('lokasi')->from('perusahaan')->where('id_perusahaan', $survei->id_perusahaan)->get()->row('lokasi');
                $nama_sales             = $this->db->select('nama_karyawan')->from('karyawan')->where('id_karyawan', $survei->sales)->get()->row('nama_karyawan');
                //data_survei
                if ($survei->status_nikah == 'l') {
                    $status_nikah         = 'Lajang';
                } else {
                    $status_nikah         = 'Menikah';
                };
                //klasifikasi pekerjaan, jika pekerjaan lain, tetap masukkan di pekerjaan
                $pekerjaan     = $this->_get_pekerjaan($survei->pekerjaan);
                if ($pekerjaan == 'Yang Lain') {
                    $pekerjaan = $survei->pekerjaan_lain;
                }

                $data_survei[] = array(
                    'no'                => $no++,
                    'nama'              => strtoupper($survei->nama),
                    'alamat'            => $survei->alamat,
                    'tgl_lahir'         => tgl_sql($survei->tgl_lahir),
                    'usia'                => $this->_hitung_usia(tgl_sql($survei->tgl_lahir)),
                    'jenis_kelamin'     => strtoupper($survei->jenis_kelamin),
                    'status_nikah'      => $this->_get_status_nikah($survei->status_nikah),
                    'jml_keluarga'      => $survei->jml_keluarga,
                    'telepone'          => $survei->telepone,
                    'email'              => $survei->email,
                    'alamat'            => $survei->alamat,
                    'alamat_domisili'   => $survei->alamat_domisili,
                    'kota'              => $nama_kota,
                    'pekerjaan'         => $pekerjaan,
                    //'pekerjaan_lain' 	=> $survei->pekerjaan_lain,
                    'bidang_usaha'        => $survei->bidang_usaha,
                    'pengeluaran'       => $this->_get_pendapatan($survei->pengeluaran),
                    'pendapatan'        => $this->_get_pendapatan($survei->pendapatan),
                    'hobi'              => $this->_get_hobi($survei->hobi),
                    'hobi_lain'         => $survei->hobi_lain,
                    'tempat_favorit'    => $this->_get_tempat_favorit($survei->tempat_favorit),
                    'tempat_favorit_lain' => $survei->tempat_favorit_lain,
                    'sumber_prospek'     => $sumber_prospek,
                    'media_motivator'     => $media_motivator,
                    'tipe_unit'         => $tipe_unit,
                    'tahu_kumala'         => ($survei->tahu_kumala == 'y') ? 'Ya' : 'Tidak',
                    'alasan_beli'       => $this->_get_alasan_beli($survei->alasan_beli),
                    'alasan_beli_lain'     => $survei->alasan_beli_lain,
                    'cara_bayar'        => ($survei->cara_bayar == 'k') ? 'Kredit' : 'Cash',
                    'dp'                => $this->_get_dp($survei->dp),
                    'leasing'           => $leasing,
                    'angsuran'          => 'Rp' . separator_harga($angsuran),
                    'tenor'             => $tenor . ' bulan',
                    'atas_permintaan'   => $this->_get_atas_permintaan($survei->atas_permintaan),
                    'status_mobil_saat_ini' => $this->_get_status_mobil($survei->status_mobil_saat_ini),
                    'detail_mobil_sebelumnya' => $survei->detail_mobil_sebelumnya,
                    'dealer'            => 'Wuling Kumala ' . ucfirst(strtolower($lokasi_dealer)),
                    'rating'            => $survei->rating,
                    'tgl_do'            => tgl_sql($survei->tgl_do),
                    'nama_sales'        => $nama_sales,
                    'tgl_survei'         => tgl_sql($survei->tgl_survei),
                );
            }
        }
        $hasil = $data_survei;
        return $hasil;
    }

    public function master_survei_do_export($id_perusahaan)
    {
        $select = "c.nama,c.jenis_kelamin,c.tgl_lahir,concat(timestampdiff(year, c.tgl_lahir, curdate()), ' Tahun') as usia,c.telepone,c.email,c.alamat,pro.nama as provinsi,kab.nama as kabupaten,kec.nama as kecamatan,kel.nama as kelurahan,c.pekerjaan,p.pengeluaran,p.pendapatan,p.status_nikah,p.jml_keluarga,if(c.cara_bayar='k','Kredit','Cash') as cara_bayar,p.merek_mobil_sebelumnya,p.tipe_mobil_sebelumnya,p.status_mobil,p.alasan_beli";
        $table  = 'db_wuling.s_customer c';
        $join   = [
            'db_wuling.s_prospek p'   => "p.id_prospek = c.id_prospek",
            'db_wuling.adm_sales as'  => "as.id_sales = c.sales",
            'kmg.karyawan k'          => "c.sales = k.id_karyawan",
            'db_wuling.provinsi pro'  => "pro.id_provinsi = c.id_provinsi",
            'db_wuling.kabupaten kab' => "kab.id_kabupaten = c.id_kabupaten",
            'db_wuling.kecamatan kec' => "kec.id_kecamatan = c.id_kecamatan",
            'db_wuling.kelurahan kel' => "kel.id_kelurahan = c.id_kelurahan",
        ];
        $where = empty($id_perusahaan) ? ['as.status_aktif' => "A", 'c.status' => "do"]
            :  ['as.status_aktif' => "A", 'as.id_perusahaan' => $id_perusahaan, 'c.status' => "do"];
        return q_data_join($select, $table, $join, $where)->result();
    }

    //**** static pustaka functions ****/
    private function _hitung_usia($tgl_lahir)
    {
        $tahun = '';
        if (!empty($tgl_lahir)) {
            $today = date('Y-m-d');
            $now = time($today);
            $selisih = $now - strtotime($tgl_lahir);
            $tahun = floor($selisih / (60 * 60 * 24 * 365)) . ' Tahun';
        }
        return $tahun;
    }

    private function _get_status_nikah($status)
    {
        $status_nikah = '';
        if (!empty($status)) {
            switch ($status) {
                case 'l':
                    $status_nikah = 'Lajang';
                    break;
                case 'm':
                    $status_nikah = 'Menikah';
                    break;
                default:
                    $status_nikah = '';
                    break;
            }
        }
        return $status_nikah;
    }

    private function  _get_pekerjaan($id)
    {
        $pk = '';
        if (!empty($id)) {
            switch ($id) {
                case 'pk01':
                    $pk = 'PNS';
                    break;
                case 'pk02':
                    $pk = 'Pegawai BUMN';
                    break;
                case 'pk03':
                    $pk = 'TNI/Polri';
                    break;
                case 'pk04':
                    $pk = 'Dokter/Tenaga Medis';
                    break;
                case 'pk05':
                    $pk = 'Wiraswasta';
                    break;
                case 'pk06':
                    $pk = 'Kontraktor';
                    break;
                case 'pk07':
                    $pk = 'Pegawai Swasta';
                    break;
                case 'pk08':
                    $pk = 'Pedagang';
                    break;
                case 'pk09':
                    $pk = 'Petani/Pekebun';
                    break;
                case 'pk00':
                    $pk = 'Yang Lain';
                    break;
            }
        }
        return $pk;
    }

    private function  _get_pendapatan($id)
    {
        $p = '';
        if (!empty($id)) {
            switch ($id) {
                case 'rp01':
                    $p = '< Rp2.500.000';
                    break;
                case 'rp02':
                    $p = 'Rp2.500.001 - Rp5.000.000';
                    break;
                case 'rp03':
                    $p = 'Rp5.000.001 - Rp7.500.000';
                    break;
                case 'rp04':
                    $p = 'Rp7.500.001 - Rp10.000.000';
                    break;
                case 'rp05':
                    $p = 'Rp10.000.001 - Rp12.500.000';
                    break;
                case 'rp06':
                    $p = 'Rp12.500.001 - Rp15.000.000';
                    break;
                case 'rp07':
                    $p = '> Rp15.000.000';
                    break;
            }
        }
        return $p;
    }

    private function  _get_hobi($id)
    {
        $hobi = '';
        if (!empty($id)) {
            switch ($id) {
                case 'hb01':
                    $hobi = 'Bulu Tangkis';
                    break;
                case 'hb02':
                    $hobi = 'Tenis Meja';
                    break;
                case 'hb03':
                    $hobi = 'Fitness';
                    break;
                case 'hb04':
                    $hobi = 'Basket';
                    break;
                case 'hb05':
                    $hobi = 'Musik';
                    break;
                case 'hb06':
                    $hobi = 'Memasak';
                    break;
                case 'hb07':
                    $hobi = 'Menonton Film';
                    break;
                case 'hb08':
                    $hobi = 'Party';
                    break;
                case 'hb00':
                    $hobi = 'Hobi Lain';
                    break;
            }
        }
        return $hobi;
    }

    private function  _get_tempat_favorit($id)
    {
        $tfav = '';
        if (!empty($id)) {
            switch ($id) {
                case 'fav01':
                    $tfav = 'Cafe/Restoran';
                    break;
                case 'fav02':
                    $tfav = 'Mall';
                    break;
                case 'fav03':
                    $tfav = 'Pantai';
                    break;
                case 'fav04':
                    $tfav = 'Tempat Olahraga';
                    break;
                case 'fav05':
                    $tfav = 'Jogging Track';
                    break;
                case 'fav06':
                    $tfav = 'Car Free Day';
                    break;
                case 'fav00':
                    $tfav = 'Tempat yang lain';
                    break;
            }
        }
        return $tfav;
    }

    private function  _get_alasan_beli($id)
    {
        $ab = '';
        if (!empty($id)) {
            switch ($id) {
                case 'ab01':
                    $ab = 'Harga';
                    break;
                case 'ab02':
                    $ab = 'Fitur';
                    break;
                case 'ab03':
                    $ab = 'Desain';
                    break;
                case 'ab04':
                    $ab = 'Kenyamanan';
                    break;
                case 'ab05':
                    $ab = 'Hemat Bahan Bakar';
                    break;
                case 'ab00':
                    $ab = 'Alasan Lain';
                    break;
            }
        }
        return $ab;
    }

    private function  _get_dp($id)
    {
        $dp = '';
        if (!empty($id)) {
            switch ($id) {
                case 'dp00':
                    $dp = 'Pembelian Cash (Tanpa DP)';
                    break;
                case 'dp01':
                    $dp = '5%';
                    break;
                case 'dp02':
                    $dp = '15%';
                    break;
                case 'dp03':
                    $dp = '20%';
                    break;
                case 'dp04':
                    $dp = '25%';
                    break;
                case 'dp05':
                    $dp = '30%';
                    break;
                case 'dp06':
                    $dp = '35%';
                    break;
                case 'dp07':
                    $dp = '40%';
                    break;
                case 'dp08':
                    $dp = '45%';
                    break;
                case 'dp09':
                    $dp = 'Lebih dari 45%';
                    break;
            }
        }
        return $dp;
    }

    private function  _get_atas_permintaan($id)
    {
        $pm = '';
        if (!empty($id)) {
            switch ($id) {
                case 'pm01':
                    $pm = 'Sendiri';
                    break;
                case 'pm02':
                    $pm = 'Suami';
                    break;
                case 'pm03':
                    $pm = 'Istri';
                    break;
                case 'pm04':
                    $pm = 'Anak';
                    break;
                case 'pm05':
                    $pm = 'Orang Tua';
                    break;
                case 'pm06':
                    $pm = 'Kerabat';
                    break;
            }
        }
        return $pm;
    }

    private function  _get_status_mobil($id)
    {
        $sm = '';
        if (!empty($id)) {
            switch ($id) {
                case 'sm01':
                    $sm = 'Pembelian Mobil Pertama';
                    break;
                case 'sm02':
                    $sm = 'Mengganti Mobil Sebelumnya';
                    break;
                case 'sm03':
                    $sm = 'Penambahan Mobil';
                    break;
            }
        }
        return $sm;
    }
    //** **//

    public function nama_bulan()
    {
        $nama_bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $hasil = $nama_bulan;
        return $hasil;
    }

    public function cabang($coverage = NULL)
    {
        $query = $this->db->query("SELECT id_perusahaan,singkat,lokasi FROM perusahaan WHERE id_brand='5' AND id_perusahaan IN ($coverage) ORDER BY lokasi");
        $hasil = $query->result();
        return $hasil;
    }

    public function get_data_test_drive($id_perusahaan, $tahun, $bulan)
    {
        $select = [
            'td.id_prospek', 'as.id_perusahaan', 'td.tahapan',
            'k.nama_karyawan', 'c.sales', 'c.nama', 'c.telepone',
            'pv.varian',
            'td.tgl_jam', 'td.tempat',
            'p.lokasi', 'td.verified',
            'td.id_test_drive', 'td.id_model', 'td.id_varian'
        ];
        $table  = 'db_wuling.s_customer c';
        $join   = [
            'db_wuling.adm_sales as'     => 'as.id_sales = c.sales',
            'db_wuling.s_suspect ss'     => 'ss.id_prospek = c.id_prospek',
            'kmg.karyawan k'             => 'c.sales = k.id_karyawan',
            'kmg.perusahaan p'            => 'p.id_perusahaan = as.id_perusahaan',
            'db_wuling.s_test_drive td'    => 'td.id_prospek = c.id_prospek',
            'db_wuling.p_model pm'         => 'pm.id_model = td.id_model',
            'db_wuling.p_varian pv'     => 'pv.id_varian = td.id_varian',
        ];
        if (!empty($id_perusahaan)) {
            $where     = "YEAR(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$tahun' AND MONTH(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$bulan' AND as.id_perusahaan='$id_perusahaan' AND td.status='1' ";
            //$where 	= "td.status='1' AND YEAR(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$tahun' AND MONTH(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$bulan' AND as.id_perusahaan='$id_perusahaan'";
        } else {
            //$id_perusahaan = q_data("GROUP_CONCAT(id_perusahaan)", 'kmg.perusahaan', ['id_brand' => 5])->result();
            $id_perusahaan = $this->db->query("SELECT GROUP_CONCAT(id_perusahaan) as id FROM perusahaan WHERE id_brand='5'")->row('id');
            $where     = "YEAR(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$tahun' AND MONTH(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$bulan' AND as.id_perusahaan IN($id_perusahaan) AND td.status='1' ";
            //$where 	= "td.status='1' AND YEAR(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$tahun' AND MONTH(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$bulan' AND as.id_perusahaan IN($id_perusahaan)";
        }
        $query_testdrive = q_data_datatable($select, $table, $join, $where, null, null, true);

        foreach ($query_testdrive as $testdrive) {
            $id_team_supervisor = $this->db_wuling->query("SELECT id_leader FROM adm_sales WHERE id_sales='$testdrive->sales'")->row("id_leader");
            $nama_spv = $this->db_wuling->query("SELECT nama_team FROM adm_team_supervisor WHERE id_team_supervisor = '$id_team_supervisor'")->row("nama_team");
            $v_tempat = '';
            switch ($testdrive->tempat) {
                case 'd':
                    $v_tempat = 'Dealer';
                    break;
                case 'r':
                    $v_tempat = 'Rumah Customer';
                    break;
                case 'k':
                    $v_tempat = 'Kantor';
                    break;
                case 'p':
                    $v_tempat = 'Area Publik';
                    break;
                case 'l':
                    $v_tempat = 'Lain-lain';
                    break;
            }
            $v_jam = date("H:i", strtotime($testdrive->tgl_jam));
            $v_tgl = tgl_sql(date("Y-m-d", strtotime($testdrive->tgl_jam)));
            $data_testdrive[] = array(
                'cabang'        => $testdrive->lokasi,
                'id_test_drive'    => $testdrive->id_test_drive,
                'id_prospek'    => $testdrive->id_prospek,
                'sales'         => strtoupper($testdrive->nama_karyawan),
                'spv'            => $nama_spv,
                'customer'         => $testdrive->nama,
                'telepone'         => $testdrive->telepone,
                'model'         => $testdrive->varian,
                'waktu'         => $v_tgl . ' Pukul ' . $v_jam,
                'tempat'         => $v_tempat,
                'verified'         => $testdrive->verified,
                'tahapan'        => strtoupper(str_replace('_', ' ', $testdrive->tahapan)),
            );
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_testdrive) ? [] : $data_testdrive, null, true);
    }

    public function verifikasi_test_drive($id_test_drive)
    {
        $approve = $this->db_wuling
            ->set('td.verified', '1')
            ->where('td.id_test_drive', $id_test_drive)
            ->update('s_test_drive td');
        if ($this->db_wuling->affected_rows() > 0) {
            $hasil = 'Verifikasi test drive sukses !';
            header('Content-Type: application/json');
            echo json_encode($hasil);
        } else {
            return false;
        }
    }
}
