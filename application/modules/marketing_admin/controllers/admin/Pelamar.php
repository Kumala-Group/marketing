<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Pelamar extends CI_Controller
{

	public $img_server = "https://kumalagroup.id/";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_marketing');
	}

	public function index()
	{
		$index = "pelamar";
		if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
			$post = $this->input->post();
			if ($post) {
				if (!empty($post['hapus'])) $this->hapus($post);
			} else {
				$d['content'] = "pages/admin/pelamar";
				$d['index'] = $index;
				// $d['img_server'] = $this->m_marketing->img_server;
				// $d['data'] = q_data("*", 'kumk6797_kumalagroup.pelamars', [], "updated_at", false, false)->result();
				//function q_data($select, $table, $where, $order = false, $group = false, $limit = false)
				$this->load->view('index', $d);
			}
		}
	}

	public function get()
	{
	
		$datatable = new Datatable;
				
		//* query utama *//
		//id	email	nama	posisi	telepon	alamat	pendidikan	pengalaman	training	alasan	status	foto	cv	surat_lamaran	created_at	updated_at
		$datatable->query = $this->db
			->select("id, email, nama, posisi, telepon, alamat, pendidikan, foto, cv, surat_lamaran")
			->from('kumk6797_kumalagroup.pelamars');
		
		//* untuk filtering */		
		$datatable->setColumns(
			"email",
			"nama",
			"posisi",
			"telepon",
			"alamat",
			"pendidikan",
			"foto",
			"cv",
			"surat_lamaran"
		);

		//* untuk ordering by, kalo ndak dipake jangan dipanggil, komen saja
		$datatable->orderBy('created_at');

		//* output result datatable  
		//* sudah format datatable_serverside
		//* untuk langsung ke format json, gunakan getJson(); untuk langsung parsing ke view
		$raw = $datatable->get();	
		
		//* untuk customisasi array */
		//* datanya dibentuk ulang, terserah berapa field
		//* pastikan untuk menyesuaikan dengan filtering setColumn
        $recordsData = [];
        foreach ($raw['data'] as $key => $value) {   			 									
            $recordsData[] = [				
                'id'       		=> $value->id,
                'posisi'       	=> $value->posisi,
                'email'       	=> $value->email,
				'nama' 			=> $value->nama,
                'telepon'      	=> $value->telepon,
                'alamat'      	=> $value->alamat,
                'pendidikan'    => $value->pendidikan,
                'foto'      	=> $this->img_server.'assets/img_marketing/pelamar/'.$value->foto,
                'surat_lamaran' => $this->img_server.'assets/img_marketing/pelamar/'.$value->surat_lamaran,            
                'cv' 			=> $this->img_server.'assets/img_marketing/pelamar/'.$value->cv,            
            ];
        }
		
        //* buat ulang response datatable_serverside
        $response = [
            'draw'            => $raw['draw'],
            'recordsTotal'    => $raw['recordsTotal'],
            'recordsFiltered' => $raw['recordsFiltered'],
            'data'            => $recordsData
        ];
        return responseJson($response);	
		// return $response;

	}

	public function simpan()
	{
		if ($this->m_marketing->auth_api()) {
			$post = $this->input->post();
			if (!$post) $this->m_marketing->error404();
			else {
				$data['posisi'] = $post['posisi'];
				$data['nama'] = $post['nama'];
				$data['alamat'] = $post['alamat'];
				$data['email'] = $post['email'];
				$data['telepon'] = $post['telepon'];
				// $data['pendidikan'] = $post['pendidikan'];
				// $data['pengalaman'] = $post['pengalaman'];
				// $data['training'] = $post['training'];
				$data['alasan'] = $post['alasan'];
				$data['foto'] = $post['foto'];
				$data['cv'] = $post['cv'];
				$data['surat_lamaran'] = $post['surat_lamaran'];
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['updated_at'] = date('Y-m-d H:i:s');
				$this->kumalagroup->insert("pelamars", $data);
				echo 1;

				//notifikasi
				$data = [];
				$data['judul'] = "Pelamar";
				$data['deskripsi'] = $post['nama'] . " - " . $post['email'] . " - " . $post['telepon'];
				$data['status'] = 0;
				$data['link'] = "admin/pelamar";
				$data['created_at'] = date('Y-m-d H:i:s');
				$this->kumalagroup->insert("notification", $data);
			}
		}
	}

	function hapus($post)
	{
		$where['id'] = $post['id'];
		$d = q_data("*", 'kumk6797_kumalagroup.pelamars', $where)->row();
		$data_post['path'] = "./assets/img_marketing/pelamar/";
		$data_post['name'] = $d->foto;
		curl_post($this->m_marketing->img_server . "delete_img", $data_post);
		$data_post['name'] = $d->cv;
		curl_post($this->m_marketing->img_server . "delete_img", $data_post);
		$data_post['name'] = $d->surat_lamaran;
		curl_post($this->m_marketing->img_server . "delete_img", $data_post);
		$this->kumalagroup->delete('pelamars', $where);
	}
}
