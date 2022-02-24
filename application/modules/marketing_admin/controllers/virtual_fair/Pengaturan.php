<?php

class Pengaturan extends \CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', 'pengaturan')) {
            $post = (object)$this->input->post();
            if ((array)$post) {
                if (isset($post->simpan)) {
                    $this->kumalagroup->trans_start();
                    $this->kumalagroup->update('masterSet', array('val' => $post->tanggalAwal), array('nama' => 'Tanggal Awal'));
                    $this->kumalagroup->update('masterSet', array('val' => $post->tanggalAkhir), array('nama' => 'Tanggal Akhir'));
                    $this->kumalagroup->update('masterSet', array('val' => $post->persen), array('nama' => 'Persen'));
                    $this->kumalagroup->update('masterSet', array('val' => $post->maks), array('nama' => 'Batas'));
                    $this->kumalagroup->trans_complete();
                    $response = $this->kumalagroup->trans_status()
                        ? array('status' => 'success', 'msg' => 'Data berhasil disimpan')
                        : array('status' => 'error', 'msg' => 'Data gagal disimpan');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } else {
                $this->load->view('index', array(
                    'content' => 'pages/virtual_fair/pengaturan',
                    'index' => 'pengaturan',
                    'data' => q_data('*', 'kumalagroup.masterSet', null)->result()
                ));
            }
        }
    }

    // untuk ubah background login
    public function ubah_bg_login()
    {
        // ambil data untuk nama gambar
        $bg         = $this->kumalagroup->query("SELECT * FROM background WHERE kd_bg = 'BG-LOGIN'")->row();

        // desktop dan tablet version
        $ext1         = explode(".", $_FILES['bg_login']['name']);
        $nma_gambar_1 = date('YmdHis') . "-1." . strtolower(end($ext1));

        // mobile version
        $ext2         = explode(".", $_FILES['bg_login_m']['name']);
        $nma_gambar_2 = date('YmdHis') . "-2." . strtolower(end($ext2));

        // untuk upload gambar
        $data_post['file'] = base64_encode(file_get_contents($_FILES['bg_login']['tmp_name']));
        $data_post['name'] = $nma_gambar_1;
        $data_post['path'] = "./assets/img_marketing/background/";
        curl_post($this->m_marketing->img_server . "post_img", $data_post);

        $data_post['file'] = base64_encode(file_get_contents($_FILES['bg_login_m']['tmp_name']));
        $data_post['name'] = $nma_gambar_2;
        $data_post['path'] = "./assets/img_marketing/background/";
        curl_post($this->m_marketing->img_server . "post_img", $data_post);

        if ($bg == null) {
            $data = [
                'kd_bg'     => 'BG-LOGIN',
                'gambar_dt' => $nma_gambar_1,
                'gambar_m'  => $nma_gambar_2,
            ];

            $this->kumalagroup->trans_start();
            $this->kumalagroup->insert('background', $data);
            $this->kumalagroup->trans_complete();

            if ($this->kumalagroup->trans_status() === TRUE) {
                $response = ['status' => true, 'msg' => 'Data Sukses diSimpan!'];
            } else {
                $response = ['status' => false, 'msg' => 'Data Gagal diSimpan!'];
            }
        } else {
            $data = [
                'gambar_dt' => $nma_gambar_1,
                'gambar_m'  => $nma_gambar_2,
            ];

            $data_post['name'] = $bg->gambar_dt;
            $data_post['path'] = "./assets/img_marketing/background/";
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);

            $data_post['name'] = $bg->gambar_m;
            $data_post['path'] = "./assets/img_marketing/background/";
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);

            $this->kumalagroup->trans_start();
            $this->kumalagroup->where('kd_bg', 'BG-LOGIN')->update('background', $data);
            $this->kumalagroup->trans_complete();

            if ($this->kumalagroup->trans_status() === TRUE) {
                $response = ['status' => true, 'msg' => 'Data Sukses diSimpan!'];
            } else {
                $response = ['status' => false, 'msg' => 'Data Gagal diSimpan!'];
            }
        }

        echo json_encode($response);
    }

    // untuk ubah background main stage
    public function ubah_main_stage()
    {
        // ambil data untuk nama gambar
        $bg         = $this->kumalagroup->query("SELECT * FROM background WHERE kd_bg = 'BG-MAIN'")->row();

        // desktop dan tablet version
        $ext1         = explode(".", $_FILES['bg_main']['name']);
        $nma_gambar_1 = date('YmdHis') . "-1." . strtolower(end($ext1));

        // mobile version
        $ext2         = explode(".", $_FILES['bg_main_m']['name']);
        $nma_gambar_2 = date('YmdHis') . "-2." . strtolower(end($ext2));

        // untuk upload gambar
        $data_post['file'] = base64_encode(file_get_contents($_FILES['bg_main']['tmp_name']));
        $data_post['name'] = $nma_gambar_1;
        $data_post['path'] = "./assets/img_marketing/background/";
        curl_post($this->m_marketing->img_server . "post_img", $data_post);

        // untuk upload gambar
        $data_post['file'] = base64_encode(file_get_contents($_FILES['bg_main_m']['tmp_name']));
        $data_post['name'] = $nma_gambar_2;
        $data_post['path'] = "./assets/img_marketing/background/";
        curl_post($this->m_marketing->img_server . "post_img", $data_post);

        if ($bg == null) {
            $data = [
                'kd_bg'     => 'BG-MAIN',
                'gambar_dt' => $nma_gambar_1,
                'gambar_m'  => $nma_gambar_2,
            ];

            $this->kumalagroup->trans_start();
            $this->kumalagroup->insert('background', $data);
            $this->kumalagroup->trans_complete();

            if ($this->kumalagroup->trans_status() === TRUE) {
                $response = ['status' => true, 'msg' => 'Data Sukses diSimpan!'];
            } else {
                $response = ['status' => false, 'msg' => 'Data Gagal diSimpan!'];
            }
        } else {
            $data = [
                'gambar_dt' => $nma_gambar_1,
                'gambar_m'  => $nma_gambar_2,
            ];

            $data_post['name'] = $bg->gambar_dt;
            $data_post['path'] = "./assets/img_marketing/background/";
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);

            $data_post['name'] = $bg->gambar_m;
            $data_post['path'] = "./assets/img_marketing/background/";
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);

            $this->kumalagroup->trans_start();
            $this->kumalagroup->where('kd_bg', 'BG-MAIN')->update('background', $data);
            $this->kumalagroup->trans_complete();

            if ($this->kumalagroup->trans_status() === TRUE) {
                $response = ['status' => true, 'msg' => 'Data Sukses diSimpan!'];
            } else {
                $response = ['status' => false, 'msg' => 'Data Gagal diSimpan!'];
            }
        }

        echo json_encode($response);
    }
}
