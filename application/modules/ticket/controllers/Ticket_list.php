<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_list extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_ticket');
			$this->load->database('default', TRUE);
	}

	public function index()
	{
		error_reporting(0);
		$cek = $this->session->userdata('logged_in');
		if (empty($cek)) {
			redirect('login_ticketing/logout', 'refresh');
		}
		$d['class'] = "list_ticket";
		$d['data'] = array(
			'items' => $this->model_ticket->getAllItems($this->session->userdata('username')),
			'list_brand' => $this->model_ticket->getAllBrand(),
			'list_dep' => $this->model_ticket->getAllDepartement()
		);
		$d['content'] = 'ticket/list_ticket/view';
		$this->load->view('ticket_home', $d);
		// $this->session->set_userdata('active-menu', 'list_ticket');
	}

	public function edit($id){
		error_reporting(0);
		$d['judul'] = "Dashboard";
		$d['class'] = "list_ticket";
		$d['content'] = 'ticket/list_ticket/form_edit';
		$d['data'] = array(
			'list_brand' => $this->model_ticket->getAllBrand(),
			'list_dep' => $this->model_ticket->getAllDepartement(),
			'item' => $this->model_ticket->getOneItem($id)
		);
		$this->load->view('ticket_home', $d);
	}

	public function simpan_update($id){
		$data = $this->input->post();
		$this->model_ticket->saveUpdateTicket($data, $id);

		if($_FILES['gambar']['name'] != ''){
			$ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
			$newname = rand(0,99999).'-'.date('dmy').'.'.$ext;
			// $data['gambar_name'] = $newname;
			$this->model_ticket->saveUpdateGambar($newname, $id);
			move_uploaded_file($_FILES['gambar']['tmp_name'], 'assets/ticketing_gambar/'.$newname);
		}

		if($_FILES['dokumen']['name'] != ''){
			$ext = pathinfo($_FILES['dokumen']['name'], PATHINFO_EXTENSION);
			$newname = rand(0,99999).'-'.date('dmy').'.'.$ext;
			// $data['dokumen_name'] = $newname;
			$this->model_ticket->saveUpdateDokumen($newname, $id);
			move_uploaded_file($_FILES['dokumen']['tmp_name'], 'assets/ticketing_dokumen/'.$newname);
		}

		redirect('ticket_list');
	}

}
