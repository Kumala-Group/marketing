<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_do extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_marketing_support');
    }
    public function index()
    {
        $index = "wuling_cust_do";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['datatable'])) echo $this->m_wuling_marketing_support->customer_do($post['perusahaan']);
            } else {
                $d['content'] = "pages/marketing_support/wuling/customer_do";
                $d['index'] = $index;
                $d['lokasi'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 5])->result();
                $this->load->view('index', $d);
            }
        }
    }
}
