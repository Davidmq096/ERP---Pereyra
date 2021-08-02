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
class ListaAsistencia {

    public static function lista($datos , $phpExcelObject) {
        
    	//Iniciamos la manipulacion del archivo
        $phpExcelObject->getProperties();
     
        //Se colocan los datos generales
        $index = 0;
        foreach ($datos as $list) {
        	$Hoja = $phpExcelObject->createSheet($index);
			$nivel = $list["nivel"];
			$evento = $list["evento"];
		
        	$Hoja->setCellValue('B1', 'Ciclo')
        	->setCellValue('C1', $evento->getEvaluacionid()->getCicloid()->getNombre())
        	->setCellValue('B2', 'Nivel')
        	->setCellValue('C2', $nivel->getNivelid()->getNombre())
        	->setCellValue('B3', 'Grado')
        	->setCellValue('C3', $nivel->getGrado())
        	->setCellValue('D1', 'Evaluación')
        	->setCellValue('E1', $evento->getEvaluacionid()->getNombre())
        	->setCellValue('D2', 'Tipo de evaluación')
        	->setCellValue('E2', $evento->getEvaluacionid()->getTipoevaluacionid()->getNombre())
        	->setCellValue('D3', 'Evaluador')
        	->setCellValue('E3', $evento->getUsuarioid()->getPersonaid()->getNombre().' '.$evento->getUsuarioid()->getPersonaid()->getapellidopaterno().' '.$evento->getUsuarioid()->getPersonaid()->getApellidomaterno())
        	->setCellValue('F1', 'Fecha')
        	->setCellValue('G1', $evento->getFechainicio()->format("d/m/y").' '.$evento->getHorainicio()->format("H:i"))
        	->setCellValue('F2', 'Lugar')
        	->setCellValue('G2', $evento->getLugarid()->getNombre())
        	->setCellValue('A6', 'Folio')
        	->setCellValue('B6', 'Nombre')
        	->setCellValue('C6', 'Ap. paterno')
        	->setCellValue('D6', 'Ap. materno')
        	->setCellValue('E6', 'Asistio');
        	
        	$fila = 7;
        	foreach ($list["aspirantes"] as $solicitud){
        		$s = $solicitud->getSolicitudadmisionid();
        		$Hoja->setCellValue('A'.$fila, $s->getFolio())
        		->setCellValue('B'.$fila, $s->getDatoaspiranteid()->getNombre())
        		->setCellValue('C'.$fila, $s->getDatoaspiranteid()->getApellidopaterno())
        		->setCellValue('D'.$fila, $s->getDatoaspiranteid()->getApellidomaterno())
        		->setCellValue('E'.$fila, $solicitud->getAsistio() ? "Si" : "No");
        		$fila++;
        	}        	
    
        	$phpExcelObject->setActiveSheetIndex($index);
        	$sheet = $phpExcelObject->getActiveSheet();
        	
        	$sheet->getStyle("B1:G3")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'C6EFCE')));
        	$sheet->getStyle("A6:E6")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '64b9b8')));
        	
        	$cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
        	$cellIterator->setIterateOnlyExistingCells(true);
        	foreach ($cellIterator as $cell) {
        		$sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
        	}
        	        	
        	$index++;
        }       

        $phpExcelObject->setActiveSheetIndex(0);
        return $phpExcelObject; 
    }
}
