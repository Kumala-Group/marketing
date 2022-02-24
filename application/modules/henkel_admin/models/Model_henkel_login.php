<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_henkel_login extends CI_Model {

	public function getLoginData($usr,$psw,$fp)
	{
		$u = $usr;
		$p = md5($psw);
        $q = $this->db->get_where('admins', array('username' => $u, 'password' => $p));
        if(count($q->result())>0)
        {
            $cek_status= $this->db->get_where('admins', array('username' => $u))->num_rows();
            $cek_fp= $this->db->get_where('admins', array('username' => $u))->num_rows();
            if($cek_status>0){
                $this->login($u,$q,$fp);
            }elseif($cek_fp>0){
                $this->login($u,$q,$fp);
            }else{
                $this->session->set_flashdata('result_login', '<br>Maaf, Akun anda sedang digunakan');
                header('location:'.base_url().'henkel');
            }

        }else{
                        $this->session->set_flashdata('result_login', '<br>Username / NIK atau Password yang anda masukkan salah. Atau Akun Anda diblokir. Silahkan Hubungi Administrator.');
                        header('location:'.base_url().'henkel');
            }

    }

    public function login($u,$q,$fp){

                date_default_timezone_set('Asia/Makassar');
                $time_login=date('Y-m-d H:i:s');
                $id=uniqid(rand(), true);
                foreach($q->result() as $qck)
                {
                    $url=$this->UrlToAdmin($qck->id_url);
                    foreach($q->result() as $qad)
                    {
                        $level=$this->LevelToAdmin($qad->id_level);
                        $foto=$this->cari_foto_username($qad->username);
                        $sess_data['logged_in'] 	= 'getLoginKMG_online';
												$sess_data['nik'] 		= $qad->nik;
                        $sess_data['username'] 		= $qad->username;
                        $sess_data['id_perusahaan'] 		= $qad->id_perusahaan;
                        $sess_data['id_jabatan'] 		= $qad->id_jabatan;
                        $sess_data['id_user'] 		= $qad->id_user;
                        $sess_data['fp'] 		= $fp;
                        $sess_data['foto'] 		= $foto;
                        $sess_data['nama_lengkap'] 	= $qad->nama_lengkap;
                        $sess_data['level'] 		= $level;
                        $sess_data['id_login'] 		= $id;
                        $this->session->set_userdata($sess_data);
                    }
                        header('location:'.base_url().$url);
                }

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

    public function cari_foto_username($u){
        $q = $this->db->query("SELECT * FROM admins WHERE username='$u'");
        foreach($q->result() as $dt){
            $hasil = $dt->foto;
        }
        return $hasil;
    }
}

?>
