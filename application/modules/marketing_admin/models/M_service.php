<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_service extends CI_Model
{
    // untuk ambil semua tipe unit
    public function get_all_tipe_unit($db)
    {
        $result = $this->$db->select('kode_unit,varian,warna')
        ->from('unit u')
        ->join('p_warna p', 'p.id_warna=u.id_warna')
        ->order_by('u.varian', 'ASC')
        ->get()
        ->result();

        return $result;
    }

    // untuk simpan data universal
    public function insert_data($db, $tabel, $data)
    {
        $this->$db->trans_start();
        $this->$db->insert($tabel, $data);
        $this->$db->trans_complete();

        if ($this->$db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}