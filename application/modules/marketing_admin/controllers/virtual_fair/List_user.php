<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class List_user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "list_user";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['datatable'])) {
                    $select = ["r.nama", "r.email", "c.telepon", "DATE_FORMAT(r.registered_at, '%d-%m-%Y') as tanggal"];
                    $table  = 'kumalagroup.reg_customer r';
                    $join   = ['kumalagroup.customer c' => "r.id = c.customer"];
                    $list = q_data_datatable($select, $table, $join, null, null, array('r.id', 'desc'));
                    echo q_result_datatable($select, $table, $join, null, $list ?? []);
                }
            } else {
                $d['content'] = "pages/virtual_fair/list_user";
                $d['index'] = $index;
                $this->load->view('index', $d);
            }
        }
    }
}
