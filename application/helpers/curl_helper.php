<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Http\Request;

defined('BASEPATH') or exit('No direct script access allowed');

function curl_post($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $r = curl_exec($curl);
    curl_close($curl);
    return $r;
}

function curl_get($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $r = curl_exec($curl);
    curl_close($curl);
    return $r;
}

// created by Gaza

//get list data dengan satu table
//set null where jika tidak ada
function q_data($select, $table, $where, $order = false, $group = false, $limit = false)
{
    $ci = &get_instance();
    $ci->db->select($select);
    $ci->db->from($table);
    if (!empty($order)) {
        is_array($order) ? $ci->db->order_by($order[0], $order[1]) : $ci->db->order_by($order, 'desc');
    }
    if (!empty($group)) $ci->db->group_by($group);
    if (!empty($where)) $ci->db->where($where);
    if (!empty($limit)) {
        $limit = strpos($limit, ',') ? explode(",", $limit) : $limit;
        is_array($limit) ? $ci->db->limit($limit[0], $limit[1]) : $ci->db->limit($limit);
    }
    return $ci->db->get();
}

//get list data dengan table join
//set null where jika tidak ada
function q_data_join($select, $table, $join, $where, $order = false, $group = false, $limit = false)
{
    $ci = &get_instance();
    $ci->db->select($select);
    $ci->db->from($table);
    foreach ($join as $table_join => $where_join)
        $ci->db->join($table_join, $where_join, 'left');
    if (!empty($order)) {
        is_array($order) ? $ci->db->order_by($order[0], $order[1]) : $ci->db->order_by($order, 'desc');
    }
    if (!empty($group)) $ci->db->group_by($group);
    if (!empty($where)) $ci->db->where($where);
    if (!empty($limit)) {
        $limit = strpos($limit, ',') ? explode(",", $limit) : $limit;
        is_array($limit) ? $ci->db->limit($limit[0], $limit[1]) : $ci->db->limit($limit);
    }
    return $ci->db->get();
}

//untuk datatable versi 1.10

//get list data datatable dengan satu table
//set null where jika tidak ada
function q_datatable($select, $table, $where, $group = false)
{
    $ci = &get_instance();
    $ci->load->library('datatables');
    $ci->datatables->select($select)->from($table);
    if (!empty($group)) $ci->datatables->group_by($group);
    if (!empty($where)) $ci->datatables->where($where);
    return $ci->datatables->generate();
}

//get list data datatable dengan table join
//set null where jika tidak ada
function q_datatable_join($select, $table, $join, $where, $group = false)
{
    $ci = &get_instance();
    $ci->load->library('datatables');
    $ci->datatables->select($select)->from($table);
    foreach ($join as $table_join => $where_join)
        $ci->datatables->join($table_join, $where_join, 'left');
    if (!empty($group)) $ci->datatables->group_by($group);
    if (!empty($where)) $ci->datatables->where($where);
    return $ci->datatables->generate();
}

//get list data yang ingin di masukkan kedalam format datatable
//set null join jika hanya satu table
//set null where jika tidak ada
function q_data_datatable($select, $table, $join, $where, $group = false, $order = false, $inner = false)
{

    $ci = &get_instance();

    foreach ($select as $v) {
        if (empty($v)) continue;
        $_select[] = $v;
    }

    $ci->db->select($_select);
    $ci->db->from($table);
    if (!empty($join)) foreach ($join as $table_join => $where_join)
        $ci->db->join($table_join, $where_join, $inner ? null : 'left');
    if (!empty($group)) $ci->db->group_by($group);
    if (!empty($where)) $ci->db->where($where);

    foreach ($select as $v)
        $column[] = strpos($v, ' as ') ? substr($v, 0, strpos($v, ' as ')) : $v;
    foreach ($column as $v) {
        if (empty($v)) continue;
        $_column[] = $v;
    }

    foreach ($_column as $i => $v) {
        if ($_POST['search']['value']) {
            if ($i === 0) {
                $ci->db->group_start();
                $ci->db->like($v, $_POST['search']['value']);
            } else
                $ci->db->or_like($v, $_POST['search']['value']);
            if (count($_column) - 1 == $i)
                $ci->db->group_end();
        }
    }
    if (isset($_POST['order']))
        $ci->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    else if (isset($order))
        is_array($order) ? $ci->db->order_by($order[0], $order[1]) : $ci->db->order_by($order);
    if ($_POST['length'] != -1)
        $ci->db->limit($_POST['length'], $_POST['start']);
    return $ci->db->get()->result();
}

