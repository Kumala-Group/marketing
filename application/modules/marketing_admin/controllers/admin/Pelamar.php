<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pelamar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "pelamar";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/admin/pelamar";
                $d['index'] = $index;
                $d['img_server'] = $this->m_marketing->img_server;
                $d['data'] = q_data("*", 'kumalagroup.pelamars', [], "updated_at")->result();
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
                $data['posisi'] = $post['posisi'];
                $data['nama'] = $post['nama'];
                $data['alamat'] = $post['alamat'];
                $data['email'] = $post['email'];
                $data['telepon'] = $post['telepon'];
                // $data['pendidikan'] = $post['pendidikan'];
                // $data['pengalaman'] = $post['pengalaman'];
                // $data['training'] = $post['training'];
                $data['alasan'] = $post['alasan'];
                $data['foto'] = $post['foto'];
                $data['cv'] = $post['cv'];
                $data['surat_lamaran'] = $post['surat_lamaran'];
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("pelamars", $data);
                echo 1;

                //notifikasi
                $data = [];
                $data['judul'] = "Pelamar";
                $data['deskripsi'] = $post['nama'] . " - " . $post['email'] . " - " . $post['telepon'];
                $data['status'] = 0;
                $data['link'] = "admin/pelamar";
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("notification", $data);
            }
        }
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $d = q_data("*", 'kumalagroup.pelamars', $where)->row();
        $data_post['path'] = "./assets/img_marketing/pelamar/";
        $data_post['name'] = $d->foto;
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $data_post['name'] = $d->cv;
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $data_post['name'] = $d->surat_lamaran;
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $this->kumalagroup->delete('pelamars', $where);
    }
}
