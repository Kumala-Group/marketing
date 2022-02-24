<?php

use app\modules\elo_models\kumalagroup\mBrand;
use app\modules\elo_models\kumalagroup\mUnitDetail;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Str;

class Fitur_360 extends \MX_Controller
{
    private static $index = '360Fitur';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('m_marketing');
    }

    public function index()
    {
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', self::$index)) {
            if ($this->request->ajax()) {
                if ($this->request->has('_getBrand')) {
                    return self::getBrand();
                } elseif ($this->request->has('_getModel')) {
                    return self::getModel($this->request->brand);
                }

                if ($this->request->has('_getData')) {
                    return self::getData($this->request->unit);
                }

                if ($this->request->has('_submit')) {
                    return self::submit($this->request->all(), $this->m_marketing->generate_kode(5), $this->m_marketing->img_server);
                }
            }

            $index   = self::$index;
            $content = 'pages/master_app/fitur_360.html';

            return $this->load->view('index', compact('index', 'content'));
        }
    }

    private static function getBrand()
    {
        $result = mBrand::all();
        foreach ($result as $key => $value) {
            $response[] = array(
                'id'   => encrypter($value->id),
                'text' => Str::title($value->jenis)
            );
        }

        return responseJson($response);
    }

    private static function getModel($brand)
    {
        $brand = encrypter($brand, 'decrypt');

        $result = mBrand::with('toUnit.toModel:brand,id,nama_model')->find($brand);
        foreach ($result->toUnit as $key => $value) {
            $response[] = array(
                'id'   => encrypter($value->id),
                'text' => Str::title($value->toModel->nama_model)
            );
        }

        return responseJson($response);
    }

    public static function getData($unit)
    {
        $unit = encrypter($unit, 'decrypt');

        $response = mUnitDetail::select('deskripsi')
            ->whereUnit($unit)
            ->whereIn('detail', array('360Drive', '360In'))
            ->orderBy('detail', 'asc')
            ->get();

        return responseJson($response);
    }

    public static function submit(array $arrayData, $kode, $imgServer)
    {
        $unit = encrypter($arrayData['model'], 'decrypt');

        DB::beginTransaction();

        try {
            $testDrive = mUnitDetail::whereUnit($unit)->whereDetail('360Drive')->first();
            if ($testDrive !== null) {
                $testDrive->deskripsi = $arrayData['test_drive'];
                if ($testDrive->isDirty()) {
                    $testDrive->save();
                }
            } else {
                mUnitDetail::create(array(
                    'unit'        => $unit,
                    'detail'      => '360Drive',
                    'nama_detail' => 'Video 360 Test Drive',
                    'deskripsi'   => $arrayData['test_drive']
                ));
            }

            $interior = mUnitDetail::whereUnit($unit)->whereDetail('360In')->first();
            if ($interior !== null) {
                $interior->deskripsi = $arrayData['interior'];
                if ($interior->isDirty()) {
                    $interior->save();
                }
            } else {
                mUnitDetail::create(array(
                    'unit'        => $unit,
                    'detail'      => '360In',
                    'nama_detail' => '360 Interior',
                    'deskripsi'   => $arrayData['interior']
                ));
            }

            if (isset($arrayData['exterior'])) {
                $exterior = mUnitDetail::whereUnit($unit)->whereDetail('360Ex');
                if ($exterior->count() > 0) {
                    foreach ($exterior->get() as $key => $value) {
                        $data = array('name' => $value->gambar, 'path' => './assets/img_marketing/otomotif/360ex/');
                        curl_post($imgServer . 'delete_img', $data);
                    }
                    $exterior->delete();
                }

                $data = array();
                foreach ($arrayData['exterior'] as $key => $value) {
                    $data = array(
                        'file' => base64_encode(file_get_contents($value->getPathName())),
                        'name' => date('Ymd') . $kode . 'part-' . ($key + 1) . '.' . $value->getClientOriginalExtension(),
                        'path' => './assets/img_marketing/otomotif/360ex/'
                    );
                    curl_post($imgServer . 'post_img', $data);

                    mUnitDetail::create(array(
                        'unit'        => $unit,
                        'detail'      => '360Ex',
                        'nama_detail' => 'Exterior 360 ' . $unit,
                        'deskripsi'   => $key,
                        'gambar'      => $data['name']
                    ));
                }
            }

            DB::commit();
            $response = array('status' => 'success', 'msg' => 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            DB::rollback();
            $response = array('status' => 'error', 'msg' => 'Data gagal diupdate');
        }

        return responseJson($response);
    }
}
