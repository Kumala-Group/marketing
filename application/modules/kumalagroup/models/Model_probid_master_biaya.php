<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH . 'third_party/vendor/autoload.php');

use Rakit\Validation\Validator;

class Model_probid_master_biaya extends CI_Model
{

    public function akun()
    {
        $kode_akun = ['608009', '608010'];
        $this->kumalagroup->select('*');
        $this->kumalagroup->from('akun');
        $this->kumalagroup->where('id_jenis_akun', '5');
        $this->kumalagroup->where_in('kode_akun', $kode_akun);
        $this->kumalagroup->order_by('nama_akun');

        $data = $this->kumalagroup->get();
        return $data->result();
    }

    public function simpan_master_biaya()
    {
        $user = $this->session->userdata('nik');
        $id_biaya = $this->input->post('id_biaya');
        $kategori_biaya = $this->input->post('kategori_biaya');
        $kode_akun = $this->input->post('akun');
        $nama_biaya = $this->input->post('nama_biaya');
        $deskripsi = $this->input->post('deskripsi');
        $cek = cek_duplikat('kumalagroup', 'jenis_biaya', 'id_biaya', 'id_biaya', $id_biaya);

        /* Memanggil file rakitvalidate */


        // Inisialisai Rakit Validate
        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'kategori'      => $kategori_biaya,
                'kode_akun'     => $kode_akun,
                'nama_biaya'    => $nama_biaya,
                'deksripsi'     => $deskripsi,

            ],
            /* Validasi yg dilakukan */
            [
                'kategori'      => 'required|',
                'kode_akun'     => 'required|',
                'nama_biaya'    => 'required|',
                'deksripsi'     => 'required|',

            ]
        );
        /* Membuat pesan custom */
        $validasi->setMessages([
            'kategori:required'     => 'Kategori tidak boleh kosong',
            'kode_akun:required'    => 'Akun tidak boleh kosong',
            'nama_biaya:required'   => 'Nama Biaya tidak boleh kosong',
            'deksripsi:required'    => 'Deksripsi tidak boleh kosong',
        ]);
        $validasi->validate();
        /* Jika data tidak valid */
        if ($validasi->fails()) {
            $pesan_errors = $validasi->errors()->all();
            /* Parsing error */
            for ($i = 0; $i < count($pesan_errors); $i++) {
                echo $pesan_errors[$i] . ", ";
            }
            exit;
        }
        if ($cek > 0) {
            $update_data = array(
                'kategori_biaya'    => $kategori_biaya,
                'kode_akun'         => $kode_akun,
                'nama_biaya'        => $nama_biaya,
                'deskripsi'         => $deskripsi,
                'user'              => $user
            );

            $this->kumalagroup->where('id_biaya', $id_biaya);
            $this->kumalagroup->update('jenis_biaya', $update_data);
            echo "data_update";
        }

        if ($cek == 0) {
            $insert_data = array(
                'kategori_biaya'    => $kategori_biaya,
                'kode_akun'         => $kode_akun,
                'nama_biaya'        => $nama_biaya,
                'deskripsi'         => $deskripsi,
                'user'              => $user
            );

            $this->kumalagroup->insert('jenis_biaya', $insert_data);
            echo "data_insert";
        }
    }

    public function data_jenis_biaya()
    {
        $this->load->library('datatables');
        $this->datatables->select('jb.id_biaya, jb.kategori_biaya, jb.nama_biaya, jb.kode_akun, jb.deskripsi, ak.nama_akun');
        $this->datatables->from('kumalagroup.jenis_biaya jb');
        $this->datatables->join('kumalagroup.akun ak', 'ak.kode_akun = jb.kode_akun');
        echo $this->datatables->generate();
    }

    public function perusahaan()
    {
        $id_user_ = $this->session->userdata('id_user');
        $id_brand_view = $this->db->get_where('users', "id_user = $id_user_")->row('id_brand_view');
        // $id_brand = $this->session->userdata('id_brand_view');
        $this->db->select('*');
        $this->db->from('perusahaan');
        $this->db->where('id_brand', $id_brand_view);
        $data = $this->db->get();
        return $data->result();
    }

    public function simpan_detail_biaya()
    {
        $id_user_ = $this->session->userdata('id_user');
        $id_brand_view = $this->db->get_where('users', "id_user = $id_user_")->row('id_brand_view');
        // $brand = $this->session->userdata('id_brand_view');
        $user = $this->session->userdata('nik');
        $detail_kategori = $this->input->post('detail_kategori');
        $perusahaan = $this->input->post('perusahaan');
        $id_pelanggan = $this->input->post('id_pelanggan');
        $deskripsi_detail = $this->input->post('deskripsi_detail');
        $type_biaya = $this->input->post('type_biaya');
        $cek = cek_duplikat('kumalagroup', 'detail_biaya', 'id_pelanggan', 'id_pelanggan', $id_pelanggan);
        $brand = $this->db->get_where('perusahaan', array('id_perusahaan' => $perusahaan))->row('id_brand');

        // Inisialisai Rakit Validate
        $validator = new Validator;
        $validasi = $validator->make(
            /* Data yg ingin divalidasi */
            [
                'brand'             => $id_brand_view,
                'detail_kategori'   => $detail_kategori,
                'perusahaan'        => $perusahaan,
                'id_pelanggan'      => $id_pelanggan,
                'deskripsi'         => $deskripsi_detail,
                'id_brand_view'     => $brand,
            ],
            /* Validasi yg dilakukan */
            [
                'brand'             => 'required|',
                'detail_kategori'   => 'required|',
                'perusahaan'        => 'required|integer',
                'id_pelanggan'      => 'required|',
                'deskripsi'         => 'required|',
                'id_brand_view'     => 'required|same:brand',
            ]
        );
        /* Membuat pesan custom */
        $validasi->setMessages([
            'brand:required'            => 'Brand Tidak Boleh Kosong, Silahkan Pilih Brand',
            'detail_kategori:required'  => 'Detail Kategori Tidak Boleh Kosong',
            'perusahaan:required'       => 'Perusahaan Tidak Boleh Kosong',
            'id_pelanggan:required'     => 'Id Pelanggan Tidak Boleh Kosong',
            'deskripsi:required'        => 'Deskripsi Tidak Boleh Kosong',
            'id_brand_view:same'        => 'Brand yang anda Pilih tidak sesuai dengan Perusahaan',
        ]);
        $validasi->validate();
        /* Jika data tidak valid */
        if ($validasi->fails()) {
            $pesan_errors = $validasi->errors()->all();
            /* Parsing error */
            for ($i = 0; $i < count($pesan_errors); $i++) {
                echo $pesan_errors[$i] . ", ";
            }
            exit;
        }

        if ($cek > 0) {
            $update_data = array(
                'detail_kategori'   => $detail_kategori,
                'type_biaya'        => $type_biaya,
                'deskripsi_detail'  => $deskripsi_detail,
                'id_brand'          => $id_brand_view,
                'id_perusahaan'     => $perusahaan,
                'user'              => $user

            );
            $this->kumalagroup->where('id_pelanggan', $id_pelanggan);
            $this->kumalagroup->update('detail_biaya', $update_data);
            echo 'update_detail';
        }

        if ($cek == 0) {
            $insert_data = array(
                'detail_kategori'   => $detail_kategori,
                'id_pelanggan'      => $id_pelanggan,
                'type_biaya'        => $type_biaya,
                'deskripsi_detail'  => $deskripsi_detail,
                'id_brand'          => $id_brand_view,
                'id_perusahaan'     => $perusahaan,
                'user'              => $user
            );
            $this->kumalagroup->insert('detail_biaya', $insert_data);
            echo 'inser_detail';
        }
    }
}
