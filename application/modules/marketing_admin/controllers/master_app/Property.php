<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Property extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "property";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['datatable'])) $this->datatable($post);
                elseif (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
                elseif (!empty($post['hapus_galeri'])) $this->hapus_galeri($post);
            } else {
                $d['content'] = "pages/master_app/property";
                $d['index'] = $index;
                $d['img_server'] = $this->m_marketing->img_server;
                $this->load->view('index', $d);
            }
        }
    }
    function datatable($post)
    {
        $select = ["nama", "daerah", "alamat", "gambar", "map_url", "id"];
        $table = 'kumalagroup.property';
        $where = empty($post['jenis']) ? null : ['jenis' => $post['jenis']];
        $list = q_data_datatable($select, $table, null, $where);
        echo q_result_datatable($select, $table, null, $where, $list ?? []);
    }
    function simpan($post)
    {
        $response = ['status' => "error", 'msg' => "Data berhasil diupdate!"];
        $where = $post['id'];
        $data['nama'] = $post['nama'];
        $data['jenis'] = $post['jenis'];
        $data['daerah'] = $post['daerah'];
        $data['harga_sewa'] = remove_separator($post['harga_sewa']);
        $data['harga_jual'] = remove_separator($post['harga_jual']);
        $data['alamat'] = $post['alamat'];
        $data['map_url'] = $post['map_url'];
        $data['ukuran'] = $post['ukuran'];
        $data['jumlah_lantai'] = $post['jumlah_lantai'];
        $data['listrik'] = $post['listrik'];
        $data['sumber_air'] = $post['sumber_air'];
        $data['keterangan'] = $post['keterangan'];

        if (!empty($_FILES['gambar'])) {
            $ext = explode(".", $_FILES['gambar']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['gambar']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/property/";
            $gambar = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }
        if (!empty($_FILES['denah'])) {
            $ext = explode(".", $_FILES['denah']['name']);
            $data_post['file'] = base64_encode(file_get_contents($_FILES['denah']['tmp_name']));
            $data_post['name'] = date('YmdHis') . "." . strtolower(end($ext));
            $data_post['path'] = "./assets/img_marketing/property/denah/";
            $denah = curl_post($this->m_marketing->img_server . "post_img", $data_post);
        }
        if (!empty($_FILES['galeri']))
            foreach ($_FILES['galeri']['name'] as $i => $v) {
                $ext = explode(".", $_FILES['galeri']['name'][$i]);
                $data_post['file'] = base64_encode(file_get_contents($_FILES['galeri']['tmp_name'][$i]));
                $data_post['name'] = date('YmdHis') . $i . "." . strtolower(end($ext));
                $data_post['path'] = "./assets/img_marketing/property/galeri/";
                $galeri[] = curl_post($this->m_marketing->img_server . "post_img", $data_post);
            }

        $q_brand = q_data("*", 'kumalagroup.property', ['id' => $where]);
        if ($q_brand->num_rows() == 0) {
            $data['gambar']     = $gambar;
            $data['denah']      = $denah;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("property", $data);
            $data = [];
            $data['id_ref'] = $this->kumalagroup->insert_id();
            if (!empty($_FILES['galeri'])) foreach ($galeri as $i => $v) {
                $data['jenis'] = "property";
                $data['img'] = $galeri[$i];
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("image_galeri", $data);
            }
            $response = ['status' => "success", 'msg' => "Data berhasil simpan!"];
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            if (!empty($_FILES['gambar'])) {
                $data['gambar'] = $gambar;
                $data_post['name'] = q_data("*", 'kumalagroup.property', ['id' => $where])->row('gambar');
                $data_post['path'] = "./assets/img_marketing/property/";
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            if (!empty($_FILES['denah'])) {
                $data['denah'] = $denah;
                $data_post['name'] = q_data("*", 'kumalagroup.property', ['id' => $where])->row('denah');
                $data_post['path'] = "./assets/img_marketing/property/denah/";
                curl_post($this->m_marketing->img_server . "delete_img", $data_post);
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("property", $data, ['id' => $where]);
            $data = [];
            $data['id_ref'] = $where;
            if (!empty($_FILES['galeri'])) foreach ($galeri as $i => $v) {
                $data['jenis'] = "property";
                $data['img'] = $galeri[$i];
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->kumalagroup->insert("image_galeri", $data);
            }
            $response = ['status' => "success", 'msg' => "Data berhasil diupdate!"];
        }
        echo json_encode($response);
    }
    function edit($post)
    {
        $where = $post['id'];
        $data = q_data("*", 'kumalagroup.property', ['id' => $where])->row();
        $d['nama'] = $data->nama;
        $d['jenis'] = $data->jenis;
        $d['daerah'] = $data->daerah;
        $d['harga_sewa'] = separator_harga($data->harga_sewa);
        $d['harga_jual'] = separator_harga($data->harga_jual);
        $d['alamat'] = $data->alamat;
        $d['map_url'] = $data->map_url;
        $d['ukuran'] = $data->ukuran;
        $d['jumlah_lantai'] = $data->jumlah_lantai;
        $d['listrik'] = $data->listrik;
        $d['sumber_air'] = $data->sumber_air;
        $d['keterangan'] = $data->keterangan;
        $d['galeri'] = q_data("id,img", 'kumalagroup.image_galeri', ['id_ref' => $where, 'jenis' => "property"])->result();
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where = $post['id'];
        $img = q_data("*", 'kumalagroup.property', ['id' => $where])->row();
        $data_post['name'] = $img->gambar;
        $data_post['path'] = "./assets/img_marketing/property/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $data_post['name'] = $img->denah;
        $data_post['path'] = "./assets/img_marketing/property/denah/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $galeri = q_data("*", 'kumalagroup.image_galeri', ['id_ref' => $where, 'jenis' => "property"])->result();
        foreach ($galeri as $v) {
            $data_post['name'] = $v->img;
            $data_post['path'] = "./assets/img_marketing/property/galeri/";
            curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        }
        $response =  $this->kumalagroup->delete('property', ['id' => $where])
            ? ['status' => "success", 'msg' => "Data berhasil dihapus!"]
            : ['status' => "error", 'msg' => "Data gagal dihapus!"];
        echo json_encode($response);
    }
    function hapus_galeri($post)
    {
        $where = $post['id'];
        $data_post['name'] = q_data("*", 'kumalagroup.image_galeri', ['id' => $where])->row('img');
        $data_post['path'] = "./assets/img_marketing/property/galeri/";
        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
        $response =  $this->kumalagroup->delete('image_galeri', ['id' => $where])
            ? ['status' => "success", 'msg' => "Data berhasil dihapus!"]
            : ['status' => "error", 'msg' => "Data gagal dihapus!"];
        echo json_encode($response);
    }
}
