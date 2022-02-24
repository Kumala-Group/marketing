<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Detail_unit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "detail_unit";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                else if (!empty($post['loadModel'])) $this->loadModel($post);
                else if (!empty($post['loadDetail'])) {
                    $response = q_data(
                        "*",
                        'kumalagroup.units_detail',
                        'unit=\'' . $post['model'] . '\' and detail in (\'360In\',\'360Drive\')'
                    )->result();
                    echo json_encode($response, JSON_PRETTY_PRINT);
                }
            } else {
                $d['content'] = "pages/virtual_fair/detail_unit";
                $d['index'] = $index;
                $d['brand'] = q_data("*", 'kumalagroup.brands', [])->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $this->kumalagroup->trans_start();
        $data['unit'] = $post['model'];
        $data['detail'] = "360Drive";
        $data['nama_detail'] = "Video 360 Test Drive";
        $data['deskripsi'] = $post['test_drive'];
        $q = q_data("*", 'kumalagroup.units_detail', ['unit' => $post['model'], 'detail' => "360Drive"]);
        if ($q->num_rows() > 0)
            $this->kumalagroup->update('units_detail', $data, ['unit' => $post['model'], 'detail' => "360Drive"]);
        else
            $this->kumalagroup->insert('units_detail', $data);

        $data['detail'] = "360In";
        $data['nama_detail'] = "360 Interior";
        $data['deskripsi'] = $post['interior'];
        $q = q_data("*", 'kumalagroup.units_detail', ['unit' => $post['model'], 'detail' => "360In"]);
        if ($q->num_rows() > 0)
            $this->kumalagroup->update('units_detail', $data, ['unit' => $post['model'], 'detail' => "360In"]);
        else
            $this->kumalagroup->insert('units_detail', $data);

        $kode = $this->m_marketing->generate_kode(5);

        if (!empty($_FILES['exterior'])) {
            $q = q_data("*", 'kumalagroup.units_detail', ['unit' => $post['model'], 'detail' => "360Ex"]);
            if ($q->num_rows() > 0) {
                foreach ($q->result() as $v) {
                    $data_post['name'] = $v->gambar;
                    $data_post['path'] = "./assets/img_marketing/otomotif/360ex/";
                    curl_post($this->m_marketing->img_server . "delete_img", $data_post);
                }
                $this->kumalagroup->delete('units_detail', ['unit' => $post['model'], 'detail' => "360Ex"]);
            }
            foreach ($_FILES['exterior']['name'] as $i => $v) {
                $ext = explode(".", $_FILES['exterior']['name'][$i]);
                $data_post['file'] = base64_encode(file_get_contents($_FILES['exterior']['tmp_name'][$i]));
                $data_post['name'] = date('Ymd') . $kode . "part-" . ($i + 1) . "." . strtolower(end($ext));
                $data_post['path'] = "./assets/img_marketing/otomotif/360ex/";
                $exterior[] = curl_post($this->m_marketing->img_server . "post_img", $data_post);

                $data['unit'] = $post['model'];
                $data['detail'] = "360Ex";
                $data['nama_detail'] = "Exterior 360 " . $post['model'];
                $data['deskripsi'] = $i;
                $data['gambar'] = $data_post['name'];
                $this->kumalagroup->insert("units_detail", $data);
            }
        }

        $response = $this->kumalagroup->trans_complete()
            ? ['status' => "success", 'msg' => "Data berhasil disimpan"]
            : ['status' => "error", 'msg' => "Data gagal disimpan"];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function loadModel($post)
    {
        $where = $post['brand'];
        $data = q_data_join("u.id,m.nama_model", 'kumalagroup.units u', [
            'kumalagroup.models m' => "m.id=u.model"
        ], ['u.brand' => $where, 'u.is_digifest' => 1])->result() ?>
        <option value="" selected disabled>-- Silahkan Pilih Model --</option>
        <?php foreach ($data as $v) : ?>
            <option value="<?= $v->id ?>"><?= $v->nama_model ?></option>
<?php endforeach;
    }
}
