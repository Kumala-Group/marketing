<?php
defined('BASEPATH') or exit('No direct script access allowed');

function GenerateCode($database, $table, $colom, $case)
{
    $ci = &get_instance();
    $ci->$database->select($colom);
    $ci->$database->from($table);
    $number = $ci->$database->get()->num_rows() + 1;
    $case = $case;
    $result = $case . "" . $number;
    return $result;
}

function keyAndRulesFailValidate($validator)
{
    $key = array_keys($validator->errors()->toArray())[0];
    $role = array_keys($validator->errors()->toArray()[$key])[0];
    $result = "{$key}.{$role}";
    return $result;
}

function cek_duplikat($database, $table, $colom, $where, $data)
{
    $ci = &get_instance();
    $ci->$database->select($colom);
    $ci->$database->from($table);
    if (is_array($where)) {
        $hitung = count($where);
        for ($i = 0; $i < $hitung; $i++) {
            $ci->$database->where($where[$i], $data[$i]);
        }
    } else {
        $ci->$database->where($where, $data);
    }
    $cek = $ci->$database->get()->num_rows();
    return $cek;
}

function delete_data($database, $table, $colom, $where)
{
    $ci = &get_instance();
    $ci->$database->where($colom, $where);
    $ci->$database->delete($table);
}

function v_all($database, $select, $table)
{
    $ci = &get_instance();
    $ci->$database->select($select);
    $ci->$database->from($table);
    $data = $ci->$database->get();
    return $data->result();
}

function v_like($database, $select, $table, $c_like, $group_by, $v_like)
{
    $ci = &get_instance();
    $ci->$database->select($select);
    $ci->$database->from($table);
    $ci->$database->like($c_like, $v_like);
    if (empty($group_by)) {
        null;
    } else {
        $ci->$database->group_by($group_by);
    }
    $data = $ci->$database->get();
    return $data->result();
}

function v_where($database, $select, $table, $c_where, $v_where)
{
    $ci = &get_instance();
    $ci->$database->select($select);
    $ci->$database->from($table);
    $ci->$database->where($c_where, $v_where);
    $data = $ci->$database->get();
    foreach ($data->result() as $row) {
        $return = $row->$select;
    }
    if (empty($return)) {
        $return = null;
    }
    return $return;
}

function v_where_2(string $database, string $table, array $where)
{
    $ci = &get_instance();
    $query = $ci->$database->get_where($table, $where);
    return $query;
}

function v_where_all($database, $select, $table, $c_where, $v_where)
{
    $ci = &get_instance();
    $ci->$database->select($select);
    $ci->$database->from($table);
    $ci->$database->where($c_where, $v_where);
    $data = $ci->$database->get();
    return $data->result();
}

function notif_kesalahan($pesan_error, $replace_lokasi)
{
    echo "<script>";
    echo "alert('" . $pesan_error . "');";
    echo "location.replace('" . $replace_lokasi . "');";
    echo "</script>";
    exit;
}

function profil_karyawan(int $nik): object
{
    $CI = &get_instance();
    $query = $CI->db->get_where('karyawan', array('nik' => $nik));
    return $query->row();
}

function hash_encode($string)
{
    error_reporting(0);
    $key = "ITDepartmentOfKumalaGroup";
    $encrypted = bin2hex(openssl_encrypt($string, 'AES-128-CBC', $key));
    return $encrypted;
}

function hash_decode($string)
{
    error_reporting(0);
    $key = "ITDepartmentOfKumalaGroup";
    $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-CBC', $key);
    return $decrypted;
}

function cek_closing($db, $tanggal, $id_perusahaan)
{
    $arr = explode("-", $tanggal);
    $closing = q_data("bln,thn", "$db.closing_ltb", "id_perusahaan=$id_perusahaan", "id_closing", null, 1)->row();
    if ($arr[1] <= $closing->bln && $arr[0] < $closing->thn) {
        die("Maaf, Transaksi dibulan yang anda pilih telah diclose.");
    } else {
        return true;
    }
}

