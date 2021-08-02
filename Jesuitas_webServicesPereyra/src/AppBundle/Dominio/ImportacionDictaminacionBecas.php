<?php

namespace AppBundle\Dominio;

use PHPExcel_Cell_DataValidation;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Alignment;
use PHPExcel_Cell;

/**
 * Description of dictaminacion de becas
 *
 * @author inceptio
 */
class ImportacionDictaminacionBecas {

    public static function layout($phpExcelObject, $registros) {
        
        //Iniciamos la manipulacion del archivo
       //First sheet
        $sheet = $phpExcelObject->getActiveSheet();

        $instituto = ENTORNO == 1 ? "Lux" : "IDC";
        $phpExcelObject->getProperties();
        //Se colocan los titulos de los datos genereales
        $Hoja = $phpExcelObject->setActiveSheetIndex(0)
        ->setCellValue('A1', 'RECIBO')
        ->setCellValue('B1', 'FOLIO')
        ->setCellValue('C1', 'beca sep actual')
        ->setCellValue('D1', 'Beca '.$instituto.' actual')
        ->setCellValue('E1', 'TIPO beca sep')
        ->setCellValue('F1', 'TIPO beca '.$instituto)
        ->setCellValue('G1', 'No. Alumno')
        ->setCellValue('H1', 'NOMBRE DEL ASPIRANTE')
        ->setCellValue('I1', 'SECCION')
        ->setCellValue('J1', 'GDO PROXIMO CICLO ESCOLAR')
        ->setCellValue('K1', 'CALIFICACIÓN')
        ->setCellValue('L1', 'ESTUDIAN EN '.$instituto)
        ->setCellValue('M1', 'ESTUDIAN EN TOTAL')
        ->setCellValue('N1', 'TOTAL DE FAM')
        ->setCellValue('O1', 'VIVE FAMILIA UNIDA, SEPARADOS, COMPUESTA, MAMÁ SOLTERA, VIUDO(A)')
        ->setCellValue('P1', 'STATUS HABITACIÓN')
        ->setCellValue('Q1', 'AUTOS MODELO Y AÑO')
        ->setCellValue('R1', 'INGRESOS')
        ->setCellValue('S1', 'EGRESOS')
        ->setCellValue('T1', 'SALDO')
        ->setCellValue('U1', 'PER CÁPITA')
        ->setCellValue('V1', 'OBSERVACIONES DOCUMENTOS')
        ->setCellValue('W1', 'OBSERVACIONES, EXPLICAR LO MAS POSIBLE EL CASO')
        ->setCellValue('X1', 'BECA DEPTO BECAS')
        ->setCellValue('Y1', 'OBSERVACIONES  DEPTO DE BECAS')
        ->setCellValue('Z1', 'OBSERVACIONES SECCION')
        ->setCellValue('AA1', 'BECA SEP')
        ->setCellValue('AB1', 'BECA '.$instituto);
         // Rename sheet
        $Hoja->setTitle("Dictaminacion de becas");
        $Hoja->getStyle("A1:".$Hoja->getHighestColumn()."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'E9E9E9')));
        $Hoja->getColumnDimension('A')->setWidth(7);
        $Hoja->getColumnDimension('B')->setWidth(7);
        $Hoja->getColumnDimension('C')->setWidth(7);
        $Hoja->getColumnDimension('D')->setWidth(7);
        $Hoja->getColumnDimension('E')->setWidth(7);
        $Hoja->getColumnDimension('F')->setWidth(7);
        $Hoja->getColumnDimension('G')->setWidth(7);
        $Hoja->getColumnDimension('H')->setWidth(30);
        $Hoja->getColumnDimension('I')->setWidth(7);
        $Hoja->getColumnDimension('J')->setWidth(7);
        $Hoja->getColumnDimension('K')->setWidth(7);
        $Hoja->getColumnDimension('L')->setWidth(7);
        $Hoja->getColumnDimension('M')->setWidth(7);
        $Hoja->getColumnDimension('N')->setWidth(7);
        $Hoja->getColumnDimension('O')->setWidth(15);
        $Hoja->getColumnDimension('P')->setWidth(25);
        $Hoja->getColumnDimension('Q')->setWidth(25);
        $Hoja->getColumnDimension('R')->setWidth(10);
        $Hoja->getColumnDimension('S')->setWidth(10);
        $Hoja->getColumnDimension('T')->setWidth(10);
        $Hoja->getColumnDimension('U')->setWidth(10);
        $Hoja->getColumnDimension('V')->setWidth(30);
        $Hoja->getColumnDimension('W')->setWidth(50);
        $Hoja->getColumnDimension('X')->setWidth(20);
        $Hoja->getColumnDimension('Y')->setWidth(30);
        $Hoja->getColumnDimension('Z')->setWidth(25);

        $Hoja->getStyle('A1:G1')->getAlignment()->setTextRotation(90);
        $Hoja->getStyle('I1:N1')->getAlignment()->setTextRotation(90);

        $Hoja->getStyle('A1:AB1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $Hoja->getStyle('A1:AB1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $Hoja->getStyle('O1')->getAlignment()->setWrapText(true);

        
        if ($registros){
            $i=2;
            foreach ($registros as $registro){
                $Hoja = $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $registro["solicitudid"])
                ->setCellValue('B'.$i, $registro["solicitudid"])
                ->setCellValue('C'.$i, $registro["becasep"])
                ->setCellValue('D'.$i, $registro["becaidc"])
                ->setCellValue('E'.$i, $registro["tipobecasep"])
                ->setCellValue('F'.$i, $registro["tipobecaidc"])
                ->setCellValue('G'.$i, $registro["matricula"])
                ->setCellValue('H'.$i, $registro["alumno"])
                ->setCellValue('I'.$i, $registro["nivel"])
                ->setCellValue('J'.$i, $registro["gradoproximo"])
                ->setCellValue('K'.$i, $registro["calificacion"])
                ->setCellValue('L'.$i, $registro["alumnosidec"])
                ->setCellValue('M'.$i, $registro["estudiantestotales"])
                ->setCellValue('N'.$i, $registro["miembrosfamilia"])
                ->setCellValue('O'.$i, $registro["vivefamilia"])
                ->setCellValue('P'.$i, $registro["propiedades"])
                ->setCellValue('Q'.$i, $registro["vehiculos"])
                ->setCellValue('R'.$i, $registro["ingresos"])
                ->setCellValue('S'.$i, $registro["egresos"])
                ->setCellValue('T'.$i, $registro["saldo"])
                ->setCellValue('U'.$i, $registro["percapita"])
                ->setCellValue('V'.$i, $registro["observacionesdocumentos"])
                ->setCellValue('W'.$i, $registro["observaciones"])
                ->setCellValue('X'.$i, $registro["pendiente"])
                ->setCellValue('Y'.$i, $registro["pendiente"])
                ->setCellValue('Z'.$i, $registro["pendiente"]);
                $i++;
            }
        }


        $phpExcelObject->setActiveSheetIndex(0);

        return ($phpExcelObject); 
    }
}
