<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//ini untuk mpdf 7.1 pake composer soalnya
class M_pdf {
  function __construct(){
    include_once APPPATH.'third_party/mpdf-7.1/vendor/autoload.php';    
  }
  function pdf(){
    $CI = & get_instance();
    log_message('Debug', 'mPDF class is loaded.');
 }
  function load($param=[]){
    return new \Mpdf\Mpdf($param);
  }
}


//versi 6.1 
// class M_pdf 
// {
//     public $param;
//     public $pdf;
   
//       public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
//       {
//         include_once APPPATH.'/third_party/mpdf-6.1.4/mpdf.php';

//           $this->param =$param;
//           $this->pdf = new mPDF($this->param);
//       }

// }


