<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_ticketing_dashboard extends CI_Controller {

	public function __construct() {
	    parent::__construct();
		$this->load->model('model_ticketing');
	}
	//Menampilkan data yang sudah solved
	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Dashboard Ticket";
			$d['class'] = "ticketing";
			$d['data'] = array(
				'list_cabang' => $this->model_ticketing->getAllCabang(),
				'list_dep' => $this->model_ticketing->getAllDepartement(),
				'list_brand' => $this->model_ticketing->getAllBrand(),
				'tickets' => $this->model_ticketing->getAllTicket(),
				'graph_brand' => $this->model_ticketing->get_graph_brand(date('m'), date('Y')),
				'graph_status' => $this->model_ticketing->get_graph_status(date('m'), date('Y')),
				'total_ticket' => $this->model_ticketing->total_ticket(date('m'), date('Y')),
				'graph_level' => $this->model_ticketing->get_graph_level(date('m'), date('Y')),
				'graph_dep' => $this->model_ticketing->get_graph_dep(date('m'), date('Y'))
				
			);
			$d['content'] = 'ticketing/dashboard';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function sortir() {
		$post = $this->input->post();
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Dashboard Ticket";
			$d['class'] = "ticketing";
			$d['data'] = array(
				'list_cabang' => $this->model_ticketing->getAllCabang(),
				'list_dep' => $this->model_ticketing->getAllDepartement(),
				'list_brand' => $this->model_ticketing->getAllBrand(),
				'tickets' => $this->model_ticketing->getAllTicket(),
				'graph_brand' => $this->model_ticketing->get_graph_brand($post['bulan'], $post['tahun']),
				'graph_status' => $this->model_ticketing->get_graph_status($post['bulan'], $post['tahun']),
				'total_ticket' => $this->model_ticketing->total_ticket($post['bulan'], $post['tahun']),
				'graph_level' => $this->model_ticketing->get_graph_level($post['bulan'], $post['tahun']),
				'graph_dep' => $this->model_ticketing->get_graph_dep($post['bulan'], $post['tahun']),
				'desc_sortir' => array(
					'bulan' => $post['bulan'],
					'tahun' => $post['tahun']
				)
			);
			$d['content'] = 'ticketing/dashboard';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
