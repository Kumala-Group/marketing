<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test_drive extends CI_Controller
{

	public $coverage;
	public $id_perusahaan;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_marketing');
		$this->load->model('m_wuling_marketing_support');
		$this->coverage = q_data("*", 'kumalagroup.users', ['nik' => $this->session->userdata('nik')])->row('coverage');
		$this->id_perusahaan = q_data("*", 'kumalagroup.users', ['nik' => $this->session->userdata('nik')])->row('id_perusahaan');
	}

	public function index()
	{
		$index = "wuling_test_drive";
		if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
			//$post = $this->input->post();
			//debug($post);
			//if ($post) {
			//	if (!empty($post['datatable'])) echo $this->m_wuling_marketing_support->get_survei_do($post['perusahaan'],$post['tahun'],$post['bulan']);
			//} else {
			$data = array(
				'content' 	=> "pages/marketing_support/wuling/test_drive",
				'index'  	=> $index,
				'nama_bulan' => $this->m_wuling_marketing_support->nama_bulan()
			);
			$this->load->view('index', $data);
			//}
		}
	}

	public function select2_cabang()
	{
		if ($this->id_perusahaan == $this->coverage) {
			$data	= $this->m_wuling_marketing_support->select2_cabang($this->id_perusahaan);
		}
		if ($this->id_perusahaan != $this->coverage) {
			$data	= $this->m_wuling_marketing_support->select2_cabang($this->coverage);
		}
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function select2_tahun()
	{
		$data  	= $this->m_wuling_marketing_support->select2_tahun();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function select2_bulan()
	{
		$data 	= $this->m_wuling_marketing_support->select2_bulan();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function get()
	{
		$id_perusahaan	 	= $this->input->post('cabang');
		$tahun 		= $this->input->post('tahun');
		$bulan 		= $this->input->post('bulan');
		// $id_sales 	= $this->_get_sales_from_coverage($cabang);
		echo $this->m_wuling_marketing_support->get_data_test_drive($id_perusahaan, $tahun, $bulan);
	}

	public function verifikasi()
	{
		$id_test_drive = $this->input->post('id_test_drive');
		$this->m_wuling_marketing_support->verifikasi_test_drive($id_test_drive);
	}
}