//menampilkan data dalam format datatable
//set null join jika hanya satu table
//set null where jika tidak ada
function q_result_datatable($select, $table, $join, $where, $data, $group = false, $inner = false)
{
    $ci = &get_instance();

    foreach ($select as $v) {
        if (empty($v)) continue;
        $_select[] = $v;
    }

    //menghitung total data
    $ci->db->select($_select);
    $ci->db->from($table);
    if (!empty($join)) foreach ($join as $table_join => $where_join)
        $ci->db->join($table_join, $where_join, $inner ? null : 'left');
    if (!empty($group)) $ci->db->group_by($group);
    if (!empty($where)) $ci->db->where($where);
    $recordsTotal = $ci->db->count_all_results();

    //menghitung total data jika difilter pencarian data
    $ci->db->select($_select);
    $ci->db->from($table);
    if ($join) foreach ($join as $table_join => $where_join)
        $ci->db->join($table_join, $where_join, $inner ? null : 'left');
    if (!empty($group)) $ci->db->group_by($group);
    if (!empty($where)) $ci->db->where($where);

    foreach ($select as $v)
        $column[] = strpos($v, ' as ') ? substr($v, 0, strpos($v, ' as ')) : $v;
    foreach ($column as $v) {
        if (empty($v)) continue;
        $_column[] = $v;
    }

    foreach ($_column as $i => $v) {
        if ($_POST['search']['value']) {
            if ($i === 0) {
                $ci->db->group_start();
                $ci->db->like($v, $_POST['search']['value']);
            } else
                $ci->db->or_like($v, $_POST['search']['value']);
            if (count($_column) - 1 == $i)
                $ci->db->group_end();
        }
    }
    $recordsFiltered = $ci->db->get()->num_rows();

    //membuat format data untuk datatable
    $result['draw']            = $_POST['draw'];
    $result['recordsTotal']    = $recordsTotal;
    $result['recordsFiltered'] = $recordsFiltered;
    $result['data']            = $data;
    return json_encode($result, JSON_PRETTY_PRINT);
}

function response($content = '', $status = 200, array $headers = [])
{
    (new \Illuminate\Http\Response($content, $status, $headers))->send();
}

function responseJson($data = null, $status = 200, $headers = [], $options = 0)
{
    (new \Illuminate\Http\JsonResponse($data, $status, $headers, $options))->send();
}

function dbname($uri)
{
    switch ($uri) {
        case 'hino':
            return 'db_hino';
        case 'honda':
            return 'db_honda';
        case 'mercedes-benz':
            return 'db_mercedes';
        case 'mazda':
            return 'db_mazda';
        case 'wuling':
            return 'db_wuling';
    }
}

