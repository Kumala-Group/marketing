<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class G_wuling_login_history_report extends CI_Controller {
	function __construct() {
        parent::__construct();
    }
    

	public function index()
    {
        $cek=$this->session->userdata('status');
        $level=$this->session->userdata('level');
        if($cek=='login' && $level=='group'){   
            $d['x']='x';
            $this->load->view('wuling/login_history_report',$d);
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
            $job_desk=$this->input->post('jd');
            $d['jd']=$job_desk;
            if($job_desk=='n'){
                $this->load->view('wuling/login_history_report_isi_sales', $d);
            }else if($job_desk=='s'){
                $this->load->view('wuling/login_history_report_isi_supervisor', $d);
            }else{
                $this->load->view('wuling/login_history_report_isi_sm', $d);
            } 
        } else {
            redirect('group/logout');
        }
    }


}

?>
