<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_update_kmg extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_update_versi');
    }

    public function index()
    {
        $cek = $this->session->userdata('logged_in');
        $level = $this->session->userdata('level');
        if (!empty($cek) && $level == 'karyawan') {
            $brand = $this->db->query("SELECT nama_brand FROM kmg.brand WHERE id_brand ='11'")->row()->nama_brand;
            $d['judul'] = " DMS UPDATE VERSI " . $brand;
            $d['class'] = "dms update";
            $d['data'] = $this->model_update_versi->all($brand);
            $d['content'] = 'dms_update/kmg/view';
            $this->load->view('hd_adm_home', $d);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function create_kd()
    {
        $cek     = $this->session->userdata('logged_in');
        $level     = $this->session->userdata('level');
        if (!empty($cek) && $level == 'karyawan') {

            $last_kd = $this->model_update_versi->last_kode();

            if ($last_kd > 0) {
                $kd = $last_kd + 1;
            } else {
                $kd = '1';
            }
            return $kd;
        } else {
            redirect('login', 'refresh');
        }
    }

    public function simpan()
    {
        $cek     = $this->session->userdata('logged_in');
        $level     = $this->session->userdata('level');
        if (!empty($cek) && $level == 'karyawan') {
            $brand = $this->db->query("SELECT nama_brand FROM kmg.brand WHERE id_brand ='11'")->row()->nama_brand;
            $id_versi = $this->create_kd();
            $double_detail_input = $this->input->post('detail_versi_double');
            $tgl_update = tgl_sql($this->input->post('tgl_update'));
            $versi_update = $this->input->post('update_versi');
            $total = count($double_detail_input);
            for ($i = 0; $i < $total; $i++) {
                $this->db_helpdesk->query("INSERT INTO update_versi_detail (id_versi, detail_versi, no_urut) VALUES ('$id_versi','$double_detail_input[$i]', '$i')");
            }
            $this->db_helpdesk->query("INSERT INTO update_versi (id_versi, tgl_update, versi_update, brand) VALUES ('$id_versi', '$tgl_update', '$versi_update','$brand')");
            echo "Berhasil simpan data.";
        } else {
            redirect('login', 'refresh');
        }
    }

    public function simpan_detail_update()
    {
        $cek = $this->session->userdata('logged_in');
        $level = $this->session->userdata('level');
        if (!empty($cek) && $level == 'karyawan') {
            $id['id'] = $this->input->post('id'); // ID UPDATE VERSI DETAIL
            $id_v = $this->input->post('id');
            $id_versi = $this->input->post('id_versi'); // ID UPDATE VERSI
            $id_ver['id_versi'] = $this->input->post('id_versi'); // ID UPDATE VERSI
            $iv['tgl_update'] = tgl_sql($this->input->post('tgl_update_edit'));
            $iv['versi_update'] = $this->input->post('update_versi_edit');
            $dv_id['detail_versi'] = $this->input->post('detail_versi' . $id_v); // ID detail update versi for detail update
            $detail_versi_add = $this->input->post('tambah_detail'); // id detail for simpan baru detail#

            if (!empty($detail_versi_add)) {
                $last_kd = $this->model_update_versi->last_kode_no_urut($id_versi);
                if ($last_kd >= 0) {
                    $kd = $last_kd + 1;
                    $count = count($detail_versi_add);
                    for ($i = 0; $i < $count; $i++) {
                        $angka = $kd++;
                        $this->db_helpdesk->query("INSERT INTO update_versi_detail (id_versi, detail_versi, no_urut) VALUES ('$id_versi','$detail_versi_add[$i]', '$angka')");
                    }
                    $this->model_update_versi->update_versi($iv, $id_ver);
                    $this->model_update_versi->update_versi_detail($id, $dv_id);
                    echo "Berhasil update dan tambah data.";
                } else {
                    $kd = '0';
                    $count = count($detail_versi_add);
                    for ($i = 0; $i < $count; $i++) {
                        $angka = $kd++;
                        $this->db_helpdesk->query("INSERT INTO update_versi_detail (id_versi, detail_versi, no_urut) VALUES ('$id_versi','$detail_versi_add[$i]', '$angka')");
                    }
                    echo "Berhasil tambah data.";
                }
            } else {
                $this->model_update_versi->update_versi($iv, $id_ver);
                $this->model_update_versi->update_versi_detail($id, $dv_id);
                echo "Berhasil update data.";
            }

            // KBC KSS
        }
    }

    public function hapus_data()
    {
        $cek = $this->session->userdata('logged_in');
        $level = $this->session->userdata('level');
        if (!empty($cek) && $level == 'karyawan') {
            $id['id'] = $this->input->post('id');
            $id_versi = $this->input->post('id_versi');
            $data = $this->db_helpdesk->query("SELECT * FROM update_versi_detail WHERE id_versi ='$id_versi'");
            $rows = $data->num_rows();

            if ($rows == 1) {
                $this->db_helpdesk->query("DELETE FROM update_versi WHERE id_versi ='$id_versi'");
                $this->model_update_versi->hapus_versi_update($id);
            } else {
                $this->model_update_versi->hapus_versi_update($id);
            }
        } else {
            redirect('login', 'refresh');
        }
    }

    public function delete_update()
    {
        $id_versi = $this->input->post('id_versi');
        $no_urut = $this->input->post('no_urut');

        $no_urut_min = $this->db_helpdesk->query("SELECT MIN(no_urut)as no_urut_min FROM update_versi_detail WHERE id_versi = '$id_versi'")->row()->no_urut_min;

        $data = $this->db_helpdesk->query("SELECT * FROM update_versi_detail WHERE id_versi = '$id_versi'");
        $rows = $data->num_rows();

        for ($i = $no_urut_min; $i < $rows; $i++) {
            foreach ($data->result() as $dt) {
                echo $dt->id_versi;
                // $this->db_helpdesk->query("UPDATE update_versi_detail SET no_urut = '$i' WHERE id_versi = '$dt->id_versi'");
            }
            // $this->db_helpdesk->query("UPDATE update_versi_detail SET no_urut = '$i' WHERE id_versi = '$dt->id_versi[$i]'");
            // echo $i;
        }




        // $jumlah = ($no_urut - 1);



        // var_dump($id_versi);
        echo "Berhasil menghapus data.";
    }



    public function cari_data()
    {
        error_reporting(0);
        $id = $this->input->get('id'); # ID tabel update_versi_detail
        $id_versi['id_versi'] = $this->input->get('id_versi'); # iID update versi
        $id_versi_detail = $this->input->get('id_versi');

        $q = $this->db_helpdesk->get_where("update_versi", $id_versi);
        $row = $q->num_rows();
        if ($row > 0) {
            $dt = $this->model_update_versi->get_all_data($id_versi_detail);
            $d['tgl_update'] = tgl_sql($dt->tgl_update);
            $d['versi_update'] = $dt->versi_update;
            $data = $this->db_helpdesk->query("SELECT detail_versi, id, no_urut FROM update_versi_detail WHERE id_versi ='$id_versi_detail' AND id ='$id'");
            $output = '';
            foreach ($data->result() as $dd) {
                $output .= '<div class="controls" style="padding-top:5px;">';
                $output .= '<input type="text" name="detail_versi' . $dd->id . '" id="detail_versi' . $dd->id . '" placeholder="Detail update" value="' . $dd->detail_versi . '"/>';
                $output .= '<a role="button" name="hapus_data" class="btn btn-small btn-danger hapus_data" style="margin-left:3px;" onclick="javascript:hapus_data(' . $id . ',' . $id_versi_detail . ')"><center><i class="icon-remove icon-large"></i></center></a>';
                $output .= '</div>';
            }
            $no_urut = $data->row()->no_urut;
            $d['detail_versi'] = $output;
            $d['id'] = $id;
            $d['id_versi'] = $id_versi_detail;
            $d['no_urut'] = $no_urut;
            echo json_encode($d);
        } else {
            $d['tgl_update'] = '';
            $d['versi_update'] = '';
            $d['detail_versi'] = '';
            $d['id'] = '';
            $d['id_versi'] = '';
            $d['no_urut'] = '';
            echo json_encode($d);
        }
    }
}
