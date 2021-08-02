<?php

namespace AppBundle\Dominio;

use PHPExcel_Cell_DataValidation;
use PHPExcel_Style_Fill;
use PHPExcel_Cell;

/**
 * Description of Evaluacion
 *
 * @author inceptio
 */
class UsuarioExterno {

    public static function layout($phpExcelObject) {    	
    	//Iniciamos la manipulacion del archivo
        $phpExcelObject->getProperties();
        
        //Se colocan los titulos de los datos genereales
        $Hoja = $phpExcelObject->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Clave')
        ->setCellValue('B1', 'Grupo externo')
        ->setCellValue('C1', 'Nombre')
        ->setCellValue('D1', 'Apellido paterno')
        ->setCellValue('E1', 'Apellido materno');


        $sheet = $phpExcelObject->getActiveSheet();
        //Estilo del encabezado
        $sheet->getStyle("A1:".$sheet->getHighestColumn()."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'C6EFCE')));
        
        
        //Columnas autoajustables
        $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(true);
        foreach ($cellIterator as $cell) {
            $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
        }

        $phpExcelObject->setActiveSheetIndex(0);
        
        return $phpExcelObject; 
    }

}
