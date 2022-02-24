<?php

class M_profil extends CI_Model {

    public function update($dt,$id){
        $q = $this->db->update('admins',$dt,$id);
        return $q;
    }

  }
