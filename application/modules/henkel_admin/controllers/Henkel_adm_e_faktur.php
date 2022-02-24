<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_e_faktur extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_e_faktur');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data E-Faktur";
			$d['class'] = "master";
			$d['data'] = $this->model_e_faktur->all();
			$d['content'] = 'e_faktur/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			  date_default_timezone_set('Asia/Makassar');
				//$id['id_e_faktur'] = $this->model_e_faktur->cari_max_e_faktur();
				$awal = $this->input->post('inputan_awal');
				$akhir = $this->input->post('inputan_akhir');
				$head = $this->input->post('head');

				for ($i=(int)$awal; $i <= (int)$akhir; $i++) {
					$this->db_kpp->query("INSERT INTO e_faktur (no_e_faktur)
																VALUES ('$head$i')");

				}

				//$this->model_e_faktur->insert($id);
				echo "Data Sukses diSimpan";
		}else{
			redirect('henkel','refresh');
		}

	}

	function get_all_data() {
	 		$query = $this->db_kpp->query('SELECT * FROM e_faktur');
	 		$result = $query->num_rows();
	 		return $result;
	}

	public function fetchdata()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			  $columns = array('no_e_faktur', 'status');

				$query = $this->db_kpp->query('SELECT * FROM e_faktur');

				if ($this->input->post(array('search', 'value'))) {
						$query .= 'WHERE no_e_faktur LIKE "%'.$this->input->post(array('search', 'value')).'%"';
				}

				if ($this->input->post('order')) {
						$query .= 'ORDER BY '.$columns[$this->input->post(array('order', '0', 'column'))].' '.$this->input->post(array('order', '0', 'dir')).'';
				} else {
 						$query .= 'ORDER BY id_e_faktur ASC';
			  }

				$query1 = '';

				if($this->input->post('length') != -1) {
				 	  $query1 = 'LIMIT ' . $this->input->post('start') . ', ' . $this->input->post('length');
				}

				$number_filter_row = $query->num_rows();

				$query = $this->db_kpp->query($query . $query1);

				$data = array();

				while($row = $result>result()) {
					 $sub_array = array();
					 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id_e_faktur"].'" data-column="no_e_faktur">' . $row["no_e_faktur"] . '</div>';
					 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id_e_faktur"].'" data-column="status">' . $row["status"] . '</div>';
					 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button>';
					 $data[] = $sub_array;
				}

				$output = array(
				 "draw"    => intval($_POST["draw"]),
				 "recordsTotal"  =>  get_all_data(),
				 "recordsFiltered" => $number_filter_row,
				 "data"    => $data
				);

				echo json_encode($output);
		}else{
			redirect('henkel','refresh');
		}

	}


	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_e_faktur']	= $this->input->get('cari');

			if($this->model_e_faktur->ada($id)) {
				$dt = $this->model_e_faktur->get($id);
				$d['id_e_faktur']	= $dt->id_e_faktur;
				$d['no_e_faktur'] 	= $dt->no_e_faktur;

				echo json_encode($d);
			} else {
				$d['id_e_faktur']		= '';
				$d['no_e_faktur']  	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_e_faktur']	= $this->uri->segment(3);

			if($this->model_e_faktur->ada($id))
			{
				$this->model_e_faktur->delete($id);
			}
			redirect('henkel_adm_e_faktur','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
