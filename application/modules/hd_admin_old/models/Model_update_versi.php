<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_update_versi extends CI_Model
{
    public function all($brand)
    {
        $q = $this->db_helpdesk->query("SELECT * FROM update_versi WHERE brand = '$brand'");
        return $q;
    }

    public function get_all_data($id_versi_detail)
    {
        $q = $this->db_helpdesk->query("SELECT * FROM update_versi WHERE id_versi ='$id_versi_detail'");
        $rows = $q->num_rows();
        if ($rows > 0) {
            $results = $q->result();
            //return $q;
            return $results[0];
        } else {
            return null;
        }
    }
    public function last_kode()
    {
        $q = $this->db_helpdesk->query("SELECT MAX(id_versi) as kode FROM update_versi_detail");
        $row = $q->num_rows();
        if ($row > 0) {
            $rows = $q->result();
            $hasil = (int) $rows[0]->kode;
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    public function last_kode_no_urut($id_versi)
    {
        $q = $this->db_helpdesk->query("SELECT MAX(no_urut) as kode FROM update_versi_detail WHERE id_versi = '$id_versi'");
        $row = $q->num_rows();
        if ($row >= 0) {
            $rows = $q->result();
            $hasil = (int) $rows[0]->kode;
        } else {
            $hasil = 0;
        }
        return $hasil;
    }

    public function hapus_versi_update($id)
    {
        $this->db_helpdesk->delete("update_versi_detail", $id);
    }
    public function get_data_update($id_ver)
    {
        $q = $this->db_helpdesk->get_where("update_versi", $id_ver);
        return $q;
    }
    public function update_versi($iv, $id_ver)
    {
        $this->db_helpdesk->update("update_versi", $iv, $id_ver);
    }
    public function update_versi_detail($id, $dv_id)
    {
        $this->db_helpdesk->update("update_versi_detail", $dv_id, $id);
    }
}
