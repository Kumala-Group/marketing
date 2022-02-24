<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_profil_user extends CI_Model
{
    public function simpan_data_profil()
    {
        $id = $this->input->post('id_profil');
        $nama_level = $this->input->post('nama_level');
        $level = $this->input->post('level');
        $deskripsi = $this->input->post('deskripsi');
        $akses_menu = $this->input->post('akses_menu');
        $cek = cek_duplikat('db', 'p_profil', 'id', 'id', $id);
        if ($cek > 0) {
            $update_data = array(
                'nama_level'    => $nama_level,
                'level'         => $level,
                'deskripsi'     => $deskripsi,
                'url'           => $akses_menu,
            );
            $this->db->where('id', $id);
            $this->db->update('p_profil', $update_data);
            echo "data_update";
        }
        if ($cek == 0) {
            $inser_data = array(
                'nama_level'    => $nama_level,
                'level'         => $level,
                'deskripsi'     => $deskripsi,
                'url'           => $akses_menu,
            );
            $this->db->insert('p_profil', $inser_data);
            echo "data_insert";
        }
    }

    public function get_data_profil()
    {
        // $id_profil = $this->session->userdata('id_profil');
        $this->db->select('*');
        $this->db->from('p_profil');
        // $this->db->where('id', $id_profil);
        $data = $this->db->get();
        return $data->result();
    }

    public function edit_data_profil()
    {
        $id_profil = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('p_profil');
        $this->db->where('id', $id_profil);
        $data = $this->db->get();
        foreach ($data->result() as $dt) {
            $akses = array(
                'id_profil' => $dt->id,
                'nama_level' => $dt->nama_level,
                'level' => $dt->level,
                'deskripsi' => $dt->deskripsi,
                'url' => $dt->url,
            );
        }
        if (empty($akses)) {
            $akses = array(
                'id_profil' => '',
                'nama_level' => '',
                'level' => '',
                'deskripsi' => '',
                'url' => '',
            );
        }
        return $akses;
    }
}
