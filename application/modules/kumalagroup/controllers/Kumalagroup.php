<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('m_marketing');
    }
    public function index()
    {
        $d['logo']    = $this->db->select('*')->get('kumalagroup.partners')->result();
        $d['version'] = $this->db->select('MAX(versi_update) as versi_update')->where('brand', 'KMG')->get('db_helpdesk.update_versi')->row();

        $this->load->view('login', $d);
    }

    public  function cek_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $this->form_validation->set_error_delimiters('<div style="color:rgb(255, 104, 104);margin-top: -6px;margin-bottom: 8px;">', '</div>');
        $this->form_validation->set_message('required', '*Enter %s');

        if ($this->form_validation->run() == false) {
            $this->load->view('login');
        } else {
            $data_username = addslashes($username);
            $data_password = md5(addslashes($password));
            $cek_username_password = $this->db->get_where('users', array('username' => $data_username, 'password' => $data_password));
            if ($cek_username_password->num_rows() > 0) {
                foreach ($cek_username_password->result() as $dt) {
                    $akses_data = array(
                        'logged_in'     => 'kumalagroup',
                        'username'      => $dt->username,
                        'id_perusahaan' => $dt->id_perusahaan,
                        'coverage'      => $dt->coverage,
                        'id_jabatan'    => $dt->id_jabatan,
                        'id_user'       => $dt->id_user,
                        'nama_lengkap'  => $dt->nama_lengkap,
                        'nik'           => $dt->nik,
                        'id_profil'     => $dt->id_profil,
                        'status'        => 'login',
                        'status_aktif'  => $dt->status_aktif,
                        'id_brand_view'  => $dt->id_brand_view,
                    );
                    $this->session->sess_expiration = '14400';
                    $this->session->set_userdata($akses_data);
                }
                header('location:' . base_url() . 'kumalagroup_home');
            } else {
                // debug();
                $this->session->set_flashdata('f_error', 'Invalid Username or Password');
                header('location:' . base_url() . 'kumalagroup');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect("kumalagroup", 'refresh');
    }
}
