<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_service extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }

    public function index()
    {
        $index = "home_service";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/admin/home_service";
                $d['index'] = $index;;
                $data = q_data("*", 'kumk6797_kumalagroup.home_service', [], "updated_at")->result();
                foreach ($data as $v) {
                    $perusahaan = q_data("*", 'kumk6797_kmg.perusahaan', ['id_perusahaan' => $v->id_perusahaan])->row();

                    $d['id'][]              = $v->id;
                    $d['tanggal_service'][] = $v->tanggal_service;
                    $d['_dealer'][]         = $perusahaan->lokasi . ' - ' . $perusahaan->kode_perusahaan;
                    $d['no_polisi'][]       = $v->no_polisi;
                    $d['nama'][]            = $v->nama;
                    $d['telepon'][]         = $v->telepon1;
                    $d['alamat'][]          = $v->alamat;
                    $d['jam_service'][]     = $v->jam_service;
                    $d['jenis_service'][]   = $v->jenis_service;
                    $d['keterangan'][]      = $v->keterangan;
                    $d['status'][]          = $v->status;
                }
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
                $data['brand']           = $post['idBrand'];
                $data['kota']            = $post['kota'];
                $data['id_perusahaan']   = $post['idPerusahaan'];
                $data['no_polisi']       = $post['noPolisi'];
                $data['no_rangka']       = $post['noRangka'];
                $data['nama']            = $post['nama'];
                $data['telepon1']        = $post['telepon1'];
                $data['telepon2']        = $post['telepon2'];
                $data['alamat']          = $post['alamat'];
                $data['tanggal_service'] = $post['tanggalService'];
                $data['jam_service']     = $post['jamService'];
                $data['jenis_service']   = $post['jenisService'];
                $data['keterangan']      = $post['keterangan'];
                $data['created_at']      = date('Y-m-d H:i:s');
                $data['updated_at']      = date('Y-m-d H:i:s');
                $r = $this->kumalagroup->insert("home_service", $data);
                if ($r) {
                    $d['result']  = "Success";
                    $d['message'] = "Selamat, Anda telah melakukan home service!";
                } else {
                    $d['result']  = "Error";
                    $d['message'] = "Maaf, Permintaan Anda tidak dapat diproses!";
                }
                echo json_encode($d);

                //notifikasi
                $data = [];
                $data['judul']      = "Home Service";
                $data['deskripsi']  = $post['nama'] . " - " . $post['telepon1'] . " - " . $post['alamat'];
                $data['status']     = 0;
                $data['link']       = "admin/home_service";
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
        $this->kumalagroup->update('home_service', array('status' => $input['val']));
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
        $this->kumalagroup->delete('home_service', $where);
    }
}
