<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database('default', TRUE);
		$this->load->model('model_ticket');
		$this->load->helper(array('form', 'url'));
	}

	public function index()
	{
		error_reporting(0);
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if (!empty($cek) && $level == 'karyawan') {
			$d['judul'] = "Dashboard";
			$d['class'] = "new_ticket";
			$d['category'] = '';
			$d['karyawan'] = '';
			$d['aktif'] = '';
			$d['resign'] = '';
			$d['habis_kontrak'] = '';
			$d['permanen'] = '';
			$d['content'] = 'ticket/new_ticket/view';
			$d['data'] = array(
				'list_brand' => $this->model_ticket->getAllBrand(),
				'list_dep' => $this->model_ticket->getAllDepartement(),
				'cabang' => $this->model_ticket->getCabang($this->session->userdata('id_perusahaan')),
				'generate_ticket_number' => $this->model_ticket->create_ticket_number()
			);
			$this->load->view('ticket_home', $d);
		} else {
			redirect('login', 'refresh');
		}
	}

	public function simpan(){
		$data = $this->input->post();

		$gambar_ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
		$gambar_newname = rand(0,99999).'-'.date('dmy').'.'.$gambar_ext;
		$data['gambar_name'] = $gambar_newname;
		move_uploaded_file($_FILES['gambar']['tmp_name'], 'assets/ticketing_gambar/'.$gambar_newname);

		$dokumen_ext = pathinfo($_FILES['dokumen']['name'], PATHINFO_EXTENSION);
		$dokumen_newname = rand(0,99999).'-'.date('dmy').'.'.$dokumen_ext;
		$data['dokumen_name'] = $dokumen_newname;
		move_uploaded_file($_FILES['dokumen']['tmp_name'], 'assets/ticketing_dokumen/'.$dokumen_newname);
		
		$this->model_ticket->saveNewTicket($data);
		redirect('ticket_list');
	}

	public function hapus($id){
		$this->model_ticket->deleteTicket($id);
		redirect('ticket_list');
	}
	
}
