<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_marketing extends CI_Model
{
    //public $img_server = "https://kumalagroup.id/";
    public $img_server = "http://kumalagroup.local.dev/";

    //autentikasi
    public function auth_login($data, $index = false)
    {
        // if ($this->input->get()) $this->error404();
        // else {
        if ($this->session->userdata('logged_in') == "marketing_admin") {
            $level = explode(",", $data);
            foreach ($level as $i => $v) {
                $q_level = q_data("*", 'kumk6797_kumalagroup.p_level', ['level' => $v])->row();
                $id[]    = (!empty($q_level)) ? $q_level->id : 0;
            }
            if (in_array($this->session->userdata('level'), $id)) $breakout = false;
            else $breakout = true;
            if ($index) {
                $q_akses = q_data("*", 'kumk6797_kumalagroup.menu_akses', ['id_user' => $this->session->userdata('id_user')])->row();
                if (in_array($this->session->userdata('level'), $id) && in_array($index, explode(",", $q_akses->akses_menu))) $breakout = false;
                else $breakout = true;
            }
            if ($breakout) $this->error404();
            else return true;
        } else redirect("marketing", 'refresh');
        // }
    }

    public function auth_api()
    {
        if ($this->input->get()) $this->error404();
        else {
            $where['token'] = $this->uri->segment(2);
            if (q_data("*", 'kumk6797_kumalagroup.api_token', $where)->num_rows() > 0) return true;
            else $this->error404();
        }
    }

    public function error404()
    {
        $this->output->set_status_header('404');
        $this->load->view('kmg404');
    }

    public function generate_kode($length = null)
    {
        $token = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $token = substr(str_shuffle($token), 0, $length ?? 10);
        return $token;
    }
}
