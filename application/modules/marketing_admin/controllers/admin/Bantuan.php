<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bantuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "bantuan";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/admin/bantuan";
                $d['index'] = $index;
                $d['kumalagroup'] = q_data("*", 'kumk6797_kumalagroup.contacts', ['website' => "kumalagroup"], "updated_at")->result();
                $d['honda'] = q_data("*", 'kumk6797_kumalagroup.contacts', ['website' => "honda"], "updated_at")->result();
                $this->load->view('index', $d);
            }
        }
    }
    public function simpan()
    {
        if ($this->m_marketing->auth_api()) {
            $this->load->library('email');
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                debug($post);
                $data['nama'] = $post['nama'];
                $data['telepon'] = $post['telepon'];
                $data['email'] = $post['email'];
                $data['pesan'] = $post['pesan'];
                $data['website'] = empty($post['website']) ? "kumalagroup" : "honda";
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $r = $this->kumalagroup->insert("contacts", $data);
                if ($r) {
                    $d['result'] = "Success";
                    $d['message'] = "Selamat, Permintaan Anda berhasil diproses!";
                } else {
                    $d['result'] = "Error";
                    $d['message'] = "Maaf, Permintaan Anda tidak dapat diproses!";
                }
                echo json_encode($d);

                //w!E_gvc3Mn_v2H4
                $config['mailtype'] = "html";
                $config['charset'] = "utf-8";
                $config['protocol'] = "smtp";
                $config['smtp_host'] = "kumalagroup.id";
                $config['smtp_user'] = "hello@kumalagroup.id";
                $config['smtp_pass'] = "admin_kumala1983";
                $config['smtp_port'] = 587;
                $config['crlf'] = "\r\n";
                $config['newline'] = "\r\n";
                $this->email->initialize($config);
                $this->email->from($data['email'], $data['nama']);
                $this->email->to(empty($post['website']) ? "hellokumalagroup@gmail.com" : "honda@honda-kmg.com");
                $this->email->subject("Hello Kumala Group");
                $this->email->message($data['pesan']);
                $this->email->send();

                //notifikasi
                $data = [];
                $data['judul'] = "Bantuan";
                $data['deskripsi'] = $post['email'] . " - " . $post['pesan'];
                $data['status'] = 0;
                $data['link'] = "admin/bantuan";
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
        $this->kumalagroup->update('contacts', array('status' => $input['val']));
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
        $this->kumalagroup->delete('contacts', $where);
    }
}
