<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Controller {
	    function __construct() {
        	parent::__construct();
			$this->load->model('m_login');
			// $this->load->library('encrypt');
        }
		public function index(){
			$this->load->view('login');
		}

		function cek_login(){

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('password','Password','required');

			$this->form_validation->set_error_delimiters('<div style="color:rgb(255, 104, 104);margin-top:4px;">', '</div>');
  			$this->form_validation->set_message('required', '*Enter %s');


			if($this->form_validation->run() == false){
				$this->load->view('login');
			}else {
					$where = array(
					'username' => $username,
					'password' => md5($password),
						'status_aktif' 	=> 'on'
					);
					$q= $this->db->get_where('admins',$where);
					$cek=$q->num_rows();
					if($cek > 0){
							foreach ($q->result() as $dt) {
								$level='group';
								$data_session = array(
							'username' => $dt->username,
								'nama' => $dt->nama_lengkap,
							'status' => "login",
								'level' => $level,
								'id_user'=>$dt->id_user,
								'photo'=>$dt->foto
							);
							}
							$this->session->set_userdata($data_session);
							redirect(base_url("g_home"));
					}else{
							$this->session->set_flashdata('f_error','Invalid Username or Password');
								redirect('group');
					}
			}


		 }

		public function logout()
		{
			$this->session->sess_destroy();
			echo '<script> top.window.location="'.base_url('group').'"</script>';
		}

	}

	?>
