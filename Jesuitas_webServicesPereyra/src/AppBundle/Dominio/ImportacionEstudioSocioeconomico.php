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
class ImportacionEstudioSocioeconomico {

    public static function layout($dbm, $datos , $phpExcelObject) {
        
        //Iniciamos la manipulacion del archivo
       //First sheet
        $sheet = $phpExcelObject->getActiveSheet();

 
        $phpExcelObject->getProperties();
        //Se colocan los titulos de los datos genereales
        $Hoja = $phpExcelObject->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Folio')
        ->setCellValue('B1', 'IngresosPadre')
        ->setCellValue('C1', 'IngresosMadre')
        ->setCellValue('D1', 'OtrosFamiliares')
        ->setCellValue('E1', 'OtrosIngresos')
        ->setCellValue('F1', 'Egresosfamiliares')
        ->setCellValue('G1', 'Descripcionsituacionfamiliar');
         // Rename sheet
        $Hoja->setTitle("Situación economica");
        $Hoja->getStyle("A1:".$Hoja->getHighestColumn()."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'E9E9E9')));
        $Hoja->getColumnDimension('A')->setWidth(15);
        $Hoja->getColumnDimension('B')->setWidth(20);
        $Hoja->getColumnDimension('C')->setWidth(20);
        $Hoja->getColumnDimension('D')->setWidth(20);
        $Hoja->getColumnDimension('E')->setWidth(20);
        $Hoja->getColumnDimension('F')->setWidth(20);
        $Hoja->getColumnDimension('G')->setWidth(25);
        // Add new sheet
        $objWorkSheet = $phpExcelObject->createSheet(1) //Setting index when creating
        ->setCellValue('A1', 'Folio')
        ->setCellValue('B1', 'Marca/Modelo')
        ->setCellValue('C1', 'Anio')
        ->setCellValue('D1', 'TarjetaCirulacion')
        ->setCellValue('E1', 'Estatus');
        
         // Rename sheet
        $objWorkSheet->setTitle("Vehículos");
        $objWorkSheet->getStyle("A1:".$objWorkSheet->getHighestColumn()."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'E9E9E9')));
        $objWorkSheet->getColumnDimension('A')->setWidth(15);
        $objWorkSheet->getColumnDimension('B')->setWidth(20);
        $objWorkSheet->getColumnDimension('C')->setWidth(20);
        $objWorkSheet->getColumnDimension('D')->setWidth(20);
        $objWorkSheet->getColumnDimension('E')->setWidth(20);
        // Add new sheet
        $objWorkSheet = $phpExcelObject->createSheet(2) //Setting index when creating
        ->setCellValue('A1', 'Folio')
        ->setCellValue('B1', 'ImporteTotal')
        ->setCellValue('C1', 'Banco/Institucion')
        ->setCellValue('D1', 'PagoMensual')
        ->setCellValue('E1', 'TipoCreditoId')
        ->setCellValue('F1', 'LimiteCredito');
        // Rename sheet
        $objWorkSheet->setTitle("Deudas y creditos");
        $objWorkSheet->getStyle("A1:".$objWorkSheet->getHighestColumn()."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'E9E9E9')));
        $objWorkSheet->getColumnDimension('A')->setWidth(15);
        $objWorkSheet->getColumnDimension('B')->setWidth(20);
        $objWorkSheet->getColumnDimension('C')->setWidth(20);
        $objWorkSheet->getColumnDimension('D')->setWidth(20);
        $objWorkSheet->getColumnDimension('E')->setWidth(20);
        $objWorkSheet->getColumnDimension('F')->setWidth(20);

        $objWorkSheet = $phpExcelObject->createSheet(3)
        ->setCellValue('A1', 'Folio')
        ->setCellValue('B1', 'Tipo de propiedad')
        ->setCellValue('C1', 'EstatusPropiedad')
        ->setCellValue('D1', 'Valor aproximado')
        ->setCellValue('E1', 'Credito a nombre de')
        ->setCellValue('F1', 'Domicilio actual')
        ->setCellValue('G1', 'Mts de terreno')
        ->setCellValue('H1', 'Mts de construccion')
        ->setCellValue('I1', 'Ubicacion')
        ->setCellValue('J1', 'Propiedad a nombre de');
        // Rename sheet
        $objWorkSheet->setTitle("Propiedades familiares");
        $objWorkSheet->getStyle("A1:".$objWorkSheet->getHighestColumn()."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'E9E9E9')));
        $objWorkSheet->getColumnDimension('A')->setWidth(15);
        $objWorkSheet->getColumnDimension('B')->setWidth(20);
        $objWorkSheet->getColumnDimension('C')->setWidth(20);
        $objWorkSheet->getColumnDimension('D')->setWidth(20);
        $objWorkSheet->getColumnDimension('E')->setWidth(20);
        $objWorkSheet->getColumnDimension('F')->setWidth(20);
        $objWorkSheet->getColumnDimension('G')->setWidth(20);
        $objWorkSheet->getColumnDimension('H')->setWidth(20);
        $objWorkSheet->getColumnDimension('I')->setWidth(20);
        $objWorkSheet->getColumnDimension('J')->setWidth(20);


        $phpExcelObject->setActiveSheetIndex(0);

        return ($phpExcelObject); 
    }
        
    public static function validarcolumnas($objPHPExcel) {
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        
        $highestRow = $objWorksheet->getHighestRow();
        $headingsArray = $objWorksheet->rangeToArray('A1:D1',null, true, true, true);
        $headingsArray = $headingsArray[1];
        
        $noencontrada= array();
        $columnas = array('IngresosPadre','IngresosMadre','OtrosFamiliares','OtrosIngresos','Egresosfamiliares');
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
