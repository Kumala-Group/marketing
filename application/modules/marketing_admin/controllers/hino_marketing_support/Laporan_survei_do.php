<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_survei_do extends CI_Controller
{

	public $coverage;
	public $id_perusahaan;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_marketing');
		$this->load->model('m_hino_laporan_survei_do');
		
		$this->coverage = q_data("*", 'kumalagroup.users', ['nik'=>$this->session->userdata('nik')])->row('coverage');
		$this->id_perusahaan = q_data("*", 'kumalagroup.users', ['nik'=>$this->session->userdata('nik')])->row('id_perusahaan');
                
	}

	public function index()
	{
		$index = "hino_laporan_survei_do";
		if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
			//$post = $this->input->post();
			//debug($post);
			//if ($post) {
			//	if (!empty($post['datatable'])) echo $this->m_hino_laporan_survei_do->get_survei_do($post['perusahaan'],$post['tahun'],$post['bulan']);
			//} else {
				$data = array(
					'content' 	=> "pages/marketing_support/hino/laporan/survei_do",
					'index'  	=> $index,
				);
				$this->load->view('index', $data);
			//}
		}
	}

	public function select2_cabang()
	{
        if ($this->id_perusahaan == $this->coverage) {            
            $data	= $this->m_hino_laporan_survei_do->select2_cabang($this->id_perusahaan);
        } 
		if ($this->id_perusahaan != $this->coverage) {
            $data	= $this->m_hino_laporan_survei_do->select2_cabang($this->coverage);            
        }		
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function select2_tahun()	{		
		$data  	= $this->m_hino_laporan_survei_do->select2_tahun();			
		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	public function select2_bulan()	{		
		$data 	= $this->m_hino_laporan_survei_do->select2_bulan();			
		header('Content-Type: application/json');
		echo json_encode($data);	
	}

	public function get()
	{				
		$cabang	 	= $this->input->post('cabang');
		$tahun 		= $this->input->post('tahun');
		$bulan 		= $this->input->post('bulan');
		$id_sales 	= $this->_get_sales_from_coverage($cabang);		
		$data 		= $this->m_hino_laporan_survei_do->get_survei_do($id_sales,$tahun,$bulan);
		header('Content-Type: application/json');
		echo json_encode(['aaData' => $data]);
	}

	public function export()
	{
		$cabang 	= $this->input->post('opt-perusahaan');		
		$tahun 		= $this->input->post('opt-tahun');
		$bulan 		= $this->input->post('opt-bulan');
		$id_sales 	= $this->_get_sales_from_coverage($cabang);		
		$data 		= $this->m_hino_laporan_survei_do->get_survei_do($id_sales,$tahun,$bulan);		
		$exportExcel = new PHPExport;
		$exportExcel->dataSet($data)
			->rataTengah('0,2,3,4,8,18,19,22,23,26,31,32,34')			
			->warnaHeader('2,218,240', 'FFFFFF')
			->excel2003('Survei DO '. $this->m_hino_laporan_survei_do->get_nama_perusahaan($cabang) .'-'. date('YmdHis'));
	}

	
	private function _get_sales_from_coverage($v_coverage)
    {		
		$coverage = explode(',', $v_coverage);
		$arrSales = array();	
		$query_sales = $this->db_hino
			->select("ads.id_sales")
			->from("adm_sales ads")
			->where("ads.status_aktif","A")
			->where("ads.status_leader","n")
			->where_in("ads.id_perusahaan",$coverage)			
			->get();		
		foreach ($query_sales->result() as $dt) {
			$arrSales[] = $dt->id_sales;
		}
		return $arrSales;
	}


	
}
