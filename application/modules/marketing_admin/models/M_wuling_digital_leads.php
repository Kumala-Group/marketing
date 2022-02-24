
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_wuling_digital_leads extends CI_Model
{
    public function customer_leads()
    {
        $this->load->library('datatables');

        $this->datatables->select('dl.komunikasi, dl.nama_leads, dl.keterangan, dl.kontak, dl.alamat, dl.status, dl.id_digital_leads');
        $this->datatables->from('db_wuling.digital_leads as dl');
        $this->datatables->where('dl.status !=', '1');
        $this->datatables->or_where('dl.status IS NULL', null, false);
        echo $this->datatables->generate();
    }

    // untuk get datatable followup
    public function customer_leads_followup_dt($nik)
    {
        $data = $this->db_wuling
            ->select('*')
            ->from('followup_digital_leads fdl')
            ->join('digital_leads dl', 'dl.id_digital_leads = fdl.id_digital_leads')
            ->where('fdl.user', $nik)
            ->get()
            ->result();
        
        $result = [];
        foreach ($data as $dt) {
            $result[] = [
                'id_digital_leads'  => $dt->id_digital_leads,
                'leads'             => $dt->leads,
                'nama_leads'        => $dt->nama_leads,
                'kontak'            => $dt->kontak,
                'alamat'            => $dt->alamat,
                'region'            => $dt->region,
                'pekerjaan'         => $dt->pekerjaan,
                'rencana_pembelian' => $dt->rencana_pembelian,
                'tanggal_fu'        => $this->status($dt->id_digital_leads)['tanggal'],
                'keterangan'        => $this->status($dt->id_digital_leads)['keterangan'],
                'status'            => $this->status($dt->id_digital_leads)['status']
            ];
        }
        return $result;
    }

    // untuk get datatable alokasi
    public function customer_leads_alokasi_dt($nik)
    {
        $data = $this->db_wuling
            ->select('*, fdl.tanggal')
            ->from('followup_digital_leads fdl')
            ->join('digital_leads dl', 'dl.id_digital_leads =  fdl.id_digital_leads')
            ->where('fdl.user', $nik)
            ->get()
            ->result();
        
        $result = [];
        foreach ($data as $dt) {
            $result[] = [
                'id_digital_leads' => $dt->id_digital_leads,
                'nama_leads'       => $dt->nama_leads,
                'kontak'           => $dt->kontak,
                'alamat'           => $dt->alamat,
                'tanggal'          => tgl_sql($dt->tanggal),
                'status'           => $dt->status,
            ];
        }
        return $result;
    }

    // untuk get datatable history
    public function customer_leads_history_dt($id_digital_leads)
    {
        $data = $this->db_wuling
            ->select('*')
            ->from('history_fu_digital_leads')
            ->where('id_digital_leads', $id_digital_leads)
            ->get()
            ->result();

        if (count($data) != 0) {
            foreach ($data as $dt) {
                $st = array(1 => 'Suspect', 'Prospek', 'Hot Prospek', 'Lost');
                $result[] = array(
                    'tanggal'        => $dt->tanggal,
                    'hasil_followup' => $dt->hasil_followup,
                    'keterangan'     => $dt->keterangan,
                    'status_leads'   => $st[$dt->status_leads],
                );
            }
        } else {
            $result[] = array(
                'tanggal'        => 'Belum Follow Up',
                'hasil_followup' => 'Belum Follow Up',
                'keterangan'     => 'Belum Follow Up',
                'status_leads'   => 'Belum Follow Up',
            );
        }
        return $result;
    }

    // untuk mencari status
    public function status($id_digital_leads)
    {
        $this->db_wuling->select('*');
        $this->db_wuling->from('followup_digital_leads');
        $this->db_wuling->where('id_digital_leads', $id_digital_leads);
        $data = $this->db_wuling->get();
        
        foreach ($data->result() as $dt) {
            $st = array(1 => 'Suspect', 'Prospek', 'Hot Prospek', 'Lost');
            $status['status'] = $st[$dt->status];
            $status['tanggal'] = tgl_sql($dt->tanggal);
            $status['keterangan'] = $dt->keterangan;
        }
        if (empty($status)) {
            $status['status'] = 'Belum FU';
            $status['tanggal'] = 'Belum FU';
            $status['keterangan'] = 'Belum FU';
        }

        return $status;
    }

    // untuk mengambil data sales
    public function data_sales()
    {
        $data = $this->db_wuling
            ->select('k.nama_karyawan,as.id_sales')
            ->from('adm_sales as')
            ->join('kmg.karyawan k', 'k.id_karyawan = as.id_sales')
            ->where('as.id_jabatan', '22')
            ->get()
            ->result();

        return $data;
    }

    // untuk mengambil data berdasarkan id
    public function update_followup($id_digital_leads)
    {
        $result = $this->db_wuling
            ->select('*, dl.nama_leads')
            ->from('digital_leads dl')
            ->join('followup_digital_leads fdl', 'fdl.id_digital_leads = dl.id_digital_leads', 'left')
            ->where('dl.id_digital_leads', $id_digital_leads)
            ->get()
            ->row();
        
        return $result;
    }
}
