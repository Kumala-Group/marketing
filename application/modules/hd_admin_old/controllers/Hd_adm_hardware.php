<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_hardware extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_hardware');
		$this->load->model('model_karyawan');
		$this->load->model('model_perusahaan');
		$this->load->model('model_jenis_hardware');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if (!empty($cek) && $level == 'karyawan') {
			$d['judul'] = "Data Hardware";
			$d['class'] = "master";
			$sess_data['sesi_id_perusahaan'] = '';
			$sess_data['sesi_id_brand'] = '';
			$sess_data['sesi_singkat_perusahaan'] = '';
			$this->session->set_userdata($sess_data);
			$d['data'] = $this->model_hardware->allhardware();
			$d['perusahaan'] = $this->model_perusahaan->data_perusahaan()->result();
			$d['jenis_hardware'] = $this->model_jenis_hardware->all()->result();
			$d['content'] = 'hardware/form';
			$this->load->view('hd_adm_home', $d);
		} else {
			redirect('login', 'refresh');
		}
	}
	public function view_data()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if (!empty($cek) && $level == 'karyawan') {
			$d['judul'] = "Data Hardware";
			$d['class'] = "master";

			$var = $this->session->userdata['sesi_id_perusahaan'];
			$var_brand = $this->session->userdata['sesi_id_brand'];
			if (empty($var) && empty($var_brand)) {
				$id_perusahaan = $this->input->post('cari_perusahaan');
				$id_brand = '';
			} else {
				$id_perusahaan = $var;
				$id_brand = $var_brand;
			}

			$perusahaan = $this->model_perusahaan->singkatPerusahaan($id_perusahaan);

			if (!empty($perusahaan)) {
				$sess_data['sesi_id_perusahaan'] = $id_perusahaan;
				$sess_data['sesi_id_brand'] = $id_brand;
				$sess_data['sesi_singkat_perusahaan'] = $perusahaan;
				$this->session->set_userdata($sess_data);
			}
			$per = $this->session->userdata('sesi_id_perusahaan');
			$br = $this->session->userdata('sesi_id_brand');
			$brand = $this->model_data->BrandToKaryawan($br);

			$d['data'] 		= $this->model_hardware->dataByPerusahaan($per);
			$d['noaset_hardware'] = $this->create_kd();
			$d['jenis_hardware'] = $this->model_jenis_hardware->all()->result();
			$d['content'] 	= 'hardware/view';
			$d['nama_perusahaan'] = $this->model_perusahaan->namaPerusahaan($this->session->userdata('sesi_id_perusahaan')) . ' <b>( ' . $brand . ' )</b>';
			$this->load->view('hd_adm_home', $d);
		} else {
			redirect('login', 'refresh');
		}
	}

	public function create_kd()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if (!empty($cek) && $level == 'karyawan') {
			$var = $this->session->userdata['sesi_id_perusahaan'];
			$last_kd = $this->model_hardware->last_kode($var);
			if ($var == 1) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOMKS." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOMKS.001';
					//echo json_encode($d);
				}
			} else if ($var == 2) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGMKS." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGMKS.001';
					//echo json_encode($d);
				}
			} else if ($var == 3) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.MPY." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.MPY.001';
					//echo json_encode($d);
				}
			} else if ($var == 4) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOKML." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOKML.001';
					//echo json_encode($d);
				}
			} else if ($var == 5) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOGOWA." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOGOWA.001';
					//echo json_encode($d);
				}
			} else if ($var == 6) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOPARE." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOPARE.001';
					//echo json_encode($d);
				}
			} else if ($var == 7) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOSIDRAP." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOSIDRAP.001';
					//echo json_encode($d);
				}
			} else if ($var == 8) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOPALOPO." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOPALOPO.001';
					//echo json_encode($d);
				}
			} else if ($var == 9) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOMAMUJU." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOMAMUJU.001';
					//echo json_encode($d);
				}
			} else if ($var == 10) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HOKENDARI." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HOKENDARI.001';
					//echo json_encode($d);
				}
			} else if ($var == 11) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOBONE." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOBONE.001';
					//echo json_encode($d);
				}
			} else if ($var == 12) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.KMSB." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.KMSB.001';
					//echo json_encode($d);
				}
			} else if ($var == 13) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.MAZDAMKS." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.MAZDAMKS.001';
					//echo json_encode($d);
				}
			} else if ($var == 14) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.MAZDAKENDARI." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.MAZDAKENDARI.001';
					//echo json_encode($d);
				}
			} else if ($var == 15) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.MAZDAPALU." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.MAZDAPALU.001';
					//echo json_encode($d);
				}
			} else if ($var == 17) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGPALU." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGPALU.001';
					//echo json_encode($d);
				}
			} else if ($var == 19) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGMDO." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGMDO.001';
					//echo json_encode($d);
				}
			} else if ($var == 20) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.BANMKS." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.BANMKS.001';
					//echo json_encode($d);
				}
			} else if ($var == 22) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.TATAMKS." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.TATAMKS.001';
					//echo json_encode($d);
				}
			} else if ($var == 23) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.TATAPARE." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.TATAPARE.001';
					//echo json_encode($d);
				}
			} else if ($var == 25) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.PROPMKS." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.PROPMKS.001';
					//echo json_encode($d);
				}
			} else if ($var == 26) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.TATAPALU." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.TATAPALU.001';
					//echo json_encode($d);
				}
			} else if ($var == 27) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGKENDARI." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGKENDARI.001';
					//echo json_encode($d);
				}
			} else if ($var == 28) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.OILMKS." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.OILMKS.001';
					//echo json_encode($d);
				}
			} else if ($var == 29) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGTRANS." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGTRANS.001';
					//echo json_encode($d);
				}
			} else if ($var == 30) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGPARE." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGPARE.001';
					//echo json_encode($d);
				}
			} else if ($var == 31) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOSAMARINDA." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOSAMARINDA.001';
					//echo json_encode($d);
				}
			} else if ($var == 32) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.PROPMPY." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.PROPMPY.001';
					//echo json_encode($d);
				}
			} else if ($var == 35) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGTOMOHON." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGTOMOHON.001';
					//echo json_encode($d);
				}
			} else if ($var == 36) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGPALOPO." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGPALOPO.001';
					//echo json_encode($d);
				}
			} else if ($var == 37) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGBONE." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGBONE.001';
					//echo json_encode($d);
				}
			} else if ($var == 38) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGKOLAKA." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGKOLAKA.001';
					//echo json_encode($d);
				}
			} else if ($var == 39) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGBAUBAU." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGBAUBAU.001';
					//echo json_encode($d);
				}
			} else if ($var == 41) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGBALI." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGBALI.001';
					//echo json_encode($d);
				}
			} else if ($var == 40) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.MAZDATRANS." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.MAZDATRANS.001';
					//echo json_encode($d);
				}
			} else if ($var == 42) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGGORONTALO." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGGORONTALO.001';
					//echo json_encode($d);
				}
			} else if ($var == 43) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.HINOBULUKUMBA." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.HINOBULUKUMBA.001';
					//echo json_encode($d);
				}
			} else if ($var == 44) {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.WULINGMAMUJU." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.WULINGMAMUJU.001';
					//echo json_encode($d);
				}
			} else {
				if ($last_kd > 0) {
					$no_akhir = $last_kd + 1;
					$kd = "IT.KMG.BELUM." . sprintf("%03s", $no_akhir);
					//echo json_encode($d);
				} else {
					$kd = 'IT.KMG.BELUM.001';
					//echo json_encode($d);
				}
			}

			return $kd;
		} else {
			redirect('login', 'refresh');
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if (!empty($cek) && $level == 'karyawan') {
			$id['id_hardware'] = $this->input->post('id_hardware');
			date_default_timezone_set('Asia/Makassar');
			$dt['id_hardware'] = $this->input->post('id_hardware');
			$dt['id_perusahaan'] 	= $this->session->userdata('sesi_id_perusahaan');
			$dt['nik'] 	= $this->input->post('nik');
			$dt['jenis_hardware'] 	= $this->input->post('jenis_hardware');
			$dt['noaset_hardware'] 	= $this->input->post('noaset_hardware');
			$dt['merk_hardware'] 	= $this->input->post('merk_hardware');
			$dt['type_hardware'] 	= $this->input->post('type_hardware');
			$dt['sn_hardware'] 	= $this->input->post('sn_hardware');
			$dt['harga_hardware'] 	= remove_separator($this->input->post('harga_hardware'));
			$dt['kondisi_hardware'] 	= $this->input->post('kondisi_hardware');
			$dt['tgl_hardware'] 			= tgl_sql($this->input->post('tgl_hardware'));
			$dt['status_hardware'] 	= $this->input->post('status_hardware');

			if ($this->model_hardware->ada($id)) {
				$dt['id_hardware'] 	= $this->input->post('id_hardware');
				$this->model_hardware->update($id, $dt);
				echo "Data Sukses diUpdate";
			} else {
				$dt['id_hardware'] 	= $this->model_hardware->cari_max_hardware();
				$this->model_hardware->insert($dt);
				echo "Data Sukses diSimpan";
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if (!empty($cek) && $level == 'karyawan') {
			$id['id_hardware']	= $this->input->get('cari');

			if ($this->model_hardware->ada($id)) {
				$dt = $this->model_hardware->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_hardware']	= $dt->id_hardware;
				$d['id_perusahaan']	= $dt->id_perusahaan;
				$d['nik']	= $dt->nik;
				$d['jenis_hardware'] 	= $dt->jenis_hardware;
				$d['noaset_hardware'] 	= $dt->noaset_hardware;
				$d['merk_hardware'] 	= $dt->merk_hardware;
				$d['type_hardware'] 	= $dt->type_hardware;
				$d['sn_hardware'] 	= $dt->sn_hardware;
				$d['harga_hardware'] 	= $dt->harga_hardware;
				$d['kondisi_hardware'] 	= $dt->kondisi_hardware;
				$d['tgl_hardware'] 			= tgl_sql($dt->tgl_hardware);
				$d['status_hardware'] 	= $dt->status_hardware;

				echo json_encode($d);
			} else {
				$d['id_hardware']	= '';
				$d['id_perusahaan']	= '';
				$d['nik']	= '';
				$d['jenis_hardware'] 	= '';
				$d['noaset_hardware'] 	= '';
				$d['merk_hardware'] 	= '';
				$d['type_hardware'] 	= '';
				$d['sn_hardware'] 	= '';
				$d['harga_hardware'] 	= '';
				$d['kondisi_hardware'] 	= '';
				$d['tgl_hardware'] 			= '';
				$d['status_hardware'] 	= '';
				echo json_encode($d);
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if (!empty($cek) && $level == 'karyawan') {
			$id['id_hardware']	= $this->uri->segment(3);

			if ($this->model_hardware->ada($id)) {
				$this->model_hardware->delete($id);
			}
			redirect('hd_adm_hardware/view_data', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
