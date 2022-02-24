<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_ticketing extends CI_Model
{
	public function getAllTicket($dari=0, $sampai=0, $brand=0, $cabang=0, $dep=0){
		$nw= '';
		if($dari != '' || $sampai !='' || $brand != '' || $cabang != '' || $dep != ''){
			if($dari !='' && $sampai != ''){
				$n[] = "`ticketing`.`tanggal_masuk` >='".$dari." 23:59:00' && `ticketing`.`tanggal_masuk` <='".$sampai." 23:59:00'";
			}
			if($brand !=''){
				$n[] = "`ticketing`.`id_brand` = '$brand'";
			}
			if($cabang !=''){
				$n[] = "`ticketing`.`cabang` = '$cabang'";
			}
			if($dep !=''){
				$n[] = "`ticketing`.`id_divisi` = '$dep'";
			}
			if($n != ''){
				$nw1 = implode(' && ', $n);
				$nw = 'WHERE '.$nw1;
			}
		}
		$q = $this->db_helpdesk->query("SELECT * FROM `ticketing` ".$nw." ORDER BY `id` DESC");
		foreach($q->result('array') as $dt){
			$q1 = $this->db_helpdesk->query("SELECT * FROM `ticketing_execute` WHERE `id_ticket`='$dt[id]'");
			foreach($q1->result('array') as $dt1){
				$q2 = $this->db->query("SELECT * FROM `karyawan` WHERE `nik`='$dt1[id_karyawan]'");
				foreach($q2->result('array') as $dt2){
					$dt['nama_executor'] = $dt2['nama_karyawan'];
				}
				$dt['tanggal_mulai'] = $dt1['tanggal_mulai'];
				$dt['estimasi_selesai'] = $dt1['estimasi_selesai'];
				$dt['tanggal_selesai'] = $dt1['tanggal_selesai'];
			}
			if(empty($dt['nama_executor'])){
				$dt['nama_executor'] = 'Belum ada';
				$dt['tanggal_mulai'] = 'Belum ada';
				$dt['estimasi_selesai'] = 'Belum ada';
				$dt['tanggal_selesai'] = 'Belum ada';
			}
			if($dt['level'] == ''){
				$dt['level_task'] = '-';
				$dt['level_task_color'] = 'grey';
			}else if($dt['level'] == '1'){
				$dt['level_task'] = 'Easy';
				$dt['level_task_color'] = '#f77b00';
			}else if($dt['level'] == '2'){
				$dt['level_task'] = 'Medium';
				$dt['level_task_color'] = '#f73601';
			}else if($dt['level'] == '3'){
				$dt['level_task'] = 'High';
				$dt['level_task_color'] = '#cc014a';
			}else if($dt['level'] == '4'){
				$dt['level_task'] = 'Expert';
				$dt['level_task_color'] = '#a3006a';
			}
			$hasil[] = $dt;
		}
		if(!isset($hasil)){
			$hasil = '';
		}
		return $hasil;
	}

	public function getAllTicketExecuting($id){
		$w = $this->db_helpdesk->query("SELECT * FROM `ticketing_execute` WHERE `id_karyawan`='$id'");
		foreach($w->result('array') as $dt1){
			$q = $this->db_helpdesk->query("SELECT * FROM `ticketing` WHERE `id`='$dt1[id_ticket]' && `status`='1'");
			foreach($q->result('array') as $dt){
				if($dt['level'] == ''){
					$dt['level_task'] = '-';
					$dt['level_task_color'] = 'grey';
				}else if($dt['level'] == '1'){
					$dt['level_task'] = 'Easy';
					$dt['level_task_color'] = '#f77b00';
				}else if($dt['level'] == '2'){
					$dt['level_task'] = 'Medium';
					$dt['level_task_color'] = '#f73601';
				}else if($dt['level'] == '3'){
					$dt['level_task'] = 'High';
					$dt['level_task_color'] = '#cc014a';
				}else if($dt['level'] == '4'){
					$dt['level_task'] = 'Expert';
					$dt['level_task_color'] = '#a3006a';
				}
				$hasil[] = $dt;
			}
		}
		if(!isset($hasil)){
			$hasil = '';
		}
		return $hasil;
	}

	public function getAllBrand($d=0)
	{
		$n ='';
		if($d != ''){
			$n = "WHERE `id`='$d'";
		}
		$q = $this->db->query("SELECT * FROM brand ".$n);
		foreach ($q->result('array') as $dt) {
			$hasil[] = $dt;
		}
		return $hasil;
	}

    public function getAllDepartement()
	{
		$q = $this->db->query("SELECT * FROM p_divisi");
		foreach ($q->result('array') as $dt) {
			$hasil[] = $dt;
		}
		return $hasil;
	}

	public function getAllCabang()
	{
		$q = $this->db->query("SELECT * FROM `perusahaan`");
		foreach ($q->result('array') as $dt) {
			$hasil[] = $dt['singkat'].' - '.$dt['lokasi'];
		}
		return $hasil;
	}

	public function update2Pickup($data){
		$tgl = date('Y-m-d H:i:s');
		$id_ticket = $data['id_ticket'];
		$level = $data['level'];
		$id_karyawan = $data['id_karyawan'];
		$tgl_estimasi = $data['tanggal_estimasi'].' 00:00:00';
		$this->db_helpdesk->query("INSERT INTO `ticketing_execute` (`id_ticket`,`id_karyawan`,`tanggal_mulai`,`estimasi_selesai`) VALUES ('$id_ticket','$id_karyawan','$tgl','$tgl_estimasi')");
		$this->db_helpdesk->query("UPDATE `ticketing` SET `status`='1', `level`='$level' WHERE `id`='$id_ticket'");
	}

	public function update2Done($data){
		$tgl = date('Y-m-d H:i:s');
		$id_ticket = $data['id_ticket'];
		$this->db_helpdesk->query("UPDATE `ticketing_execute` SET `tanggal_selesai`='$tgl' WHERE `id_ticket`='$id_ticket'");
		$this->db_helpdesk->query("UPDATE `ticketing` SET `status`='2' WHERE `id`='$id_ticket'");
	}

	public function update2Cancel($data){
		$tgl = date('Y-m-d H:i:s');
		$id_ticket = $data['id_ticket'];
		$this->db_helpdesk->query("UPDATE `ticketing_execute` SET `tanggal_selesai`='$tgl' WHERE `id_ticket`='$id_ticket'");
		$this->db_helpdesk->query("UPDATE `ticketing` SET `status`='3' WHERE `id`='$id_ticket'");
	}

	public function arrayAddslashes($array){
		foreach($array as $key => $value){
			$hasil[$key] = addslashes($value); 
		}
		return $hasil;
	}

	public function updateTicket($array){
		$data = $this->arrayAddslashes($array);
		$this->db_helpdesk->query("UPDATE `ticketing` SET `detail_problem`='$data[detail_problem]', `type_job`='$data[type_job]', `level`='$data[level]' WHERE `id`='$data[id_ticket]'");
	}

	public function ticket_process(){
		$sql = "SELECT *,`ticketing`.`id`,`ticketing_execute`.`tanggal_mulai`,`ticketing_execute`.`estimasi_selesai`,`ticketing_execute`.`tanggal_selesai` FROM `ticketing` INNER JOIN `ticketing_execute` ON `ticketing`.`id` = `ticketing_execute`.`id_ticket`";
		$q = $this->db_helpdesk->query($sql);
		foreach($q->result('array') as $dt){
			$e = $this->db->query("SELECT * FROM `karyawan` WHERE `nik`='$dt[id_karyawan]'");
			foreach($e->result('array') as $dt2){
				$dt['nama_executor'] = $dt2['nama_karyawan'];
			}
			$hasil[] = $dt;
		}
		if(!isset($hasil)){
			$hasil = '';
		}
		return $hasil;
	}

	public function cetak_ticket($dari=0, $sampai=0, $brand=0, $cabang=0, $dep=0){
		$r = $this->getAllTicket($dari, $sampai, $brand, $cabang, $dep);
		foreach($r as $row){
			$q = $this->db->query("SELECT * FROM `brand` WHERE `id_brand`='$row[id_brand]'");
			foreach($q->result('array') as $dt){
				$row['brand'] = $dt['nama_brand'];
			}
			$q1 = $this->db->query("SELECT * FROM `p_divisi` WHERE `id_divisi`='$row[id_divisi]'");
			foreach($q1->result('array') as $dt){
				$row['departement'] = $dt['divisi'];
			}
			if($row['status'] == '0'){
				$row['status_ticket'] = 'Waiting';
			}else if($row['status'] == '1'){
				$row['status_ticket'] = 'Pickup';
			}else if($row['status'] == '2'){
				$row['status_ticket'] = 'Done';
			}else if($row['status'] == '3'){
				$row['status_ticket'] = 'Canceled';
			}
			
			// unset($row['id']);
			// unset($row['id_divisi']);
			// unset($row['id_brand']);
			// unset($row['gambar']);
			// unset($row['status']);
			$hasil[] = $row;
		}
		if(!isset($hasil)){
			$hasil = '';
		}
		return $hasil;
	}

	public function get_graph_level($bln=0, $thn=0){
		$n = '';
		if($bln != ''){
			$tgl_dari = $thn.'-'.$bln.'-1 00:00:00';
			$tgl_sampai = $thn.'-'.$bln.'-31 23:59:00';

			$n = "&& `tanggal_masuk`>='$tgl_dari' && `tanggal_masuk`<='$tgl_sampai'";
		}
		$levels = array(
			'-', 'Easy', 'Medium', 'High', 'Expert'
		);
		for($i=1; $i<=4; $i++){
			$q = $this->db_helpdesk->query("SELECT id FROM `ticketing` WHERE `level`='$i' ".$n);
			$tmp1['nama'] = $levels[$i];
			$tmp1['jumlah'] = count($q->result());
			$tmp[] = $tmp1;
		}
		$hasil = $tmp;
		return $hasil;
	}

	public function get_graph_dep($bln=0, $thn=0){
		$n = '';
		if($bln != ''){
			$tgl_dari = $thn.'-'.$bln.'-1 00:00:00';
			$tgl_sampai = $thn.'-'.$bln.'-31 23:59:00';

			$n = "&& `tanggal_masuk`>='$tgl_dari' && `tanggal_masuk`<='$tgl_sampai'";
		}
		$deps = $this->getAllDepartement();
		foreach($deps as $dep){
			$q = $this->db_helpdesk->query("SELECT id FROM `ticketing` WHERE `id_divisi`='$dep[id_divisi]' ".$n);
			$tmp1['nama'] = $dep['divisi'];
			$tmp1['jumlah'] = count($q->result());
			if($tmp1['jumlah'] > 0){
				$tmp[] = $tmp1;
			}

		}
		if(!isset($tmp)){
			$tmp = '';
		}
		$hasil = $tmp;
		return $hasil;
	}

	public function get_graph_brand($bln=0, $thn=0){
		$n = '';
		if($bln != ''){
			$tgl_dari = $thn.'-'.$bln.'-1 00:00:00';
			$tgl_sampai = $thn.'-'.$bln.'-31 23:59:00';

			$n = "&& `tanggal_masuk`>='$tgl_dari' && `tanggal_masuk`<='$tgl_sampai'";
		}
		$list_brand = $this->getAllBrand();
		foreach($list_brand as $brand){
			$q = $this->db_helpdesk->query("SELECT id FROM `ticketing` WHERE `id_brand`='$brand[id_brand]' ".$n);
			$c = count($q->result());
			if($c > 0){
				$hasil[$brand['nama_brand']] = $c;
			}
		}
		if(!isset($hasil)){
			$hasil = '';
		}
		return $hasil;
	}

	public function get_graph_status($bln=0, $thn=0){
		$n = '';
		if($bln != ''){
			$tgl_dari = $thn.'-'.$bln.'-1 00:00:00';
			$tgl_sampai = $thn.'-'.$bln.'-31 23:59:00';

			$n = "&& `tanggal_masuk`>='$tgl_dari' && `tanggal_masuk`<='$tgl_sampai'";
		}
		$list_brand = $this->getAllBrand();
		$bgcolor = array(
			"#63b598", "#ce7d78", "#ea9e70", "#a48a9e", "#c6e1e8", "#648177" ,"#0d5ac1" ,
			"#f205e6" ,"#1c0365" ,"#14a9ad" ,"#4ca2f9" ,"#a4e43f" ,"#d298e2" ,"#6119d0",
			"#d2737d" ,"#c0a43c" ,"#f2510e" ,"#651be6" ,"#79806e" ,"#61da5e" ,"#cd2f00" ,
			"#9348af" ,"#01ac53" ,"#c5a4fb" ,"#996635","#b11573" ,"#4bb473" ,"#75d89e" ,
			"#2f3f94" ,"#2f7b99" ,"#da967d" ,"#34891f" ,"#b0d87b" ,"#ca4751" ,"#7e50a8" ,
			"#c4d647" ,"#e0eeb8" ,"#11dec1" ,"#289812" ,"#566ca0" ,"#ffdbe1" ,"#2f1179" ,
			"#935b6d" ,"#916988" ,"#513d98" ,"#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
			"#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
			"#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
			"#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf"
		);
		$i = 0;
		foreach($list_brand as $brand){
			for($u=0; $u<4; $u++){
				$q = $this->db_helpdesk->query("SELECT `id`,`status` FROM `ticketing` WHERE `id_brand`='$brand[id_brand]' && `status`='$u' ".$n);
				$tmp[$brand['nama_brand']][$u] = count($q->result());
			}
			if(isset($tmp[$brand['nama_brand']])){
				$tmp1[$brand['nama_brand']]['backgroundColor'] = $bgcolor[$i];
				$tmp1[$brand['nama_brand']]['label'] = $brand['nama_brand'];
				$tmp1[$brand['nama_brand']]['data'][] = $tmp[$brand['nama_brand']][0];
				$tmp1[$brand['nama_brand']]['data'][] = $tmp[$brand['nama_brand']][1];
				$tmp1[$brand['nama_brand']]['data'][] = $tmp[$brand['nama_brand']][2];
				$tmp1[$brand['nama_brand']]['data'][] = $tmp[$brand['nama_brand']][3];
			}
			$cekH = 0;
			foreach($tmp1[$brand['nama_brand']]['data'] as $cek){
				if($cek > 0){
					$cekH = 1;
				}
			}
			if($cekH == 1){
				$hasil[] = $tmp1[$brand['nama_brand']];
			}

			$i++;
		}
		if(!isset($hasil)){
			$hasil = '';
		}
		return $hasil;
	}

	public function total_ticket($bln=0, $thn=0){
		$n ='';
		if($bln != '' && $thn != ''){
			$tgl_dari = $thn.'-'.$bln.'-1 00:00:00';
			$tgl_sampai = $thn.'-'.$bln.'-31 23:59:00';

			$n = "WHERE `tanggal_masuk`>='$tgl_dari' && `tanggal_masuk`<='$tgl_sampai'";
		}

		$q = $this->db_helpdesk->query("SELECT `id`,`status` FROM `ticketing` ".$n);
		return count($q->result());
	}

	public function all()
	{
		$q = $this->db_helpdesk->query("SELECT id_tiket,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,tgl_tiket,
      wkt_tiket,masalah,priority,status_tiket FROM ((db_helpdesk.tiket INNER JOIN kmg.perusahaan on
        kmg.perusahaan.id_perusahaan=db_helpdesk.tiket.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand )
        INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tiket.nik WHERE status_tiket != 'Solved' ORDER BY priority ASC,tgl_tiket DESC,wkt_tiket DESC
                               ");
		return $q;
	}

	//Ambil seluruh pengaduan yang belum solved
	public function all_baru()
	{
		$q = $this->db_helpdesk->query("SELECT id_pengaduan,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,
		tanggal_pengaduan,type_pengaduan,jenis_masalah,keterangan,priority,status_pengaduan FROM 
		((db_helpdesk.tabel_pengaduan INNER JOIN kmg.perusahaan on kmg.perusahaan.id_perusahaan=db_helpdesk.tabel_pengaduan.id_perusahaan) 
		INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand ) INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tabel_pengaduan.nik WHERE 
		status_pengaduan != 'S' AND status_pengaduan != 'C' ORDER BY `tabel_pengaduan`.`priority` DESC
                               ");
		return $q;
	}
	public function all_pengaduan_karyawan($id)
	{
		$q = $this->db_helpdesk->query("SELECT id_pengaduan,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,
		tanggal_pengaduan,keterangan,priority,status_pengaduan FROM 
		((db_helpdesk.tabel_pengaduan INNER JOIN kmg.perusahaan on kmg.perusahaan.id_perusahaan=db_helpdesk.tabel_pengaduan.id_perusahaan) 
		INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand ) INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tabel_pengaduan.nik WHERE 
		status_pengaduan != 'S' AND tabel_pengaduan.nik='$id' ORDER BY `tabel_pengaduan`.`tanggal_pengaduan` ASC
                               ");
		return $q;
	}

	public function alldone()
	{
		$q = $this->db_helpdesk->query("SELECT id_tiket,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,tgl_tiket,
      wkt_tiket,masalah,priority,status_tiket FROM ((db_helpdesk.tiket INNER JOIN kmg.perusahaan on
        kmg.perusahaan.id_perusahaan=db_helpdesk.tiket.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand )
        INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tiket.nik WHERE status_tiket = 'Solved' ORDER BY priority ASC,tgl_tiket DESC,wkt_tiket DESC
                               ");
		return $q;
	}
	//ambil seluruh pengaduan yang sudah solved
	/*
	public function alldone_baru()
	{
		$q = $this->db_helpdesk->query("SELECT db_helpdesk.tabel_pengaduan.id_pengaduan,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,tanggal_pengaduan,
		tanggal_selesai,type_pengaduan,jenis_masalah,keterangan,priority,status_pengaduan,nik_eksekutor,nama_eksekutor,status_solving,tanggal_solving FROM (((db_helpdesk.tabel_pengaduan INNER JOIN 
		kmg.perusahaan on kmg.perusahaan.id_perusahaan=db_helpdesk.tabel_pengaduan.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=
		kmg.perusahaan.id_brand ) INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tabel_pengaduan.nik) INNER JOIN db_helpdesk.tabel_solving 
		ON db_helpdesk.tabel_solving.id_pengaduan=db_helpdesk.tabel_pengaduan.id_pengaduan WHERE status_pengaduan = 'S' ORDER BY db_helpdesk.tabel_solving.id_pengaduan DESC, tanggal_solving DESC
							   ");
							   
		return $q;
	}
	*/
	public function alldone_baru()
	{
		$q = $this->db_helpdesk->query("SELECT db_helpdesk.tabel_pengaduan.id_pengaduan,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,
		type_pengaduan,jenis_masalah,keterangan,priority,status_pengaduan,nik_eksekutor,nama_eksekutor,status_solving,tanggal_pengaduan, 
		tanggal_selesai,tanggal_mulai,estimasi FROM (((db_helpdesk.tabel_pengaduan INNER JOIN kmg.perusahaan on 
		kmg.perusahaan.id_perusahaan=db_helpdesk.tabel_pengaduan.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand= kmg.perusahaan.id_brand) 
		INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tabel_pengaduan.nik) INNER JOIN db_helpdesk.tabel_solving ON 
		db_helpdesk.tabel_solving.id_pengaduan=db_helpdesk.tabel_pengaduan.id_pengaduan WHERE (status_pengaduan = 'S' AND status_solving='S') OR 
		(status_pengaduan = 'C' AND status_solving='C') ORDER BY db_helpdesk.tabel_solving.id_pengaduan DESC, tanggal_solving DESC
							   ");
							   
		return $q;
	}
	
	public function data_modal($id)
	{
		$q = $this->db_helpdesk->query("SELECT db_helpdesk.tabel_pengaduan.id_pengaduan,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,tanggal_pengaduan,
		tanggal_selesai,keterangan,priority,status_pengaduan,nik_eksekutor,nama_eksekutor FROM (((db_helpdesk.tabel_pengaduan INNER JOIN 
		kmg.perusahaan on kmg.perusahaan.id_perusahaan=db_helpdesk.tabel_pengaduan.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=
		kmg.perusahaan.id_brand ) INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tabel_pengaduan.nik) INNER JOIN db_helpdesk.tabel_solving 
		ON db_helpdesk.tabel_solving.id_pengaduan=db_helpdesk.tabel_pengaduan.id_pengaduan WHERE status_pengaduan = 'S' AND id_pengaduan = '$id',
		tanggal_pengaduan DESC
                               ");
		if( $query->num_rows() == 1 )
		{
			return $query->row_array();
		}
		
		return FALSE;
	}
	
	public function dataTiket($per)
	{
		$query = $this->db_helpdesk->query("SELECT id_tiket,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,tgl_tiket,
      wkt_tiket,masalah,priority,status_tiket FROM ((db_helpdesk.tiket INNER JOIN kmg.perusahaan on
        kmg.perusahaan.id_perusahaan=db_helpdesk.tiket.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand )
        INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tiket.nik WHERE id_tiket='$per'");
		return $query;
	}

	public function allbykaryawan($per)
	{
		$query = $this->db_helpdesk->query("SELECT * FROM (((db_helpdesk.tiket INNER JOIN kmg.perusahaan on kmg.perusahaan.id_perusahaan=db_helpdesk.tiket.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand )
INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tiket.nik )INNER JOIN db_helpdesk.t_solving on db_helpdesk.t_solving.id_tiket=db_helpdesk.tiket.id_tiket WHERE nik_exe='$per' ORDER BY priority ASC,tgl_tiket DESC,wkt_tiket DESC");
		return $query;
	}

	public function get_lama($id)
	{
		$q 	 = $this->db_helpdesk->get_where("tiket", $id);
		$rows = $q->num_rows();

		if ($rows > 0) {
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}
	public function get($id)
	{
		$q 	 = $this->db_helpdesk->get_where("tabel_pengaduan", $id);
		$rows = $q->num_rows();

		if ($rows > 0) {
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

	public function last_kode()
	{
		$q = $this->db_helpdesk->query("SELECT MAX(right(no_inv_pengiriman,3)) as kode FROM ticketing ");
		$row = $q->num_rows();

		if ($row > 0) {
			$rows = $q->result();
			$hasil = (int) $rows[0]->kode;
		} else {
			$hasil = 0;
		}
		return $hasil;
	}

	public function ada_id_pesanan($id)
	{
		$q 	 = $this->db_helpdesk->get_where("pengiriman", $id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function t_ada_id_pesanan($id)
	{
		$q 	 = $this->db_helpdesk->get_where("t_pengiriman", $id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id)
	{
		$q 	 = $this->db_helpdesk->get_where("tiket", $id);
		$row = $q->num_rows();

		return $row > 0;
	}
	//mengecek keberadaan tabel
	public function ada_baru($id)
	{
		$q 	 = $this->db_helpdesk->get_where("tabel_pengaduan", $id);
		$row = $q->num_rows();

		return $row > 0;
	}
	public function adatsolv($id)
	{
		$q 	 = $this->db_helpdesk->get_where("t_solving", $id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function cari_max_ticketing()
	{
		$q = $this->db_helpdesk->query("SELECT MAX(id_tiket) as no FROM tiket");
		foreach ($q->result() as $dt) {
			$no = (int) $dt->no + 1;
		}
		return $no;
	}
	public function cari_max_pengaduan()
	{
		$q = $this->db_helpdesk->query("SELECT MAX(id_pengaduan) as no FROM tabel_pengaduan");
		foreach ($q->result() as $dt) {
			$no = (int) $dt->no + 1;
		}
		return $no;
	}
	public function cari_max_solv()
	{
		$q = $this->db_helpdesk->query("SELECT MAX(id_solv) as no FROM solving");
		foreach ($q->result() as $dt) {
			$no = (int) $dt->no + 1;
		}
		return $no;
	}

	public function insert($dt)
	{
		$this->db_helpdesk->insert("tiket", $dt);
	}
	//tambah data pengaduan
	public function insert_pengaduan($dt)
	{
		$this->db_helpdesk->insert("tabel_pengaduan", $dt);
	}
	
	public function insert_t_solv($dt)
	{
		$this->db_helpdesk->insert("t_solving", $dt);
	}
	//tambah data penyelesaian pengaduan
	public function insert_tabel_solving($dt)
	{
		$this->db_helpdesk->insert("tabel_solving", $dt);
	}
	
	public function insertsolv($dt)
	{
		$this->db_helpdesk->insert("solving", $dt);
	}
	public function update($id, $dts)
	{
		$this->db_helpdesk->update("tiket", $dts, $id);
	}
	//update status pengaduan
	public function updatetsolv($id, $dts)
	{
		$this->db_helpdesk->update("t_solving", $dts, $id);
	}

	public function delete_lama($id)
	{
		$this->db_helpdesk->delete("ticketing", $id);
	}
	//hapus tabel pengaduan
	public function delete_tabel_pengaduan($id)
	{
		$this->db_helpdesk->delete("tabel_pengaduan", $id);
	}

	public function delete_tsolv($id)
	{
		$this->db_helpdesk->delete("t_solving", $id);
	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */