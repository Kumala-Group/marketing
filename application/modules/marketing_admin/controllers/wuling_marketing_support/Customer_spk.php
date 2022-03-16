<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_spk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_marketing_support');
    }
    public function index()
    {
        $index = "wuling_cust_spk";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['datatable'])) echo $this->m_wuling_marketing_support->customer_spk($post['perusahaan']);
            } else {
                $d['content'] = "pages/marketing_support/wuling/customer_spk";
                $d['index'] = $index;
                $d['lokasi'] = q_data("*", 'kumk6797_kmg.perusahaan', ['id_brand' => 5])->result();
                $this->load->view('index', $d);
            }
        }
    }
}
