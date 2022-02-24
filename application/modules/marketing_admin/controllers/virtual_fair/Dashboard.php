<?php

class Dashboard extends \MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', 'dashboard_digifest')) {
            if ($this->request->ajax()) {
                if ($this->request->has('aktivitas')) {
                    $result = dataDaysOfMonth(date('Y'), date('m'), array(
                        '(SELECT COUNT(id) FROM kumalagroup.reg_customer WHERE  DATE(registered_at)=thisDate) AS registrasi',
                        '(SELECT SUM(visit) FROM kumalagroup.visitor WHERE DATE(tanggal)=thisDate) AS kunjungan'
                    ));
                    foreach ($result as $key => $value) {
                        $registrasi[] = (int)$value->registrasi;
                        $kunjungan[] = (int)$value->kunjungan;
                    }
                    $response = array(array(
                        'name' => 'Registrasi',
                        'data' => $registrasi
                    ), array(
                        'name' => 'Kunjungan',
                        'data' => $kunjungan
                    ));
                } elseif ($this->request->has('transaksi')) {
                    $result = dataDaysOfMonth(date('Y'), date('m'), array(
                        '(SELECT COUNT(checkout.status) FROM kumalagroup.checkout AS checkout
                        JOIN kmg.perusahaan AS p ON p.id_perusahaan = checkout.cabang_tujuan
                        WHERE DATE(created_at)=thisDate AND checkout.status=2 AND p.id_brand=3) AS hino',
                        '(SELECT COUNT(checkout.status) FROM kumalagroup.checkout AS checkout
                        JOIN kmg.perusahaan AS p ON p.id_perusahaan = checkout.cabang_tujuan
                        WHERE DATE(created_at)=thisDate AND checkout.status=2 AND p.id_brand=4) AS mazda',
                        '(SELECT COUNT(checkout.status) FROM kumalagroup.checkout AS checkout
                        JOIN kmg.perusahaan AS p ON p.id_perusahaan = checkout.cabang_tujuan
                        WHERE DATE(created_at)=thisDate AND checkout.status=2 AND p.id_brand=5) AS wuling',
                        '(SELECT COUNT(checkout.status) FROM kumalagroup.checkout AS checkout
                        JOIN kmg.perusahaan AS p ON p.id_perusahaan = checkout.cabang_tujuan
                        WHERE DATE(created_at)=thisDate AND checkout.status=2 AND p.id_brand=17) AS honda',
                        '(SELECT COUNT(checkout.status) FROM kumalagroup.checkout AS checkout
                        JOIN kmg.perusahaan AS p ON p.id_perusahaan = checkout.cabang_tujuan
                        WHERE DATE(created_at)=thisDate AND checkout.status=2 AND p.id_brand=18) AS mercedes'
                    ));
                    foreach ($result as $key => $value) {
                        $hino[] = (int)$value->hino;
                        $mazda[] = (int)$value->mazda;
                        $wuling[] = (int)$value->wuling;
                        $honda[] = (int)$value->honda;
                        $mercedes[] = (int)$value->mercedes;
                    }
                    $response = array(array(
                        'name' => 'Hino',
                        'data' => $hino
                    ), array(
                        'name' => 'Mazda',
                        'data' => $mazda
                    ), array(
                        'name' => 'Wuling',
                        'data' => $wuling
                    ), array(
                        'name' => 'Honda',
                        'data' => $honda
                    ), array(
                        'name' => 'Mercedes-Benz',
                        'data' => $mercedes
                    ));
                }
                return responseJson($response);
            } else {
                $this->load->view('index', array(
                    'content' => 'pages/virtual_fair/dashboard',
                    'index' => 'dashboard_digifest',
                ));
            }
        }
    }
}
