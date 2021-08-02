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
class ImportacionResultado {

    public static function layout($dbm, $datos , $phpExcelObject) {
        
    	$Solicitudes = $dbm->getRepositoriosById('Evaluacionporsolicitudadmision', 'evaluacionid', $datos['evaluacionid']);
    	$arrayobject = new \ArrayObject($Solicitudes);
    	$iterator = $arrayobject->getIterator();
    	$iterator->uasort(function ($a, $b) {
            if($a->getSolicitudadmisionid() == null || $b->getSolicitudadmisionid() == null){
                return -1;
            }else{
                return ($a->getSolicitudadmisionid()->getFolio() < $b->getSolicitudadmisionid()->getFolio()) ? -1 : 1;
            }
    	});
    	$Solicitudes= new \Doctrine\Common\Collections\ArrayCollection(iterator_to_array($iterator));
    	$Solicitudes = $Solicitudes->filter(function ($p) use ($datos){
            if($p->getSolicitudadmisionid() == null){
                return false;
            }else{
                return $p->getSolicitudadmisionid()->getGradoid()->getGradoid()== $datos["gradoid"];
            }
    	});
    	
    	
    	$Ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $datos['cicloid']);
    	$Preguntas = $dbm->getRepositoriosById('Preguntaporevaluacion', 'evaluacionid', $datos['evaluacionid'], 'orden');
    	
    	//Iniciamos la manipulacion del archivo
        $phpExcelObject->getProperties();
        
        //Se colocan los titulos de los datos genereales
        $Hoja = $phpExcelObject->setActiveSheetIndex(0)
        ->setCellValue('A2', 'Evaluación por solicitud admisión Id')
        ->setCellValue('B2', 'Folio de solicitud')
        ->setCellValue('C2', 'Ciclo')
        ->setCellValue('D2', 'Nombre')
        ->setCellValue('E2', 'Apellido paterno')
        ->setCellValue('F2', 'Apellido materno');
        
        //Se colocan los datos generales
        $fila = 3;
        foreach ($Solicitudes as $solicitud) {
        	$s = $solicitud->getSolicitudadmisionid();
        	$Hoja->setCellValue('A'.$fila, $solicitud->getEvaluacionporsolicitudadmisionid())
        	->setCellValue('B'.$fila, $s->getFolio())
        	->setCellValue('C'.$fila, $Ciclo->getNombre())
        	->setCellValue('D'.$fila, $s->getDatoaspiranteid()->getNombre())
        	->setCellValue('E'.$fila, $s->getDatoaspiranteid()->getApellidopaterno())
        	->setCellValue('F'.$fila, $s->getDatoaspiranteid()->getApellidomaterno());
        	$fila++;
        }
        
        //Se colocan la pregunta con sus Id
        $columna = 6;
        foreach ($Preguntas as $pregunta) {
        	$p = $pregunta->getPreguntaid();
        	$Hoja->setCellValueByColumnAndRow($columna, 1, $p->getPreguntaid());
        	$Hoja->setCellValueByColumnAndRow($columna, 2, $p->getPregunta());
        	
        	$RespuestasSelect = $p->getTipopreguntaid()->getTipopreguntaid() == 3 || $p->getTipopreguntaid()->getTipopreguntaid() == 4 ? 
        			$dbm->getRepositoriosById('Respuesta', 'preguntaid', $p->getPreguntaid()) : null;
        	
        	$fila = 3;
        	foreach ($Solicitudes as $s) {
        		$Respuesta = $dbm->getByParametersRepositorios('Respuestaporaspirante',array("preguntaid" => $p , "evaluacionporsolicitudadmisionid" => $s));
        		switch ($p->getTipopreguntaid()->getTipopreguntaid()) {
        			case 1:
        			case 2:
        			case 5:
        				//Pregunta abierta
        				$Hoja->setCellValueByColumnAndRow($columna, $fila, $Respuesta ? $Respuesta[0]->getRespuestaabierta() : "");        				
        				break;
        			case 3:
        			case 4:
        				//Opcion multiple        				     				
        				//$Hoja->setCellValueByColumnAndRow($columna, $fila, $Respuesta[0]->getRespuestaid()->getRespuesta());        				
        				//Posibles respuestas  
        				//$a = implode(',',array_map(function ($object) { return $object->getRespuesta(); }, $RespuestasSelect));
        				//$select = $Hoja->getCellByColumnAndRow($columna, $fila)->getDataValidation();
        				//$select->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
        				//$select->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
        				//$select->setAllowBlank(false)->setShowInputMessage(true)->setShowDropDown(true)->setShowErrorMessage(true);
        				//$select->setPromptTitle('Seleccione')->setPrompt('Seleccione una opci�n de la lista.');
        				//$select->setErrorTitle('Input error')->setError('El valor no esta en la lista');
        				//$select->setFormula1("'".$a."'");
        				break;
        				
        		}
        		$fila++;
        	}
        	$columna++;
        }

        $sheet = $phpExcelObject->getActiveSheet();
        //Estilo del encabezado
        $sheet->getStyle("B2:".$sheet->getHighestColumn()."2")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'C6EFCE')));
        
        
        //Columnas autoajustables
        $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
        try {
            $cellIterator->setIterateOnlyExistingCells(true);
        } catch (\Exception $e) {
            return false;
        }
        foreach ($cellIterator as $cell) {
            $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
        }
        
        //Ocultamos la primera fila y la primer columna
        $sheet->getColumnDimension('A')->setVisible(false);
        $sheet->getRowDimension('1')->setVisible(false);
        
        //Protegemos la hoja
        $sheet->getProtection()->setSheet(true);
        //Desbloquemos todas las celdas
        $sheet->getStyle("A1:".$sheet->getHighestDataColumn().$sheet->getHighestRow())->getProtection()->setLocked( \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED );
        //Bloqueamos las celdas que no se deben mover 
        $sheet->getStyle("A1:".$sheet->getHighestDataColumn()."2")->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);
        $sheet->getStyle("A3:"."F".$sheet->getHighestDataRow())->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);
        
        $phpExcelObject->setActiveSheetIndex(0);
        
        return $phpExcelObject; 
    }

    
    
    public static function validarcolumnas($objPHPExcel) {
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        
        $highestRow = $objWorksheet->getHighestRow();
        $headingsArray = $objWorksheet->rangeToArray('A1:G1',null, true, true, true);
        $headingsArray = $headingsArray[1];
        
        $noencontrada= array();
        $columnas = array('Id','Folio','Nombre','Evaluacion','Resultado','Comentarios','Aprobado');
        foreach ($columnas as $c) {
            if(!array_search($c, $headingsArray)){
                array_push($noencontrada, $c);
            }
        }
        
        if(sizeof($noencontrada) == 0){
            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A'.$row.':G'.$row,null, true, true, true);
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