function getNoInvCustomerHonda($no_wo)
{
    // apa bila sudah di cetak
    $CI = get_instance();
    $cek_no_wo_dibuku_besar = $CI->db_honda->get_where('buku_besar', array('no_transaksi' => $no_wo, 'jb' => '0'), 1)->num_rows();
    if ($cek_no_wo_dibuku_besar > 0) {
        return $no_wo;
    } else {
        $cek_no_wo_invoice = $CI->db_honda_as->get_where('invoice_after_sales', array('no_ref' => $no_wo));
        foreach ($cek_no_wo_invoice->result() as $row) {
            if (strpos($row->no_invoice, 'CLM') !== false) {
                null;
            } else {
                $no_inv[] = $row->no_invoice;
            }
        }
        if (empty($no_inv)) {
            $statusCetak = $CI->db_honda_as->get_where('work_order', array('no_wo' => $no_wo))->row("cetak_invoice");
            if ($statusCetak == "y") {
                die("Maaf, terjadi kesalahan, status cetak invoice y, tetapi no invoice tidak ditemukan");
            } else {
                return null;
            }
        } else {
            if (count($no_inv) > 1) {
                die("No invoice WO {$no_wo} customer lebih dari 1");
            } else {
                $cek_no_inv_di_bb = $CI->db_honda->get_where('buku_besar', array('no_transaksi' => $no_inv[0], 'jb' => '0'))->num_rows();
                if ($cek_no_inv_di_bb > 0) {
                    return $no_inv[0];
                } else {
                    die("No invoice ada, tapi tidak terjurnal " . $no_wo);
                }
            }
        }
    }
}

function getNoInvCustomerMercedes($no_wo)
{
    // apa bila sudah di cetak
    $CI = get_instance();
    $cek_no_wo_dibuku_besar = $CI->db_mercedes->get_where('buku_besar', array('no_transaksi' => $no_wo, 'jb' => '0'), 1)->num_rows();
    if ($cek_no_wo_dibuku_besar > 0) {
        return $no_wo;
    } else {
        $cek_no_wo_invoice = $CI->db_mercedes_as->get_where('invoice_after_sales', array('no_ref' => $no_wo));
        foreach ($cek_no_wo_invoice->result() as $row) {
            if (strpos($row->no_invoice, 'CLM') !== false) {
                null;
            } else {
                $no_inv[] = $row->no_invoice;
            }
        }
        if (empty($no_inv)) {
            $statusCetak = $CI->db_mercedes_as->get_where('work_order', array('no_wo' => $no_wo))->row("cetak_invoice");
            if ($statusCetak == "y") {
                die("Maaf, terjadi kesalahan, status cetak invoice y, tetapi no invoice tidak ditemukan");
            } else {
                return null;
            }
        } else {
            if (count($no_inv) > 1) {
                die("No invoice WO {$no_wo} customer lebih dari 1");
            } else {
                $cek_no_inv_di_bb = $CI->db_mercedes->get_where('buku_besar', array('no_transaksi' => $no_inv[0], 'jb' => '0'))->num_rows();
                if ($cek_no_inv_di_bb > 0) {
                    return $no_inv[0];
                } else {
                    die("No invoice ada, tapi tidak terjurnal " . $no_wo);
                }
            }
        }
    }
}

