<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_dl_followup extends CI_Controller
{
    private $list_followup = [
        ['', 'id_followup', 'hidden'],
        ['', 'id_dl_customer', 'hidden'],
        ['Tanggal', 'tgl_fu', 'date'],
        ['Status Customer', 'id_status_customer', 'select'],
        ['Status Follow Up', 'id_status_fu', 'select'],
        ['Keterangan', 'id_keterangan_fu', 'select']
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_dl_customer');
        $this->load->model('m_wuling_dl_followup');
    }

    public function datetime_sekarang()
    {
        $date = new \DateTime(date('Y-m-d H:i:s'));
        $date->setTimezone(new \DateTimeZone('Asia/Makassar'));
        return $date->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $d['brand'] = "wuling";
            $d['judul'] = "Daftar Follow Up Customer";
            $d['content'] = "pages/digital_leads_wuling/wuling_dl_followup";
            $d['list_followup'] = $this->list_followup;
            $d['is_sales_digital'] = $this->session->userdata('id_jabatan') == 171;
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function edit_customer($id)
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $d['judul'] = "Data Follow Up Customer";
            $d['content'] = "pages/digital_leads_wuling/follow_up/edit_customer";
            $d['list_followup'] = $this->list_followup;
            $d['customer'] = $this->db_wuling->get_where('digital_leads_customer', ['id_dl_customer' => $id])->result();
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function data_masuk()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
            $limit = $_POST['length']; // Ambil data limit per page
            $start = $_POST['start']; // Ambil data start
            $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
            $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
            $sql_total = $this->m_wuling_dl_followup->count_all(); // Panggil fungsi count_all pada m_wuling_dl_followup
            $sql_data = $this->m_wuling_dl_followup->filter($search, $limit, $start, $order_field, $order_ascdesc); // Panggil fungsi filter pada m_wuling_dl_followup
            $sql_filter = $this->m_wuling_dl_followup->count_filter($search); // Panggil fungsi count_filter pada m_wuling_dl_followup
            $callback = array(
                'draw' => $_POST['draw'], // Ini dari datatablenya
                'recordsTotal' => $sql_total,
                'recordsFiltered' => $sql_filter,
                'data' => $sql_data
            );
            header('Content-Type: application/json');
            echo json_encode($callback); // Convert array $callback ke json
        }
    }

    public function data_followup($id)
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $this->m_wuling_dl_followup->data_followup($id);
        }
    }

    public function get_customer()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $id = $this->input->post('id');
            $data = $this->m_wuling_dl_customer->get_data_customer($id);
            echo json_encode($data);
        }
    }

    public function _cari_status_customer_terakhir($id_customer)
    {
        return $this->db_wuling->query(
            "SELECT
                MAX(digital_leads_followup.id_status_customer) as id_status_customer
            FROM
                digital_leads_followup
            WHERE
                digital_leads_followup.id_dl_customer = $id_customer
        "
        )->result()[0]->id_status_customer;
    }

    public function _cari_id_followup_terakhir($id_customer)
    {
        return $this->db_wuling->query(
            "SELECT MAX(digital_leads_followup.id_followup) as id_followup
            FROM digital_leads_followup WHERE digital_leads_followup.id_dl_customer = $id_customer"
        )->result()[0]->id_followup;
    }

    public function _data_cabang_customer($id_customer)
    {
        return $this->db_wuling->query(
            "SELECT id_perusahaan, id_sales_force FROM digital_leads_customer
            WHERE digital_leads_customer.id_dl_customer = $id_customer"
        )->result()[0];
    }

    public function simpan_customer()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $data = [];
            foreach ($this->list_followup as $kolom) {
                $data[$kolom[1]] = $this->input->post($kolom[1]);
            }

            if (empty($data['id_followup'])) {
                $data['w_insert'] = $this->datetime_sekarang();
                $data['w_update'] = $this->datetime_sekarang();
            } else {
                $data['w_update'] = $this->datetime_sekarang();
            }

            $data['id_perusahaan']  = $this->_data_cabang_customer($data['id_dl_customer'])->id_perusahaan;
            $data['id_sales_force'] = $this->_data_cabang_customer($data['id_dl_customer'])->id_sales_force;

            $this->m_wuling_dl_followup->simpan_status_fu_cutomer($data);
            $status = [
                'id_dl_customer' => $data['id_dl_customer'],
                'id_status_customer' => $this->_cari_status_customer_terakhir($data['id_dl_customer']),
                'w_update' => $this->datetime_sekarang()
            ];
            $this->m_wuling_dl_customer->simpan_data_customer($status);
            echo 'Data Sukses diUpdate';
        }
    }

    public function simpan_cabang_customer()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $cabang                 = $this->input->post('dealer');
            $data['dealer']         = $this->db->query(
                "SELECT lokasi FROM perusahaan WHERE id_perusahaan='$cabang' 
                AND id_brand='5' AND kode_perusahaan NOT IN ('0','HO')"
            )->result_array()[0]['lokasi'];
            $data['id_dl_customer'] = $this->input->post('id_customer');
            $data['id_perusahaan']  = $cabang;
            $data['id_sales_force'] = $this->input->post('sales_force');

            $data_fu['id_followup']    = $this->_cari_id_followup_terakhir($data['id_dl_customer']);
            $data_fu['id_perusahaan']  = $data['id_perusahaan'];
            $data_fu['id_sales_force'] = $data['id_sales_force'];
            $data_fu['w_update']       = $this->datetime_sekarang();

            $update_cabang_customer  = $this->db_wuling->update(
                "digital_leads_customer",
                $data,
                ['id_dl_customer' => $data['id_dl_customer']]
            );
            $update_data_fu_terakhir = $this->db_wuling->update(
                "digital_leads_followup",
                $data_fu,
                ['id_followup' => $data_fu['id_followup']]
            );

            if ($update_data_fu_terakhir && $update_cabang_customer) {
                echo 'Data Sukses diUpdate';
            } else {
                echo 'Ada masalah dalam menyimpan data';
            }
        }
    }

    public function get_detail_fu()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $id = $this->input->post('id');
            echo json_encode($this->db_wuling->get_where(
                'digital_leads_followup',
                ['id_followup' => $id]
            )->result_array()[0]);
        }
    }

    public function daftar_status_fu()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            echo json_encode($this->db_wuling->get('dl_status_fu')->result());
        }
    }

    public function daftar_keterangan_fu()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            echo json_encode($this->db_wuling->get('dl_keterangan_fu')->result());
        }
    }

    public function daftar_status_customer()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $result = $this->db_wuling
                ->where_not_in('id_status_customer', ['1'])
                ->get('dl_status_customer')
                ->result();
            echo json_encode($result);
        }
    }

    public function daftar_sales_force()
    {
        $index = 'wuling_dl_followup';
        if ($this->m_marketing->auth_login('admin_it,SDIGM,tm_w', $index)) {
            $id_perusahaaan = $this->input->post('id_cabang');
            echo json_encode($this->db_wuling->distinct(
                "adms.id_sales,
                k.nik,
                k.nama_karyawan"
            )
                ->from("adm_sales adms")
                ->join("kmg.karyawan k", "adms.id_sales = k.id_karyawan")
                ->where("adms.id_perusahaan", $id_perusahaaan)
                ->where("adms.status_aktif", 'A')
                ->order_by("k.nama_karyawan", 'ASC')
                ->get()->result());
        }
    }
}
