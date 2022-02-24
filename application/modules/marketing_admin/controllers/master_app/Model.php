<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "model";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['simpan'])) $this->simpan($post);
                elseif (!empty($post['edit'])) $this->edit($post);
                elseif (!empty($post['hapus'])) $this->hapus($post);
                elseif (!empty($post['load'])) $this->load($post);
            } else {
                $d['content'] = "pages/master_app/model";
                $d['index'] = $index;
                $d['brand'] = q_data("*", 'kumalagroup.brands', [])->result();
                $d['hino'] = q_data("*", 'kumalagroup.models', ['brand' => 3])->result();
                $d['honda'] = q_data("*", 'kumalagroup.models', ['brand' => 17])->result();
                $d['mazda'] = q_data("*", 'kumalagroup.models', ['brand' => 4])->result();
                $d['mercedes'] = q_data("*", 'kumalagroup.models', ['brand' => 18])->result();
                $d['wuling'] = q_data("*", 'kumalagroup.models', ['brand' => 5])->result();
                $this->load->view('index', $d);
            }
        }
    }
    function simpan($post)
    {
        $status = 0;
        $where['id'] = $post['id'];
        $data['brand'] = $post['brand'];
        $data['nama_model'] = $post['model'];
        $q_brand = q_data("*", 'kumalagroup.models', $where);
        if ($q_brand->num_rows() == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->insert("models", $data);
            $status = 1;
        } elseif ($q_brand->num_rows() > 0 && !empty($where)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->kumalagroup->update("models", $data, $where);
            $status = 2;
        }
        echo $status;
    }
    function edit($post)
    {
        $where['id'] = $post['id'];
        $data = q_data("*", 'kumalagroup.models', $where)->row();
        $d['brand'] = $data->brand;
        $d['model'] = $data->nama_model;
        echo json_encode($d);
    }
    function hapus($post)
    {
        $where['id'] = $post['id'];
        echo $this->kumalagroup->delete('models', $where) ? 1 : 0;
    }
    function load($post)
    {
        $where['brand'] = $post['brand'];
        $data = q_data("*", 'kumalagroup.models', $where)->result() ?>
        <option value="" selected disabled>-- Silahkan Pilih Model --</option>
        <?php foreach ($data as $v) : ?>
            <option value="<?= $v->id ?>"><?= $v->nama_model ?></option>
<?php endforeach;
    }
}
