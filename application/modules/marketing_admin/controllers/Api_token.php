<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_token extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        if ($this->m_marketing->auth_login('admin_it')) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/api_token";
                $d['index'] = '';
                $data = q_data("*", 'kumalagroup.api_token', [])->result();
                foreach ($data as $v) {
                    $arr['id'] = $v->id;
                    $arr['username'] = q_data("*", 'kumalagroup.users', ['id' => $v->username])->row()->username;
                    $arr['token'] = $v->token;
                    $d['data'][] = $arr;
                }
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['username'] = $post['username'];
        $u = q_data("*", 'kumalagroup.users', $where);
        if ($u->num_rows() > 0) {
            $q = q_data("*", 'kumalagroup.api_token', ['username' => $u->row()->id])->num_rows();
            if ($q == 0) {
                $data['username'] = $u->row()->id;
                $data['token'] = $this->acak_token();
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("api_token", $data);
                $status = 1;
            }
        } else $status = 2;
        echo $status;
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        $this->kumalagroup->delete('api_token', $where);
    }
    function acak_token()
    {
        $token = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $token = str_shuffle($token);
        return $token;
    }
}
