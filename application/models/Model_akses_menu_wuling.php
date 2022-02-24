<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_akses_menu_wuling extends CI_Model
{


    public function akses_menu()
    {
        $id_user = $this->session->userdata('id_user');
        $this->db_wuling_as->select('*');
        $this->db_wuling_as->from('after_sales_users as');
        $this->db_wuling_as->where('id_users', $id_user);
        $data = $this->db_wuling_as->get();
        foreach ($data->result() as $row) {
            $access = $row->access;
        }
        return $access;
    }
}
