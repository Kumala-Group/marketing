<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_marketing');
	}

	public function index()
	{
		if ($this->m_marketing->auth_login('admin_it,adm_mrktng')) {
			$post = $this->input->post();
			if ($post) {
				if (!empty($post['hapus'])) $this->hapus($post);
				elseif (!empty($post['update'])) $this->update($post);
				elseif (!empty($post['load'])) $this->load();
			} else {
				$d['content'] = "component/notifikasi";
				$d['index'] = "";
				$d['read'] = q_data("*", 'kumk6797_kumalagroup.notification', ['status' => 1], "created_at")->result();
				$d['unread'] = q_data("*", 'kumk6797_kumalagroup.notification', ['status' => 0], "created_at")->result();
				$this->load->view('index', $d);
			}
		}
	}

	function hapus($post)
	{
		$where['id'] = $post['id'];
		$this->kumalagroup->delete('notification', $where);
	}

	function update($post)
	{
		$where['id'] = $post['id'];
		$data['status'] = 1;
		$q = q_data("*", 'kumk6797_kumalagroup.notification', $where)->row()->status;
		if ($q == 0) $this->kumalagroup->update('notification', $data, $where);
	}

	function read_all()
	{
		//$q = q_data("*", 'kumk6797_kumalagroup.notification', $where)->row()->status;
		$this->kumalagroup->update('notification', ['status'=>1], ['status'=>0]);
		redirect(base_url().'notifikasi');
	}

	function load()
	{
		$data = q_data("*", 'kumk6797_kumalagroup.notification', [], "created_at")->result();
		foreach ($data as $v) {
			$arr['id'] = $v->id;
			$arr['kategori'] = $v->judul;
			$arr['deskripsi'] = strlen($v->deskripsi) > 80 ? substr($v->deskripsi, 0, 80) . "..." : $v->deskripsi . ".";
			$arr['status'] = $v->status;
			$arr['link'] = $v->link;
			$date = new DateTime($v->created_at);
			$now = new DateTime(date('Y-m-d H:i:s'));
			$diff = $date->diff($now);
			if ($diff->format('%h') == 0 && $diff->format('%i') < 60) $arr['time'] = $diff->format('%i') . " menit yang lalu";
			elseif ($diff->format('%d') == 0 && $diff->format('%h') > 0) $arr['time'] = $diff->format('%h') . " jam yang lalu";
			elseif (floor($diff->days / 7) == 0 && $diff->format('%d') > 0) $arr['time'] = $diff->format('%d') . " hari yang lalu";
			elseif (floor($diff->days / 7) > 0) $arr['time'] = floor($diff->days / 7) . " minggu yang lalu";
			$d['notifikasi'][] = $arr;
		}
		$d['count'] = q_data("*", 'kumk6797_kumalagroup.notification', ['status' => 0])->num_rows();
		echo json_encode($d);
	}
}
