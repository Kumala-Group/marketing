<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_akses_menu_honda extends CI_Model
{


    public function akses_menu()
    {
        $id_user = $this->session->userdata('id_user');
        $this->db_honda_as->select('*');
        $this->db_honda_as->from('after_sales_users as');
        $this->db_honda_as->where('id_users', $id_user);
        $data = $this->db_honda_as->get();
        foreach ($data->result() as $row) {
            $access = $row->access;
        }
        if(empty($access)){
            return null;
        } else {
            return $access;
        }
    }
}
