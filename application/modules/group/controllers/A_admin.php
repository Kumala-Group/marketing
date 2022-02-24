<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class A_admin extends CI_Controller {
	function __construct() {
        parent::__construct();
				$this->load->model('m_admin');
    }

		public function index()
			{
				$cek=$this->session->userdata('status');
				$level=$this->session->userdata('level');
				if($cek=='login' && $level=='a'){
                    $d['title']='Data Admin'; 
                    $d['icon']='fa-user';       
					$this->load->view('admin/view',$d);
				}else {
				    redirect('login/logout');
				}

			}

			function get_data_admin()
	    {
	        $list = $this->m_admin->get_datatables();
	        $data = array();
	        $no = $this->input->post('start');
	        foreach ($list as $dt) {
							if($dt->level=='a'){
								$lvl='<span class="badge badge-primary">Administrator</span>';
								$posko='-';
							}elseif ($dt->level=='ap'){
								$lvl='<span class="badge badge-warning">Admin Posko</span>';
								$posko=$dt->nama_posko;
							}
							if($dt->aktif=='1'){
								$status='<span class="badge badge-success">Aktif</span>';
							}else{
								$status='<span class="badge badge-danger">Tidak Aktif</span>';
							}
					    $no++;
	            $row = array();
	            $row[] = '<center>'.$no.'<center>';
				  		$row[] = ''.$dt->nama.'';
				  		$row[] = ''.$dt->nik.'';
				  		$row[] = ''.$dt->kontak.'';
				  		$row[] = ''.$posko.'';
				  		$row[] = ''.$lvl.'';
				  		$row[] = '<center>'.$status.'</center>';
							$row[] =  '<center>
														<span class="btn-action btn-action-delete delete" data-id="'.$dt->id_admin.'"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus </span>
														<a href="#" class="btn-action btn-action-warning account" data-id="'.$dt->id_admin.'" data-toggle="modal" data-target="#modal-account"><i class="fa fa-key" aria-hidden="true"></i> Akun </a>
														<a href="#" class="btn-action edit" data-id="'.$dt->id_admin.'" data-toggle="modal" data-target="#modal-admin"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
													</center>';

	            $data[] = $row;
	        }

	        $output = array(
	            "draw" => $this->input->post('draw'),
	            "recordsTotal" => $this->m_admin->count_all(),
	            "recordsFiltered" => $this->m_admin->count_filtered(),
	            "data" => $data,
	        );
	        echo json_encode($output);
			}
		



			public function cari_admin()
				{
					$cek=$this->session->userdata('status');
					$level=$this->session->userdata('level');
					if($cek=='login' && $level=='a'){
								$id['id_admin'] = $this->input->post('id');
								$q=$this->db->get_where('admins',$id);
								$row=$q->num_rows();
								if($row>0){
									foreach ($q->result() as $dt) {
										$d['id_admin']=$dt->id_admin;
										$d['username']=$dt->username;
										$d['nama']=$dt->nama;
										$d['nik']=$dt->nik;
										$d['alamat']=$dt->alamat;
										$d['kontak']=$dt->kontak;
										$d['level']=$dt->level;
										$d['posko']=$dt->id_posko;
										$d['aktif']=$dt->aktif;
									}
								}else {
									$d['id_admin']='';
									$d['username']='';
									$d['nama']='';
									$d['nik']='';
									$d['alamat']='';
									$d['kontak']='';
									$d['level']='';
									$d['posko']='';
									$d['aktif']='';
								}
								echo json_encode($d);
					}else {
						  redirect('login/logout');
					}

				}

				public function cari_account()
					{
						$cek=$this->session->userdata('status');
						$level=$this->session->userdata('level');
						if($cek=='login' && $level=='a'){
									$id['id_admin'] = $this->input->post('id');
									$q=$this->db->get_where('admins',$id);
									$row=$q->num_rows();
									if($row>0){
										foreach ($q->result() as $dt) {
											$d['id_admin']=$dt->id_admin;
											$d['username']=$dt->username;
										}
									}else {
										$d['id']='';
										$d['username']='';
									}
									echo json_encode($d);
						}else {
							  redirect('login/logout');
						}

					}

			public function simpan()
				{
					$cek=$this->session->userdata('status');
					$level=$this->session->userdata('level');
					if($cek=='login' && $level=='a'){
						    // error_reporting(0);
								date_default_timezone_set('Asia/Makassar');
								$key=$this->input->post('id_admin');
								$id['id_admin'] = $key;
								$dt['username'] = $this->input->post('username');
								$dt['nama'] = $this->input->post('nama');
								$dt['nik'] = $this->input->post('nik');
								$dt['kontak'] = $this->input->post('kontak');
								$dt['alamat'] = $this->input->post('alamat');
								$dt['level'] = $this->input->post('level');
								$dt['id_posko'] = $this->input->post('posko');
								$dt['aktif'] = $this->input->post('aktif');
								$dt['updated_by'] = $this->session->userdata('id_admin');

								$q=$this->db->get_where('admins',$id)->num_rows();
								if($q>0){
									$dt['w_update'] =date('Y-m-d H:i:s');
									$this->m_admin->update($dt,$id);
									echo "Data Sukses DiUpdate";
								}else {
									$dt['id_admin'] = 'A-'.uniqid();
								  $dt['password'] = md5($this->input->post('username'));
									$dt['w_insert'] =date('Y-m-d H:i:s');
									$this->m_admin->insert($dt);
									echo "Data Sukses DiSimpan";
								}
					}else {
						  redirect('login/logout');
					}

				}

				public function simpan_account()
					{
						$cek=$this->session->userdata('status');
						$level=$this->session->userdata('level');
						if($cek=='login' && $level=='a'){
							    error_reporting(0);
									date_default_timezone_set('Asia/Makassar');
									$key=$this->input->post('id_admin_a');
									$id['id_admin'] = $key;
									$dt['username'] = $this->input->post('username_a');
									$dt['password'] = md5($this->input->post('password1'));
									$this->m_admin->update($dt,$id);
									echo "Data Sukses DiUpdate";
						}else {
							  redirect('login/logout');
						}

					}


					public function hapus()
						{
							error_reporting(0);
							$cek=$this->session->userdata('status');
							$level=$this->session->userdata('level');
							if($cek=='login' && $level=='a'){
										$id['id_admin'] = $this->input->post('id');
										$this->m_admin->delete($id);
										echo "Data Sukses Dihapus";
							}else {
								  redirect('login/logout');
							}

						}

	}

	?>
