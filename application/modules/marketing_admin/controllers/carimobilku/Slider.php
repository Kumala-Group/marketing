<?php

use app\modules\elo_models\kumalagroup\mSlider;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class Slider extends \MX_Controller
{
    private static $website = 'carimobilku';
    private static $pathImg = './assets/img_marketing/slider/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }

    public function index()
    {
        $index = 'ucslider';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            if ($this->request->ajax()) {
                if ($this->request->has('_getDatatable')) {
                    $baseImg = $this->m_marketing->img_server . 'assets/img_marketing/slider/';
                    return self::getDatatable($baseImg);
                } elseif ($this->request->has('_getDetail')) {
                    $id = $this->request->id;
                    return self::getDetail($id);
                }

                if ($this->request->has('_submit')) {
                    $data = $this->request->all();
                    $baseImg = $this->m_marketing->img_server;
                    return self::submit($data, $baseImg);
                }

                if ($this->request->isMethod('delete')) {
                    $id = $this->request->id;
                    $baseImg = $this->m_marketing->img_server;
                    return self::delete($id, $baseImg);
                }
            }
            $content = 'pages/carimobilku/slider.html';
            $data = compact('index', 'content');

            return $this->load->view('index', $data);
        }
    }

    private static function getDatatable($baseImg)
    {
        $query = mSlider::selectRaw('id,aksi,gambar,date_format(created_at, \'%d-%m-%Y\') as tanggal')
            ->whereKategori(self::$website);

        $columns  = [
            [
                'date_format(created_at, \'%d-%m-%Y\')',
                'created_at'
            ],
            'aksi',
            null,
            null
        ];
        $order    = [
            'created_at',
            'desc'
        ];
        $response = datatablesOf($query, $columns, $order);

        foreach ($response['data'] as $key => $value) {
            $id        = encrypter($value['id']);
            $gambar    = $baseImg . $value['gambar'];

            unset($response['data'][$key]['id']);

            $response['data'][$key]['gambar']    = '<a href="' . $gambar . '" target="_blank">Gambar</a>';
            $response['data'][$key]['event']      = '<div class="form-group mb-0">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a href="javascript:void(0)" data-id="' . $id . '" class="btn btn-info ubah">Ubah</a>
                    <a href="javascript:void(0)" data-id="' . $id . '" class="btn btn-danger hapus">Hapus</a>
                </div>
            </div>';
        }

        return responseJson($response);
    }

    private static function getDetail($id)
    {
        $id = encrypter($id, 'decrypt');

        $response = mSlider::selectRaw('aksi')
            ->find($id);

        return responseJson($response);
    }

    private static function submit(array $dataRaw, $baseImg)
    {
        $data = [
            'id'   => encrypter($dataRaw['id'], 'decrypt'),
            'kategori' => self::$website,
            'aksi' => $dataRaw['aksi']
        ];

        if (isset($dataRaw['gambar'])) {
            $data['gambar'] = Carbon::now()->format('YmdHis')
                . $dataRaw['gambar']->getFilename() . '.'
                . $dataRaw['gambar']->getClientOriginalExtension();
        }

        try {
            $result = mSlider::find($data['id']);

            if ($result !== null) {
                $result->aksi = $data['aksi'];

                if (isset($dataRaw['gambar'])) {
                    $result->gambar = $data['gambar'];
                }

                if ($result->isDirty()) {
                    if (isset($dataRaw['gambar'])) {
                        $dataImg = [
                            'name' => $result->getOriginal('gambar'),
                            'path' => self::$pathImg
                        ];
                        curl_post($baseImg . 'delete_img', $dataImg);

                        $fileImg = file_get_contents($dataRaw['gambar']->getPathName());
                        $dataImg = [
                            'file' => base64_encode($fileImg),
                            'name' => $data['gambar'],
                            'path' => self::$pathImg
                        ];
                        curl_post($baseImg . 'post_img', $dataImg);
                    }

                    $result->save();

                    return responseJson([
                        'status' => true,
                        'msg'    => 'Data berhasil diupdate.'
                    ]);
                }

                return responseJson([
                    'status' => false,
                    'msg'    => 'Tidak ada data yang diupdate.'
                ]);
            }

            $result = mSlider::create(Arr::except($data, 'id'));

            if ($result !== null) {
                if (isset($dataRaw['gambar'])) {
                    $fileImg = file_get_contents($dataRaw['gambar']->getPathName());
                    $dataImg = [
                        'file' => base64_encode($fileImg),
                        'name' => $data['gambar'],
                        'path' => self::$pathImg
                    ];
                    curl_post($baseImg . 'post_img', $dataImg);
                }

                return responseJson([
                    'status' => true,
                    'msg'    => 'Data berhasil disimpan'
                ]);
            }

            return responseJson([
                'status' => false,
                'msg'    => 'Data gagal disimpan.'
            ]);
        } catch (\Throwable $th) {
            return responseJson([
                'status' => false,
                'msg'    => $th
            ]);
        }
    }

    private static function delete($id, $baseImg)
    {
        $id = encrypter($id, 'decrypt');

        try {
            $result = mSlider::find($id);

            if ($result !== null) {
                $dataImg = [
                    'name' => $result['gambar'],
                    'path' => self::$pathImg
                ];
                curl_post($baseImg . 'delete_img', $dataImg);

                $result->delete();

                return responseJson([
                    'status' => true,
                    'msg'    => 'Data berhasil dihapus'
                ]);
            }

            return responseJson([
                'status' => false,
                'msg'    => 'Data gagal dihapus'
            ]);
        } catch (\Throwable $th) {
            return responseJson([
                'status' => false,
                'msg'    => $th
            ]);
        }
    }
}
