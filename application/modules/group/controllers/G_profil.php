<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class G_profil extends CI_Controller {
	function __construct() {
        parent::__construct();
                $this->load->model('m_profil');
                $this->load->library('image_lib');
    }

		public function index()
			{
				$cek=$this->session->userdata('status');
                $level=$this->session->userdata('level');
                if($cek=='login' && $level=='group'){
                    $d['title']='Edit Profil'; 
                    $d['icon']='fa-user-circle';    
                    $id['id_user']=$this->session->userdata('id_user');  
                    $q=$this->db->get_where('admins',$id);
                    foreach($q->result() as $dt){
                        $d['nama']=$dt->nama_lengkap;
                        $d['nik']=$dt->nik;
                        $d['alamat']='';
                        $d['kontak']='';
                        $d['username']=$dt->username;
                    }
                    $photo=$this->session->userdata('photo');
                    if(!empty($photo)){
                        $url='assets/group/assets/img/admins/ori/'.$photo;
                    }else{
                        $url='assets/group/assets/images/user.png';
                    } 
                    $d['url_image_profil']=$url;
                    $this->load->view('profil/view',$d);
                }else {
                    redirect('group/logout');
                }

            }

        public function update_profil()
        {
            $cek=$this->session->userdata('status');
            $level=$this->session->userdata('level');
            if($cek=='login' && $level=='group'){
                // error_reporting(0);
                date_default_timezone_set('Asia/Makassar');
                $key=$this->session->userdata('id_user');
                $id['id_user'] = $key;
                $dt['nama_lengkap'] = $this->input->post('nama');
                $dt['nik'] = $this->input->post('nik');
                $dt['updated_by'] = $this->session->userdata('id_user');

                $dt['tgl_update'] =date('Y-m-d H:i:s');
                $this->m_profil->update($dt,$id);
                echo "Data Sukses DiUpdate";
            }else {
                    redirect('group/logout');
            }

        }

        public function update_akun()
        {
            $cek=$this->session->userdata('status');
            $level=$this->session->userdata('level');
            if($cek=='login' && $level=='group'){
                // error_reporting(0);
                date_default_timezone_set('Asia/Makassar');
                $key=$this->session->userdata('id_user');
                $pass_old=md5($this->input->post('pass_old'));
                $cek=$this->db->select('id_user')->where("id_user='$key' AND password='$pass_old'")->get('admins')->num_rows();
                if($cek>0){
                    $id['id_user'] = $key;
                    $dt['username'] = $this->input->post('username');
                    $dt['password'] = md5($this->input->post('pass_new'));
                    $dt['updated_by'] = $this->session->userdata('id_user');
                    $dt['tgl_update'] =date('Y-m-d H:i:s');
                    $this->m_profil->update($dt,$id);
                    $hasil='1';
                }else{
                    $hasil='0';
                }
                echo $hasil;
            }else {
                    redirect('group/logout');
            }

        }

        public function update_image()
        {
            $cek=$this->session->userdata('status');
            $level=$this->session->userdata('level');
            if($cek=='login' && $level=='group'){
                // error_reporting(0);
                date_default_timezone_set('Asia/Makassar');
                $key=$this->session->userdata('id_user');
                $id['id_user'] = $key;
                $dt['updated_by'] = $this->session->userdata('id_user');
                $dt['tgl_update'] =date('Y-m-d H:i:s');

                $files = $_FILES;
                $config['upload_path']="assets/img/admins/ori";
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '200000000';
                $config['remove_spaces'] = false;
                $new_name = $key;
                $config['file_name'] = $new_name;
                $config['overwrite'] = true;
                $config['max_width'] = '';
                $config['max_height'] = '';
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                $this->upload->do_upload();
                if(($files['userfile']['name'])!=''){
                    $ext = pathinfo($files['userfile']['name'], PATHINFO_EXTENSION);
                    $image_name = $config['file_name'].'.'.$ext;
                    $dt['photo'] = $image_name;
                 
                    /* First size */
                    $configSize1['image_library']   = 'gd2';
                    $configSize1['source_image']    = 'assets/img/admins/ori/'.$image_name;
                    $configSize1['create_thumb']    = FALSE;
                    $configSize1['maintain_ratio']  = TRUE;
                    $configSize1['width']           = 200;
                    $configSize1['height']          = 200;
                    $configSize1['new_image']       = 'assets/img/admins/200x200/'.$image_name;

                    $this->image_lib->initialize($configSize1);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    /* Second size */
                    $configSize2['image_library']   = 'gd2';
                    $configSize2['source_image']    = 'assets/img/admins/ori/'.$image_name;
                    $configSize2['create_thumb']    = FALSE;
                    $configSize2['maintain_ratio']  = TRUE;
                    $configSize2['quality']         = '50%';
                    $configSize2['width']           = 80;
                    $configSize2['height']          = 80;
                    $configSize2['new_image']       = 'assets/img/admins/80x80/'.$image_name;

                    $this->image_lib->initialize($configSize2);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                }

                $this->m_profil->update($dt,$id);
                echo 'assets/img/admins/80x80/'.$image_name;
            }else {
                    redirect('group/logout');
            }

        }
             
     

	}

	?>
