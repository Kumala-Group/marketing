<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Booking_service extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_service');
    }

    public function index()
    {
        $index = "booking_service";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['hapus'])) $this->hapus($post);
            } else {
                $d['content'] = "pages/admin/booking_service";
                $d['index'] = $index;
                $data = q_data("*", 'kumk6797_kumalagroup.booking_service', [], "updated_at")->result();
                foreach ($data as $v) {
                    $perusahaan = q_data("*", 'kmg.perusahaan', ['id_perusahaan' => $v->id_perusahaan])->row();
                    
                    $d['id'][]              = $v->id;
                    $d['tanggal_service'][] = $v->tanggal_service;
                    $d['_dealer'][]         = $perusahaan->lokasi .' - '. $perusahaan->kode_perusahaan;
                    $d['no_polisi'][]       = $v->no_polisi;
                    $d['nama'][]            = $v->nama;
                    $d['telepon'][]         = $v->telepon1;
                    $d['alamat'][]          = $v->alamat;
                    $d['jam_service'][]     = $v->jam_service;
                    $d['jenis_service'][]   = $v->jenis_service;
                    $d['keterangan'][]      = $v->keterangan;
                    $d['status'][]          = $v->status;
                }
                $this->load->view('index', $d);
            }
        }
    }

    public function simpan()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {

                $data = [
                    'brand'           => $post['idBrand'],
                    'kota'            => $post['kota'],
                    'id_perusahaan'   => $post['idPerusahaan'],
                    'no_polisi'       => $post['noPolisi'],
                    'no_rangka'       => $post['noRangka'],
                    'nama'            => $post['nama'],
                    'telepon1'        => $post['telepon1'],
                    'telepon2'        => $post['telepon2'],
                    'alamat'          => $post['alamat'],
                    'tanggal_service' => $post['tanggalService'],
                    'jam_service'     => $post['jamService'],
                    'jenis_service'   => $post['jenisService'],
                    'keterangan'      => $post['keterangan'],
                    'created_at'      => date('Y-m-d H:i:s'),
                    'updated_at'      => date('Y-m-d H:i:s'),
                ];

                $ins  = $this->kumalagroup->insert("booking_service", $data);

                // if ($post['idBrand'] == 3) {
                //     $id_customer = GenerateCode('db_hino_as', 'customer', 'id_customer', 'CS-');
                //     $id_booking  = GenerateCode('db_hino_as', 'booking_service', 'kode_booking', 'BS-' . $post['idPerusahaan'] . '-');

                //     $data_customer = [

                //     ];

                //     $data_booking = [

                //     ];

                //     $ins1 = $this->m_service->insert_data('db_hino_as', "customer", $data_customer);
                //     $ins2 = $this->m_service->insert_data('db_hino_as', "booking_service", $data_booking);
                // } else if ($post['idBrand'] == 5) {
                //     $id_customer = GenerateCode('db_wuling_as', 'customer', 'id_customer', 'CS-');
                //     $id_booking  = GenerateCode('db_wuling_as', 'booking_service', 'kode_booking', 'BS-' . $post['idPerusahaan'] . '-');

                //     $data_customer = [

                //     ];

                //     $data_booking = [

                //     ];

                //     $ins1 = $this->m_service->insert_data('db_wuling_as', "customer", $data_customer);
                //     $ins2 = $this->m_service->insert_data('db_wuling_as', "booking_service", $data_booking);
                // } else if ($post['idBrand'] == 17) {
                //     $id_customer = GenerateCode('db_honda_as', 'customer', 'id_customer', 'CS-');
                //     $id_booking  = GenerateCode('db_honda_as', 'booking_service', 'kode_booking', 'BS-' . $post['idPerusahaan'] . '-');
                    
                //     $data_customer = [
                //         'id_group_customer' => '0',
                //         'id_customer'       => $id_customer,
                //         'ktp'               => '-',
                //         'no_rangka'         => $post['noRangka'],
                //         'id_region'         => '-',
                //         'id_perusahaan'     => $post['idPerusahaan'],
                //         'nama'              => $post['nama'],
                //         'alamat'            => '-',
                //         'kota'              => '-',
                //         'telepon'           => $post['telepon1'],
                //         'ttl'               => '-',
                //         'id_agama'          => '-',
                //         'email'             => '-',
                //         'keterangan_cus'    => '-',
                //     ];

                //     $data_booking = [
                //         'kode_booking'  => $id_booking,
                //         'no_polisi'     => $post['noPolisi'],
                //         'kode_unit'     => $post['kodeUnit'],
                //         'nama'          => $post['nama'],
                //         'id_customer'   => $id_customer,
                //         'no_rangka'     => $post['noRangka'],
                //         'telepon'       => $post['telepon1'],
                //         'telepon1'      => $post['telepon2'],
                //         'tanggal'       => $post['tanggalService'],
                //         'waktu'         => $post['jamService'],
                //         'keterangan'    => $post['keterangan'],
                //         'jenis_service' => $post['jenisService'],
                //         'id_perusahaan' => $post['idPerusahaan'],
                //         'confirm'       => 'n',
                //     ];

                //     $data_unit = [
                //         'no_rangka'         => $post['noRangka'],
                //         'id_perusahaan'     => $post['idPerusahaan'],
                //         'id_customer'       => $id_customer,
                //         'ktp'               => '-',
                //         'nama_stnk'         => '-',
                //         'alamat_stnk'       => '-',
                //         'telepon_stnk'      => '-',
                //         'no_mesin'          => '-',
                //         'kode_unit'         => $post['kodeUnit'],
                //         'no_polisi'         => $post['noPolisi'],
                //         'tahun'             => '-',
                //         'tgl_deliv'         => '-',
                //         'km_deliv'          => '-',
                //         'tgl_awal_garansi'  => '-',
                //         'tgl_akhir_garansi' => '-',
                //         'km_akhir_garansi'  => '-',
                //         'kumala'            => '-',
                //     ];

                //     $ins1 = $this->m_service->insert_data("db_honda_as", "customer", $data_customer);
                //     $ins2 = $this->m_service->insert_data("db_honda_as", "booking_service", $data_booking);
                //     $ins3 = $this->m_service->insert_data("db_honda_as", "detail_unit_customer", $data_unit);
                // } else if ($post['idBrand'] == 18) {
                //     $id_customer = GenerateCode('db_mercedes_as', 'customer', 'id_customer', 'CS-');
                //     $id_booking  = GenerateCode('db_mercedes_as', 'booking_service', 'kode_booking', 'BS-' . $post['idPerusahaan'] . '-');

                //     $data_customer = [
                        
                //     ];

                //     $data_booking = [

                //     ];

                //     $ins1 = $this->m_service->insert_data("db_mercedes_as", "customer", $data_customer);
                //     $ins2 = $this->m_service->insert_data("db_mercedes_as", "booking_service", $data_booking);
                // }

                if ($ins) {
                    $d['result']  = "Success";
                    $d['message'] = "Selamat, Anda telah melakukan booking service!";
                } else {
                    $d['result']  = "Error";
                    $d['message'] = "Maaf, Permintaan Anda tidak dapat diproses!";
                }
                echo json_encode($d);

                // notifikasi
                $data = [];
                $data['judul']      = "Booking Service";
                $data['deskripsi']  = $post['nama'] . " - " . $post['telepon1'] . " - " . $post['alamat'];
                $data['status']     = 0;
                $data['link']       = "admin/booking_service";
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("notification", $data);
            }
        }
    }

    // untuk ubah status
    public function ubah_status()
    {
        $input = $this->input->post();

        $this->kumalagroup->trans_start();
        $this->kumalagroup->where('id', $input['id']);
        $this->kumalagroup->update('booking_service', array('status' => $input['val']));
        $this->kumalagroup->trans_complete();

        if ($this->kumalagroup->trans_status() === TRUE) {
            $reponse = ['status' => true, 'message' => 'Status berhasil diubah!'];
        } else {
            $reponse = ['status' => false, 'message' => 'Status gagal diubah!'];
        }

        echo json_encode($reponse);
    }

    function hapus($post)
    {
        $where['id'] = $post['id'];
        $this->kumalagroup->delete('booking_service', $where);
    }
}
