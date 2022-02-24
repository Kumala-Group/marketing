<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_gm_request_ar extends CI_Controller {

	public function __construct() {
	    parent::__construct();
			$this->load->model('model_request_ar');
	}

  public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && ($level=='wuling_gm')){
			$d['judul']="Request AR";
			$d['class'] = "request_ar";
			$d['content'] = 'request_ar/view';
			$d['data']=$this->request_ar_data();
			$this->load->view('wuling_gm_home',$d);
		}else{
			redirect('wuling_gm_login','refresh');
		}
	}

    public function request_ar_data(){
        $q=$this->db_wuling->select('ra.id_prospek, ra.request_ar, ra.id_request_ar, rap.sales, rap.spv, rap.sm, rap.gm, rap.admin_keuangan')
        ->from('request_ar ra')
        ->join('request_ar_progress rap', 'rap.id_request_ar = ra.id_request_ar')
        ->where("rap.gm!='0'")
        ->get();
		return $q;
	}

	public function get_id_request_ar($id_prospek){
        $q=$this->db_wuling->select('id_request_ar')
        ->from('request_ar')
        ->where("id_prospek='$id_prospek'")
        ->get();
		return $q->row()->id_request_ar;
	}

	public function get_id_spv($id_sales){
        $q=$this->db_wuling->select('ats.id_supervisor')
        ->from('adm_team_supervisor ats')
        ->join('adm_sales as', 'as.id_leader = ats.id_team_supervisor')
        ->where("as.id_sales='$id_sales'")
        ->get();
		return $q->row()->id_supervisor;
	}

	public function simpan()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='wuling_gm'){
			date_default_timezone_set('Asia/Makassar');
			$id_request_ar = $this->input->post('id_request_ar');

			/* Tabel Request AR Progress */
			$this->db_wuling->query("UPDATE request_ar_progress SET gm = '2', admin_keuangan='1'
				WHERE id_request_ar='$id_request_ar';");
			echo "Data Sukses diSimpan";
		}else{
			redirect('login','refresh');
		}

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
