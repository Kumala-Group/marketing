<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class G_honda_financial_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $cek = $this->session->userdata('status');
        $level = $this->session->userdata('level');
        if ($cek == 'login' && $level == 'group') {
            $d['title'] = 'Honda';
            $d['pt'] = 'Kumala Group';
            $d['color'] = '#0c0c0c;';
            $d['icon'] = 'fa-pie-chart';
            $this->load->view('honda/dashboard', $d);
        } else {
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
            $this->load->view('honda/dashboard_isi', $d);
        } else {
            redirect('group/logout');
        }
    }
}
