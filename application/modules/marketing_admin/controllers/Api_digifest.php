<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_digifest extends \MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        header('Content-Type: application/json');
    }
    public function login()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $q = q_data("*", 'kumk6797_kumalagroup.reg_customer', ['email' => $post['email']]);
                if ($q->num_rows() > 0)
                    $verify = password_verify($post['password'], $q->row('password'));
                if (!empty($verify)) $response = [
                    "status" => "success",
                    "data" => [
                        'id' => $q->row('id'),
                        'nama' => $q->row('nama'),
                        'email' => $q->row('email'),
                    ]
                ];
                else $response = ["status" => "error", "msg" => "Email atau password anda salah"];
                return responseJson($response);
            }
        }
    }
    public function register()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $nama = $post['nama'];
                $email = $post['email'];
                $password = password_hash($post['password'], PASSWORD_DEFAULT);
                $q = q_data("*", 'kumk6797_kumalagroup.reg_customer', ['email' => $email]);
                if ($q->num_rows() == 0) {
                    $kode = $this->generateKode('CS-DG', 'kumk6797_kumalagroup.customer');
                    $this->kumalagroup->trans_start();
                    $data['nama'] = $nama;
                    $data['email'] = $email;
                    $data['password'] = $password;
                    $data['registered_at'] = date('Y-m-d H:i:s');
                    $this->kumalagroup->insert("reg_customer", $data);
                    $data = [];
                    $data['customer'] = $this->kumalagroup->insert_id();
                    $data['kode'] = $kode;
                    $data['telepon'] = $post['telepon'];
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $this->kumalagroup->insert("customer", $data);
                    $this->kumalagroup->trans_complete();
                    $response = $this->kumalagroup->trans_status()
                        ? ["status" => "success", "msg" => "Data berhasil disimpan"]
                        : ["status" => "error", "msg" => "Data gagal disimpan"];
                } else
                    $response = ["status" => "error", "msg" => "Email telah digunakan"];
                return responseJson($response);
            }
        }
    }
    public function lineUp()
    {
        if ($this->m_marketing->auth_api()) {
            $id = q_data("*", 'kumk6797_kumalagroup.brands', ['jenis' => $this->uri->segment(4)])->row('id');
            $id_produk = is_numeric($this->uri->segment(5))
                ? $this->uri->segment(5)
                : q_data_join(
                    ["ku.id"],
                    'kumk6797_kumalagroup.units ku',
                    ['kumk6797_kumalagroup.models km' => "km.id=ku.model"],
                    "km.nama_model like '" . $this->uri->segment(5) . "%' and ku.brand = $id"
                )->row('id');
            if ($this->uri->segment(6)) {
                $response = $this->uri->segment(6) == "360Drive"
                    ? q_data("*", 'kumk6797_kumalagroup.units_detail', ['unit' => $id_produk, 'detail' => $this->uri->segment(6)])->result()
                    : [
                        "interior" => q_data("*", 'kumk6797_kumalagroup.units_detail', ['unit' => $id_produk, 'detail' => "360In"])->result(),
                        "exterior" => q_data("*", 'kumk6797_kumalagroup.units_detail', ['unit' => $id_produk, 'detail' => "360Ex"])->result()
                    ];
            } elseif ($this->uri->segment(5)) {
                $response['detail'] = q_data_join(
                    ["km.nama_model as nama", "ku.*"],
                    'kumk6797_kumalagroup.units ku',
                    ['kumk6797_kumalagroup.models km' => "km.id=ku.model"],
                    ['ku.id' => $id_produk]
                )->row();
                $response['spesifikasi'] =  q_data(
                    "*",
                    'kumk6797_kumalagroup.units_detail',
                    ['unit' => $id_produk, 'detail' => "spek"]
                )->result();
                $response['warna'] =  q_data_join(
                    ["kc.nama_warna", "ku.deskripsi", "ku.gambar"],
                    'kumk6797_kumalagroup.units_detail ku',
                    ['kumk6797_kumalagroup.colors kc' => "kc.id=ku.nama_detail"],
                    ['ku.unit' => $id_produk, 'ku.detail' => "warna"]
                )->result();
            } else {
                $response = q_data_join(
                    ["km.nama_model as nama", "ku.gambar", "ku.harga"],
                    'kumk6797_kumalagroup.units ku',
                    ['kumk6797_kumalagroup.models km' => "km.id=ku.model"],
                    array('ku.brand' => $id, 'ku.is_digifest' => 1),
                    array('km.nama_model', 'asc')
                )->result();
            }
            return responseJson($response);
        }
    }
    public function profil()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if ($post) {
                if (isset($post['gambar'])) {
                    $data_post['name'] = q_data("*", 'kumk6797_kumalagroup.customer', ['customer' => $post['id']])->row('gambar');
                    $data_post['path'] = "./assets/img_marketing/customer/";
                    $q = $this->kumalagroup->update(
                        "customer",
                        ['gambar' => $post['gambar']],
                        ['customer' => $post['id']]
                    );
                    if ($q) {
                        curl_post($this->m_marketing->img_server . "delete_img", $data_post);
                        $response = ["status" => "success", "msg" => "Data berhasil disimpan", "img" => $post['gambar']];
                    } else $response = ["status" => "error", "msg" => "Data gagal disimpan"];
                } elseif (isset($post['password'])) {
                    $password = password_hash($post['password'], PASSWORD_DEFAULT);
                    $response = $this->kumalagroup->update(
                        "reg_customer",
                        ['password' => $password],
                        ['id' => $post['id']]
                    )
                        ? ["status" => "success", "msg" => "Data berhasil disimpan"]
                        : ["status" => "error", "msg" => "Data gagal disimpan"];
                } elseif (isset($post['email'])) {
                    $q = q_data("*", 'kumk6797_kumalagroup.reg_customer', ['id!=' => $post['id'], 'email' => $post['email']]);
                    if ($q->num_rows() == 0) {
                        $this->kumalagroup->update("reg_customer", ['nama' => $post['nama']], ['id' => $post['id']]);
                        $data['tanggal_lahir'] = $post['tanggal_lahir'];
                        $data['jenis_kelamin'] = $post['jenis_kelamin'];
                        $data['agama'] = $post['agama'];
                        $data['alamat'] = $post['alamat'];
                        $data['telepon'] = $post['telepon'];
                        $data['no_npwp'] = $post['no_npwp'];
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        $response = $this->kumalagroup->update("customer", $data, ['customer' => $post['id']])
                            ? ["status" => "success", "msg" => "Data berhasil disimpan"]
                            : ["status" => "error", "msg" => "Data gagal disimpan"];
                    } else $response = ["status" => "error", "msg" => "Email telah digunakan"];
                }
            } else {
                $response = q_data_join(
                    "*",
                    "kumalagroup.reg_customer rc",
                    ['kumk6797_kumalagroup.customer c' => "c.customer=rc.id"],
                    ['rc.id' => $this->uri->segment(4)]
                )->row();
            }
            return responseJson($response);
        }
    }

    public function main_stage()
    {
        if ($this->m_marketing->auth_api()) {
            $response = q_data("*", 'kumk6797_kumalagroup.main_stage', ['id' => 1])->row();
            return responseJson($response);
        }
    }
    public function rundown()
    {
        if ($this->m_marketing->auth_api()) {
            $q = q_data("*", 'kumk6797_kumalagroup.rundown', "waktu like '" . $this->uri->segment(4) . "%'", ["waktu", "asc"])->result();
            foreach ($q as $v) {
                $date = explode(" ", $v->waktu);
                $response[] = [
                    "id" => $v->id,
                    "tanggal" => tgl_sql($date[0]),
                    "waktu" => date('H:i', strtotime($date[1])),
                    "judul" => $v->judul
                ];
            }
            return responseJson($response);
        }
    }
    public function cart()
    {
        if ($this->m_marketing->auth_api()) {
            $post = $this->input->post();
            if ($post) {
                if ($post['method'] == 'post') {
                    $where = $post['unit'];
                    $data['jumlah'] = $post['jumlah'];
                    $data['customer'] = $post['customer'];
                    $q = q_data("*", 'kumk6797_kumalagroup.keranjang', ['unit' => $where, 'customer' => $post['customer'], 'status' => 0]);
                    if ($q->num_rows() > 0)
                        $response = $this->kumalagroup->update('keranjang', $data, ['unit' => $where, 'customer' => $post['customer']])
                            ? ["status" => "success", "msg" => "Data berhasil diupdate", "id" => $q->row('id')]
                            : ["status" => "error", "msg" => "Data gagal diupdate"];
                    else {
                        $data['unit'] = $post['unit'];
                        $response = $this->kumalagroup->insert('keranjang', $data)
                            ? ["status" => "success", "msg" => "Data berhasil disimpan", "id" => $this->kumalagroup->insert_id()]
                            : ["status" => "error", "msg" => "Data gagal disimpan"];
                    }
                } elseif ($post['method'] == 'delete') {
                    $response = $this->kumalagroup->delete('keranjang', ['id' => $post['id']])
                        ? ["status" => "success", "msg" => "Data berhasil dihapus"]
                        : ["status" => "error", "msg" => "Data gagal dihapus"];
                }
            } else {
                if ($this->uri->segment(4)) {
                    $response = q_data_join(
                        "k.id,k.unit,b.jenis as brand,m.nama_model as model,k.jumlah",
                        'kumk6797_kumalagroup.keranjang k',
                        [
                            'kumk6797_kumalagroup.units u' => "u.id=k.unit",
                            'kumk6797_kumalagroup.brands b' => "u.brand=b.id",
                            'kumk6797_kumalagroup.models m' => "u.model=m.id"
                        ],
                        ['customer' => $this->uri->segment(4), 'status' => 0],
                        ['b.jenis', 'asc']
                    )->result();
                } else $this->m_marketing->error404();
            }
            return responseJson($response);
        }
    }
    public function provinsi()
    {
        if ($this->m_marketing->auth_api()) {
            $q = q_data("*", 'db_honda.provinsi', [], ["nama", "asc"])->result();
            foreach ($q as $v) {
                $response[] = [
                    "id" => $v->id_provinsi,
                    "text" => $v->nama
                ];
            }
            return responseJson($response);
        }
    }
    public function checkout()
    {
        if ($this->m_marketing->auth_api()) {
            $post = (object) $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $kode = $this->generateKode('INV-DG', 'kumk6797_kumalagroup.checkout', $post->kd);

                $diskon = q_data('*', 'kumk6797_kumalagroup.masterSet', array('item' => 'diskon'))->result();
                $hariIni = date('Y-m-d');
                $tanggalAwal = tgl_sql($diskon[0]->val);
                $tanggalAkhir = tgl_sql($diskon[1]->val);
                $persen = $diskon[2]->val / 100;
                $batas = remove_separator($diskon[3]->val);
                if ($hariIni >= $tanggalAwal && $hariIni <= $tanggalAkhir) {
                    $potongan = remove_separator($post->uang_muka) * $persen;
                    if ($potongan > $batas) {
                        $potongan = $batas;
                    }
                } else {
                    $potongan = 0;
                }
                $this->kumalagroup->trans_start();
                $data = array(
                    "kode" => $kode . '-' . date('m') . '-' . date('Y'),
                    "customer" => $post->customer,
                    "provinsi" => $post->provinsi,
                    "uang_muka" => remove_separator($post->uang_muka),
                    "diskon" => $potongan,
                    "cabang_tujuan" => $post->cabang_tujuan,
                    "foto_ktp" => $post->foto_ktp ?? "",
                    // "foto_kk" => $post->foto_kk ?? "",
                    // "foto_reklis" => $post->foto_reklis ?? "",
                    "created_at" => date('Y-m-d H:i:s')
                );
                $this->kumalagroup->insert('checkout', $data);
                foreach (json_decode(base64_decode($post->query)) as $value) {
                    $this->kumalagroup->update(
                        'keranjang',
                        ['kode_checkout' => $data['kode'], 'status' => 1],
                        ['id' => $value]
                    );
                }

                $this->kumalagroup->trans_complete();
                $response = $this->kumalagroup->trans_status()
                    ? ["status" => "success", "msg" => "Data berhasil disimpan", 'kdinvdg' => $data['kode']]
                    : ["status" => "error", "msg" => "Data gagal disimpan"];
                return responseJson($response);
            }
        }
    }

    public function riwayat()
    {
        if ($this->m_marketing->auth_api()) {
            if ($this->uri->segment(5)) {
                $kdinvdg = json_decode(base64_decode($this->uri->segment(5)));
                $detail = q_data_join(
                    "c.kode,rc.nama,rc.email,cs.telepon,p.nama as provinsi,c.uang_muka,
                    c.diskon,c.status,c.created_at,b.jenis,c.cabang_tujuan",
                    'kumk6797_kumalagroup.checkout c',
                    [
                        'kumk6797_kumalagroup.reg_customer rc' => "rc.id=c.customer",
                        'kumk6797_kumalagroup.customer cs' => "rc.id=cs.customer",
                        'db_honda.provinsi p' => "p.id_provinsi=c.provinsi",
                        'kmg.perusahaan kp' => 'kp.id_perusahaan=c.cabang_tujuan',
                        'kumk6797_kumalagroup.brands b' => 'b.id=kp.id_brand'
                    ],
                    ['c.kode' => $kdinvdg[0]]
                )->row();
                $dbname = dbname($detail->jenis);
                $rekening = q_data_join(
                    "*",
                    $dbname . '.bank b',
                    ['kmg.perusahaan p' => 'b.id_perusahaan=p.id_perusahaan'],
                    "b.jenis = 'penr_unit' AND b.bank LIKE 'MCU%' AND b.bank NOT LIKE '%LAMA%'
                    AND b.bank NOT LIKE 'MCU HO%' AND b.id_perusahaan={$detail->cabang_tujuan}"
                )->row();
                $result = q_data_join(
                    "k.id,k.unit,b.jenis as brand,m.nama_model as model,k.jumlah",
                    'kumk6797_kumalagroup.keranjang k',
                    [
                        'kumk6797_kumalagroup.units u' => "u.id=k.unit",
                        'kumk6797_kumalagroup.brands b' => "u.brand=b.id",
                        'kumk6797_kumalagroup.models m' => "u.model=m.id"
                    ],
                    ['k.kode_checkout' => $kdinvdg[0], 'k.status' => 1],
                    'k.id'
                )->result();
                $response = compact('detail', 'rekening', 'result');
                return responseJson($response);
            } else {
                $select = array(
                    null, 'kode', '(select count(id) from kumalagroup.keranjang 
                    where kode_checkout=kumalagroup.checkout.kode) as item',
                    'uang_muka', 'status', 'diskon'
                );
                $table  = 'kumk6797_kumalagroup.checkout';
                $where = array('customer' => $this->uri->segment(4));
                $list = q_data_datatable($select, $table, null, $where, null, array('id', 'desc'));
                $response = array();
                foreach ($list as $key => $value) {
                    $uangMuka = $value->uang_muka - $value->diskon;
                    array_push($response, array(
                        'kode' => $value->kode,
                        'item' => $value->item,
                        'uangMuka' => separator_harga($value->uang_muka),
                        'potongan' => separator_harga($uangMuka),
                        'status' => $value->status
                    ));
                }
                echo q_result_datatable($select, $table, null, $where, $response ?? array());
            }
        }
    }

    public function cabang()
    {
        if ($this->m_marketing->auth_api()) {
            $dbname = dbname($this->uri->segment(4));
            $q = q_data_join(
                "*",
                $dbname . '.bank b',
                ['kmg.perusahaan p' => 'b.id_perusahaan=p.id_perusahaan'],
                "b.jenis = 'penr_unit' AND b.bank LIKE 'MCU%' AND b.bank NOT LIKE 'MCU HO%'",
                null,
                'b.id_perusahaan'
            )->result();
            foreach ($q as $v) {
                $response[] = [
                    "id" => $v->id_perusahaan,
                    "text" => $v->lokasi . ' - ' . $v->nama_perusahaan
                ];
            }
            return responseJson($response);
        }
    }

    public function confirm()
    {
        if ($this->m_marketing->auth_api()) {
            $post = (object) $this->input->post();
            if (!$post) $this->m_marketing->error404();
            else {
                $this->kumalagroup->trans_start();
                $data = array(
                    'kode_checkout' => $post->kode,
                    'tanggal_bayar' => tgl_sql($post->tanggal_bayar),
                    'nama_bank' => $post->nama_bank,
                    'nama_rekening' => $post->nama_rekening,
                    'bukti_bayar' => $post->bukti_bayar,
                    "created_at" => date('Y-m-d H:i:s')
                );
                $this->kumalagroup->insert('konfirmasi_pembayaran', $data);
                $this->kumalagroup->update(
                    'checkout',
                    array('status' => 1, 'updated_at' => date('Y-m-d H:i:s')),
                    array('kode' => $post->kode)
                );

                //notifikasi
                $data = array(
                    'judul' => 'Konfirmasi Transaksi',
                    'deskripsi' => $post->kode . ', ' . $post->nama_bank . ' - ' . $post->nama_rekening,
                    'status' => 0,
                    'link' => 'virtual_fair/list_transaksi',
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->kumalagroup->insert("notification", $data);

                $this->kumalagroup->trans_complete();
                $response = $this->kumalagroup->trans_status()
                    ? array("status" => "success", "msg" => "Data berhasil disimpan")
                    : array("status" => "error", "msg" => "Data gagal disimpan");
                return responseJson($response);
            }
        }
    }

    public function bgLogin()
    {
        if ($this->m_marketing->auth_api()) {
            $bg = $this->kumalagroup->query("SELECT * FROM background WHERE kd_bg = 'BG-LOGIN'")->row();
            return responseJson($bg);
        }
    }

    public function bgMainStage()
    {
        if ($this->m_marketing->auth_api()) {
            $bg = $this->kumalagroup->query("SELECT * FROM background WHERE kd_bg = 'BG-MAIN'")->row();
            return responseJson($bg);
        }
    }

    public function visitorCounter()
    {
        if ($this->m_marketing->auth_api()) {
            $post = (object) $this->input->post();
            $where = array(
                'customer' => $post->customer,
                'ip_address' => $post->ipAddress,
                'browser' => $post->browser,
                'tanggal' => date('Y-m-d')
            );
            $q = q_data("*", 'kumk6797_kumalagroup.visitor', $where);
            if ($q->num_rows() > 0) {
                $this->kumalagroup->update('visitor', array(
                    'visit' => $q->row('visit') + 1
                ), $where);
            } else {
                $data = array(
                    'ip_address' => $post->ipAddress,
                    'tanggal' => date('Y-m-d'),
                    'browser' => $post->browser,
                    'customer' => $post->customer,
                    'visit' => 1
                );
                $this->kumalagroup->insert('visitor', $data);
            }
            $response = $this->kumalagroup->affected_rows()
                ? array('status' => 'success')
                : array('status' => 'error');
            return responseJson($response);
        }
    }

    function generateKode($kode, $table, $randKode = null)
    {
        $count = '0001';
        $response = q_data("*", $table, null, 'id');
        if ($response->num_rows() > 0) {
            $raw = explode('-', $response->row('kode'));
            $count = sprintf("%04s", (int)$raw[0] + 1);
        }
        $rand = $randKode ?? $this->m_marketing->generate_kode(4);
        $generated = $count . '-' . $kode . '-' . $rand;
        return $generated;
    }
}
