<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_honda_marketing_support extends CI_Model
{
    public function activity()
    {
        $nik['nik'] = $this->session->userdata('nik');
        $coverage   = q_data("*", 'kumalagroup.users', $nik)->row('coverage');

        $select = ["ej.event_jenis", "e.event", "e.tgl_mulai", "e.tgl_selesai", "el.lokasi", "concat('Rp. ',FORMAT(e.total_biaya, 0, 'de_DE')) as total_biaya", "e.id_event"];
        $tabel  = 'db_honda.event e';
        $join   = [
            'db_honda.event_jenis ej'  => "e.id_event_jenis=ej.id_event_jenis",
            'db_honda.event_lokasi el' => "e.id_event_lokasi=el.id_event_lokasi",
            'db_honda.event_area ea'   => "el.id_event_area=ea.id_event_area",
        ];
        $where = "e.id_perusahaan IN ($coverage)";
        $data  = q_data_datatable($select, $tabel, $join, $where);
        return q_result_datatable($select, $tabel, $join, $where, $data);
    }
}
