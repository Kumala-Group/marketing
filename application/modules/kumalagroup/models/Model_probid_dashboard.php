<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH . 'third_party/vendor/autoload.php');

use Rakit\Validation\Validator;

class Model_probid_dashboard extends CI_Model
{
    private function nama_database_brand()
    {
        $id_user_ = $this->session->userdata('id_user');
        $id_brand_view = $this->db->get_where('users', "id_user = $id_user_")->row('id_brand_view');
        $data_tabel = array("3" => "db_hino", "4" => "", "5" => "db_wuling", "7" => "", "8" => "", "11" => "", "13" => "", "15" => "", "26" => "", "17" => "db_honda", "18" => "db_mercedes", "19" => "", "20" => "", "21" => "db_kuc");
        return $data_tabel[$id_brand_view];
    }

    private function get_id_brand()
    {
        $id_user = $this->session->userdata('id_user');
        $id_brand = $this->db->get_where('users', "id_user = $id_user")->row('id_brand_view');
        return $id_brand;
    }

    public function cabang()
    {

        $id_brand_view = $this->get_id_brand();
        $cabang = $this->db->get_where('perusahaan', array('id_brand' => $id_brand_view));
        return $cabang->result();
    }

    public function jenis_biaya()
    {

        $this->kumalagroup->select('*');
        $this->kumalagroup->from('jenis_biaya');
        $data = $this->kumalagroup->get();
        return $data->result();
    }

    public function detail_biaya()
    {
        $kategori_biaya = $this->input->get('kategori_biaya');
        $type = array();
        // $data = $this->kumalagroup->get_where('detail_biaya', array('detail_kategori' => ($kategori_biaya)));
        $this->kumalagroup->select('*');
        $this->kumalagroup->from('detail_biaya');
        $this->kumalagroup->where('detail_kategori', $kategori_biaya);
        $this->kumalagroup->group_by('type_biaya');
        $data = $this->kumalagroup->get();
        foreach ($data->result() as $key => $row) {
            $type['id'][] = $row->type_biaya;
            $type['biaya'][] = $row->type_biaya == '1' ? 'Internal' : 'External';
        }
        return $type;
    }

    public function get_data_internal($id_perusahaan, $kategori_biaya, $tahun, $type)
    {
        $nama_table = $this->nama_database_brand();
        $id_brand   = $this->get_id_brand();
        $arrBulan   = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Juli', 'Agst', 'Sep', 'Okt', 'Nov', 'Des'];
        $result     = array();
        $pembayaran = array();
        $total      = array();
        $this->db->select('pod.jumlah , po.tgl, pod.id_pelanggan');
        $this->db->from('kumalagroup.detail_biaya db');
        $this->db->join($nama_table . '.pengeluaran_operasional_detail pod', 'pod.id_pelanggan = db.id_pelanggan');
        $this->db->join($nama_table . '.pengeluaran_operasional po', 'po.no_pengeluaran = pod.no_pengeluaran');
        $this->db->where('db.detail_kategori', $kategori_biaya);
        $this->db->where('db.id_brand', $id_brand);
        $this->db->where('db.id_perusahaan', $id_perusahaan);
        $this->db->where('db.type_biaya', $type);
        $this->db->where("po.tgl LIKE '%$tahun%'");
        $this->db->group_by('pod.id_pelanggan');
        $data = $this->db->get();
        foreach ($data->result() as  $dt) {
            // $result[$dt->id_pelanggan][] = "[Date.UTC(" . date('Y, n, j', strtotime('-1 month', strtotime($dt->tgl))) . "), $dt->jumlah]";
            for ($i = 1; $i <= count($arrBulan); $i++) {
                $total[$i] = (intval($this->get_jumlah($dt->id_pelanggan, $tahun, $i)));
            }
            $pembayaran[] = [
                'name' => $dt->id_pelanggan,
                'data' => array_values($total)
            ];
        }
        $result = array(
            'categories' => $arrBulan,
            'series'     => $pembayaran,
        );
        return responseJson($result);
    }


    private function get_jumlah($id, $tahun, $i)
    {
        $bulan = $i < 10 ? '0' . $i : $i;
        // debug($bulan);
        $tahun_bulan = $tahun . '-' . $bulan;
        $nama_table = $this->nama_database_brand();
        $this->$nama_table->select('SUM(pod.jumlah) as total');
        $this->$nama_table->from('pengeluaran_operasional_detail pod');
        $this->$nama_table->join('pengeluaran_operasional po', 'po.no_pengeluaran = pod.no_pengeluaran');
        $this->$nama_table->where('pod.id_pelanggan', $id);
        $this->$nama_table->like('po.tgl ', $tahun_bulan);
        $data = $this->$nama_table->get()->row('total');
        return $data;
    }
}
