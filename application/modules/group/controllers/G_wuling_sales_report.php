<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class G_wuling_sales_report extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('M_wuling_sales_report','m_sales_report');
    }
    

	public function index()
    {
        $cek=$this->session->userdata('status');
        $level=$this->session->userdata('level');
        if($cek=='login' && $level=='group'){   
            $d['x']='x';
            $this->load->view('wuling/sales_report',$d);
        }else {
            redirect('group/logout');
        }

    }

    function data()
    {
        // error_reporting(0);
        $cek = $this->session->userdata('status');
        $level = $this->session->userdata('level');
        if ($cek == 'login' && $level == 'group') {
            $d['unit_model'] = $this->input->post('unit_model');
			$d['thn'] = $this->input->post('thn');			
			$d['performance'] = $this->m_sales_report->get_performance_data($d['unit_model'],$d['thn']);
			$this->load->view('wuling/sales_report_isi',$d);
        } else {
            redirect('group/logout');
        }
    }


}

?>
