<?php
/* Created by GAZA */

namespace app\libraries;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Http\Request;

class Datatable
{
    public $query;

    private $columns = [];
    private $orderBy;
    private $recordsTotal;
    private $recordsFiltered;
    private $recordsData;
    private $request;

    public function __construct()
    {
        $this->request = Request::capture();
    }

    public function setColumns()
    {
        $this->columns = func_get_args();
        return $this;
    }

    public function orderBy(string $orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function get()
    {
        $this->generate();
        return $this->produceOutput();
    }

    public function getJson()
    {
        $this->generate();
        return $this->produceOutput(true);
    }

    private function generate()
    {
        if (empty($this->query)) {
            throw new Exception('Error Processing Request. Variabel $query tidak boleh kosong.');
        }
        if (empty($this->columns)) {
            throw new Exception('Error Processing Request. Variabel $columns tidak boleh kosong, gunakan fungsi setColumns.');
        }
        if (is_string($this->query)) {
            $this->stringQuery();
        } else {
            try {
                $this->codeigniterQuery();
            } catch (\Throwable $th) {
                $this->laravelOrEloquentQuery();
            }
        }
    }

    private function stringQuery()
    {
        $select      = $this->cekString('SELECT ');
        $from        = $this->cekString(' FROM ', 'last');
        $length      = strripos($this->query, $from, $offset = strlen($select)) - $offset;
        $parsed      = substr($this->query, $offset, $length);
        $queryCount  = str_replace($parsed, 'COUNT(*) AS count', $this->query);
        $queryFilter = '';
        $queryOrder  = '';
        foreach ($columnsSearch = array_values(array_filter($this->columns)) as $key => $value) {
            if (is_array($value)) {
                $column = $value[0];
            } else {
                $column = $value;
            }
            if ($key === 0) {
                $queryFilter .= ' AND (';
                $queryFilter .= $column . ' LIKE \'%' . $this->request->search['value'] . '%\'';
            } else {
                $queryFilter .= ' OR ' . $column . ' LIKE \'%' . $this->request->search['value'] . '%\'';
            }
            if (count($columnsSearch) - 1 === $key) {
                $queryFilter .= ')';
            }
        }
        if ($this->request->order) {
            if (is_array($this->columns[$this->request->order['0']['column']])) {
                $column = $this->columns[$this->request->order['0']['column']][1];
            } else {
                $column = $this->columns[$this->request->order['0']['column']];
            }
            $queryOrder = ' ORDER BY ' . $column . ' ' . $this->request->order['0']['dir'];
        } elseif (!empty($this->orderBy)) {
            $queryOrder = ' ORDER BY ' . $this->orderBy;
        }
        $this->recordsTotal    = DB::select($queryCount)[0]->count;
        $this->recordsFiltered = DB::select($queryCount . $queryFilter)[0]->count;
        $this->recordsData     = DB::select($this->query . $queryFilter . $queryOrder . ' LIMIT ' . $this->request->length . ' OFFSET ' . $this->request->start);
    }

    private function codeigniterQuery()
    {
        $queryFiltered = clone $this->query;
        foreach ($columnsSearch = array_values(array_filter($this->columns)) as $key => $value) {
            if (is_array($value)) {
                $column = $value[0];
            } else {
                $column = $value;
            }
            if ($key === 0) {
                $queryFiltered->group_start();
                $queryFiltered->where($column . ' LIKE \'%' . $this->request->search['value'] . '%\'', null, false);
            } else {
                $queryFiltered->or_where($column . ' LIKE \'%' . $this->request->search['value'] . '%\'', null, false);
            }
            if (count($columnsSearch) - 1 === $key) {
                $queryFiltered->group_end();
            }
        }
        $queryData = clone $queryFiltered;
        if ($this->request->order) {
            if (is_array($this->columns[$this->request->order['0']['column']])) {
                $column = $this->columns[$this->request->order['0']['column']][1];
            } else {
                $column = $this->columns[$this->request->order['0']['column']];
            }
            $queryData->order_by($column . ' ' . $this->request->order['0']['dir']);
        } elseif (!empty($this->orderBy)) {
            $queryData->order_by($this->orderBy);
        }
        $this->recordsTotal    = $this->query->count_all_results();
        $this->recordsFiltered = $queryFiltered->count_all_results();
        $this->recordsData     = $queryData->limit($this->request->length, $this->request->start)->get()->result();
    }

    private function laravelOrEloquentQuery()
    {
        $queryFiltered = clone $this->query;
        $queryFiltered = $queryFiltered->where(function ($query) {
            foreach (array_values(array_filter($this->columns)) as $key => $value) {
                if (is_array($value)) {
                    if ($value[0] === 'search') {
                        $query->orWhereRaw($value[1]);
                    } else {
                        $query->orWhereRaw($value[0] . ' like \'%' . $this->request->search['value'] . '%\'');
                    }
                } else {
                    $query->orWhereRaw($value . ' like \'%' . $this->request->search['value'] . '%\'');
                }
            }
        });
        if ($this->request->order) {
            $offset = $this->request->order['0']['column'];
            if (is_array($this->columns[$offset])) {
                if ($this->columns[$offset][0] === 'search') {
                    $column = $this->columns[$offset][2];
                } else {
                    $column = $this->columns[$offset][1];
                }
            } else {
                $column = $this->columns[$offset];
            }
            $queryFiltered =  $queryFiltered->orderByRaw($column . ' ' . $this->request->order['0']['dir']);
        } elseif (!empty($this->orderBy)) {
            $queryFiltered = $queryFiltered->orderByRaw($this->orderBy);
        }
        $this->recordsTotal    = $this->query->count();
        $this->recordsFiltered = $queryFiltered->count();
        $this->recordsData     = $queryFiltered->skip($this->request->start)->take($this->request->length)->get();
    }

    private function produceOutput($json = false)
    {
        $response =  [
            'draw'            => $this->request->draw,
            'recordsTotal'    => $this->recordsTotal,
            'recordsFiltered' => $this->recordsFiltered,
            'data'            => $this->recordsData
        ];
        if ($json === true) {
            return responseJson($response);
        } else {
            return $response;
        }
    }

    private function cekString(string $string, $position = 'first')
    {
        if ($position !== 'first') {
            if (strripos($this->query, $upper = mb_strtoupper($string)) !== false) {
                return $upper;
            } else {
                if (strripos($this->query, $lower = mb_strtolower($string)) !== false) {
                    return $lower;
                } else {
                    if (strripos($this->query, $title = mb_convert_case($string, MB_CASE_TITLE)) !== false) {
                        return $title;
                    } else {
                        throw new Exception('Error Processing Request. (SQL: ' . $this->query . ')');
                    }
                }
            }
        } else {
            if (strpos($this->query, $upper = mb_strtoupper($string)) !== false) {
                return $upper;
            } else {
                if (strpos($this->query, $lower = mb_strtolower($string)) !== false) {
                    return $lower;
                } else {
                    if (strpos($this->query, $title = mb_convert_case($string, MB_CASE_TITLE)) !== false) {
                        return $title;
                    } else {
                        throw new Exception('Error Processing Request. (SQL: ' . $this->query . ')');
                    }
                }
            }
        }
    }
}
