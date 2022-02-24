<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_apps_post extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        header('Content-Type: application/json');
    }
    public function checkout()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $where = $post['id_customer'];
                $data['alamat'] = $post['alamat'];
                $data['telepon'] = $post['nohp'];
                $data['no_npwp'] = $post['nonpwp'];
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->update("customer", $data, ['customer' => $where]);
                $data = [];
                $data['kode_checkout'] = $this->m_marketing->generate_kode();
                $data['customer'] = $where;
                $data['kode_produk'] = $post['id_produk'];
                $data['provinsi'] = $post['id_provinsi'];
                $data['brand'] = $post['id_brand'];
                $data['tipe'] = $post['type'];
                $data['harga'] = $post['harga'];
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');

                if (empty($post['web'])) {
                    $data_post['path'] = "./assets/img_marketing/checkout/";

                    $ext = explode(".", $post['nm_foto_ktp']);
                    $data_post['file'] = $post['foto_ktp'];
                    $data_post['name'] = date('YmdHis') . "ktp." . strtolower(end($ext));
                    $data['foto_ktp'] = curl_post($this->m_marketing->img_server . "post_img", $data_post);

                    $ext = explode(".", $post['nm_foto_kk']);
                    $data_post['file'] = $post['foto_kk'];
                    $data_post['name'] = date('YmdHis') . "kk." . strtolower(end($ext));
                    $data['foto_kk'] = curl_post($this->m_marketing->img_server . "post_img", $data_post);

                    $ext = explode(".", $post['nm_foto_reklis']);
                    $data_post['file'] = $post['foto_reklis'];
                    $data_post['name'] = date('YmdHis') . "reklis." . strtolower(end($ext));
                    $data['foto_reklis'] = curl_post($this->m_marketing->img_server . "post_img", $data_post);
                } else {
                    $data['foto_ktp'] = $post['foto_ktp'];
                    $data['foto_kk'] = $post['foto_kk'];
                    $data['foto_reklis'] = $post['foto_reklis'];
                }

                $r = $this->kumalagroup->insert("checkout", $data);
                if ($r) {
                    $d['type'] = "success";
                    $d['title'] = "Berhasil!";
                    $d['desc'] = "Selamat, Permintaan Anda berhasil diproses!";
                    $d['button'] = "Ok!";
                } else {
                    $d['type'] = "error";
                    $d['title'] = "Gagal!";
                    $d['desc'] = "Maaf, Permintaan Anda tidak dapat diproses!";
                    $d['button'] = "Ok!";
                }
                echo json_encode($d);
            }
        }
    }
    public function profil_cust()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $where = $post['id_customer'];
                $u = q_data("*", 'kumalagroup.reg_customer', ['id' => $where, 'email' => $post['email']]);
                if ($u->num_rows() == 0) {
                    $q = q_data("*", 'kumalagroup.reg_customer', ['id!=' => $where, 'email' => $post['email']]);
                    if ($q->num_rows() == 0) $data['email'] = $post['email'];
                    else $error = 1;
                }
                if (empty($error)) {
                    $data['nama'] = $post['nama'];
                    $this->kumalagroup->update("reg_customer", $data, ['id' => $where]);
                    $data = [];
                    $data['tanggal_lahir'] = $post['tanggal_lahir'];
                    $data['jenis_kelamin'] = $post['jenis_kelamin'];
                    $data['agama'] = $post['agama'];
                    $data['alamat'] = $post['alamat'];
                    $data['telepon'] = $post['no_hp'];
                    $data['no_npwp'] = $post['no_npwp'];

                    if (!empty($post['foto_profil'])) {
                        $data_post['path'] = "./assets/img_marketing/customer/";

                        $img = q_data("*", 'kumalagroup.customer', ['customer' => $where])->row()->gambar;
                        if (!empty($img)) {
                            $data_post['name'] = $img;
                            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
                        }

                        $ext = explode(".", $post['nm_foto_profil']);
                        $data_post['file'] = $post['foto_profil'];
                        $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
                        $data['gambar'] = curl_post($this->m_marketing->img_server . "post_img", $data_post);
                    }
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $r = $this->kumalagroup->update("customer", $data, ['customer' => $where]);
                    if ($r) {
                        $d['type'] = "success";
                        $d['title'] = "Berhasil!";
                        $d['desc'] = "Selamat, Permintaan Anda berhasil diproses!";
                        $d['button'] = "Ok!";
                    } else {
                        $d['type'] = "error";
                        $d['title'] = "Gagal!";
                        $d['desc'] = "Maaf, Permintaan Anda tidak dapat diproses!";
                        $d['button'] = "Ok!";
                    }
                } else {
                    $d['type'] = "warning";
                    $d['title'] = "Peringatan!";
                    $d['desc'] = "Maaf, Email yang Anda masukkan telah terdaftar!";
                    $d['button'] = "Ok!";
                }
                echo json_encode($d);
            }
        }
    }
    public function register_cust()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $nama = $post['nama'];
                $email = $post['email'];
                $password = password_hash($post['password'], PASSWORD_DEFAULT);
                $q = q_data("*", 'kumalagroup.reg_customer', ['email' => $email]);
                if ($q->num_rows() == 0) {
                    $data['nama'] = $nama;
                    $data['email'] = $email;
                    $data['password'] = $password;
                    $data['registered_at'] = date('Y-m-d H:i:s');
                    $r = $this->kumalagroup->insert("reg_customer", $data);
                    if ($r) {
                        $data = [];
                        $data['customer'] = $this->kumalagroup->insert_id();
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $this->kumalagroup->insert("customer", $data);
                        $d['type'] = "success";
                        $d['title'] = "Berhasil!";
                        $d['desc'] = "Selamat, Permintaan Anda berhasil diproses!";
                        $d['button'] = "Ok!";
                    } else {
                        $d['type'] = "error";
                        $d['title'] = "Gagal!";
                        $d['desc'] = "Maaf, Permintaan Anda tidak dapat diproses!";
                        $d['button'] = "Ok!";
                    }
                } else {
                    $d['type'] = "warning";
                    $d['title'] = "Peringatan!";
                    $d['desc'] = "Maaf, Email yang Anda masukkan telah terdaftar!";
                    $d['button'] = "Ok!";
                }
                echo json_encode($d);
            }
        }
    }
    public function login_cust()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $where['email'] = $post['email'];
                $q = q_data("*", 'kumalagroup.reg_customer', $where);
                if ($q->num_rows() > 0) $verify = password_verify($post['password'], $q->row()->password);
                if (!empty($verify)) {
                    $d['id'] = $q->row()->id;
                    $d['nama'] = $q->row()->nama;
                    $d['email'] = $q->row()->email;
                    $d['status'] = true;
                } else {
                    $d['status'] = false;
                    $d['type'] = "error";
                    $d['title'] = "Gagal!";
                    $d['desc'] = "Maaf, Username atau password yang Anda masukkan salah!";
                    $d['button'] = "Ok!";
                }
                echo json_encode($d);
            }
        }
    }
    public function password_cust()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $where['id'] = $post['id_customer'];
                $q = q_data("*", 'kumalagroup.reg_customer', $where);
                if ($q->num_rows() > 0) $verify = password_verify($post['password_lama'], $q->row()->password);
                if (!empty($verify)) {
                    $data['password'] = password_hash($post['password_baru'], PASSWORD_DEFAULT);
                    $this->kumalagroup->update("reg_customer", $data, $where);
                    $d['type'] = "success";
                    $d['title'] = "Berhasil!";
                    $d['desc'] = "Selamat, Password Anda berhasil diubah!";
                    $d['button'] = "Ok!";
                } else {
                    $d['type'] = "error";
                    $d['title'] = "Gagal!";
                    $d['desc'] = "Maaf, Password yang Anda masukkan salah!";
                    $d['button'] = "Ok!";
                }
                echo json_encode($d);
            }
        }
    }
}
