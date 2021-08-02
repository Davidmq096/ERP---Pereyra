<?php

namespace AppBundle\Dominio;

use PHPExcel_Cell_DataValidation;
use PHPExcel_Style_Fill;
use PHPExcel_Cell;

/**
 * Description of solicitud
 *
 * @author inceptio
 */
class ImportacionSolicitud {

    public static function layout($dbm, $datos , $phpExcelObject) {
        
    	//Iniciamos la manipulacion del archivo
        $phpExcelObject->getProperties();

        //Se colocan los titulos de los datos genereales
        $Hoja = $phpExcelObject->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Costo')
        ->setCellValue('B1', 'Estatus')
        ->setCellValue('C1', 'Tipo de beca')
        ->setCellValue('D1', '% de beca')
        ->setCellValue('E1', 'Familia')
        ->setCellValue('F1', 'Folio')
        ->setCellValue('G1', 'Matricula')
        ->setCellValue('H1', 'Alumno')
        ->setCellValue('I1', 'Nivel')
        ->setCellValue('J1', 'Grado')
        ->setCellValue('K1', 'Cobranza')
        ->setCellValue('L1', 'Hijo(a) de personal');
    
        
        $sheet = $phpExcelObject->getActiveSheet();
        //Estilo del encabezado
        $sheet->getStyle("A1:".$sheet->getHighestColumn()."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'E9E9E9')));
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(18);
        $sheet->getColumnDimension('L')->setWidth(18);
        $phpExcelObject->setActiveSheetIndex(0);
        
        return $phpExcelObject; 
    }

    
    
    public static function validarcolumnas($objPHPExcel) {
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        
        $highestRow = $objWorksheet->getHighestRow();
        $headingsArray = $objWorksheet->rangeToArray('A1:H1',null, true, true, true);
        $headingsArray = $headingsArray[1];
        
        $noencontrada= array();
        $columnas = array('Costo','Estatus','Tipo de beca','% de beca','Familia','Folio','Matricula','Alumno',
            'Nivel','Grado','Cobranza','Hijo(a) de personal');
        foreach ($columnas as $c) {
            if(!array_search($c, $headingsArray)){
                array_push($noencontrada, $c);
            }
        }
        
        if(sizeof($noencontrada) == 0){
            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A'.$row.':H'.$row,null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    foreach($headingsArray as $columnKey => $columnHeading) {
                        $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                    } 
                }
            }
            return array("Paso1" => true ,"Datos" => $namedDataArray);
        }else{
            return array("Paso1" => false ,"Noencontrado" => $noencontrada);
        }
    }
}
