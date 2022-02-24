<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_suspect_prospek extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "wuling_cust_suspect_prospek";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['datatable']))
                    echo q_datatable_join(
                        "c.id_prospek,k.nama_karyawan,c.nama,c.alamat,upper(c.status) as status",
                        'db_wuling.s_customer c',
                        [
                            'db_wuling.adm_sales as' => "as.id_sales = c.sales",
                            'db_wuling.s_suspect ss' => "ss.id_prospek = c.id_prospek",
                            'kmg.karyawan k'         => "c.sales = k.id_karyawan",
                        ],
                        "as.id_perusahaan='" . $post['perusahaan'] . "' and (ss.tgl_suspect between '" . tgl_sql($post['tanggal_awal']) . "' and '" . tgl_sql($post['tanggal_akhir']) . "')"
                    );
            } else {
                $d['content'] = "pages/marketing_support/wuling/customer_suspect_prospek";
                $d['index'] = $index;
                $d['lokasi'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 5])->result();
                $this->load->view('index', $d);
            }
        }
    }
}
