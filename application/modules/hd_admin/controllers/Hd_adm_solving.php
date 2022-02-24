<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_solving extends CI_Controller {

	public function __construct() {
	    parent::__construct();
		$this->load->model('model_ticketing');
	}
	//Menampilkan data yang sudah solved
	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Tiket Selesai";
			$d['class'] = "ticketing";
			// $d['data'] = $this->model_ticketing->alldone_baru();
			$d['data'] = array(
				'list_cabang' => $this->model_ticketing->getAllCabang(),
				'list_dep' => $this->model_ticketing->getAllDepartement(),
				'list_brand' => $this->model_ticketing->getAllBrand(),
				'tickets' => $this->model_ticketing->getAllTicket(),
				'download' => array(
					'tanggal_dari' => '', 
					'tanggal_sampai' => '', 
					'brand' => '', 
					'cabang' => '', 
					'dep' => ''
				)
			);
			$d['content'] = 'ticketing/view_solving';
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
			$d['judul']=" Data Tiket Selesai";
			$d['class'] = "ticketing";
			// $d['data'] = $this->model_ticketing->alldone_baru();
			$d['data'] = array(
				'list_cabang' => $this->model_ticketing->getAllCabang(),
				'list_dep' => $this->model_ticketing->getAllDepartement(),
				'list_brand' => $this->model_ticketing->getAllBrand(),
				'tickets' => $this->model_ticketing->getAllTicket($post['sort_tanggal_dari'], $post['sort_tanggal_sampai'], $post['brand'], $post['cabang'], $post['dep']),
				'download' => array(
					'tanggal_dari' => $post['sort_tanggal_dari'], 
					'tanggal_sampai' => $post['sort_tanggal_sampai'], 
					'brand' => $post['brand'], 
					'cabang' => $post['cabang'], 
					'dep' => $post['dep']
				)
			);
			$d['content'] = 'ticketing/view_solving';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function edit($id_ticket) {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Tiket Selesai";
			$d['class'] = "ticketing";
			// $d['data'] = $this->model_ticketing->alldone_baru();
			$all_T = $this->model_ticketing->getAllTicket();
			$all_C = count($all_T);
			for($x=0; $x<$all_C; $x++){
				if($all_T[$x]['id'] == $id_ticket){
					$res = $all_T[$x];
				}
			}
			$d['data'] = array(
				'list_cabang' => $this->model_ticketing->getAllCabang(),
				'list_dep' => $this->model_ticketing->getAllDepartement(),
				'list_brand' => $this->model_ticketing->getAllBrand(),
				'tickets' => $res
			);
			$d['content'] = 'ticketing/view_edit';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function simpan_edited() {
		$post = $this->input->post();
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$this->model_ticketing->updateTicket($post);
			redirect('hd_adm_solving/edit/'.$post['id_ticket'],'refresh');
		}else{
			redirect('login','refresh');
		}
	}

	public function cetak_excel(){
		$post = $this->input->post();
		// $this->load->library('phpexcel');
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0);
		$excel->getActiveSheet()->setTitle('ticketing');
		
		$this->load->model('model_ticketing');
		$items = $this->model_ticketing->cetak_ticket($post['sort_tanggal_dari'], $post['sort_tanggal_sampai'], $post['brand'], $post['cabang'], $post['dep']);
		$cols = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N");
		$val = array("No","NIK Pengadu","Nama Pengadu","Cabang","Tanggal Masuk","Type Job","Nama Executor","Tanggal Mulai","Estimasi Selesai","Tanggal Selesai","Brand","Departement","Status","Detail Problem");
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(40);
		for($i=0;$i<14;$i++){
			$excel->getActiveSheet()->setCellValue($cols[$i].'1', $val[$i]);
		}
		$index = 2;
		foreach($items as $dt){
			for($i=0;$i<14;$i++){
				$excel->getActiveSheet()->setCellValue("A".$index, $index-1);
				$excel->getActiveSheet()->setCellValue("B".$index, $dt['nik']);
				$excel->getActiveSheet()->setCellValue("C".$index, $dt['nama']);
				$excel->getActiveSheet()->setCellValue("D".$index, $dt['cabang']);
				$excel->getActiveSheet()->setCellValue("E".$index, $dt['tanggal_masuk']);
				$excel->getActiveSheet()->setCellValue("F".$index, $dt['type_job']);
				$excel->getActiveSheet()->setCellValue("G".$index, $dt['nama_executor']);
				$excel->getActiveSheet()->setCellValue("H".$index, $dt['tanggal_mulai']);
				$excel->getActiveSheet()->setCellValue("I".$index, $dt['estimasi_selesai']);
				$excel->getActiveSheet()->setCellValue("J".$index, $dt['tanggal_selesai']);
				$excel->getActiveSheet()->setCellValue("K".$index, $dt['brand']);
				$excel->getActiveSheet()->setCellValue("L".$index, $dt['departement']);
				$excel->getActiveSheet()->setCellValue("M".$index, $dt['status_ticket']);
				$excel->getActiveSheet()->setCellValue("N".$index, $dt['detail_problem']);
			}
			$index++;	
		}
		// $excel->getActiveSheet()->fromArray($users);
		$filename='ticketing '.date('d-m-Y').'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5'); 
		$objWriter->save('php://output');
		redirect('hd_adm_solving','refresh');
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
