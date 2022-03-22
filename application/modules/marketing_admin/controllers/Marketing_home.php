<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Marketing_home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_marketing');
	}

	public function index()
	{
		$status = 0;		
		$post = $this->input->post();
		if ($post) {
			$username = strip_tags($post['username']);
			$password = strip_tags($post['password']);
			$where['username'] = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $username);
			$password = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $password);
			$q_user = q_data("*", 'kumk6797_kumalagroup.users', $where);
			if ($q_user->num_rows() > 0) {
				$r = $q_user->row();
				$status = $r->status_aktif;
				$verify = password_verify($password, $r->password);
				if ($verify && $status == "on") {
					foreach ($this->session->userdata() as $i => $v) $this->session->unset_userdata($i);
					$s_data['logged_in'] = "marketing_admin";
					$s_data['nik'] = $r->nik;
					$s_data['username'] = $r->username;
					$s_data['id_perusahaan'] = $r->id_perusahaan;
					$s_data['coverage'] = $r->coverage;
					$s_data['id_jabatan'] = $r->id_jabatan;
					$s_data['id_user'] = $r->id;
					$s_data['fp'] = $r->fp;
					$s_data['foto'] = $r->foto;
					$s_data['nama_lengkap'] = $r->nama_lengkap;
					$s_data['level'] = $r->id_level;
					$s_data['url'] = q_data("*", 'kumk6797_kumalagroup.p_level', ['id' => $r->id_level])->row()->url;
					$this->session->set_userdata($s_data);
					$status = 1;
				}
			}
			echo $status;
		} else {
			if ($this->input->get()) $this->m_marketing->error404();
			else {
				if ($this->session->userdata('logged_in') == "marketing_admin") redirect($this->session->userdata('url'), 'refresh');
				else {
					$d['logo'] = q_data("*", 'kumk6797_kumalagroup.partners', [])->result();
					$d['version'] = $this->db->select('versi_update')->where('brand', 'MARKETING')->order_by('id_versi', 'desc')->limit('1')->get('kumk6797_helpdesk.update_versi')->row();

					$this->load->view('login', $d);
				}
			}
		}
	}
	public function beranda()
	{
		if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup,tm_w,SDIGM')) {
			$d['content'] = "pages/beranda";
			$d['index'] = "beranda";
			$this->load->view('index', $d);
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}

	public function simpan_profile(){
		$post = $this->input->post();
		$nik = $post['nik'];
		$nama_lengkap = $post['nama_lengkap'];
		$email = $post['email'];
							
	}


}
