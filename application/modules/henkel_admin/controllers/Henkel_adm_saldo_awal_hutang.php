<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_saldo_awal_hutang extends CI_Controller {

	public function __construct() {
	    parent::__construct();
		$this->load->model('model_sa_hutang');
		$this->load->model('model_item');
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Saldo Awal Hutang";
			$d['class'] = "akuntansi";
			$d['data'] =$this->db_kpp->query('SELECT sa.*, s.nama_supplier FROM saldo_awal_hutang sa
																 JOIN supplier s on s.kode_supplier=sa.kode_supplier
	                               ');
			$d['content'] = 'saldo_awal_hutang/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function reset(){
		$username= $this->session->userdata('username');
		$id['user']=$username;
			$this->db_kpp->delete("t_detail_sah",$id);
	}


	public function tambah() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$this->reset();
			$d = array('judul' 			=> 'Tambah Saldo Awal Hutang',
						'class' 		=> 'akuntansi',
						'id_saldo_awal_hutang'=>'' ,
						'tanggal'=> date("Y-m-d"),
						'kode_supplier'	=> '',
						'nama_supplier'	=> '',
						'alamat'	=> '',
						'content' 		=> 'saldo_awal_hutang/add',
						'data'		=>  $this->db_kpp->query('SELECT sa.*,a.nama_akun FROM t_detail_sah sa
																			 JOIN akun a on sa.kode_akun=a.kode_akun
				                               ')
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	function t_detail(){
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['user']=$this->input->get('user');
			$parent = $this->db_kpp->select('sa.*,a.nama_akun')->join('akun a','sa.kode_akun = a.kode_akun')->get_where('t_detail_sah sa', $id)->result();
			//$this->db->join('emp e','e.id = p.emp_id')->get_where('pay p', array("p.date" => $date,"e.status"=>"Active"));

				if(count($parent)>0){
					$output='';
					$i=0;
					foreach ($parent as $dt) {
						$i++;
						$output.='<tr>';
						$output.='<td class="center">'.$dt->no_invoice.'</td>';
						$output.='<td class="center">'.tgl_sql($dt->tgl_inv).'</td>';
						$output.='<td class="center">'.$dt->jt.'</td>';
						$output.='<td class="center">'.$dt->nama_akun.'</td>';
						$output.='<td class="center"> Rp. '.separator_harga2($dt->total).'</td>';
						$output.='<td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" id="a" href="#modal-table" onclick="javascript:editData('.$dt->id_t.')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>
										<a class="red" onclick="javascript:hapusData('.$dt->id_t.')">
												<i class="icon-trash bigger-130"></i>
										</a>
                </div>

                <div class="hidden-desktop visible-phone">
                    <div class="inline position-relative">
                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-caret-down icon-only bigger-120"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                            <li>
                                <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                    <span class="green">
                                        <i class="icon-edit bigger-120"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                    <span class="red">
                                        <i class="icon-trash bigger-120"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                </center>
            </td>';
						$output.='</tr>';
						$count=$i;
						$data= array('table'=>$output,'count'=>$count);
					}
				}else {
					$output='';
					$count=0;
					$data= array('table'=>$output,'count'=>$count);
				}
				echo json_encode($data);

		}else {
			redirect('henkel','refresh');
		}

	}

	public function t_cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t']	= $this->input->get('cari');
			$q 	 = $this->db_kpp->get_where("t_detail_sah",$id);
			$row = $q->num_rows();
      if($row>0){
				$dt = $this->model_sa_hutang->get($id);
				$d['id_t'] 	= $dt->id_t;
				$d['no_invoice'] 	= $dt->no_invoice;
				$d['tgl_inv'] 	= tgl_sql($dt->tgl_inv);
				$d['jt'] 	= $dt->jt;
				$d['akun'] 	= $dt->kode_akun;
				$d['total'] 	= $dt->total;
				echo json_encode($d);
			}else {
				$d['id_t'] 	= '';
				$d['no_invoice'] 	= '';
				$d['tgl_inv'] 	= '';
				$d['jt'] 	= '';
				$d['akun'] 	= '';
				$d['total'] 	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function t_simpan_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$dt['no_invoice']= $this->input->post('no_invoice');
			$dt['tgl_inv'] 	= tgl_sql($this->input->post('tgl_inv'));
			$dt['kode_akun'] 	= $this->input->post('akun');
			$dt['jt'] 	= $this->input->post('jt');
			$dt['total'] 	= $this->input->post('total');
			$dt['user'] = $this->session->userdata('username');
			$id_t=$this->input->post('id_t');
			if($id_t==''){
				$id_a='';
			}else {
				$id_a=$id_t;
			}
			$id['id_t']=$id_a;

			$q 	 = $this->db_kpp->get_where("t_detail_sah",$id);
			$row = $q->num_rows();
			if ($row <= 0){
				$this->db_kpp->insert("t_detail_sah",$dt);
				echo "Data Sukses diSimpan";
			}else {
				$this->db_kpp->update("t_detail_sah",$dt,$id);
				echo "Data Sukses diUpdate";
			}
		}else{
			redirect('henkel','refresh');
		}

	}

	public function t_hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t']	= $this->input->post('id_h');
			$q 	 = $this->db_kpp->get_where("t_detail_sah",$id);
			$row = $q->num_rows();
      if($row>0){
				$this->db_kpp->delete("t_detail_sah",$id);
			}
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$kode_supplier = $this->input->post('kode_supplier');
			$tgl= $this->input->post('tanggal');
			$id_t=$this->session->userdata('username');
			$this->db_kpp->query("INSERT INTO saldo_awal_hutang (kode_supplier, tgl, no_invoice, tgl_inv, jt, kode_akun,total,user)
														SELECT '$kode_supplier','$tgl',no_invoice, tgl_inv, jt, kode_akun,total,user
														FROM t_detail_sah
														WHERE user='$id_t'");
			$this->db_kpp->query("DELETE FROM t_detail_sah WHERE user='$id_t'");
			echo "Data Sukses diSimpan";
		}else{
			redirect('henkel','refresh');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
