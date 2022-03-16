<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Otomotif extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "otomotif";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
                elseif (!empty($post['hapus_detail'])) $this->hapus_detail($post);
                elseif (!empty($post['load_warna'])) $this->load_warna($post);
                elseif (isset($post['digifest'])) {
                    $this->kumalagroup->update('units', array(
                        'is_digifest' => $post['value']
                    ), array(
                        'id' => $post['id']
                    ));
                    $response = $this->kumalagroup->affected_rows()
                        ? array('status' => 'success')
                        : array('status' => 'error');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } else {
                $d['content'] = "pages/master_app/otomotif";
                $d['index'] = $index;
                $d['img_server'] = $this->m_marketing->img_server;
                $d['brand'] = q_data("*", 'kumk6797_kumalagroup.brands', [])->result();
                $hino = q_data("*", 'kumk6797_kumalagroup.units', ['brand' => 3,'is_deleted' => '0'], ["updated_at", 'asc'])->result();
                foreach ($hino as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['harga'] = $v->harga;
                    $arr['gambar'] = $v->gambar;
                    $arr['is_digifest'] = $v->is_digifest;
                    $d['hino'][] = $arr;
                }
                $arr = [];
                $honda = q_data("*", 'kumk6797_kumalagroup.units', ['brand' => 17,'is_deleted' => '0'], ["updated_at", 'asc'])->result();
                foreach ($honda as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['harga'] = $v->harga;
                    $arr['gambar'] = $v->gambar;
                    $arr['is_digifest'] = $v->is_digifest;
                    $d['honda'][] = $arr;
                }
                $arr = [];
                $mazda = q_data("*", 'kumk6797_kumalagroup.units', ['brand' => 4,'is_deleted' => '0'], ["updated_at", 'asc'])->result();
                foreach ($mazda as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['harga'] = $v->harga;
                    $arr['gambar'] = $v->gambar;
                    $arr['is_digifest'] = $v->is_digifest;
                    $d['mazda'][] = $arr;
                }
                $arr = [];
                $mercedes = q_data("*", 'kumk6797_kumalagroup.units', ['brand' => 18,'is_deleted' => '0'], ["updated_at", 'asc'])->result();
                foreach ($mercedes as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['harga'] = $v->harga;
                    $arr['gambar'] = $v->gambar;
                    $arr['is_digifest'] = $v->is_digifest;
                    $d['mercedes'][] = $arr;
                }
                $arr = [];
                $wuling = q_data("*", 'kumk6797_kumalagroup.units', ['brand' => 5,'is_deleted' => '0'], ["updated_at", 'asc'])->result();
                foreach ($wuling as $v) {
                    $arr['id'] = $v->id;
                    $arr['_model'] = q_data("*", 'kumk6797_kumalagroup.models', ['id' => $v->model])->row()->nama_model;
                    $arr['harga'] = $v->harga;
                    $arr['gambar'] = $v->gambar;
                    $arr['is_digifest'] = $v->is_digifest;
                    $d['wuling'][] = $arr;
                }
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where = $post['id'];
        if (empty($where)) $data['kode_unit'] = $this->m_marketing->generate_kode();
        $data['brand'] = $post['brand'];
        $data['model'] = $post['model'];
        $data['harga'] = remove_separator($post['harga']);
        $data['deskripsi'] = $post['deskripsi'];
        $data['video'] = $this->url_youtube($post['video']);

        if (!empty($_FILES['gambar'])) {
            $ext = explode(".", $_FILES['gambar']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/otomotif/";
            $gambar = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }
        if (!empty($_FILES['brosur'])) {
            $ext = explode(".", $_FILES['brosur']['name']);
            $data_post['file'] =  new CURLFile($_FILES['brosur']['tmp_name'], $_FILES['brosur']['type'], $_FILES['brosur']['name']);
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/otomotif/brosur/";
            $brosur = curl_post($this->m_marketing->img_server . "post_file", $data_post);
            if (!$brosur) $error = 1;
        }

        if (!empty($_FILES['gambar_warna']))
            foreach ($_FILES['gambar_warna']['name'] as $i => $v) {
                $ext = explode(".", $_FILES['gambar_warna']['name'][$i]);
                $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar_warna']['tmp_name'][$i]));
                $data_post['name'] = date('YmdHis') . $i . "." . strtolower(end($ext));
                $data_post['path'] = "./assets/img_marketing/otomotif/warna/";
                $gambar_warna[] = curl_post($this->m_marketing->img_server . "post_img", $data_post);
            }

        if (!empty($_FILES['gambar_detail']))
            foreach ($_FILES['gambar_detail']['name'] as $i => $v) {
                $ext = explode(".", $_FILES['gambar_detail']['name'][$i]);
                $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar_detail']['tmp_name'][$i]));
                $data_post['name'] = date('YmdHis') . $i . "." . strtolower(end($ext));
                $data_post['path'] = "./assets/img_marketing/otomotif/detail/";
                $gambar_detail[] = curl_post($this->m_marketing->img_server . "post_img", $data_post);
            }

        $q_brand = q_data("*", 'kumk6797_kumalagroup.units', ['id' => $where]);
        if ($q_brand->num_rows() == 0) {
            $data['gambar'] = $gambar;
            if ($brosur) $data['brosur'] = $brosur;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("units", $data);
            $data = [];
            $data['unit'] = $this->kumalagroup->insert_id();
            if (!empty($_FILES['gambar_warna'])) foreach ($gambar_warna as $i => $v) {
                $data['detail'] = "warna";
                $data['nama_detail'] = $post['id_warna'][$i];
                $data['deskripsi'] = $post['hex_warna'][$i];
                $data['gambar'] = $gambar_warna[$i];
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("units_detail", $data);
            }
            foreach ($post['spesifikasi'] as $i => $v) {
                $data['detail'] = "spek";
                $data['nama_detail'] = $post['nama_spek'][$i];
                $data['deskripsi'] = $post['spesifikasi'][$i];
                unset($data['gambar']);
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("units_detail", $data);
            }
            if (!empty($_FILES['gambar_detail'])) foreach ($gambar_detail as $i => $v) {
                $data['detail'] = "detail";
                $data['nama_detail'] = $post['nama_detail'][$i];
                $data['deskripsi'] = $post['deskripsi_detail'][$i];
                $data['gambar'] = $gambar_detail[$i];
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("units_detail", $data);
            }
            $status = empty($error) ? 1 : 3;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            if (!empty($_FILES['gambar'])) {
                $data['gambar'] = $gambar;
                $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.units', ['id' => $where])->row()->gambar;
                $data_post['path'] = "./assets/img_marketing/otomotif/";
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            if (!empty($_FILES['brosur'])) if ($brosur) {
                $data['brosur'] = $brosur;
                $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.units', ['id' => $where])->row()->brosur;
                $data_post['path'] = "./assets/img_marketing/otomotif/brosur/";
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("units", $data, ['id' => $where]);
            $data = [];
            if (!empty($post['id_warna'])) foreach ($post['id_warna'] as $i => $v) {
                $data['detail'] = "warna";
                $data['nama_detail'] = $post['id_warna'][$i];
                $data['deskripsi'] = $post['hex_warna'][$i];
                if (!empty($post['i_warna'])) if (in_array($i, $post['i_warna']))
                    $data['gambar'] = $gambar_warna[array_search($i, $post['i_warna'])];
                else unset($data['gambar']);
                $q = q_data("*", 'kumk6797_kumalagroup.units_detail', ['nama_detail' => $post['id_warna'][$i], 'unit' => $where]);
                if ($q->num_rows() > 0) {
                    if (!empty($post['i_warna'])) if (in_array($i, $post['i_warna'])) {
                        $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.units_detail', ['nama_detail' => $post['id_warna'][$i], 'unit' => $where])->row()->gambar;
                        $data_post['path'] = "./assets/img_marketing/otomotif/warna/";
                        if (!empty($data_post['name'])) curl_post($this->m_marketing->img_server . "delete_img", $data_post);
                    }
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $this->kumalagroup->update("units_detail", $data, ['nama_detail' => $post['id_warna'][$i], 'unit' => $where]);
                } else {
                    $data['unit'] = $where;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $this->kumalagroup->insert("units_detail", $data);
                }
            }
            $data = [];
            foreach ($post['id_spek'] as $i => $v) {
                $data['detail'] = "spek";
                $data['nama_detail'] = $post['nama_spek'][$i];
                $data['deskripsi'] = $post['spesifikasi'][$i];
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->update("units_detail", $data, ['id' => $post['id_spek'][$i]]);
            }
            $data = [];
            if (!empty($post['nama_detail'])) foreach ($post['nama_detail'] as $i => $v) {
                $data['detail'] = "detail";
                $data['nama_detail'] = $post['nama_detail'][$i];
                $data['deskripsi'] = $post['deskripsi_detail'][$i];
                if (!empty($post['i_detail'])) if (in_array($i, $post['i_detail']))
                    $data['gambar'] = $gambar_detail[array_search($i, $post['i_detail'])];
                else unset($data['gambar']);
                $q = q_data("*", 'kumk6797_kumalagroup.units_detail', ['id' => $post['id_detail'][$i]]);
                if ($q->num_rows() > 0) {
                    if (!empty($post['i_detail'])) if (in_array($i, $post['i_detail'])) {
                        $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.units_detail', ['id' => $post['id_detail'][$i]])->row()->gambar;
                        $data_post['path'] = "./assets/img_marketing/otomotif/detail/";
                        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
                    }
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $this->kumalagroup->update("units_detail", $data, ['id' => $post['id_detail'][$i]]);
                } else {
                    $data['unit'] = $where;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $this->kumalagroup->insert("units_detail", $data);
                }
            }
            $status = empty($error) ? 2 : 3;
        }
        echo $status;
    }
    function edit($post)
    {
        $where = $post['id'];
        $data = q_data("*", 'kumk6797_kumalagroup.units', ['id' => $where])->row();
        $d['brand'] = $data->brand;
        $d['model'] = $data->model;
        $d['harga'] = separator_harga($data->harga);
        $d['deskripsi'] = $data->deskripsi;
        $d['video'] = $data->video;
        $d['detail'] = q_data("*", 'kumk6797_kumalagroup.units_detail', ['unit' => $where, 'detail' => "detail"])->result();
        $d['spek'] = q_data("*", 'kumk6797_kumalagroup.units_detail', ['unit' => $where, 'detail' => "spek"])->result();
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where = $post['id'];
        $img = q_data("*", 'kumk6797_kumalagroup.units', ['id' => $where])->row();
        $data_post['name'] = $img->gambar;
        $data_post['path'] = "./assets/img_marketing/otomotif/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $data_post['name'] = $img->brosur;
        $data_post['path'] = "./assets/img_marketing/otomotif/brosur/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $warna = q_data("*", 'kumk6797_kumalagroup.units_detail', ['unit' => $where, 'detail' => "warna"])->result();
        foreach ($warna as $v) {
            $data_post['name'] = $v->gambar;
            $data_post['path'] = "./assets/img_marketing/otomotif/warna/";
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        }
        $detail = q_data("*", 'kumk6797_kumalagroup.units_detail', ['unit' => $where, 'detail' => "detail"])->result();
        foreach ($detail as $v) {
            $data_post['name'] = $v->gambar;
            $data_post['path'] = "./assets/img_marketing/otomotif/detail/";
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        }
        $this->kumalagroup->update('units',['is_deleted'=>'1'] ,['id' => $where]);
    }
    function hapus_detail($post)
    {
        $post = $this->input->post();
        if (!$post) $this->m_marketing->error404();
        else {
            $where['id'] = $post['id'];
            $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.units_detail', $where)->row()->gambar;
            $data_post['path'] = "./assets/img_marketing/otomotif/detail/";
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            $this->kumalagroup->delete('units_detail', $where);
        }
    }
    function load_warna($post)
    {
        $where['model'] = $post['model'];
        $data = q_data("*", 'kumk6797_kumalagroup.colors', $where)->result();
        foreach ($data as $v) :
            $r = !empty($post['id']) ? q_data("*", 'kumk6797_kumalagroup.units_detail', ['unit' => $post['id'], 'nama_detail' => $v->id]) : null;
            $hex = !empty($r) ? ($r->num_rows() > 0 ? $r->row()->deskripsi : "") : "" ?>
            <div class="col-md-4 col-sm-6">
                <div class="form-group mb-1">
                    <input type="text" class="hex_warna form-control" name="h<?= $v->id ?>" placeholder="Kode HEX Warna e.g. ffffff" value="<?= $hex ?>" required>
                </div>
                <div class="form-group mb-1">
                    <label><?= $v->nama_warna ?> <small class="text-danger">*Maks 300kB</small></label>
                    <input type="file" name="w<?= $v->id ?>" class="gambar_warna form-control-file" required>
                    <input type="hidden" class="id_warna" value="<?= $v->id ?>">
                </div>
            </div>
<?php endforeach;
    }
    function url_youtube($url)
    {
        $link =  parse_url($url);
        if ($link['host'] == "www.youtube.com") {
            parse_str($link['query'], $r);
            $r = $r['v'];
        } elseif ($link['host'] == "youtu.be") {
            $r = substr($link['path'], 1);
        }
        return "https://www.youtube.com/watch?v=$r";
    }
}
