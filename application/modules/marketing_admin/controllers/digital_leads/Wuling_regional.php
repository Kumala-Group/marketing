<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// wuling_digital_leads_customer

class Wuling_regional extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_digital_leads');
        $this->load->helper('string');
    }

    // fungsi default
    public function index()
    {
        $index = 'wuling_regional';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d = [
                'judul'    => "Data Regional Wuling",
                'content'  => "pages/digital_leads/wuling_regional",
                'index'    => $index,
            ];
            $this->load->view('index', $d);
        }
    }

    // untuk simpan regional
    public function simpan_regional()
    {
        $id         = $this->input->post('inp_id');
        $v_regional = $this->input->post('nama_regional');
        $regional   = strip_quotes($v_regional);        

        $nama_cabang = $this->input->post('pilih_cabang');
        if ($id == '') {
            $cek = $this->db_wuling->get_where("regional", "id_perusahaan = '$nama_cabang[0]'");
            $rows = $cek->num_rows();
            if ($rows > 0) {
                $id_pe['id_perusahaan'] = $nama_cabang[0];
                $perusahaan = $this->db->select('lokasi')->get_where('perusahaan', $id_pe)->row()->lokasi;
                echo "Nama cabang " . $perusahaan . " sudah ada di regional lain.";
            } else {
                $count = count($nama_cabang);
                for ($i = 0; $i < $count; $i++) {
                    $insert = array(
                        'id' => '',
                        'regional' => $regional,
                        'id_perusahaan' => $nama_cabang[$i]
                    );
                    $this->db_wuling->insert("regional", $insert);
                }
                echo "Sukses simpan data.";
            }
        } else {
            $cek = $this->db_wuling->get_where("regional", "id_perusahaan = '$nama_cabang[0]'");
            $rows = $cek->num_rows();
            if ($rows > 0) {
                $id_pe['id_perusahaan'] = $nama_cabang[0];
                $perusahaan = $this->db->select('lokasi')->get_where('perusahaan', $id_pe)->row()->lokasi;
                echo "Nama cabang " . $perusahaan . " sudah ada di regional lain.";
            } else {
                $count = count($nama_cabang);
                if ($count == 1) {
                    $id_up['id'] = $id;
                    $update = array(
                        'regional' => $regional,
                        'id_perusahaan' => $nama_cabang[0]
                    );
                    $this->db_wuling->update("regional", $update, $id_up);
                    echo "Sukses update data.";
                } else {
                    for ($i = 0; $i < $count; $i++) {
                        $insert = array(
                            'id' => '',
                            'regional' => $regional,
                            'id_perusahaan' => $nama_cabang[$i]
                        );
                        $this->db_wuling->insert("regional", $insert);
                    }
                    echo "Sukses update data.";
                }
            }
        }
    }

    // untuk cek data regional
    public function cek_regional()
    {
        $id['id'] = $this->input->get('id');
        $data = $this->db_wuling->get_where("regional", $id);
        $row = $data->num_rows();
        if ($row > 0) {
            $dt = $data->row();
            $d = array(
                'id' => $dt->id,
                'regional' => $dt->regional,
                'id_perusahaan' => $dt->id_perusahaan
            );
        } else {
            $d = array(
                'id' => '',
                'regional' => '',
                'id_perusahaan' => ''
            );
        }
        echo json_encode($d);
    }

    // untuk hapus regional
    public function hapus_regional()
    {
        $id['id'] = $this->input->post('id');
        $data = $this->db_wuling->get_where('regional', $id)->num_rows();
        if ($data > 0) {
            $this->db_wuling->delete('regional', $id);
            echo "Sukses hapus data.";
        } else {
            echo "Gagal hapus data, Hubungi tim IT.";
        }
    }
}
