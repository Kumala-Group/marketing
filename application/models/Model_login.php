<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_login extends CI_Model {
    
    public function UrlToAdmin($id){
		$this->db->where('id_url',$id);
		$q=$this->db->get('p_url');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->url;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}
    
    public function LevelToAdmin($id){
		$this->db->where('id_level',$id);
		$q=$this->db->get('p_level');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->level;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}
    
    public function cari_foto_username($u){
		$q = $this->db->query("SELECT * FROM admins WHERE username='$u'");
		foreach($q->result() as $dt){
			$hasil = $dt->foto;
		}
		return $hasil;
	}

	public function getLoginData($usr,$psw)
	{
		$u = addslashes($usr);
		$p = md5(addslashes($psw));
		$q_cek_login = $this->db->get_where('admins', array('username' => $u, 'password' => $p));
		if(count($q_cek_login->result())>0)
		{
			foreach($q_cek_login->result() as $qck)
			{
				$url=$this->UrlToAdmin($qck->id_url);
				foreach($q_cek_login->result() as $qad)
				{
					$level=$this->LevelToAdmin($qad->id_level);
					$foto=$this->cari_foto_username($qad->username);
					$sess_data['logged_in']     = 'getLoginKMG_online';
					$sess_data['username']      = $qad->username;
					$sess_data['id_perusahaan'] = $qad->id_perusahaan;
					$sess_data['id_brand']      = $qad->id_brand;
					$sess_data['id_jabatan']    = $qad->id_jabatan;
					$sess_data['id_user']       = $qad->id_user;
					$sess_data['foto']          = $foto;
					$sess_data['nama_lengkap']  = $qad->nama_lengkap;
					$sess_data['level']         = $level;
					$this->session->set_userdata($sess_data);
				}
					header('location:'.base_url().$url);

			}
		} else
		{
			/**login ADMIN OLI **/
			$u = addslashes($usr);
			$p = md5(addslashes($psw));
			$status = array('Aktif');
			$this->db->where('nik',$u);
			$this->db->where('password',$p);
			$this->db->where_in('status_aktif',$status);
			$q_karyawan = $this->db->get('karyawan');
			$id_jabatan='';
			if($q_karyawan->num_rows()>0){
				foreach($q_karyawan->result() as $dt){
					$sess_data['logged_in']     = 'getLoginKMG_online';
					$sess_data['username']      = $dt->nik;
					$sess_data['nama_lengkap']  = $dt->nama_karyawan;
					$sess_data['id_perusahaan'] = $dt->id_perusahaan;
					$sess_data['id_brand']      = $dt->id_brand;
					$sess_data['id_jabatan']    = $dt->id_jabatan;
					$id_jabatan                 = $dt->id_jabatan;
					$sess_data['id_divisi']		= $dt->id_divisi;
					$sess_data['level']         = 'karyawan';
					$sess_data['status']        = $dt->status_aktif;
					$this->session->set_userdata($sess_data);
				}
				if ($id_jabatan=='45') {

					header('location:'.base_url().'hd_adm_home');
				}else{
					header('location:'.base_url().'hd_adm_home');
				}
			}else{

					$this->session->set_flashdata('result_login', '<br>Username / NIK atau Password yang anda masukkan salah. Atau Akun Anda diblokir. Silahkan Hubungi Administrator.');
					header('location:'.base_url().'login');
				}
			}


	}

	public function getLoginDataTicketing($usr,$psw)
	{
		$u = addslashes($usr);
		$p = md5(addslashes($psw));
		$status = array('Aktif');
		$this->db->where('nik',$u);
		$this->db->where('password',$p);
		$this->db->where_in('status_aktif',$status);
		$q_karyawan = $this->db->get('karyawan');
		$id_jabatan='';
		if($q_karyawan->num_rows()>0){
			foreach($q_karyawan->result() as $dt){
				$sess_data['logged_in']     = 'getLoginKMG_online';
				$sess_data['username']      = $dt->nik;
				$sess_data['nama_lengkap']  = $dt->nama_karyawan;
				$sess_data['id_perusahaan'] = $dt->id_perusahaan;
				$sess_data['id_brand']      = $dt->id_brand;
				$sess_data['id_jabatan']    = $dt->id_jabatan;
				$id_jabatan                 = $dt->id_jabatan;
				$sess_data['id_divisi']		= $dt->id_divisi;
				$sess_data['level']         = 'karyawan';
				$sess_data['status']        = $dt->status_aktif;
				$this->session->set_userdata($sess_data);
			}

			header('location:'.base_url().'ticket');

		}else{
				$this->session->set_flashdata('result_login', '<br>Username / NIK atau Password yang anda masukkan salah. Atau Akun Anda diblokir. Silahkan Hubungi Administrator.');
				header('location:'.base_url().'login_ticketing');
			}
		}
	}
?>
