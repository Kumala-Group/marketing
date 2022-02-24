<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class G_home extends CI_Controller {
	function __construct() {
        parent::__construct();
			  $this->load->database('default');
    }

	public function index()
	{
		$cek=$this->session->userdata('status');
		$level=$this->session->userdata('level');
		if($cek=='login' && $level=='group'){
			$d['nama'] = $this->session->userdata('nama');
			$photo=$this->session->userdata('photo');
			if(!empty($photo)){
				$url='assets/group/assets/img/admins/80x80/'.$photo;
			}else{
				$url='assets/group/assets/images/user.png';
			}
			$d['url_image']=$url;
			$d['content']='v_home';
			$this->load->view('home',$d);
		}else {
			redirect('group/logout');
		}
	}

}
