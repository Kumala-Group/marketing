<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Multidatabase
{

        public function __construct()
        {
                $this->load();
        }

        /**
         * Load the databases and ignore the old ordinary CI loader which only allows one
         */
        public function load()
        {
                $CI = &get_instance();

                $CI->db = $CI->load->database('default', TRUE);
                $CI->db_helpdesk = $CI->load->database('db_helpdesk', TRUE);
                // $CI->db_oli = $CI->load->database('db_oli', TRUE);
                // $CI->db_wuling = $CI->load->database('db_wuling', TRUE);
                // $CI->db_wuling_sp = $CI->load->database('db_wuling_sp', TRUE);
                // $CI->db_wuling_as = $CI->load->database('db_wuling_as', TRUE);
                // $CI->db_honda = $CI->load->database('db_honda', TRUE);
                // $CI->db_honda_sp = $CI->load->database('db_honda_sp', TRUE);
                // $CI->db_honda_as = $CI->load->database('db_honda_as', TRUE);
                // $CI->db_mercedes = $CI->load->database('db_mercedes', TRUE);
                // $CI->db_mercedes_sp = $CI->load->database('db_mercedes_sp', TRUE);
                // $CI->db_mercedes_as = $CI->load->database('db_mercedes_as', TRUE);
                // $CI->db_kpp = $CI->load->database('db_kpp', TRUE);
                // $CI->db_ksa = $CI->load->database('db_ksa', TRUE);
                // $CI->db_kss = $CI->load->database('db_kss', TRUE);
                // $CI->db_hino = $CI->load->database('db_hino', TRUE);
                // $CI->db_ksa_sp = $CI->load->database('db_ksa_sp', TRUE);
                // $CI->db_kpp_sp = $CI->load->database('db_kpp_sp', TRUE);
                // $CI->db_hino_as = $CI->load->database('db_hino_as', TRUE);
                // $CI->db_hino_sp = $CI->load->database('db_hino_sp', TRUE);
                // $CI->db_mazda = $CI->load->database('db_mazda', TRUE);
                $CI->kumalagroup = $CI->load->database('kumalagroup', TRUE);
                // $CI->db_kuc = $CI->load->database('db_kuc', TRUE);
        }

        // Add more functions two use commonly.
        public function save()
        {
        }
}
