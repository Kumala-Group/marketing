<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main_stage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "main_stage";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['main_stage'])) $this->main_stage($post);
                elseif (!empty($post['publish'])) {
                    $response = $this->kumalagroup->update('main_stage', ['is_live' => $post['data']], ['id' => 1])
                        ? ['status' => "success", 'msg' => "Data berhasil diupdate"]
                        : ['status' => "error", 'msg' => "Data gagal diupdate"];
                    echo json_encode($response, JSON_PRETTY_PRINT);
                } elseif (!empty($post['zoom'])) {
                    $response = $this->kumalagroup->update('main_stage', ['is_zoom' => $post['data']], ['id' => 1])
                        ? ['status' => "success", 'msg' => "Data berhasil diupdate"]
                        : ['status' => "error", 'msg' => "Data gagal diupdate"];
                    echo json_encode($response, JSON_PRETTY_PRINT);
                } elseif (!empty($post['rundown'])) $this->rundown($post);
                elseif (!empty($post['getrundown'])) {
                    $q = q_data("*", 'kumk6797_kumalagroup.rundown', [], ["waktu", "asc"])->result();
                    foreach ($q as $v) {
                        $date = explode(" ", $v->waktu);
                        $response[] = [
                            "id" => $v->id,
                            "tanggal" => tgl_sql($date[0]),
                            "waktu" => $date[1],
                            "judul" => $v->judul
                        ];
                    }
                    echo json_encode($response, JSON_PRETTY_PRINT);
                } else if (!empty($post['hapus'])) {
                    $response = $this->kumalagroup->delete('rundown', ['id' => $post['id']])
                        ? ['status' => "success", 'msg' => "Data berhasil dihapus"]
                        : ['status' => "error", 'msg' => "Data gagal dihapus"];
                    echo json_encode($response, JSON_PRETTY_PRINT);
                }
            } else {
                $d['content'] = "pages/virtual_fair/main_stage";
                $d['index'] = $index;
                $d['data'] = q_data("*", 'kumk6797_kumalagroup.main_stage', ['id' => 1])->row();
                $this->load->view('index', $d);
            }
        }
    }
    function main_stage($post)
    {
        $data['live'] = $post['live'];
        $data['playlist'] = $post['playlist'];
        $data['link_zoom'] = $post['link_zoom'];
        $data['meeting_id'] = $post['meeting_id'];
        $data['passcode'] = $post['passcode'];
        $data['waktu'] = date("Y-m-d H:i:s",  strtotime(tgl_sql($post['tanggal']) . " " . $post['waktu']));
        $response = $this->kumalagroup->update('main_stage', $data, ['id' => 1])
            ? ['status' => "success", 'msg' => "Data berhasil disimpan"]
            : ['status' => "error", 'msg' => "Data gagal disimpan"];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    function rundown($post)
    {
        foreach ($post['judul'] as $i => $v) {
            $data['id'] = $post['id'][$i];
            $data['waktu'] = date("Y-m-d H:i:s",  strtotime(tgl_sql($post['tanggal'][$i]) . " " . $post['waktu'][$i]));
            $data['judul'] = $post['judul'][$i];
            $q = q_data("*", 'kumk6797_kumalagroup.rundown', ['id' => $post['id'][$i]]);
            $r = $q->num_rows() > 0
                ? $this->kumalagroup->update('rundown', $data, ['id' => $post['id'][$i]])
                : $this->kumalagroup->insert('rundown', $data);
        }
        $response =  $r ? ['status' => "success", 'msg' => "Data berhasil disimpan"]
            : ['status' => "error", 'msg' => "Data gagal disimpan"];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}
