<?php

use app\modules\elo_models\kumalagroup\mBerita;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Blog extends \MX_Controller
{
    private static $website = 'carimobilku';
    private static $thumbPath = './assets/img_marketing/berita/thumb/';
    private static $gambarPath = './assets/img_marketing/berita/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }

    public function index()
    {
        $index = 'ucblog';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            if ($this->request->ajax()) {
                if ($this->request->has('_getDatatable')) {
                    $type = $this->request->type;
                    $baseImg = $this->m_marketing->img_server . 'assets/img_marketing/berita/';
                    return self::getDatatable($type, $baseImg);
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

            $content = 'pages/carimobilku/blog.html';
            $data = compact('index', 'content');

            return $this->load->view('index', $data);
        }
    }

    private static function getDatatable($type, $baseImg)
    {
        $query = mBerita::selectRaw('id,judul,deskripsi,thumb,gambar,date_format(created_at, \'%d-%m-%Y\') as tanggal')
            ->whereWebsite(self::$website)
            ->whereType($type);

        $columns  = [
            [
                'date_format(created_at, \'%d-%m-%Y\')',
                'created_at'
            ],
            'judul',
            'deskripsi',
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
            $deskripsi = strip_tags($value['deskripsi']);
            $thumb     = $baseImg . 'thumb/' . $value['thumb'];
            $gambar    = $baseImg . $value['gambar'];

            unset($response['data'][$key]['id']);
            unset($response['data'][$key]['thumb']);

            $response['data'][$key]['deskripsi'] = Str::limit($deskripsi, 150);
            $response['data'][$key]['gambar']    = '<ul style="padding-left: 15px">
                <li><a href="' . $thumb . '" target="_blank">Thumbnail</a></li>
                <li><a href="' . $gambar . '" target="_blank">Gambar</a></li>
            </ul>';
            $response['data'][$key]['aksi']      = '<div class="form-group mb-0">
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

        $response = mBerita::selectRaw('type,judul,deskripsi')
            ->find($id);

        return responseJson($response);
    }

    private static function submit(array $dataRaw, $baseImg)
    {
        $data = [
            'id'        => encrypter($dataRaw['id'], 'decrypt'),
            'type'      => $dataRaw['type'],
            'website'   => self::$website,
            'judul'     => $dataRaw['judul'],
            'slug'      => Str::slug($dataRaw['judul']),
            'deskripsi' => $dataRaw['deskripsi'],
        ];

        if (isset($dataRaw['thumb'])) {
            $data['thumb'] = Carbon::now()->format('YmdHis')
                . $dataRaw['thumb']->getFilename() . '.'
                . $dataRaw['thumb']->getClientOriginalExtension();
        }

        if (isset($dataRaw['gambar'])) {
            $data['gambar'] = Carbon::now()->format('YmdHis')
                . $dataRaw['gambar']->getFilename() . '.'
                . $dataRaw['gambar']->getClientOriginalExtension();
        }

        try {
            $result = mBerita::find($data['id']);

            if ($result !== null) {
                $result->type = $data['type'];
                $result->judul = $data['judul'];
                $result->slug = $data['slug'];
                $result->deskripsi = $data['deskripsi'];

                if (isset($dataRaw['thumb'])) {
                    $result->thumb = $data['thumb'];
                }

                if (isset($dataRaw['gambar'])) {
                    $result->gambar = $data['gambar'];
                }

                if ($result->isDirty()) {
                    if (isset($dataRaw['thumb'])) {
                        $dataImg = [
                            'name' => $result->getOriginal('thumb'),
                            'path' => self::$thumbPath
                        ];
                        curl_post($baseImg . 'delete_img', $dataImg);

                        $fileImg = file_get_contents($dataRaw['thumb']->getPathName());
                        $dataImg = [
                            'file' => base64_encode($fileImg),
                            'name' => $data['thumb'],
                            'path' => self::$thumbPath
                        ];
                        curl_post($baseImg . 'post_img', $dataImg);
                    }

                    if (isset($dataRaw['gambar'])) {
                        $dataImg = [
                            'name' => $result->getOriginal('gambar'),
                            'path' => self::$gambarPath
                        ];
                        curl_post($baseImg . 'delete_img', $dataImg);

                        $fileImg = file_get_contents($dataRaw['gambar']->getPathName());
                        $dataImg = [
                            'file' => base64_encode($fileImg),
                            'name' => $data['gambar'],
                            'path' => self::$gambarPath
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

            $result = mBerita::create(Arr::except($data, 'id'));

            if ($result !== null) {
                if (isset($dataRaw['thumb'])) {
                    $fileImg = file_get_contents($dataRaw['thumb']->getPathName());
                    $dataImg = [
                        'file' => base64_encode($fileImg),
                        'name' => $data['thumb'],
                        'path' => self::$thumbPath
                    ];
                    curl_post($baseImg . 'post_img', $dataImg);
                }

                if (isset($dataRaw['gambar'])) {
                    $fileImg = file_get_contents($dataRaw['gambar']->getPathName());
                    $dataImg = [
                        'file' => base64_encode($fileImg),
                        'name' => $data['gambar'],
                        'path' => self::$gambarPath
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
            $result = mBerita::find($id);

            if ($result !== null) {
                $dataImg = [
                    'name' => $result['thumb'],
                    'path' => self::$thumbPath
                ];
                curl_post($baseImg . 'delete_img', $dataImg);

                $dataImg = [
                    'name' => $result['gambar'],
                    'path' => self::$gambarPath
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