function dataDaysOfMonth($year, $month, array $query)
{
    $firstDayOfMonth = date('Y-m-d', strtotime($year . '-' . $month . '-01'));
    $query = implode(',', $query);

    $dataLength = 'SELECT 0 AS a';
    for ($i = 1; $i < date('t', strtotime($firstDayOfMonth)); $i++) {
        $dataLength .= ' UNION ALL SELECT ' . $i;
    }

    return DB::select('SELECT ' . $query . ' 
    FROM ( SELECT @firstDate + INTERVAL a.a DAY AS thisDate FROM ( ' . $dataLength . ' ) AS a 
        CROSS JOIN( SELECT @firstDate := \'' . $firstDayOfMonth . '\', @lastDate := LAST_DAY(\'' . $firstDayOfMonth . '\') ) AS b ) AS a 
    WHERE thisDate BETWEEN @firstDate AND @lastDate ORDER BY thisDate');
}

function dataMonthsOfYear($year, array $query)
{
    $firstDate = date('Y-m-d', strtotime($year . '-01-01'));
    $lastDate = date('Y-m-d', strtotime($year . '-12-01'));
    $query = implode(',', $query);

    $dataLength = 'SELECT 0 AS a';
    for ($i = 1; $i < 12; $i++) {
        $dataLength .= ' UNION ALL SELECT ' . $i;
    }

    return DB::select('SELECT YEAR(thisDate) AS thisYear, MONTH(thisDate) AS thisMonth, ' . $query . ' 
    FROM ( SELECT @firstDate + INTERVAL a.a MONTH AS thisDate FROM ( ' . $dataLength . ' ) AS a 
        CROSS JOIN( SELECT @firstDate := \'' . $firstDate . '\', @lastDate := LAST_DAY(\'' . $lastDate . '\') ) AS b ) AS a 
    WHERE thisDate BETWEEN @firstDate AND @lastDate ORDER BY thisDate');
}

function dataYears($firstYear, $lastYear, array $query)
{
    $firstDate = date('Y-m-d', strtotime($firstYear . '-01-01'));
    $lastDate = date('Y-m-d', strtotime($lastYear . '-12-01'));
    $query = implode(',', $query);

    $diff = $lastYear - $firstYear + 1;
    $dataLength = 'SELECT 0 AS a';
    for ($i = 1; $i < $diff; $i++) {
        $dataLength .= ' UNION ALL SELECT ' . $i;
    }

    return DB::select('SELECT YEAR(thisDate) AS thisYear, ' . $query . ' 
    FROM ( SELECT @firstDate + INTERVAL a.a YEAR AS thisDate FROM ( ' . $dataLength . ' ) AS a 
        CROSS JOIN( SELECT @firstDate := \'' . $firstDate . '\', @lastDate := LAST_DAY(\'' . $lastDate . '\') ) AS b ) AS a 
    WHERE thisDate BETWEEN @firstDate AND @lastDate ORDER BY thisDate');
}


function datatablesOf($query, array $columns, array $order = null)
{
    $request = Request::capture();

    $recordsTotal = $query->count();
    $filter = clone $query;

    $filter = $filter->where(function ($query) use ($request, $columns) {
        foreach ($columns as $key => $value) {
            if (isset($value)) {
                if (is_array($value)) {
                    $column = $value[0];
                } else {
                    $column = $value;
                }

                $query->orWhereRaw($column . ' like \'%' . $request->search['value'] . '%\'');
            }
        }
    });

    $recordsFiltered = $filter->count();

    if ($request->order) {
        if (is_array($columns[$request->order['0']['column']])) {
            $column = $columns[$request->order['0']['column']][1];
        } else {
            $column = $columns[$request->order['0']['column']];
        }

        $filter =  $filter->orderByRaw($column . ' ' . $request->order['0']['dir']);
    } elseif (isset($order)) {
        $filter = $filter->orderByRaw($order[0] . ' ' . $order[1]);
    }

    if ($request->length != -1) {
        $filter = $filter->skip($request->start)->take($request->length);
    }

    $data = $filter->get()->toArray();

    $result = array(
        'draw'            => $request->draw,
        'recordsTotal'    => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data'            => $data
    );

    return $result;
}

function encrypter($value = null, $type = 'encrypt')
{
    $chiper = "AES-256-CBC";
    $secret_key = 'Encrypter Parsed by Gaza';
    $secret_iv = 'Costum Encrypter';

    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($type === 'decrypt') {
        $decryptString = base64_decode($value);
        return openssl_decrypt($decryptString, $chiper, $key, 0, $iv);
    }

    $encryptString = openssl_encrypt($value, $chiper, $key, 0, $iv);
    return base64_encode($encryptString);
}

function cekDbError($req)
{
    $ci = &get_instance();
    if (!$req) {
        $error = (object) $ci->db->error();
        throw new Exception($error->message, $error->code);
    }
}

function generateKode($length = null)
{
    $token = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $token = substr(str_shuffle($token), 0, $length ?? 10);
    return $token;
}
