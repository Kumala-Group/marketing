<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model_konfigurasi_user extends CI_Model
{

    public function brand_hino()
    {
        $this->db->select('nama_brand, id_brand');
        $this->db->from('brand');
        $this->db->where('id_brand', '3');
        $data = $this->db->get();
        return $data->result();
    }

    public function brand_honda()
    {
        $this->db->select('nama_brand, id_brand');
        $this->db->from('brand');
        $this->db->where('id_brand', '17');
        $data = $this->db->get();
        return $data->result();
    }

    public function brand_mazda()
    {
        $this->db->select('nama_brand, id_brand');
        $this->db->from('brand');
        $this->db->where('id_brand', '4');
        $data = $this->db->get();
        return $data->result();
    }

    public function brand_mercy()
    {
        $this->db->select('nama_brand, id_brand');
        $this->db->from('brand');
        $this->db->where('id_brand', '18');
        $data = $this->db->get();
        return $data->result();
    }

    public function brand_wuling()
    {
        $this->db->select('nama_brand, id_brand');
        $this->db->from('brand');
        $this->db->where('id_brand', '5');
        $data = $this->db->get();
        return $data->result();
    }

    public function coverage_hino()
    {
        $this->db->select('*');
        $this->db->from('perusahaan');
        $this->db->where('id_brand', '3');
        $data = $this->db->get();
        return $data->result();
    }

    public function coverage_honda()
    {
        $this->db->select('*');
        $this->db->from('perusahaan');
        $this->db->where('id_brand', '17');
        $data = $this->db->get();
        return $data->result();
    }

    public function coverage_mazda()
    {
        $this->db->select('*');
        $this->db->from('perusahaan');
        $this->db->where('id_brand', '4');
        $data = $this->db->get();
        return $data->result();
    }

    public function coverage_marcy()
    {
        $this->db->select('*');
        $this->db->from('perusahaan');
        $this->db->where('id_brand', '18');
        $data = $this->db->get();
        return $data->result();
    }

    public function coverage_wuling()
    {
        $this->db->select('*');
        $this->db->from('perusahaan');
        $this->db->where('id_brand', '5');
        $data = $this->db->get();
        return $data->result();
    }

    public function data_profil()
    {
        $this->db->select('*');
        $this->db->from('p_profil');
        $data = $this->db->get();
        return $data->result();
    }

    public function data_user()
    {
        $this->load->library('datatables');
        $this->datatables->select('us.status_aktif, us.nik, us.username, pp.nama_level, kr.nama_karyawan, jb.nama_jabatan, CONCAT(pr.singkat, " - ",pr.lokasi) as perusahaan, us.id_user, pp.id');
        $this->datatables->from('kmg.users us');
        $this->datatables->join('kmg.p_profil pp', 'pp.id = us.id_profil');
        $this->datatables->join('kmg.karyawan kr', 'kr.nik = us.nik');
        $this->datatables->join('kmg.perusahaan pr', 'pr.id_perusahaan = us.id_perusahaan');
        $this->datatables->join('kmg.jabatan jb', 'jb.id_jabatan = us.id_jabatan');
        // $this->datatables->add_column('id', '$1', 'id_profil');
        echo $this->datatables->generate();
    }

    public function simpan_data_user()
    {
        $nik            = $this->input->post('nik');
        $username       = $this->input->post('username');
        $level          = $this->input->post('level');
        $password       = $this->input->post('password');
        $coverage       = $this->input->post('coverage');
        // $status_aktif   = $this->input->post('status_aktif');
        $foto           = $this->input->post('foto');
        // $akses_menu     = $this->input->post('akses_menu');
        $cek            = cek_duplikat('db', 'karyawan', 'nik', 'nik', $nik);
        $cek_data       = cek_duplikat('db', 'users', 'nik', 'nik', $nik);
        $this->db->select('*');
        $this->db->from('p_profil');
        $this->db->where('id', $level);
        $data_url = $this->db->get();
        foreach ($data_url->result() as $dt) {
            $url = $dt->url;
            $id_level = $dt->id;
        }
        if (empty($cek)) {
            echo "data_fail";
        }
        if ($cek > 0 && $cek_data == 0) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->where('nik', $nik);
            $this->db->where('status_aktif', 'Aktif');
            $data_karyawan = $this->db->get();
            foreach ($data_karyawan->result() as $row) {

                $insert_data = array(
                    'id_level'      => $level,
                    'id_perusahaan' => $row->id_perusahaan,
                    'id_jabatan'    => $row->id_jabatan,
                    'coverage'      => $coverage,
                    'username'      => $username,
                    'password'      => md5($password),
                    'id_profil'     => $id_level,
                    'nama_lengkap'  => $row->nama_karyawan,
                    'nik'           => $nik,
                    'foto'          => $foto,
                    'status_aktif'  => 'on',
                );
                $this->db->insert('users', $insert_data);
            }
            echo "data_sukses";
        }
        if ($cek_data > 0) {
            $update_data = array(
                'username'      => $username,
                'coverage'      => $coverage,
                'password'      => md5($password),
                'id_profil'     => $id_level,
            );
            $this->db->where('nik', $nik);
            $this->db->update('users', $update_data);
            echo "data_update";
        }
    }

    public function profil($id)
    {
        $this->db->select('*');
        $this->db->from('p_profil');
        $this->db->where('id', $id);
        $data = $this->db->get();
        foreach ($data->result() as $dt) {
            $level = $dt->id;
        }
        return $level;
    }

    public function menu()
    {
        $id_user = $this->session->userdata('id_profil');
        $this->db->select('*');
        $this->db->from('p_profil');
        $this->db->where('id', $id_user);
        $data = $this->db->get();
        foreach ($data->result() as $dt) {
            $access = $dt->url;
        }
        return $access;
    }

    public function update_status()
    {
        $status_aktif = $this->input->post('status');
        $nik = $this->input->post('nik');
        $update_data_status = array(
            'status_aktif'  => $status_aktif,
        );
        $this->db->where('nik', $nik);
        $this->db->update('users', $update_data_status);
        echo "updates";
    }

    public function update_id_brand_view()
    {
        $id_brand = $this->input->post('brand');
        $id_user = $this->session->userdata('id_user');
        $dt = array(
            'id_brand_view'  => $id_brand,
        );
        $this->db->where('id_user', $id_user);
        $this->db->update('users', $dt);
        echo "updates";
    }

    public function view_data_brand()
    {
        $id_brand_ = array('3', '5', '17', '18', '21');
        $data = $this->db->select("*")->from('brand')->where_in("id_brand", $id_brand_)->get();
        return $data;
    }

    public function GetIdBrand()
    {
        $id_user_ = $this->session->userdata('id_user');
        $data = $this->db->select("id_brand_view")->get_where('users', "id_user = $id_user_");
        return $data->row('id_brand_view');
    }
}
