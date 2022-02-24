<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_item');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data ITEM";
			$d['class'] = "management_user";

			$d['data'] = $this->db_kpp->query("SELECT *	FROM item ORDER BY id_item");
			$d['content'] = 'item/view';
			$this->load->view('item_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
