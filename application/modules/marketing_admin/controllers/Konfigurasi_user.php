<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Konfigurasi_user extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_marketing');
	}

	public function index()
	{
		$index = "konfigurasi_user";
		if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
			$post = $this->input->post();
			if ($post) {
				if (!empty($post['simpan'])) $this->simpan($post);
				elseif (!empty($post['edit'])) $this->edit($post);
				elseif (!empty($post['hapus'])) $this->hapus($post);
				elseif (!empty($post['update'])) $this->update($post);
				elseif (!empty($post['load'])) $this->load($post);
			} else {
				$d['content'] = "pages/konfigurasi_user";
				$d['index'] = $index;
				$d['level'] = q_data("*", 'kumalagroup.p_level', [])->result();
				$d['hino'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 3])->result();
				$d['honda'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 17])->result();
				$d['mazda'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 4])->result();
				$d['mercedes'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 18])->result();
				$d['wuling'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 5])->result();
				$on = q_data("*", 'kumalagroup.users', ['status_aktif' => "on"])->result();
				foreach ($on as $v) {
					// $p = q_data("*", 'kmg.perusahaan', ['id_perusahaan' => $v->id_perusahaan])->row();
					// $arr['id'] = $v->id;
					// $arr['status_aktif'] = $v->status_aktif;
					// $arr['nik'] = $v->nik;
					// $arr['username'] = $v->username;
					// $arr['nama_level'] = q_data("*", 'kumalagroup.p_level', ['id' => $v->id_level])->row()->nama_level;
					// $arr['nama_lengkap'] = $v->nama_lengkap;
					// $arr['nama_jabatan'] = q_data("*", 'kmg.jabatan', ['id_jabatan' => $v->id_jabatan])->row()->nama_jabatan;
					// $arr['perusahaan'] = "$p->singkat-$p->lokasi";
					// $d['on'][] = $arr;
				}
				$arr = [];
				$off = q_data("*", 'kumalagroup.users', ['status_aktif' => "off"])->result();
				foreach ($off as $v) {
					// $p = q_data("*", 'kmg.perusahaan', ['id_perusahaan' => $v->id_perusahaan])->row();
					// $arr['id'] = $v->id;
					// $arr['status_aktif'] = $v->status_aktif;
					// $arr['nik'] = $v->nik;
					// $arr['username'] = $v->username;
					// $arr['nama_level'] = q_data("*", 'kumalagroup.p_level', ['id' => $v->id_level])->row()->nama_level;
					// $arr['nama_lengkap'] = $v->nama_lengkap;
					// $arr['nama_jabatan'] = q_data("*", 'kmg.jabatan', ['id_jabatan' => $v->id_jabatan])->row()->nama_jabatan;
					// $arr['perusahaan'] = "$p->singkat-$p->lokasi";
					// $d['off'][] = $arr;
				}
				$this->load->view('index', $d);
			}
		}
	}

	function simpan($post)
	{
		$status = 0;
		$where = $post['id'];
		$hash = password_hash($post['password'], PASSWORD_DEFAULT);
		$q_user = q_data("*", 'kumalagroup.users', ['nik' => $post['nik']]);
		if ($q_user->num_rows() == 0) {
			$q_kmg = q_data("*", 'kmg.karyawan', ['nik' => $post['nik'], 'status_aktif' => "Aktif"]);
			if ($q_kmg->num_rows() > 0) {
				$data['id_level'] = $post['level'];
				$data['id_perusahaan'] = $q_kmg->row()->id_perusahaan;
				$data['id_jabatan'] = $q_kmg->row()->id_jabatan;
				$data['coverage'] = $post['coverage'];
				$data['username'] = $post['nik'];
				$data['password'] = $hash;
				$data['nama_lengkap'] = $q_kmg->row()->nama_karyawan;
				$data['nik'] = $post['nik'];
				$data['status_aktif'] = "on";
				$data['tgl_insert'] = date('Y-m-d H:i:s');
				$data['tgl_update'] = date('Y-m-d H:i:s');
				$this->kumalagroup->insert("users", $data);
				$data = [];
				$data['id_user'] = $this->kumalagroup->insert_id();
				$data['akses_menu'] = $post['akses_menu'];
				$this->kumalagroup->insert("menu_akses", $data);
				$status = 1;
			}
		} elseif ($q_user->num_rows() > 0 && !empty($where)) {
			$data['id_level'] = $post['level'];
			if (!empty($post['password'])) $data['password'] = $hash;
			$data['coverage'] = $post['coverage'];
			$data['tgl_update'] = date('Y-m-d H:i:s');
			$this->kumalagroup->update("users", $data, ['id' => $where]);
			$data = [];
			$data['akses_menu'] = $post['akses_menu'];
			$this->kumalagroup->update("menu_akses", $data, ['id_user' => $where]);
			$status = 2;
		} else $status = 3;
		echo $status;
	}

	function update($post)
	{
		$where['id'] = $post['id'];
		$data['status_aktif'] = $post['status'];
		$data['tgl_update'] = date('Y-m-d H:i:s');
		$this->kumalagroup->update("users", $data, $where);
	}

	function edit($post)
	{
		$where = $post['id'];
		$q_user = q_data("*", 'kumalagroup.users', ['id' => $where])->row();
		$q_akses = q_data("*", 'kumalagroup.menu_akses', ['id_user' => $where])->row();
		$d['nik'] = $q_user->nik;
		$d['level'] = $q_user->id_level;
		$d['coverage'] = !empty($q_user->coverage) ? explode(",", $q_user->coverage) : null;
		$d['menu_akses'] = $q_akses->akses_menu;
		echo json_encode($d);
	}

	function hapus($post)
	{
		$where['id'] = $post['id'];
		$this->kumalagroup->delete('users', $where);
	}

	function load($post)
	{
		$akses = !empty($post) ? $post['akses'] : "";
		$menu_akses = !empty($akses) ? explode(",", $akses) : [] ?>
		<div class="row">
			<div class="col-md-4">
				<h6 class="card-title m-0">Manajemen Aplikasi</h6>
				<div id="m_a">
					<ul>
						<?php
						echo child_edit($menu_akses, "Beranda", "beranda", "");
						echo open_parent_head_edit("", "Manajemen Sistem");
						echo child_edit($menu_akses, "Konfigurasi User", "konfigurasi_user", "");
						echo child_edit($menu_akses, "User Profil", "user_profil", "");
						echo close_parent_head_edit();

						echo child_edit($menu_akses, "<strong>Dashboard (Header)</strong>", "dashboard", "");
						echo open_parent_head_edit("", "Wuling");
						echo child_edit($menu_akses, "Controlling Survei DO", "wuling_ctrl_survey_do", "");
						echo close_parent_head_edit();

						echo child_edit($menu_akses, "<strong>Manajemen Aplikasi (Header)</strong>", "manajemen_aplikasi", "");
						echo open_parent_head_edit("", "Pustaka");
						echo child_edit($menu_akses, "Brand", "brand", "");
						echo child_edit($menu_akses, "Model", "model", "");
						echo child_edit($menu_akses, "Tipe", "tipe", "");
						echo child_edit($menu_akses, "Warna", "warna", "");
						echo close_parent_head_edit();

						echo open_parent_head_edit("", "Website");
						echo child_edit($menu_akses, "Karir", "karir", "");
						echo child_edit($menu_akses, "Partner", "partner", "");
						echo child_edit($menu_akses, "Property", "property", "");
						echo close_parent_head_edit();

						echo open_parent_head_edit("", "Website & Apps");
						echo child_edit($menu_akses, "Berita", "berita", "");
						echo child_edit($menu_akses, "Dealer", "dealer", "");
						echo child_edit($menu_akses, "Otomotif", "otomotif", "");
						echo child_edit($menu_akses, "360 Fitur", "360Fitur", "");
						echo child_edit($menu_akses, "Slider", "slider", "");
						echo close_parent_head_edit();

						echo open_parent_head_edit("", "Apps");
						echo child_edit($menu_akses, "Acara", "acara", "");
						echo child_edit($menu_akses, "Sparepart", "sparepart", "");
						echo child_edit($menu_akses, "Voucher", "voucher", "");
						echo close_parent_head_edit();

						echo open_parent_head_edit("", "Virtual Fair");
						echo child_edit($menu_akses, "Dashboard", "dashboard_digifest", "");
						echo child_edit($menu_akses, "Customer", "list_user", "");
						echo child_edit($menu_akses, "Transaksi", "list_transaksi", "");
						echo child_edit($menu_akses, "Main Stage", "main_stage", "");
						echo child_edit($menu_akses, "Detail Unit", "detail_unit", "");
						echo child_edit($menu_akses, "Pengaturan", "pengaturan", "");
						echo close_parent_head_edit();

						echo open_parent_head_edit("", "Used Car");
						echo child_edit($menu_akses, "Inventori", "ucinventori", "");
						echo child_edit($menu_akses, "Blog & Promo", "ucblog", "");
						echo child_edit($menu_akses, "Slider", "ucslider", "");
						echo close_parent_head_edit();

						echo child_edit($menu_akses, "<strong>Admin (Header)</strong>", "admin", "");
						echo child_edit($menu_akses, "Bantuan", "bantuan", "");

						echo open_parent_head_edit("", "Layanan");
						echo child_edit($menu_akses, "Test Drive", "test_drive", "");
						echo child_edit($menu_akses, "Penawaran", "penawaran", "");
						echo close_parent_head_edit();

						echo child_edit($menu_akses, "Pelamar", "pelamar", "");

						echo open_parent_head_edit("", "Apps Admin");
						echo child_edit($menu_akses, "Booking Service", "booking_service", "");
						echo child_edit($menu_akses, "Home Service", "home_service", "");
						echo child_edit($menu_akses, "Saran", "saran", "");
						echo child_edit($menu_akses, "Tiket", "tiket", "");
						echo close_parent_head_edit();
						?>
					</ul>
				</div>
			</div>			
		</div>
<?php }
}
