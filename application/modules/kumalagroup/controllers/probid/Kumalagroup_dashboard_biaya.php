<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_dashboard_biaya extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_probid_dashboard');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }


    public function index()
    {
        $d['content']   = 'probid/dashboard_biaya';
        $d['cabang'] = $this->model_probid_dashboard->cabang();
        $d['jenis_biaya'] = $this->model_probid_dashboard->jenis_biaya();
        $this->load->view('home', $d);
    }

    public function json_chart_get_data()
    {
        $id_perusahaan = $this->input->get('cabang');
        $kategori_biaya = $this->input->get('jenis_biaya');
        $tahun = $this->input->get('tahun');
        $type = $this->input->get('detail_biaya');
        echo $this->model_probid_dashboard->get_data_internal($id_perusahaan, $kategori_biaya, $tahun, $type);
    }

    public function detail_biaya()
    {

        echo json_encode($this->model_probid_dashboard->detail_biaya());
    }
}
