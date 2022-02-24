<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_profil extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('model_data');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']="Edit Profil";
			$d['class'] = "home";
			$d['tgl_hari'] = hari_ini(date('w'));
			$d['tgl_indo'] = tgl_indo(date('Y-m-d'));

			$d['nama_lengkap'] = $this->session->userdata('nama_lengkap');
			$d['username'] = $this->session->userdata('username');
			$d['open_username'] = $this->session->userdata('username');
			$d['id_user'] = $this->session->userdata('id_user');
			$d['content']= 'profil/profil';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_profil()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['username'] = $this->session->userdata('username');
			$dt['nama_lengkap'] = $this->input->post('nama_lengkap');
			$q = $this->db->get_where('admins');
			$r = $q->num_rows();
			if($r>0){
				$this->db->update('admins',$dt,$id);
				echo "Sukses di Ubah";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_foto()
	{
		error_reporting(0);
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$key = $this->model_data->cari_id_username($this->session->userdata('username'));

			$config['upload_path'] = './assets/avatars/';
			$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png';
			//$config['max_size'] = '2000';
			//$config['max_width'] = '1280';
			//$config['max_height'] = '1280';
			$config['overwrite'] = TRUE;
			$config['file_name'] = $key;
			$this->load->library('upload', $config);

			$foto = $_FILES['gambar']['name'];

			if(!empty($foto)){
				if($this->upload->do_upload('gambar')){
					$tp=$this->upload->data();
					$ori = $tp['file_name'];

					$data['foto'] = $ori;

					$this->load->library('image_lib');
					$config['image_library'] = 'gd2';
					$config['source_image'] = './assets/avatars/'.$ori;
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 300;
					$config['height'] = 200;

					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					$id['username'] = $this->session->userdata('username');

					$q = $this->db->get_where('admins',$id);
					$r = $q->num_rows();
					if($r>0){
						$this->db->update('admins',$data,$id);
						redirect('henkel_adm_profil','refresh');
					}
				}else{
					$info =  $this->upload->display_errors();
					$this->session->set_flashdata('result_info', '<center>'.$info.'</center>');
					redirect('henkel_adm_profil');
				}
			}else{
				redirect('henkel_adm_profil');
			}



		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_pwd()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['username'] = $this->session->userdata('username');

				$q = $this->db->get_where('admins', $id);
				$row = $q->row();

				$old_pwd = md5($this->input->post('old_pwd'));

				if ($old_pwd == $row->password){
					$pwd = $this->input->post('pwd_1');
					$dt['password'] = md5($pwd);

					$q = $this->db->get_where('admins');
					$r = $q->num_rows();
					if($r>0){
						$this->db->update('admins',$dt,$id);
						echo "Password sukses diubah";
					}
				} else {
					echo "Password lama tidak cocok";
				}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_open_username()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_user'] = $this->session->userdata('id_user');
			$cek_username=$this->input->post('change_username');
			$this->db->where_in('username',$cek_username);
			$q_cek = $this->db->get('admins');
			if($q_cek->num_rows()>0){
				echo "Username sudah ada. Coba username yang lain!";
			}else{
				$dt['username'] = $this->input->post('change_username');
				$q = $this->db->get_where('admins');
				$r = $q->num_rows();
				if($r>0){
					$this->db->update('admins',$dt,$id);
					$this->session->sess_destroy();
					echo "<script type='text/javascript'>
								alert('username berhasil diubah. Silahkan login kembali! ');
								window.location.href = 'henkel';
								</script>";
				}

			}

		}else{
			redirect('henkel','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
