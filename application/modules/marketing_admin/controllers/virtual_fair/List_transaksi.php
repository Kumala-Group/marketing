<?php

use app\modules\elo_models\kumalagroup\mBrand;
use app\modules\elo_models\kumalagroup\mKeranjang;
use Illuminate\Database\Capsule\Manager as DB;

class List_transaksi extends \MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', 'list_transaksi')) {
            if ($this->request->ajax()) {
                if ($this->request->has('getDatatable')) {
                    $select = array(
                        'DATE_FORMAT(kp.tanggal_bayar, \'%d-%m-%Y\') as tanggal',
                        'kp.kode_checkout',
                        'rs.nama',
                        'cs.telepon',
                        'kp.nama_bank',
                        'kp.nama_rekening',
                        'c.uang_muka',
                        'c.diskon',
                        'p.singkat',
                        'p.lokasi',
                        'kp.bukti_bayar',
                        'c.status',
                        'c.id'
                    );
                    $table  = 'kumk6797_kumalagroup.konfirmasi_pembayaran kp';
                    $join   = array(
                        'kumk6797_kumalagroup.checkout c' => 'c.kode = kp.kode_checkout',
                        'kmg.perusahaan p' => 'p.id_perusahaan = c.cabang_tujuan',
                        'kumk6797_kumalagroup.customer cs' => 'cs.customer = c.customer',
                        'kumk6797_kumalagroup.reg_customer rs' => 'rs.id = cs.customer',
                    );
                    if (!empty($this->request->brand) && empty($this->request->cabang)) {
                        $where =  array('p.id_brand' => $this->request->brand);
                    } elseif (!empty($this->request->brand) && !empty($this->request->cabang)) {
                        $where =  array('p.id_brand' => $this->request->brand, 'c.cabang_tujuan' => $this->request->cabang);
                    } else {
                        $where = null;
                    }
                    $list = q_data_datatable($select, $table, $join, $where, null, 'kp.tanggal_bayar desc, rs.nama asc, c.status asc');
                    $data = array();
                    foreach ($list as $value) {
                        array_push($data, array(
                            'tanggal' => $value->tanggal,
                            'kodeCheckout' => $value->kode_checkout,
                            'nama' => $value->nama . ' - ' . $value->telepon,
                            'detailRekening' => $value->nama_bank . ' - ' . $value->nama_rekening,
                            'uangMuka' => separator_harga($value->uang_muka),
                            'cabangTujuan' => $value->lokasi . ' - ' . $value->singkat,
                            'buktiBayar' => $value->bukti_bayar,
                            'status' => $value->status,
                            'id' => $value->id,
                            'potongan' => separator_harga($value->uang_muka - $value->diskon)
                        ));
                    }
                    echo q_result_datatable($select, $table, $join, $where, $data ?? []);
                } elseif ($this->request->has('changeStatus')) {
                    $this->kumalagroup->update(
                        'checkout',
                        array('status' => $this->request->value),
                        array('id' => $this->request->id)
                    );
                    $response = $this->kumalagroup->affected_rows()
                        ? array('status' => 'success')
                        : array('status' => 'error', 'msg' => 'Data gagal diupdate');
                    return responseJson($response);
                } elseif ($this->request->has('detailPembelian')) {
                    $result = mKeranjang::with(array('toUnit.toBrand', 'toUnit.toModel'))
                        ->where('kode_checkout', '=', $this->request->value)
                        ->where('status', '=', 1)->get();
                    foreach ($result as $key => $value) {
                        $response[] = array(
                            'brand' => ucwords($value->toUnit->toBrand->jenis),
                            'model' => $value->toUnit->toModel->nama_model,
                            'jumlah' => $value->status
                        );
                    }
                    return responseJson($response);
                } elseif ($this->request->has('getCabang')) {
                    $dbname = dbname(strtolower($this->request->brand));
                    $result = DB::table($dbname . '.bank as b')
                        ->join('kmg.perusahaan as p', 'p.id_perusahaan', '=', 'b.id_perusahaan')
                        ->where('b.jenis', '=', 'penr_unit')
                        ->where('b.bank', 'like', 'MCU%')
                        ->where('b.bank', 'not like', 'MCU HO%')
                        ->groupBy('b.id_perusahaan')
                        ->get();
                    foreach ($result as $key => $value) {
                        $response[] = array(
                            "id" => $value->id_perusahaan,
                            "text" => $value->lokasi . ' - ' . $value->singkat
                        );
                    }
                    return responseJson($response);
                }
            } else {
                $this->load->view('index', array(
                    'content' => 'pages/virtual_fair/list_transaksi',
                    'index' => 'list_transaksi',
                    'imgServer' => $this->m_marketing->img_server,
                    'brands' => mBrand::all(),
                ));
            }
        }
    }
}
