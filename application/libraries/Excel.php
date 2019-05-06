<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/PHPExcel.php";

class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }


     public   function Align_right($column,$i)
        {
         
         return   $this->getActiveSheet()->getStyle(''.$column.''.$i.'')
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }

      public   function Align_center($column,$i)
        {
        return    $this->getActiveSheet()->getStyle(''.$column.''.$i.'')
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
      public   function Cell_color($column,$i,$rgb)
        {  
                       
           return             $this->getActiveSheet()->getStyle(''.$column.''.$i.'')->getFill()->applyFromArray(
                             array(
                                 'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                                 'rotation'   => 0,
                                 'startcolor' => array(
                                     'rgb' => $rgb
                                 )
                             )
                         );

        }   

      public   function Set_bold($column,$i){
        return $this->getActiveSheet()->getStyle(''.$column.''.$i.'')->getFont()->setBold(TRUE);
    }
}