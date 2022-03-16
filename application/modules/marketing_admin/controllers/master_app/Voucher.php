<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Voucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "voucher";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/master_app/voucher";
                $d['index'] = $index;
                $d['data'] = q_data("*", 'kumk6797_kumalagroup.vouchers', [], "updated_at")->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['judul'] = $post['judul'];
        $data['deskripsi'] = $post['deskripsi'];
        $data['tanggal_berlaku'] = tgl_sql($post['tanggal']);
        $q_level = q_data("*", 'kumk6797_kumalagroup.vouchers', $where);
        if ($q_level->num_rows() == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("vouchers", $data);
            $status = 1;
        } elseif ($q_level->num_rows() > 0 && !empty($where)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("vouchers", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumk6797_kumalagroup.vouchers', $where)->row();
        $d['judul'] = $data->judul;
        $d['deskripsi'] = $data->deskripsi;
        $d['tanggal'] = tgl_sql($data->tanggal_berlaku);
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $this->kumalagroup->delete('vouchers', $where);
    }
}
