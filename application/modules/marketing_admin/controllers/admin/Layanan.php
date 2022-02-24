<?php

use app\modules\elo_models\kumalagroup\mLayanan;

class Layanan extends \MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }

    public function index()
    {
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng')) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['hapus'])) $this->hapus($post);
            } else {
                if ($this->uri->segment(2) == "test_drive") {
                    $index = "test_drive";
                    if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
                        $d['index'] = $index;
                        $d['judul'] = "Test Drive";
                        $d['test_drive'] = mLayanan::with(array('toUnit.toBrand', 'toUnit.toModel'))
                            ->where('jenis', '=', 'Test Drive')
                            ->orderBy('created_at', 'desc')->get();
                    }
                } else {
                    $index = "penawaran";
                    if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
                        $d['index'] = $index;
                        $d['judul'] = "Penawaran";
                        $d['penawaran'] = mLayanan::where('jenis', '=', 'Penawaran')
                            ->orderBy('created_at', 'desc')->get();
                    }
                }
                $d['content'] = "pages/admin/layanan";
                $this->load->view('index', $d);
            }
        }
    }

    public function simpan()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $data['nama']       = $post['nama'];
                $data['telepon']    = $post['telepon'];
                $data['kota']       = $post['asalKota'];
                $data['jenis']      = $post['layanan'];
                $data['unit']       = $post['unit'];
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $r = $this->kumalagroup->insert("layanan", $data);
                if ($r) {
                    $d['result']  = "Success";
                    $d['message'] = "Selamat, Permintaan Anda berhasil diproses!";
                } else {
                    $d['result']  = "Error";
                    $d['message'] = "Maaf, Permintaan Anda tidak dapat diproses!";
                }
                echo json_encode($d);

                //notifikasi
                $data = [];
                $data['judul']      = $post['layanan'];
                $data['deskripsi']  = $post['nama'] . " - " . $post['telepon'];
                $data['status']     = 0;
                $data['link']       = $post['layanan'] == "Test Drive" ? "admin/test_drive" : "admin/penawaran";
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("notification", $data);
            }
        }
    }

    // untuk ubah status
    public function ubah_status()
    {
        $input = $this->input->post();

        $this->kumalagroup->trans_start();
        $this->kumalagroup->where('id', $input['id']);
        $this->kumalagroup->update('layanan', array('status' => $input['val']));
        $this->kumalagroup->trans_complete();

        if ($this->kumalagroup->trans_status() === TRUE) {
            $reponse = ['status' => true, 'message' => 'Status berhasil diubah!'];
        } else {
            $reponse = ['status' => false, 'message' => 'Status gagal diubah!'];
        }

        echo json_encode($reponse);
    }

    function hapus($post)
    {
        $where['id'] = $post['id'];
        $this->kumalagroup->delete('layanan', $where);
    }
}
