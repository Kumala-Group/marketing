<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketing_dept_lap_summary extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->database('default', TRUE);
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='marketing_dept'){
			$d['judul']="Summary Activity";
			$d['class'] = "wuling";
			$d['content'] = 'lap/summary/view';
			$this->load->view('marketing_dept_home',$d);
		}else{
			redirect('kmg','refresh');
		}
	}

	public function get_summary_per_perusahaan($id,$bulan) {

    $where='';
    if ($bulan!='' && $id!='') {
      $where = " ((MONTH(e.tgl_mulai)= '$bulan' OR MONTH(e.tgl_selesai)= '$bulan') AND e.id_perusahaan='$id') ";
    } elseif ($bulan!='' && $id=='') {
    $where = " ((MONTH(e.tgl_mulai)= '$bulan' OR MONTH(e.tgl_selesai)= '$bulan') ) ";
	} elseif ($bulan==''  && $id!=''){
      $where = " e.id_perusahaan='$id' ";
    }
		$this->db_wuling->select('e.event,ej.event_jenis,ea.event_area,e.tgl_mulai,e.tgl_selesai,e.total_biaya,el.lokasi')
		->from('event e')->join('event_jenis ej','e.id_event_jenis=ej.id_event_jenis')->join('event_lokasi el','e.id_event_lokasi=el.id_event_lokasi')->join('event_area ea','ea.id_event_area=el.id_event_area')->where($where);
	 	$q = $this->db_wuling->get();
		return $q;
	}
	public function summary_per_perusahaan() {
		//error_reporting(0);
		$id=$this->input->get('perusahaan');
		$bulan=$this->input->get('bulan');
		$list = $this->get_summary_per_perusahaan($id,$bulan);
		$cek=$list->num_rows();
		$row = array();
			if($cek>0){
						$i=1;
						$total_akhir=0;
				foreach ($list->result() as $dt) {
						$value=$dt->total_biaya;
						$total_akhir=$total_akhir+$value;
						$row[] = array(
							'no'=>'<center>'.$i++.'</center>',
							'jenis_event'=>'<center>'.$dt->event_jenis.'</center>',
							'event'=>'<center>'.$dt->event.'</center>',
							'tgl_mulai'=>'<center>'.tgl_sql($dt->tgl_mulai).'</center>',
							'tgl_selesai'=>'<center>'.tgl_sql($dt->tgl_selesai).'</center>',
							'lokasi'=>'<center>'.$dt->event_area.' - '.$dt->lokasi.'</center>',
							'total_biaya'=>'<center>'.'Rp. '.separator_harga($dt->total_biaya).'</center>'
							);
						}
					}else {
						$total_akhir=0;
						$row[] = array(
							'no'=>'Data Kosong',
							'jenis_event'=>'Data Kosong',
							'event'=>'Data Kosong',
							'tgl_mulai'=>'Data Kosong',
							'tgl_selesai'=>'Data Kosong',
							'lokasi'=>'Data Kosong',
							'total_biaya'=>'Data Kosong'
						);
					}

					$data= array('aaData'=>$row,'ta'=>separator_harga($total_akhir));

					echo json_encode($data);
		    }






}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
