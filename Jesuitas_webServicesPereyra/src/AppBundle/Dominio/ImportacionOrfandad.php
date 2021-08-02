<?php

namespace AppBundle\Dominio;

use PHPExcel_Cell_DataValidation;
use PHPExcel_Style_Fill;
use PHPExcel_Cell;

/**
 * Description of fondo de orfandad
 *
 * @author inceptio
 */
class ImportacionOrfandad {

    public static function layout($dbm, $datos , $phpExcelObject) {
        
    	//Iniciamos la manipulacion del archivo
        $phpExcelObject->getProperties();

        //Se colocan los titulos de los datos genereales
        $Hoja = $phpExcelObject->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Matricula')
        ->setCellValue('B1', 'Fecha inicio')
        ->setCellValue('C1', 'Porcentaje de apoyo')
        ->setCellValue('D1', 'Comentarios');
        
        //Se colocan los datos generales
        //$fila = 2;
        //foreach ($Fondo as $fondo) {
        //	$Hoja->setCellValue('A'.$fila, $Ciclo->getNombre())
        //	->setCellValue('B'.$fila, $fondo->getAlumnoid()->getMatricula())
        //	->setCellValue('C'.$fila, $fondo->getAlumnoid()->getPrimernombre() . " " . 
        //                $fondo->getAlumnoid()->getApellidopaterno() . " " . $fondo->getAlumnoid()->getApellidomaterno())
        //	->setCellValue('D'.$fila, $Nivel->getNombre())
        //	->setCellValue('E'.$fila, $Grado->getGrado())
        //	->setCellValue('F'.$fila, $fondo->getEstatusid()->getNombre())
        //    ->setCellValue('G'.$fila, $fondo->getFechainicio())
        //    ->setCellValue('H'.$fila, $fondo->getComentarios());        
        //	$fila++;
        //}
/*
        $objValidation = $phpExcelObject->getActiveSheet()->getCell('A2')->getDataValidation();
        $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
        $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
        $objValidation->setAllowBlank(false);
        $objValidation->setShowInputMessage(true);
        $objValidation->setShowErrorMessage(true);
        $objValidation->setShowDropDown(true);
        $objValidation->setErrorTitle('Input error');
        $objValidation->setError('Value is not in list.');
        $objValidation->setPromptTitle('Pick from list');
        $objValidation->setPrompt('Please pick a value from the drop-down list.');
        $objValidation->setFormula1('"Item A,Item B,Item C"');
*/        
        $sheet = $phpExcelObject->getActiveSheet();
        //Estilo del encabezado
        $sheet->getStyle("A1:".$sheet->getHighestColumn()."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'E9E9E9')));
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $phpExcelObject->setActiveSheetIndex(0);
        
        return $phpExcelObject; 
    }
        
    public static function validarcolumnas($objPHPExcel) {
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        
        $highestRow = $objWorksheet->getHighestRow();
        $headingsArray = $objWorksheet->rangeToArray('A1:D1',null, true, true, true);
        $headingsArray = $headingsArray[1];
        
        $noencontrada= array();
        $columnas = array('Matricula','Fecha inicio','Porcentaje de apoyo','Comentarios');
        foreach ($columnas as $c) {
            if(!array_search($c, $headingsArray)){
                array_push($noencontrada, $c);
            }
        }
        
        if(sizeof($noencontrada) == 0){
            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A'.$row.':D'.$row,null, true, true, true);
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
