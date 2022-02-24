<?php

use app\modules\elo_models\kumalagroup\mImgGaleri;
use app\modules\elo_models\kumalagroup\mUcUnit;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Inventori extends \MX_Controller
{
    private static $website    = 'carimobilku';
    private static $pathImg    = './assets/img_marketing/uc_unit/';
    private static $pathGaleri = './assets/img_marketing/uc_unit/galeri/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }

    public function index()
    {
        $index = 'ucinventori';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            if ($this->request->ajax()) {
                if ($this->request->has('_getDatatable')) {
                    $baseImg = $this->m_marketing->img_server . 'assets/img_marketing/uc_unit/';
                    return self::getDatatable($baseImg);
                } elseif ($this->request->has('_getDetail')) {
                    $id = $this->request->id;
                    $baseImg = $this->m_marketing->img_server . 'assets/img_marketing/uc_unit/galeri/';
                    return self::getDetail($id, $baseImg);
                } elseif ($this->request->has('_getGaleri')) {
                    $id = $this->request->id;
                    $baseImg = $this->m_marketing->img_server . 'assets/img_marketing/uc_unit/galeri/';
                    return self::getGaleri($id, $baseImg);
                }

                if ($this->request->has('_submit')) {
                    $data = $this->request->all();
                    $kode = $this->m_marketing->generate_kode(5);
                    $baseImg = $this->m_marketing->img_server;
                    return self::submit($data, $kode, $baseImg);
                }

                if ($this->request->isMethod('delete')) {
                    $id = $this->request->id;
                    $baseImg = $this->m_marketing->img_server;
                    return self::delete($id, $baseImg);
                }
            }

            $content = 'pages/carimobilku/inventori.html';
            $data = compact('index', 'content');

            return $this->load->view('index', $data);
        }
    }

    private static function getDatatable($baseImg)
    {
        $query = mUcUnit::select(
            'id',
            'nama',
            'brand',
            'warna',
            'tahun',
            'kilometer',
            'gambar',
            DB::raw('date_format(created_at, \'%d-%m-%Y\') as tanggal')
        );

        $columns  = [
            [
                'date_format(created_at, \'%d-%m-%Y\')',
                'created_at'
            ],
            'nama',
            'brand',
            'warna',
            'tahun',
            'kilometer',
            null,
            null
        ];
        $order    = [
            'created_at',
            'desc'
        ];
        $response = datatablesOf($query, $columns, $order);

        foreach ($response['data'] as $key => $value) {
            $id     = encrypter($value['id']);
            $gambar = $baseImg . $value['gambar'];

            unset($response['data'][$key]['id']);

            $response['data'][$key]['gambar'] = '<ul style="padding-left: 15px">
                <li><a href="' . $gambar . '" target="_blank">Gambar</a></li>
                <li><a href="javascript:void(0)" class="lihat_galeri" data-id="' . $id . '">Galeri</a></li>
            </ul>';
            $response['data'][$key]['aksi']   = '<div class="form-group mb-0">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a href="javascript:void(0)" data-id="' . $id . '" class="btn btn-info ubah">Ubah</a>
                    <a href="javascript:void(0)" data-id="' . $id . '" class="btn btn-danger hapus">Hapus</a>
                </div>
            </div>';
        }

        return responseJson($response);
    }

    private static function getDetail($id, $baseImg)
    {
        $id = encrypter($id, 'decrypt');

        $result = mUcUnit::with(['toGaleri' => function ($query) {
            $query->whereJenis(self::$website);
        }])->find($id);

        $unit = [
            'nama'         => $result->nama,
            'brand'        => $result->brand,
            'warna'        => $result->warna,
            'tahun'        => $result->tahun,
            'kilometer'    => separator_harga($result->kilometer),
            'transmisi'    => $result->transmisi,
            'bahan_bakar'  => $result->bahan_bakar,
            'tempat_duduk' => $result->tempat_duduk,
            'dimensi'      => $result->dimensi,
            'harga'        => separator_harga($result->harga),
            'deskripsi'    => $result->deskripsi,
            'video'        => $result->video,
            'lokasi'       => $result->lokasi,
        ];

        foreach ($result->toGaleri as $key => $value) {
            $id     = encrypter($value->id);
            $gambar = $baseImg . $value->img;

            $galeri[] = '<div class="col-sm-6 col-md-4 mb-1">
                <img src="' . $gambar . '" alt="" class="img-fluid" style="width: 100%; height: 150px; object-fit: cover;">
                <div style="position: absolute; top: 10px; right: 25px;">
                    <button class="btn btn-danger btn-sm hapus_galeri" type="button" data-id="' . $id . '">Hapus</button>
                </div>
            </div>';
        }

        $response = compact('unit', 'galeri');

        return responseJson($response);
    }

    private static function getGaleri($id, $baseImg)
    {
        $id = encrypter($id, 'decrypt');

        $result = mUcUnit::with(['toGaleri' => function ($query) {
            $query->whereJenis(self::$website);
        }])->find($id);

        foreach ($result->toGaleri as $key => $value) {
            $id     = encrypter($value->id);
            $gambar = $baseImg . $value->img;

            $response[] = '<div class="col-sm-6 col-md-4 mb-1">
                <a href="' . $gambar . '" target="_blank">
                    <img src="' . $gambar . '" alt="" class="img-fluid" style="width: 100%; height: 150px; object-fit: cover;">
                </a>
            </div>';
        }

        return responseJson($response ?? []);
    }

    private static function submit(array $dataRaw, $kode, $baseImg)
    {
        $data = [
            'id'           => encrypter($dataRaw['id'], 'decrypt'),
            'nama'         => $dataRaw['nama'],
            'slug'         => $kode . '-' . Str::slug($dataRaw['nama']),
            'brand'        => $dataRaw['brand'],
            'warna'        => $dataRaw['warna'],
            'tahun'        => $dataRaw['tahun'],
            'kilometer'    => remove_separator($dataRaw['kilometer']),
            'transmisi'    => $dataRaw['transmisi'],
            'bahan_bakar'  => $dataRaw['bahan_bakar'],
            'tempat_duduk' => $dataRaw['tempat_duduk'],
            'dimensi'      => $dataRaw['dimensi'],
            'harga'        => remove_separator($dataRaw['harga']),
            'deskripsi'    => $dataRaw['deskripsi'],
            'video'        => $dataRaw['video'],
            'lokasi'       => $dataRaw['lokasi'],
        ];

        if (isset($dataRaw['gambar'])) {
            $data['gambar'] = Carbon::now()->format('YmdHis')
                . $dataRaw['gambar']->getFilename() . '.'
                . $dataRaw['gambar']->getClientOriginalExtension();
        }

        if (isset($dataRaw['galeri'])) {
            foreach ($dataRaw['galeri'] as $key => $value) {
                $data['galeri'][] = Carbon::now()->format('YmdHis')
                    . $value->getFilename() . '.'
                    . $value->getClientOriginalExtension();
            }
        }

        if (isset($dataRaw['id_galeri'])) {
            foreach ($dataRaw['id_galeri'] as $key => $value) {
                $data['id_galeri'][] = encrypter($value, 'decrypt');
            }
        }

        DB::beginTransaction();

        try {
            $result = mUcUnit::find($data['id']);

            if ($result !== null) {
                $result->nama         = $data['nama'];
                $result->brand        = $data['brand'];
                $result->warna        = $data['warna'];
                $result->tahun        = $data['tahun'];
                $result->kilometer    = $data['kilometer'];
                $result->transmisi    = $data['transmisi'];
                $result->bahan_bakar  = $data['bahan_bakar'];
                $result->tempat_duduk = $data['tempat_duduk'];
                $result->dimensi      = $data['dimensi'];
                $result->harga        = $data['harga'];
                $result->deskripsi    = $data['deskripsi'];
                $result->video        = $data['video'];
                $result->lokasi       = $data['lokasi'];

                if ($result->isDirty('nama')) {
                $result->slug = $data['slug'];
                }

                if (isset($dataRaw['gambar'])) {
                    $result->gambar = $data['gambar'];
                }

                if ($result->isDirty() || isset($data['galeri']) || isset($data['id_galeri'])) {
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

                    if (isset($dataRaw['galeri'])) {
                        foreach ($dataRaw['galeri'] as $key => $value) {
                            $resultGaleri = mImgGaleri::create([
                                'id_ref' => $data['id'],
                                'jenis'  => self::$website,
                                'img'    => $data['galeri'][$key]
                            ]);
                            if ($resultGaleri !== null) {
                                $fileImg = file_get_contents($value->getPathName());
                                $dataImg = [
                                    'file' => base64_encode($fileImg),
                                    'name' => $data['galeri'][$key],
                                    'path' => self::$pathGaleri
                                ];
                                curl_post($baseImg . 'post_img', $dataImg);
                            }
                        }
                    }

                    if (isset($dataRaw['id_galeri'])) {
                        $resultIdGaleri = mImgGaleri::whereIn('id', $data['id_galeri']);
                        if ($resultIdGaleri->count() > 0) {
                            foreach ($resultIdGaleri->get() as $key => $value) {
                                $dataImg = [
                                    'name' => $value->img,
                                    'path' => self::$pathGaleri
                                ];
                                curl_post($baseImg . 'delete_img', $dataImg);
                            }

                            $resultIdGaleri->delete();
                        }
                    }

                    $result->save();

                    DB::commit();

                    return responseJson([
                        'status' => true,
                        'msg'    => 'Data berhasil diubah.'
                    ]);
                }

                return responseJson([
                    'status' => false,
                    'msg'    => 'Tidak ada data yang diubah.'
                ]);
            }

            $result = mUcUnit::create(Arr::except($data, 'id'));

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

                if (isset($dataRaw['galeri'])) {
                    foreach ($dataRaw['galeri'] as $key => $value) {
                        $resultGaleri = mImgGaleri::create([
                            'id_ref' => $result->id,
                            'jenis'  => self::$website,
                            'img'    => $data['galeri'][$key]
                        ]);
                        if ($resultGaleri !== null) {
                            $fileImg = file_get_contents($value->getPathName());
                            $dataImg = [
                                'file' => base64_encode($fileImg),
                                'name' => $data['galeri'][$key],
                                'path' => self::$pathGaleri
                            ];
                            curl_post($baseImg . 'post_img', $dataImg);
                        }
                    }
                }

                DB::commit();

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
            DB::rollback();
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
            $result = mUcUnit::find($id);

            if ($result !== null) {
                $dataImg = [
                    'name' => $result->gambar,
                    'path' => self::$pathImg
                ];
                curl_post($baseImg . 'delete_img', $dataImg);

                $resultGaleri = mImgGaleri::whereId_ref($id)
                    ->whereJenis(self::$website);

                if ($resultGaleri->count() > 0) {
                    foreach ($resultGaleri->get() as $key => $value) {
                        $dataImg = [
                            'name' => $value->img,
                            'path' => self::$pathGaleri
                        ];
                        curl_post($baseImg . 'delete_img', $dataImg);
                    }

                    $resultGaleri->delete();
                }

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
