<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Saran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "saran";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/admin/saran";
                $d['index'] = $index;
                $d['data'] = q_data("*", 'kumk6797_kumalagroup.saran', [], "updated_at")->result();
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
                $data['nama'] = $post['nama'];
                $data['telepon'] = $post['telepon'];
                $data['email'] = $post['email'];
                $data['provinsi'] = $post['idProvinsi'];
                $data['kabupaten'] = $post['idKabupaten'];
                $data['kecamatan'] = $post['idKecamatan'];
                $data['keluhan'] = $post['keluhan'];
                $data['penjelasan'] = $post['penjelasan'];
                $data['harapan'] = $post['harapan'];
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $r = $this->kumalagroup->insert("saran", $data);
                if ($r) {
                    $d['result'] = "Success";
                    $d['message'] = "Selamat, Permintaan Anda berhasil diproses!";
                } else {
                    $d['result'] = "Error";
                    $d['message'] = "Maaf, Permintaan Anda tidak dapat diproses!";
                }
                echo json_encode($d);

                //notifikasi
                $data = [];
                $data['judul'] = "Saran";
                $data['deskripsi'] = $post['nama'] . " - " . $post['telepon'] . " - " . $post['keluhan'];
                $data['status'] = 0;
                $data['link'] = "admin/saran";
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
        $this->kumalagroup->update('saran', array('status' => $input['val']));
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
        $this->kumalagroup->delete('saran', $where);
    }
}
