<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_admins extends CI_Model {

  public function data_perusahaan(){
		$q = $this->db->order_by('id_perusahaan');
		$q = $this->db->get('perusahaan');
		return $q;
	}

  public function cari_id_user($u){
		$q = $this->db_wuling->query("SELECT id_user FROM users WHERE username='$u'");
		foreach($q->result() as $dt){
			$hasil = $dt->id_user;
		}
		return $hasil;
	}

  public function cari_foto_username($u){
		$q = $this->db_wuling->query("SELECT foto FROM users WHERE username='$u'");
		foreach($q->result() as $dt){
			$hasil = $dt->foto;
		}
		return $hasil;
	}

  public function LevelToAdmin($id){
    $this->db_wuling->where('id_level',$id);
    $q=$this->db_wuling->get('p_level');
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
    $this->db_wuling->where('id_url',$id);
    $q=$this->db_wuling->get('p_url');
     if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->url;
            }
        }else{
            $hasil = '';
        }
    return $hasil;
  }



}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
