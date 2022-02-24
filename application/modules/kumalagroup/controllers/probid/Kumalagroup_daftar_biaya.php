<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_daftar_biaya extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_probid_daftar_biaya');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }


    public function index()
    {
        $d['judul']     = 'Pengeluran External';
        $d['content']   = 'probid/daftar_biaya';
        $this->load->view('home', $d);
    }

    public function get_detail_biaya()
    {
        echo $this->model_probid_daftar_biaya->detail_biaya();
    }

    public function simpan()
    {
        $post = $this->input->post();
        // debug($post);
        $this->kumalagroup->trans_start();
        $tagihan = [
            'id_pelanggan' => $post['id_pelanggan'],
            'tgl_tagihan'  => tgl_sql($post['tgl_tagihan']),
            'tagihan'      => remove_separator($post['tagihan']),
            'user'         => $this->session->userdata('nik'),
        ];
        $this->kumalagroup->insert('tagihan_biaya', $tagihan);
        $this->kumalagroup->trans_complete();

        if ($this->kumalagroup->trans_status() === FALSE) {
            $response = "Gagal Simpan Data";
        } else {
            $response = "Berhasil Simpan Data";
        }

        echo json_encode($response);
    }

    public function get_list_detail_biaya()
    {
        echo $this->model_probid_daftar_biaya->detail_tagihan();
    }
}
