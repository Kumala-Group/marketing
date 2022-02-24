<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Do_by_type extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "wuling_do_by_type";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['load'])) $this->load($post);
            } else {
                $d['content'] = "pages/marketing_support/wuling/do_by_type";
                $d['index'] = $index;
                $d['lokasi'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 5])->result();
                $this->load->view('index', $d);
            }
        }
    }
    function load($post)
    {
        $output = '';
        $bulan = 0;
        $id_perusahaan = $post['perusahaan'];
        $tahun = $post['tahun'];
        if (empty($id_perusahaan)) {
            $all = $this->db->query("SELECT id_perusahaan, singkat, lokasi FROM perusahaan WHERE id_brand='5'");
            foreach ($all->result() as $dt_all) {
                $varian = $this->db_wuling->query("SELECT DISTINCT(varian) as varian FROM unit");
                $varian_rows = $varian->num_rows() + 1;
                $output .= "
					<tr>
						<td class='center' rowspan='$varian_rows'>$dt_all->singkat - $dt_all->lokasi</td>";
                foreach ($varian->result() as $dt_varian) {
                    $unit_codes = $this->db_wuling->query("
							SELECT DISTINCT(u.kode_unit) FROM unit u 
							JOIN s_prospek spr ON spr.kode_unit = u.kode_unit
							JOIN s_do sdo ON sdo.id_prospek = spr.id_prospek
							WHERE u.varian='$dt_varian->varian'
						");

                    $unit_codss = $this->db_wuling->query("
							SELECT u.kode_unit FROM unit u 
							WHERE u.varian IN ('$dt_varian->varian')
						");

                    $output .=
                        "<tr>
							<td class='center'>$dt_varian->varian</td>
						";

                    for ($x = 1; $x <= 12; $x++) {
                        if ($x < 10) {
                            $bulan = '0' . $x;
                        } else {
                            $bulan = $x;
                        }
                        $unit_cods = $this->db_wuling->query("
								SELECT COUNT(u.kode_unit) AS kode_unit 
								FROM unit u 
								JOIN s_prospek spr ON spr.kode_unit=u.kode_unit
								JOIN s_do sdo ON sdo.id_prospek = spr.id_prospek
								JOIN s_spk ssp ON ssp.id_prospek = sdo.id_prospek
								WHERE u.varian IN ('$dt_varian->varian') AND sdo.tgl_do LIKE '%$tahun-$bulan%' AND ssp.id_perusahaan='$dt_all->id_perusahaan'
							");

                        foreach ($unit_cods->result() as $dt_unit_codes) {
                            $output .=
                                "
								<td class='center'>$dt_unit_codes->kode_unit</td>
							
							";
                        }
                    }
                }
                $output .= "</tr></tr>";
                $data = array('view' => $output);
            }
        } else {
            $perusahaan = $this->db->query("SELECT singkat, lokasi FROM perusahaan WHERE id_perusahaan='$id_perusahaan'")->row();
            $varian = $this->db_wuling->query("SELECT DISTINCT(varian) as varian FROM unit");
            $varian_rows = $varian->num_rows() + 1;
            $output .= "
					<tr>
						<td class='center' rowspan='$varian_rows'>$perusahaan->singkat - $perusahaan->lokasi</td>";
            foreach ($varian->result() as $dt_varian) {
                $unit_codes = $this->db_wuling->query("
							SELECT DISTINCT(u.kode_unit) FROM unit u 
							JOIN s_prospek spr ON spr.kode_unit = u.kode_unit
							JOIN s_do sdo ON sdo.id_prospek = spr.id_prospek
							WHERE u.varian='$dt_varian->varian'
						");

                $unit_codss = $this->db_wuling->query("
							SELECT u.kode_unit FROM unit u 
							WHERE u.varian IN ('$dt_varian->varian')
						");

                $output .=
                    "<tr>
							<td class='center'>$dt_varian->varian</td>
						";

                for ($x = 1; $x <= 12; $x++) {
                    if ($x < 10) {
                        $bulan = '0' . $x;
                    } else {
                        $bulan = $x;
                    }
                    $unit_cods = $this->db_wuling->query("
								SELECT COUNT(u.kode_unit) AS kode_unit 
								FROM unit u 
								JOIN s_prospek spr ON spr.kode_unit=u.kode_unit
								JOIN s_do sdo ON sdo.id_prospek = spr.id_prospek
								JOIN s_spk ssp ON ssp.id_prospek = sdo.id_prospek
								WHERE u.varian IN ('$dt_varian->varian') AND sdo.tgl_do LIKE '%$tahun-$bulan%' AND ssp.id_perusahaan='$id_perusahaan'
							");

                    foreach ($unit_cods->result() as $dt_unit_codes) {
                        $output .=
                            "
								<td class='center'>$dt_unit_codes->kode_unit</td>
							
							";
                    }
                }
            }
            $output .= "</tr></tr>";
            $data = array('view' => $output);
        }
        echo json_encode($data);
    }
}
