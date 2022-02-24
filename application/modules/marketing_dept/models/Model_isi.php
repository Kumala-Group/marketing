<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_isi extends CI_Model {
    
  function count_pd(){
      $q = $this->db_wuling->select('count(pd.no_spk) as jml')->from('pengajuan_diskon_gm pd')->where("pd.checked IN ('n','gm') AND pd.diskon<>0 ")->get()->row()->jml;
      return $q;
  }



}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
