<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tiket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "tiket";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/admin/tiket";
                $d['index'] = $index;
                $data = q_data("*", 'kumk6797_kumalagroup.tickets', [], "updated_at")->result();
                foreach ($data as $v) {
                    $arr['id'] = $v->id;
                    $arr['acara'] = q_data("*", 'kumk6797_kumalagroup.events', ['id' => $v->acara])->row()->judul;
                    $arr['nama'] = $v->nama;
                    $arr['email'] = $v->email;
                    $arr['harga'] = $v->harga;
                    $arr['jumlah_tiket'] = $v->jumlah_tiket;
                    $arr['status'] = $v->status;
                    $d['data'][] = $arr;
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
                $data['acara'] = $post['idAcara'];
                $data['nama'] = $post['nama'];
                $data['email'] = $post['email'];
                $data['harga'] = $post['harga'];
                $data['jumlah_tiket'] = $post['jumlahTiket'];
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $r = $this->kumalagroup->insert("tickets", $data);
                if ($r) {
                    $d['result'] = "Success";
                    $d['message'] = "Selamat, Permintaan Anda berhasil diproses!";
                } else {
                    $d['result'] = "Error";
                    $d['message'] = "Maaf, Permintaan Anda tidak dapat diproses!";
                }
                echo json_encode($d);

                //w!E_gvc3Mn_v2H4
                // $config['mailtype'] = "html";
                // $config['charset'] = "utf-8";
                // $config['protocol'] = "smtp";
                // $config['smtp_host'] = "mail.kumalagroup.id";
                // $config['smtp_user'] = "hello@kumalagroup.id";
                // $config['smtp_pass'] = "admin_kumala1983";
                // $config['smtp_port'] = 587;
                // $config['crlf'] = "\r\n";
                // $config['newline'] = "\r\n";
                // $this->email->initialize($config);
                // $this->email->from($data['email'], $data['nama']);
                // $this->email->to('hellokumalagroup@gmail.com');
                // $this->email->subject("Form bantuan Kumala Group");
                // $this->email->message($data['pesan']);
                // $this->email->send();

                //notifikasi
                $data = [];
                $data['judul'] = "Tiket";
                $data['deskripsi'] = $post['nama'] . " - " . $post['email'];
                $data['status'] = 0;
                $data['link'] = "admin/tiket";
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert('notification', $data);
            }
        }
    }

    // untuk ubah status
    public function ubah_status()
    {
        $input = $this->input->post();

        $this->kumalagroup->trans_start();
        $this->kumalagroup->where('id', $input['id']);
        $this->kumalagroup->update('tickets', array('status' => $input['val']));
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
        $this->kumalagroup->delete('tickets', $where);
    }
}