function getNoInvClaimHonda($no_wo)
{
    // apa bila sudah di cetak
    $CI = get_instance();
    $cek_no_wo_dibuku_besar = $CI->db_honda->get_where('buku_besar', array('no_transaksi' => $no_wo, 'jb' => '0'), 1)->num_rows();
    if ($cek_no_wo_dibuku_besar > 0) {
        return $no_wo; /* Berarti no invoicenya masih gabung antara claim dan non claim */
    } else {
        $cek_no_wo_invoice = $CI->db_honda_as->get_where('invoice_after_sales', array('no_ref' => $no_wo));
        foreach ($cek_no_wo_invoice->result() as $row) {
            if (strpos($row->no_invoice, 'CLM') !== false) {
                $no_inv[] = $row->no_invoice;
            } else {
                null;
            }
        }
        if (empty($no_inv)) {
            return null;
        } else {
            if (count($no_inv) > 1) {
                die("No invoice customer lebih dari 1");
            } else {
                $cek_no_inv_di_bb = $CI->db_honda->get_where('buku_besar', array('no_transaksi' => $no_inv[0], 'jb' => '0'))->num_rows();
                if ($cek_no_inv_di_bb > 0) {
                    return $no_inv[0];
                } else {
                    die("No invoice ada, tapi tidak terjurnal " . $no_wo);
                }
            }
        }
    }
}

function getNoInvClaimMercedes($no_wo)
{
    // apa bila sudah di cetak
    $CI = get_instance();
    $cek_no_wo_dibuku_besar = $CI->db_mercedes->get_where('buku_besar', array('no_transaksi' => $no_wo, 'jb' => '0'), 1)->num_rows();
    if ($cek_no_wo_dibuku_besar > 0) {
        return $no_wo; /* Berarti no invoicenya masih gabung antara claim dan non claim */
    } else {
        $cek_no_wo_invoice = $CI->db_mercedes_as->get_where('invoice_after_sales', array('no_ref' => $no_wo));
        foreach ($cek_no_wo_invoice->result() as $row) {
            if (strpos($row->no_invoice, 'CLM') !== false) {
                $no_inv[] = $row->no_invoice;
            } else {
                null;
            }
        }
        if (empty($no_inv)) {
            return null;
        } else {
            if (count($no_inv) > 1) {
                die("No invoice customer lebih dari 1");
            } else {
                $cek_no_inv_di_bb = $CI->db_mercedes->get_where('buku_besar', array('no_transaksi' => $no_inv[0], 'jb' => '0'))->num_rows();
                if ($cek_no_inv_di_bb > 0) {
                    return $no_inv[0];
                } else {
                    die("No invoice ada, tapi tidak terjurnal " . $no_wo);
                }
            }
        }
    }
}

function jsonResponseFormFail($message, $inputRef)
{
    header('Content-Type: application/json');
    $err["status"] = "fail";
    $err["message"] = $message;
    $err["inputRef"] = $inputRef;
    die(json_encode($err));
}

function jsonResponse($status, $message, $ket)
{
    header('Content-Type: application/json');
    $result["status"] = $status;
    $result["message"] = $message;
    $result["ket"] = $ket;
    die(json_encode($result));
}

function encrypt_decrypt($action, $string)
{
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'birakomputer';
    $secret_iv = 'komputerbira';
    // hash
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

class SimpleResponse
{
    private $outp = array('status' => false, 'message' => '', 'data' => array());
    public function __construct($status = false)
    {
        header('Content-Type: application/json, charset=utf-8');
        $this->outp['status'] = $status;
    }
    function true()
    {
        $this->outp['status'] = true;
    }
    function false()
    {
        $this->outp['status'] = false;
    }
    function message($message)
    {
        $this->outp['message'] = $message;
    }
    function process($data)
    {
        $this->data($data);
        if ($this->outp['data'] == null) {
            $this->false();
        } else {
            $this->true();
        }
    }
    function data($data)
    {
        $this->outp['data'] = $data;
    }
    function success($data = [], $message = '')
    {
        $this->outp['status'] = true;
        $this->outp['message'] = $message == '' ? $this->outp['message'] : $message;
        $this->outp['data'] = $data == [] ? $this->outp['data'] : $data;
        http_response_code(200);
        die(json_encode($this->outp));
    }
    function failed()
    {
        http_response_code(200);
        $this->outp['message'] = 'Failed on SimpleResponse';
        die(json_encode($this->outp));
    }
    function end()
    {
        if ($this->outp['status']) {
            $this->success();
        } else {
            $this->failed();
        }
    }
}
