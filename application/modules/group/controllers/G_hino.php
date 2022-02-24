<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class G_hino extends CI_Controller {
	function __construct() {
        parent::__construct();
    }
    

	public function index()
    {
        $cek=$this->session->userdata('status');
        $level=$this->session->userdata('level');
        if($cek=='login' && $level=='group'){
            $d['title']='Hino'; 
            $d['pt']='Kumala Group'; 
            $d['color']='#139c2d;';
            $d['icon']='fa-pie-chart';   
            $this->load->view('hino/dashboard',$d);
        }else {
            redirect('group/logout');
        }

    }

    function data()
    {
        error_reporting(0);
        $cek = $this->session->userdata('status');
        $level = $this->session->userdata('level');
        if ($cek == 'login' && $level == 'group') {
            $d['month'] = $this->input->post('bln');
            $d['year'] = $this->input->post('thn');
            $this->load->view('hino/dashboard_isi', $d);
        } else {
            redirect('group/logout');
        }
    }


}

?>
