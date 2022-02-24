<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_wuling_sales_report extends CI_Model
{

    ////<--start (z) -->////
    public function region() {
        $query = $this->db_wuling->query
            ("SELECT id_team_sm,coverage,region FROM adm_team_sm ORDER BY region ASC");
        $hasil = $query->result();
        return $hasil;
    }

    public function nama_bulan() {
        $nama_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $hasil = $nama_bulan;
        return $hasil;
    }

    //untuk keperluan title header di atas table
    public function get_title_header($cabang) {
        if ($cabang=='all') {
            $title_header = 'KCA - ALL';
        } else {
            $q = $this->db->query("SELECT singkat, lokasi FROM perusahaan WHERE id_perusahaan='$cabang'")->row();
            $title_header = $q->singkat.' - '.$q->lokasi;
        } 
        return $title_header;
    }

    public function nama_leasing() {
        $q =  $this->db_wuling->query("SELECT * FROM leasing ORDER BY leasing");
        $hasil = $q->result();
        return $hasil;
    }

    public function model_varian() {
        $q =  $this->db_wuling->query("SELECT * FROM p_model ORDER BY model");
        $hasil = $q->result();
        return $hasil;
    }


    private function _hitung_do_by_id_model($id_perusahaan,$tahun,$bulan,$id_model) {
        $and_id_perusahaan = "";
        if($id_perusahaan<>""){
            $and_id_perusahaan = " AND s_spk.id_perusahaan=$id_perusahaan";
        }
        $q =  $this->db_wuling->query("SELECT COUNT(p_varian.id_model) AS total_do FROM s_do
            INNER JOIN s_spk ON s_do.id_prospek = s_spk.id_prospek
            INNER JOIN s_prospek ON s_spk.id_prospek = s_prospek.id_prospek 
            INNER JOIN unit ON unit.kode_unit = s_prospek.kode_unit
            INNER JOIN p_varian ON p_varian.id_varian = unit.id_varian
            WHERE
            MONTH(s_do.tgl_do)=$bulan AND YEAR(s_do.tgl_do)=$tahun
            $and_id_perusahaan
            AND p_varian.id_model = $id_model")->row();
        $hasil = $q->total_do;
        return $hasil;
    }

    private function _sum_do_by_id_model($tahun,$bulan,$id_model) {       
        $q =  $this->db_wuling->query("SELECT COUNT(pu.no_rangka) as total_do FROM penjualan_unit AS pu
          INNER JOIN detail_unit_masuk ON pu.no_rangka = detail_unit_masuk.no_rangka
          INNER JOIN unit ON detail_unit_masuk.kode_unit = unit.kode_unit
          INNER JOIN p_varian ON unit.id_varian = p_varian.id_varian
      WHERE
          MONTH(pu.tgl) = $bulan AND YEAR(pu.tgl) = $tahun 
          AND pu.batal = 'n'
          AND p_varian.id_model = $id_model")->row();            
        $hasil = $q->total_do;
        return $hasil;
    }

    private function _sum_do_by_id_model_old($tahun,$bulan,$id_model) {       
        $q =  $this->db_wuling->query("SELECT COUNT(p_varian.id_model) AS total_do FROM s_do
            INNER JOIN s_spk ON s_do.id_prospek = s_spk.id_prospek
            INNER JOIN s_prospek ON s_spk.id_prospek = s_prospek.id_prospek 
            INNER JOIN unit ON unit.kode_unit = s_prospek.kode_unit
            INNER JOIN p_varian ON p_varian.id_varian = unit.id_varian
            WHERE
            MONTH(s_do.tgl_do)=$bulan AND YEAR(s_do.tgl_do)=$tahun
            AND p_varian.id_model = $id_model")->row();
        $hasil = $q->total_do;
        return $hasil;
    }
    //ini dari table target_cabang        
    private function _hitung_target_by_id_model($id_perusahaan,$tahun,$bulan,$id_model) {
        $and_id_perusahaan = "";
        if($id_perusahaan<>""){
            $and_id_perusahaan = " AND id_perusahaan=$id_perusahaan";
        }
        $q_target =  $this->db_wuling->query("SELECT target FROM target_cabang 
            WHERE id_model=$id_model
            $and_id_perusahaan            
            AND thn = $tahun
            AND bln = $bulan
            ");
        $target = $q_target->row();
        $hasil = $target->target;        
        return $hasil;
    }
    private function _sum_target_by_id_model($tahun,$bulan,$id_model) {       
        $q_target =  $this->db_wuling->query("SELECT SUM(target) AS sum_target FROM target_cabang 
            WHERE id_model=$id_model
            AND thn = $tahun
            AND bln = $bulan
            ");
        $target = $q_target->row();
        $hasil = $target->sum_target;        
        return $hasil;
    }
    //ini versi dari table sm_mme
    private function _hitung_target_by_id_model_old($id_perusahaan,$tahun,$bulan,$id_model) {
        $q_model =  $this->db_wuling->query("SELECT * FROM p_varian WHERE id_model=$id_model");
        $varians = $q_model->result();
        $total = 0;
        foreach($varians as $varian) {
            $q_target =  $this->db_wuling->query("SELECT SUM(total) AS totals FROM sm_mme
                WHERE MONTH(date) = $bulan
                AND YEAR(date) = $tahun
                AND id_varian = $varian->id_varian
                AND id_perusahaan = $id_perusahaan
            ")->row();
            $total += $q_target->totals;
        }
        $hasil = $total;
        //print_r($hasil);
        //die();
        return $hasil;
    }


    public function get_performance_data($id_model,$tahun) {  
        $q_model = $this->db_wuling->query
            ("SELECT id_model,model FROM p_model ORDER BY model");
        
        $id_models = $q_model->result_array();            
        $id_perusahaan = "";
                          
        if($id_model<>'all') { //by model        
            $targets = array();
            $aktuals = array();
            for($i=0;$i<12;$i++) { //jumlah bulan
                $targets[$i] = $this->_sum_target_by_id_model($tahun,$i+1,$id_model);
                $aktuals[$i] = $this->_sum_do_by_id_model($tahun,$i+1,$id_model);
                $diffs[$i] = $aktuals[$i] - $targets[$i];
                //mencegah division zero
                if($aktuals[$i]>0 && $targets[$i]>0) {
                    $achvs[$i] = round(($aktuals[$i]/$targets[$i]),2);
                } else {
                    $achvs[$i] = 0;
                }
            }

            //tambah satu untuk total columns di bagian kanan
            $targets[12] = array_sum($targets);  
            $aktuals[12] = array_sum($aktuals); 
            $diffs[12] = $aktuals[12] - $targets[12];
            //mencegah division zero
            if($aktuals[12]>0 && $targets[12]>0) {
                $achvs[12] = round(($aktuals[12]/$targets[12]),2);
            } else {
                $achvs[12] = 0;
            }

            //untuk ambil nama modelnya ji saja, keperluan di array performances["model"]
            $q_model = $this->db_wuling->query
            ("SELECT id_model,model FROM p_model WHERE id_model=$id_model")->row();                
            $performances[$id_model] = array(
                "model" => $q_model->model,
                "target"=> $targets,
                "aktual"=> $aktuals,
                "diff"  => $diffs,
                "%achv" => $achvs
            );   
        } else { //all model
            //
            foreach($id_models as $id_m) {
                //fill array with zero untuk keperluan totalan
                for($i=0;$i<12;$i++) {
                    $v_total_target[$id_m["id_model"]][$i] = 0;
                    $v_total_aktual[$id_m["id_model"]][$i] = 0;
                } 
                $targets = array();
                $aktuals = array();
                for($i=0;$i<12;$i++) { //jumlah bulan
                    $targets[$i] = $this->_sum_target_by_id_model($tahun,$i+1,$id_m["id_model"]);
                    $aktuals[$i] = $this->_sum_do_by_id_model($tahun,$i+1,$id_m["id_model"]);
                    $diffs[$i] = $aktuals[$i] - $targets[$i];
                    $v_total_target[$id_m["id_model"]][$i] += $targets[$i];
                    $v_total_aktual[$id_m["id_model"]][$i] += $aktuals[$i];
                    //mencegah division zero
                    if($aktuals[$i]>0 && $targets[$i]>0) {
                        $achvs[$i] = round(($aktuals[$i]/$targets[$i]),2);
                    } else {
                        $achvs[$i] = 0;
                    }
                }   
                //tambah satu untuk total columns di bagian kanan
                $targets[12] = array_sum($targets);  
                $aktuals[12] = array_sum($aktuals); 
                $diffs[12] = $aktuals[12] - $targets[12];
                //mencegah division zero
                if($aktuals[12]>0 && $targets[12]>0) {
                    $achvs[12] = round(($aktuals[12]/$targets[12]),2);
                } else {
                    $achvs[12] = 0;
                }

                $performances[$id_m["id_model"]] = array(
                    "model" => $id_m["model"],
                    "target"=> $targets,
                    "aktual"=> $aktuals,
                    "diff"  => $diffs,
                    "%achv" => $achvs
                );   
            }

            //hitung totalan
            foreach($id_models as $id_m) {
                for($i=0;$i<12;$i++) {
                    //$total_target[$i] = $v_total_target[$id_m["id_model"]][$i];
                    $total_target[$i] = array_sum(array_column($v_total_target, $i));
                    $total_aktual[$i] = array_sum(array_column($v_total_aktual, $i));
                    $total_diffs[$i] = $total_aktual[$i] - $total_target[$i];
                    //mencegah division zero
                    if($total_aktual[$i]>0 && $total_target[$i]>0) {
                        $total_achvs[$i] = round(($total_aktual[$i]/$total_target[$i]),2);
                    } else {
                        $total_achvs[$i] = 0;
                    }
                }                               
            }
            //tambah satu untuk total columns di bagian kanan
            $total_target[12] = array_sum($total_target);  
            $total_aktual[12] = array_sum($total_aktual); 
            $total_diffs[12] = $total_aktual[12] - $total_target[12];
             //mencegah division zero
            if($total_aktual[12]>0 && $total_target[12]>0) {
                $total_achvs[12] = round(($total_aktual[12]/$total_target[12]),2);
            } else {
                $total_achvs[12] = 0;
            }

            $performances["totals"] = array(
                "model"         => "All Model",
                "total_target"  => $total_target,
                "total_aktual"  => $total_aktual,
                "total_diff"    => $total_diffs,
                "total_achvs"   => $total_achvs
            );   
                        
        }            
        $hasil  = $performances;
        return $hasil;
    }

    public function get_mom_review_data($region,$tahun) {
        $where_region = "";
        if($region<>'all') {
            $where_region = " WHERE coverage = '$region'";
        }
        $q_region = $this->db_wuling->query
            ("SELECT region,coverage,nama_team,id_sm 
              FROM adm_team_sm 
              $where_region
              ORDER BY region ASC");    
        $q_model = $this->db_wuling->query
            ("SELECT id_model,model FROM p_model ORDER BY model");
        $id_models = $q_model->result_array();
        
        //ambil id_perusahaans, untuk dijadikan array, dipake diforeach nanti
        $id_perusahaans = explode(",",$q_region->row()->coverage);

        foreach($id_perusahaans as $id_perusahaan){    
             //fill array with zero
            for($i=0;$i<12;$i++) {
                $v_total_target[$id_perusahaan][$i] = 0;
                $v_total_aktual[$id_perusahaan][$i] = 0;
                $targets[$i] = 0;
                $aktuals[$i] = 0;
                $total_target[$i] =0;
                $total_aktual[$i] =0;
            }

            $q_perusahaan = $this->db->query
                ("SELECT id_perusahaan,lokasi,singkat
                  FROM perusahaan
                  WHERE id_perusahaan=$id_perusahaan 
                  AND id_brand='5'");            
            $perusahaan = $q_perusahaan->row()->singkat.' - '. $q_perusahaan->row()->lokasi;
            
            $total_target = array();
            foreach($id_models as $id_model){
                $targets = array();    
                $aktuals = array();
                // for($i=0;$i<12;$i++) { //jumlah bulan
                //     $targets[] = 0;                
                // }
                for($i=0;$i<12;$i++) { //jumlah bulan
                    $targets[] = $this->_hitung_target_by_id_model($id_perusahaan,$tahun,$i+1,$id_model["id_model"]);
                    $aktuals[] = $this->_hitung_do_by_id_model($id_perusahaan,$tahun,$i+1,$id_model["id_model"]);
                    $v_total_target[$id_perusahaan][$i] += $targets[$i];
                    $v_total_aktual[$id_perusahaan][$i] += $aktuals[$i];
                }
                //hitung total_target
                for($i=0;$i<12;$i++) {
                    $total_target[$i] = $v_total_target[$id_perusahaan][$i];//array_sum(array_column($v_total_target, $i));
                    $total_aktual[$i] = $v_total_aktual[$id_perusahaan][$i];//array_sum(array_column($v_total_target, $i));
                    $total_persen[$i] = 0;
                    //mencegah division zero
                    if($total_target[$i]>0 && $total_aktual[$i]>0){
                        //aktual/target 
                        $total_persen[$i] = round(($total_aktual[$i]/$total_target[$i]),2)*100;
                    }
                }
                $target_aktuals[$id_model["id_model"]] = array(
                    "model" => $id_model["model"],
                    "target"=> $targets,
                    "aktual"=> $aktuals,
                    "total_target" => $total_target,
                    "total_aktual" => $total_aktual,
                    "total_persen" => $total_persen
                );                
            }
            $moms[$id_perusahaan] = array(
                "perusahaan"    => $perusahaan,
                "target_aktual" => $target_aktuals,
                //"model"=>$id_models
            );
        }       
         //$hasil["region"] = "ALL-REGION";
        // if($region<>'all') {
        //     $hasil["region"] = $q_region->row()->region;
        // }   
        $hasil  = array(
            "region"=>$q_region->row()->region,
            //"perusahaan"=>$perusahaans,
            "moms"=> $moms            
        );
        return $hasil;
    }

    

    public function get_nama_model_with_otr_no_json($id_model) {
        $q =  $this->db_wuling->query
            ("SELECT v.id_varian,v.id_model, m.model, p.harga_otr
              FROM p_varian AS v
              INNER JOIN p_model AS m ON m.id_model=v.id_model
              INNER JOIN pricelist AS p ON p.id_varian=v.id_varian
              WHERE m.id_model = $id_model
              AND v.id_varian IN (1,2,18,22,28) 
              GROUP BY m.model
            ");
        $hasil = $q->row();
        return $hasil;
    }

    private function _hitung_do_by_id_perusahaan($id_perusahaan,$tahun,$bulan) {
        $q_do = $this->db_wuling->query
        ("SELECT COUNT(s_do.tgl_do) as total_do
            FROM s_do
            INNER JOIN s_spk ON s_do.id_prospek = s_spk.id_prospek
            INNER JOIN s_prospek ON s_spk.id_prospek = s_prospek.id_prospek           
          WHERE
            MONTH(s_do.tgl_do)=$bulan AND YEAR(s_do.tgl_do)=$tahun
            AND s_spk.id_perusahaan IN ($id_perusahaan)                
        ")->row();
        $hasil = $q_do->total_do;
        return $hasil;
    }

    private function _hitung_jumlah_salesman($id_perusahaan,$tahun,$bulan) {
        if ($bulan < 10) {
            $bulan = '0' . $bulan;
        } else {
            $bulan = $bulan;
        }
        $q_sales_aktif = $this->db_wuling->query 
        ("SELECT COUNT(sl.id_sales) AS total_sales
            FROM adm_sales AS sl 
            JOIN kmg.karyawan k ON sl.id_sales = k.id_karyawan 
          WHERE sl.status_aktif='A' 
            AND sl.status_leader = 'n' 
            AND sl.id_perusahaan = $id_perusahaan
            AND CONCAT(YEAR(k.tgl_mulai_kerja),MONTH(k.tgl_mulai_kerja)) between '201001' AND '$tahun$bulan'
         ")->row();
          $q_sales_resign = $this->db_wuling->query 
          ("SELECT COUNT(sl.id_sales) AS total_sales
            FROM adm_sales AS sl 
            JOIN kmg.karyawan k ON sl.id_sales = k.id_karyawan 
          WHERE sl.status_aktif='R' 
            AND sl.status_leader = 'n' 
            AND sl.id_perusahaan = $id_perusahaan
            AND CONCAT(YEAR(k.tgl_resign),MONTH(k.tgl_resign)) between '201001' AND '$tahun$bulan'
        ")->row(); //CONCAT, gabung string        
        $hasil = $q_sales_aktif->total_sales + $q_sales_resign->total_sales;
        return $hasil;
    }

    public function get_productivity_data($region,$tahun) {
        $where_region = "";
        if($region<>'all') {
            $where_region = " WHERE coverage = '$region'";
        }
        $q_region = $this->db_wuling->query
            ("SELECT region,coverage,nama_team,id_sm 
              FROM adm_team_sm 
              $where_region
              ORDER BY region ASC");                              

        //ambil id_perusahaans, untuk dijadikan array, dipake diforeach nanti
        $perusahaans = explode(",",$q_region->row()->coverage);
       
        //fill array with zero
        foreach($perusahaans as $id_perusahaan){
            for($i=0;$i<12;$i++) {
                $v_total_do[$id_perusahaan][$i]=0;
                $v_total_salesman[$id_perusahaan][$i]=0;
            }
        }

        foreach($perusahaans as $id_perusahaan){
            
            $jumlah_salesman = 0;
            $jumlah_do = 0;
            $hasil_produktivitas = 0;
            $total_do = 0;
            // $total_salesman = 0;
            // $total_produktivitas = 0;
            $q_perusahaan = $this->db->query
            ("SELECT id_perusahaan,lokasi,singkat
              FROM perusahaan
              WHERE id_perusahaan=$id_perusahaan 
              AND id_brand='5'");
            for($i=0;$i<12;$i++) { //jumlah bulan    
                $salesmans[$i]   = $this->_hitung_jumlah_salesman($id_perusahaan,$tahun,$i+1);
                //exit loop for, kalau tahun berjalan untuk bulan depan (real date)
                $tahun_skrg = date('Y');  
                $bulan_skrg = date('m');
                if($i>$bulan_skrg-1  && $tahun==$tahun_skrg) {
                    $salesmans[$i]  = 0;                  
                }
                $dos[$i]         = $this->_hitung_do_by_id_perusahaan($id_perusahaan,$tahun,$i+1);
                $v_total_do[$id_perusahaan][$i] += $dos[$i];
                $jumlah_salesman = $salesmans[$i];
                $v_total_salesman[$id_perusahaan][$i] += $salesmans[$i];

                $jumlah_do = $dos[$i];
                $productivities[$i] = 0;
                //mencegah division zero
                if($jumlah_salesman>0 && $jumlah_do>0) {
                    $productivities[$i] = round(($jumlah_do/$jumlah_salesman),2);
                }                
            }  
            //hitung total_do
            $total_dos = array();
            $total_salesmans = array();
            $total_produktivitas = array();
            for($i=0;$i<12;$i++) {
                $total_dos[$i] = array_sum(array_column($v_total_do, $i));
                $total_salesmans[$i] = array_sum(array_column($v_total_salesman, $i));
                //mencegah division zero
                if($total_salesmans[$i]>0 && $total_dos[$i]>0) {
                    $total_produktivitas[$i] = round(($total_dos[$i]/$total_salesmans[$i]),2);
                } else {
                    $total_produktivitas[$i] = 0;
                }
            }            
            //$productivity=array("salesman"=>$salesmans,"do"=>$dos,"productivity"=>$productivities);
            $perusahaan = $q_perusahaan->row()->singkat.' - '. $q_perusahaan->row()->lokasi;
            $produktivitas[$id_perusahaan]=array("perusahaan"=>$perusahaan,"salesman"=>$salesmans,"do"=>$dos,"productivity"=>$productivities);
        }       
         //$hasil["region"] = "ALL-REGION";
         if($region<>'all') {
            $hasil["region"] = $q_region->row()->region;
        }           
        $hasil  = array(
            "region"=>$q_region->row()->region,
            "produktivitas"=>$produktivitas,
            "total_salesman"=>$total_salesmans,
            "total_do"=>$total_dos,
            "total_produktivitas"=>$total_produktivitas
        );
        return $hasil;
    }


    public function get_leasing_movement_data($id_leasing) {       
        $where_leasing = "";
        if ($id_leasing<>'all') {
            $where_leasing = " WHERE id_leasing='$id_leasing'";
        }
        $q_leasing = $this->db_wuling->query
            ("SELECT * FROM leasing $where_leasing ORDER BY leasing");  
        $q_leasing_movement = $this->db_wuling->query
            ("SELECT 
				m.id_model,m.model,
				p.harga_otr,
				lm.id,lm.discount,lm.dp,lm.angsuran_4,lm.angsuran_5,
                l.leasing
		    FROM leasing_movement AS lm
			JOIN p_model AS m ON m.id_model=lm.id_model
			JOIN pricelist AS p ON p.id_varian=lm.id_varian
            JOIN leasing AS l ON l.id_leasing=lm.id_leasing
			WHERE p.jenis_warna='n'
			AND p.id_perusahaan='2'
			AND lm.id_leasing='$id_leasing'
			");		
        $net_dp = 0;
        $leasing_movements = array();
        if($q_leasing_movement->num_rows()==0) {
            $leasing_movements["leasing"] = $q_leasing->row()->leasing;
            $movements[] = array(
				'model' => '',
				'harga_otr'	=> '',
				'discount'	=> '',
				'dp'		=> '',
				'net_dp'	=> '',
				'angsuran_4'=> '',
                'angsuran_5'=> '',
                'total_4'   => '',
                'total_5'   => ''
            );
            $leasing_movements["movements"] = $movements;
        }
		foreach ($q_leasing_movement->result() as $qlm) {	
            $net_dp = $qlm->dp - $qlm->discount;
            $total_4 = $net_dp+(4*12*$qlm->angsuran_4);
            $total_5 = $net_dp+(4*12*$qlm->angsuran_5);
            $movements[$qlm->id_model] = array(
				'model' => $qlm->model,
				'harga_otr'	=> separator_harga($this->get_nama_model_with_otr_no_json($qlm->id_model)->harga_otr),
				'discount'	=> separator_harga($qlm->discount),
				'dp'		=> separator_harga($qlm->dp),
				'net_dp'	=> separator_harga($net_dp),
				'angsuran_4'=> separator_harga($qlm->angsuran_4),
                'angsuran_5'=> separator_harga($qlm->angsuran_5),
                'total_4'   => separator_harga($total_4),
                'total_5'   => separator_harga($total_5)						
            );
            $leasing_movements["leasing"] = $q_leasing->row()->leasing;
            $leasing_movements["movements"] = $movements;
        }		
        //$leasing_movements["leasing"] = $q_leasing->row()->leasing;        
        $hasil = $leasing_movements;
        return $hasil;		
    }

    public function get_leasing_movement_data__($id_leasing) {       
        $where_leasing = "";
        if ($id_leasing<>'all') {
            $where_leasing = " WHERE id_leasing='$id_leasing'";
        }
        $q_leasing = $this->db_wuling->query
            ("SELECT * FROM leasing $where_leasing ORDER BY leasing");        
        $q_model = $this->db_wuling->query
            ("SELECT v.id_varian,v.id_model, m.model, p.harga_otr
              FROM p_varian AS v
              INNER JOIN p_model AS m ON m.id_model=v.id_model
              INNER JOIN pricelist AS p ON p.id_varian=v.id_varian
              WHERE m.id_model IN (1,2,4,5,6) 
              AND v.id_varian IN (1,2,18,22,28) 
              GROUP BY m.model
            ");
            //--manual pilih id_model
            //--manual pilih id_varian --karna ndak bisa diklasifikasi
        // $leasing_rejects = array();
        // foreach ($q_model->result() as $qm) {        
        // }
        foreach ($q_leasing->result() as $ql) {
            $movements = array();
            //deklarasi variabel
            $otr = 0;
            $discount = 0;
            $dp = 1000000;
            $net_dp = $dp-$discount;
            $angsuran_4 = 4000000;
            $angsuran_5= 5000000;
            $total_4 = $net_dp+(4*12*$angsuran_4);
            $total_5 = $net_dp+(4*12*$angsuran_4);
            foreach ($q_model->result() as $qm) {
                $movements[$qm->id_model] = array(
                    "model"=> $qm->model,
                    "otr"=> $qm->harga_otr,
                    "discount"=> $discount,
                    "dp"=> $dp,
                    "net_dp"=> $net_dp,
                    "angsuran_4" => $angsuran_4,
                    "angsuran_5" => $angsuran_5,
                    "total_4" => $total_4,
                    "total_5" => $total_5
                );
            }        
            //$leasing_movements[] = array("leasing"=>$ql->leasing,"movements"=>$movements);
            //$leasing_movements[$ql->leasing] = array("movements"=>$movements);
            $leasing_movements["leasing"] = $ql->leasing;
            $leasing_movements["movements"] = $movements;
            //$ll[]=array("ll"=>$leasing_movements);
        }                          
        $hasil = $leasing_movements;
        return $hasil;
    }

    //hitung do by region
    private function _hitung_do($region,$tahun,$bulan) {
        $q_do = $this->db_wuling->query
        ("SELECT COUNT(s_do.tgl_do) as total_do
        FROM s_do
        INNER JOIN s_spk ON s_do.id_prospek = s_spk.id_prospek
        INNER JOIN s_prospek ON s_spk.id_prospek = s_prospek.id_prospek           
      WHERE
        MONTH(s_do.tgl_do)=$bulan AND YEAR(s_do.tgl_do)=$tahun
        AND s_spk.id_perusahaan IN ($region)             
        ")->row();
        $hasil = $q_do->total_do;
        return $hasil;
    }

    private function _hitung_new_spk($region,$tahun,$bulan) {
        $q_spk_new = $this->db_wuling->query
        ("SELECT COUNT(s_spk.tgl_spk) as total_spk
            FROM s_spk          
          WHERE
            MONTH(s_spk.tgl_spk)=$bulan AND YEAR(s_spk.tgl_spk)=$tahun          
            AND s_spk.batal='n'
            AND s_spk.id_perusahaan IN ($region)                
        ")->row();
        $hasil = $q_spk_new->total_spk;
        return $hasil;
    }


    private function _hitung_batal_spk($region,$tahun,$bulan) {
        $q_spk_new = $this->db_wuling->query
        ("SELECT COUNT(s_spk.tgl_spk) as total_spk
            FROM s_spk          
          WHERE
            MONTH(s_spk.tgl_spk)=$bulan AND YEAR(s_spk.tgl_spk)=$tahun          
            AND s_spk.batal='y'
            AND s_spk.id_perusahaan IN ($region)                
        ")->row();
        $hasil = $q_spk_new->total_spk;
        return $hasil;
    }

    public function get_conversion_data($region,$tahun) {
        $where_region = "";
        if($region<>'all') {
            $where_region = " WHERE coverage = '$region'";
        }
        $q_region = $this->db_wuling->query
            ("SELECT region,coverage,nama_team,id_sm 
              FROM adm_team_sm 
              $where_region
              ORDER BY region ASC");                              
        $dos = array();

        //coba buat loop sendiri untuk kasus khusus tahun baru
        //fill array with zero
        for($i=0;$i<12;$i++) { //jumlah bulan     
            $v_outstanding_spks[$i] = 0;            
            $v_new_spks[$i]         = 0;
            $v_dos[$i]              = 0;
            $v_cancel_rejects[$i]   = 0;
            $v_remainings[$i]       = 0;
        }
        for($i=0;$i<12;$i++) { //jumlah bulan
            //$grand_grand_total[$i] = 0;
            //kondisi untuk os_spk di awal tahun (bulan 1), 
            //berarti harus ambil remaining bulan 12 tahun lalu
            if($i>0){//os_spk ambil dari remaining bulan lalu
                $v_outstanding_spks[$i] = $v_remainings[$i-1];
            }          
            $v_new_spks[$i]         = $this->_hitung_new_spk($region,$tahun-1,$i+1);
            $v_dos[$i]              = $this->_hitung_do($region,$tahun-1,$i+1);
            $v_cancel_rejects[$i]   = $this->_hitung_batal_spk($region,$tahun-1,$i+1);;
            $v_remainings[$i]       = ($v_outstanding_spks[$i]+$v_new_spks[$i]) - ($v_dos[$i]+$v_cancel_rejects[$i]);
        }

        //normal
        for($i=0;$i<12;$i++) { //jumlah bulan
            //$grand_grand_total[$i] = 0;
            //kondisi untuk os_spk di awal tahun (bulan 1), 
            //berarti harus ambil remaining bulan 12 tahun lalu
            if($i>0){//os_spk ambil dari remaining bulan lalu
                $outstanding_spks[$i] = $remainings[$i-1];
            } else {//os_spk ambil dari tahun lalu, bulan 12
                // $new_spk = $this->_hitung_new_spk($region,$tahun,$i+1); //0=jan, 11=des
                // $v_dos = $this->_hitung_do($region,$tahun,$i+1);
                // $cancel = $this->_hitung_batal_spk($region,$tahun,$i+1);
                //hitung remaining spk tahun lalu bulan 12
                $new_spk_min_1 = $this->_hitung_new_spk($region,$tahun-1,12);
                $dos_min_1 = $this->_hitung_do($region,$tahun-1,12);
                $cancel_min_1 = $this->_hitung_batal_spk($region,$tahun-1,12);
                $remaining_min_1 = $new_spk_min_1-($dos_min_1+$cancel_min_1);                

                //$outstanding_spks[$i] = $os_spk_min_1+$new_spk_min_1-($dos_min_1-$cancel_min_1);
                $remaining_min_1 = $v_remainings[11];
                $outstanding_spks[$i] = $remaining_min_1; 
            }            
            $new_spks[$i]         = $this->_hitung_new_spk($region,$tahun,$i+1);
            $dos[$i]              = $this->_hitung_do($region,$tahun,$i+1);
            $cancel_rejects[$i]   = $this->_hitung_batal_spk($region,$tahun,$i+1);;
            $remainings[$i]       = ($outstanding_spks[$i]+$new_spks[$i]) - ($dos[$i]+$cancel_rejects[$i]);
            //hitung conversion_rate
            //kondisi 0 biar gak division zero
            if($outstanding_spks[$i]==0 && $new_spks[$i]==0) {
                $conversion_rates[$i] = 0;
            } else {
                $conversion_rates[$i] = round($dos[$i]/($outstanding_spks[$i]+$new_spks[$i]),2);
            }
            //hitung rejection rate
            //kondisi 0 biar gak division zero
            if($outstanding_spks[$i]==0 && $new_spks[$i]==0) {
                $rejection_rates[$i] = 0;
            } else {
                $rejection_rates[$i] = round($cancel_rejects[$i]/($outstanding_spks[$i]+$new_spks[$i]),2);
            }
            //exit loop for, kalau tahun berjalan untuk bulan depan (real date)
            $tahun_skrg = date('Y');  
            $bulan_skrg = date('m');
            if($i>$bulan_skrg-1  && $tahun==$tahun_skrg)
            {
                $outstanding_spks[$i] = 0;
                $new_spks[$i]         = 0;
                $dos[$i]              = 0;
                $cancel_rejects[$i]   = 0;
                $remainings[$i]       = 0;
                $conversion_rates[$i] = 0;
                $rejection_rates[$i]  = 0;
            }
        }  
        $hasil["region"] = "ALL-REGION";
        if($region<>'all') {
            $hasil["region"] = $q_region->row()->region;
        }   
        $hasil["outstanding_spk"] = $outstanding_spks;
        $hasil["new_spk"] = $new_spks;
        $hasil["do"] = $dos;
        $hasil["cancel_reject"] = $cancel_rejects;
        $hasil["remaining"] = $remainings;
        $hasil["conversion_rate"] = $conversion_rates;
        $hasil["rejection_rate"] = $rejection_rates;
        return $hasil;
    }

    public function count_spk_reject_by_model_leasing($tahun,$bulan,$id_model,$id_leasing) {
        $hasil = 0;
        // $where_region = "";
        // if($region<>'all') {
        //     $where_region = " AND s_spk.id_perusahaan IN ($region)";
        // }        
        //hitung total spk reject/batal
            $q = $this->db_wuling->query 
                ("SELECT COUNT(pk.no_spk) as total
                FROM s_spk_batal AS sbtl 
                INNER JOIN s_spk AS pk ON pk.no_spk=sbtl.no_spk
                INNER JOIN leasing AS ls ON ls.id_leasing=pk.id_leasing
                INNER JOIN s_prospek AS pr ON pr.id_prospek = pk.id_prospek
                INNER JOIN unit AS u ON pr.kode_unit = u.kode_unit
                INNER JOIN p_varian AS v ON v.id_varian = u.id_varian 
                INNER JOIN p_model AS m ON m.id_model = v.id_model
                WHERE MONTH(sbtl.tgl)=$bulan AND YEAR(sbtl.tgl)=$tahun
                AND v.id_model = $id_model
                AND ls.id_leasing = $id_leasing
            ")->row();
            $hasil = $q->total;
        return $hasil;
    }

    public function get_leasing_reject_data($tahun,$bulan) {       
        $q_model = $this->db_wuling->query
            ("SELECT id_model,model FROM p_model ORDER BY model");
        $q_leasing = $this->db_wuling->query
            ("SELECT * FROM leasing ORDER BY leasing");        
        $leasing_rejects = array();
        foreach ($q_leasing->result() as $ql) {
            $rejects = array();
            foreach ($q_model->result() as $qm) {
                $rejects[$qm->id_model] = array(
                    "model"=> $qm->model,
                    "total"=> $this->count_spk_reject_by_model_leasing($tahun,$bulan,$qm->id_model,$ql->id_leasing)
                );
            }        
            $leasing_rejects[$ql->id_leasing] = array("leasing"=>$ql->leasing,"rejects"=>$rejects);
        }                          
        $hasil = $leasing_rejects;
        return $hasil;
    }
    ////<--end (z) -->////

}