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
			$d['judul']=" Data Item";
			$d['class'] = "item";
			$d['data'] = $this->model_item->all();
			$d['content'] = 'item/view';
			$this->load->view('item_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='admin_hrd'){
			$id['id_item']	= $this->uri->segment(3);

			if($this->model_item->ada($id))
			{
				$this->modeldb_kpp->delete($id);
			}
			redirect('item','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
