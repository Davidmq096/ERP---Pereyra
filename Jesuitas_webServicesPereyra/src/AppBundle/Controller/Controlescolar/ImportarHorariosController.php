<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAgendaextraordinario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\PHPExcel\XLSXWriter;
use PHPExcel;
use PHPExcel_Style_Protection;
use PHPExcel_IOFactory;
use PHPExcel_Style_NumberFormat;
use PHPExcel_Cell_DataValidation;
use PHPExcel_NamedRange;
use Proxies\__CG__\AppBundle\Entity\CeHorario;

/**
 * Auto: David
 */
class ImportarHorariosController extends FOSRestController
{

    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Get("/api/Controlescolar/ImportarHorarios/Filtros", name="getFiltros")
     */
    public function getFiltros()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);

            return new View([
                'ciclo' => $ciclo,
                'nivel' => $nivel,
                'grado' => $grado,
                'semestre' => $semestre
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    
    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Post("/api/Controlescolar/ImportarHorarios/ImportarHorarios", name="ImportarHorarios")
     */
    public function ImportarHorarios()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach($filtros['data'] as $data){
                $prof = $dbm->getRepositorioById('CeProfesorpormateriaplanestudios',  'profesorpormateriaplanestudiosid', $data['profesorpormateriaplanestudiosid']);
                if(!$data['existe']){
                    $horario =  new CeHorario();
                    $horario->setDia($data['Dia']);
                    $horario->setSalon($data['Salon']);
                    $horario->setHorainicio(new \Datetime('1999-01-01 ' . $data['HoraInicio']));
                    $horario->setHorafin(new \Datetime('1999-01-01 ' . $data['HoraFin']));
                    $horario->setProfesorpormateriaplanestudiosid($prof);
                    $dbm->saveRepositorio($horario);
                }
            }
            $dbm->getConnection()->commit();
            return new View('Se han importado los horarios correctamente', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Post("/api/Controlescolar/ImportarHorarios/ProcesarArchivo", name="ProcesarArchivo")
     */
    public function ProcesarArchivo()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $datos = $dbm->getHorarioFiltros($filtros['filtros'], true);

            $materias = [];

            foreach($datos['materias'] as $m){
                if($m['materiaid']){
                    $materias[] =  $m;
                }
            }

            $datos['materias'] = $materias;

            if($filtros['type'] == 'xlsx'){
                $dat = [];
                foreach($filtros['data'] as &$filtro){
                    if(empty($filtro['HoraInicio']) || empty($filtro['HoraFin'])){
                        //return new View("Encontramos una o varias filas con horarios vacíos, favor de verificar el archivo antes de importarlo", Response::HTTP_PARTIAL_CONTENT);
                    }else{
                        $find = false;
                        foreach($datos['profesores'] as $p){
                            if($p['profesorpormateriaplanestudiosid'] == $filtro['Identificador']){
                                $find = true;
                            }
                        }
                        if($find){
                            $prof = $dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'profesorpormateriaplanestudiosid', $filtro['Identificador']);
                            if($prof){
                                $gf = false;
                                foreach($filtros['filtros']['gradoid'] as $g){
                                    if($prof->getGrupoid()){
                                        if ($prof->getGrupoid()->getGradoid()->getGradoid() == $g) {
                                            if(!$gf){
                                                $gf = true;
                                            }
                                        }
                                    }else if($prof->getTallerid()){
                                        $gra = $dbm->getOneByParametersRepositorio('CeGradoportallercurricular', [
                                            'tallercurricularid' => $prof->getTallerid()->getTallercurricularid(),
                                            'gradoid' => $g
                                        ]);
                                        if($gra){
                                            if(!$gf){
                                                $gf = true;
                                            }
                                        }
                                    }
                                }
                                if(!$gf){
                                    return new View("El archivo que estas intentando importar contiene grados que no pertenecen a los filtros", Response::HTTP_PARTIAL_CONTENT);
                                }
                                $horario = $dbm->getOneByParametersRepositorio('CeHorario', [
                                    'profesorpormateriaplanestudiosid' => $filtro['Identificador'],
                                    'horainicio' => new \Datetime('1999-01-01 ' . $filtro['HoraInicio']),
                                    'horafin' => new \Datetime('1999-01-01 ' . $filtro['HoraFin']),
                                    'dia' => $filtro['Dia']
                                ]);
                                $filtro['encontrado'] = true;
                                $filtro['profesorpormateriaplanestudiosid'] = $prof->getProfesorpormateriaplanestudiosid();
                                if($horario){
                                    $filtro['existe'] = true;
                                    $filtro['horario'] = [
                                        'horarioid' => $horario->getHorarioid(),
                                        'horainicio' => $horario->getHorainicio(),
                                        'horafin' => $horario->getHorafin(),
                                        'dia' => $horario->getDia()
                                    ];
                                }
                                if($prof->getGrupoid()){
                                    $filtro['grupoid'] = $prof->getGrupoid()->getGrupoid();
                                    $filtro['grupoencontrado'] = true;
                                }else if($prof->getTallerid()){
                                    $filtro['tallerid'] = $prof->getTallerid()->getTallercurricularid();
                                    $filtro['tallerencontrado'] = true;
                                }
                            }
                        }
                        $clave = explode(', ',$filtro['ClaveMateria']);
                        $materia = $dbm->getRepositorioById('Materia', 'clave', $clave);
                        if($materia){
                            $filtro['materiaencontrada'] = true;
                            $filtro['materiaid'] = $materia->getMateriaid();
                        }
                        $dat[] = $filtro;
                    }
                }
                $filtros['data'] = $dat;
            }else{
                foreach($filtros['data'] as &$filtro){
                    $find = false;
                    $prof = null;
                    foreach($datos['profesores'] as $p){
                        if($p['numeronomina'] == $filtro['NominaProfesor']){
                            $find = true;
                            $prof = $p;
                        }
                    }
                    if($find){
                        if($prof){
                            $prof = $dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'profesorpormateriaplanestudiosid', $prof['profesorpormateriaplanestudiosid']);
                            $gf = false;
                            foreach($filtros['filtros']['gradoid'] as $g){
                                if($prof->getGrupoid()){
                                    if ($prof->getGrupoid()->getGradoid()->getGradoid() == $g) {
                                        if(!$gf){
                                            $gf = true;
                                        }
                                    }
                                }else if($prof->getTallerid()){
                                    $gra = $dbm->getOneByParametersRepositorio('CeGradoportallercurricular', [
                                        'tallercurricularid' => $prof->getTallerid()->getTallercurricularid(),
                                        'gradoid' => $g
                                    ]);
                                    if($gra){
                                        if(!$gf){
                                            $gf = true;
                                        }
                                    }
                                }
                            }
                            if(!$gf){
                                return new View("El archivo que estas intentando importar contiene grados que no pertenecen a los filtros", Response::HTTP_PARTIAL_CONTENT);
                            }
                            $horario = $dbm->getOneByParametersRepositorio('CeHorario', [
                                'profesorpormateriaplanestudiosid' => $prof->getProfesorpormateriaplanestudiosid(),
                                'horainicio' => new \Datetime('1999-01-01 ' . $filtro['HoraInicio']),
                                'horafin' => new \Datetime('1999-01-01 ' . $filtro['HoraFin']),
                                'dia' => $filtro['Dia']
                            ]);
                            $filtro['encontrado'] = true;
                            $filtro['profesorpormateriaplanestudiosid'] = $prof->getProfesorpormateriaplanestudiosid();
                            if($horario){
                                $filtro['existe'] = true;
                                $filtro['horario'] = [
                                    'horarioid' => $horario->getHorarioid(),
                                    'horainicio' => $horario->getHorainicio(),
                                    'horafin' => $horario->getHorafin(),
                                    'dia' => $horario->getDia()
                                ];
                            }
                            if($prof->getGrupoid()){
                                if($filtro['Grupo'] == $prof->getGrupoid()->getNombre()){
                                    $filtro['grupoid'] = $prof->getGrupoid()->getGrupoid();
                                    $filtro['grupoencontrado'] = true;
                                }else{
                                    $filtro['grupoid'] = $prof->getGrupoid()->getGrupoid();
                                    $filtro['grupoencontrado'] = false;
                                }
                            }else if($prof->getTallerid()){
                                if($filtro['Grupo'] == $prof->getTallerid()->getNombre()){
                                    $filtro['tallerid'] = $prof->getTallerid()->getTallercurricularid();
                                    $filtro['tallerencontrado'] = true;
                                }else{
                                    $filtro['tallerid'] = $prof->getTallerid()->getTallercurricularid();
                                    $filtro['tallerencontrado'] = false;
                                }
                            }
                        }
                    }
                    $materia = $dbm->getRepositorioById('Materia', 'clave', $filtro['ClaveMateria']);
                    if($materia){
                        $filtro['materiaencontrada'] = true;
                        $filtro['materiaid'] = $materia->getMateriaid();
                    }
                }
            }


            return new View([
                'filtros' => $datos,
                'data' => $filtros['data'],
                'type' => $filtros['type']
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Post("/api/Controlescolar/ImportarHorarios/GenerarArchivoImportacion", name="GenerarArchivoImportacion")
     */
    public function GenerarArchivoImportacion()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $root = str_replace('app', '', $this->get('kernel')->getRootDir()) . "src/AppBundle/Dominio/DocxMerge/tmp/";
            $datos = $dbm->getHorarioFiltros($filtros, false);
            $nivel = $dbm->getRepositorioById('Nivel', 'nivelid', $filtros['nivelid']);
            $grado = $dbm->getRepositorioById('Grado', 'gradoid', $filtros['gradoid']);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 50; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $finalPath = $root . $randomString . ".xlsx";

            foreach($datos['profesores'] as &$prof){
                $prof['Col'] = 'partern_id';
            }
            foreach($datos['materias'] as &$prof){
                $prof['Col'] = 'partern_id';
            }
            foreach($datos['grupos'] as &$prof){
                $prof['Col'] = 'partern_id';
            }
            foreach($datos['talleres'] as &$prof){
                $prof['Col'] = 'partern_id';
            }

            $writer = new XLSXWriter();
            $writer->writeSheet($datos['profesores'], 'Profesores', array(
                'Número de nómina'=>'string',
                'Nombre'=>'string',
                'Apellido Paterno'=>'string',
                'Apellido Materno'=>'string',
                'Nombre de la propiedad XML'=>'string',
            ));
            $writer->writeSheet($datos['materias'], 'Materias',array(
                'Clave'=>'string',
                'Nombre'=>'string',
                'Nombre de la propiedad XML'=>'string',
            ));
            $writer->writeSheet($datos['grupos'], 'Grupos',array(
                'Id'=>'string',
                'Nombre'=>'string',
                'Nombre de la propiedad XML'=>'string',
            ));
            $writer->writeSheet($datos['talleres'], 'Talleres',array(
                'Id'=>'string',
                'Nombre'=>'string',
                'Nombre de la propiedad XML'=>'string',
            ));
            $writer->writeToFile($finalPath);

            $final = file_get_contents($finalPath);

            $response = new \Symfony\Component\HttpFoundation\Response(
                //$pdf["formato"],
                $final,
                200,
                array(
                    'Content-Type' => "application/vnd.ms-excel;" . $nivel->getNombre() . '-' . $grado->getGrado() . '-' .  time() . '.xlsx',
                    'Content-Length' => filesize($finalPath),
                    //'Content-Length' => $pdf["tamano"]
                )
            );

            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Post("/api/Controlescolar/ImportarHorarios/GenerarLayout", name="GenerarLayout")
     */
    public function GenerarLayout()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $root = str_replace('app', '', $this->get('kernel')->getRootDir()) . "src/AppBundle/Dominio/DocxMerge/tmp/";
            $datos = $dbm->getProfesoresPorHorario($filtros);
            $nivel = $dbm->getRepositorioById('Nivel', 'nivelid', $filtros['nivelid']);
            $grado = $dbm->getRepositorioById('Grado', 'gradoid', $filtros['gradoid']);

            $profesores = [];

            foreach($datos as $d){
                if($d['materiaid'] == 0){
                    $gradostaller = $dbm->getOneByParametersRepositorio('CeGradoportallercurricular', ['tallercurricularid' => $d['tallercurricularid'], 'gradoid' => $filtros['gradoid']]);
                    $gradostalleres = $dbm->getByParametersRepositorios('CeGradoportallercurricular', ['tallercurricularid' => $d['tallercurricularid']]);
                    $materias = [];
                    $grados = [];
                    $claves = [];


                    foreach($gradostalleres as $gta){
                        $materias[] = $gta->getMateriaporplanestudioid()->getMateriaid()->getNombre();
                        $claves[] = $gta->getMateriaporplanestudioid()->getMateriaid()->getClave();
                        $grados[] = $gta->getGradoid()->getGrado();
                    }

                    $materias = implode(', ', $materias);
                    $claves = implode(', ', $claves);
                    $grados = implode(', ', $grados);
                    $find = false;
                    foreach($profesores as $pr){
                        if($pr['clavemateria'] == $gradostaller->getMateriaporplanestudioid()->getMateriaid()->getClave() &&$pr['profesorpormateriaplanestudiosid'] == $d['profesorpormateriaplanestudiosid']){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $horarios = $dbm->getRepositoriosById('CeHorario', 'profesorpormateriaplanestudiosid', $d['profesorpormateriaplanestudiosid']);

                        if(count($horarios) > 0){
                            foreach($horarios as $hora){
                                $dia = 'L';
                                if($hora->getDia() == 1){
                                    $dia = 'L';
                                }else if($hora->getDia() == 2){
                                    $dia = 'M';
                                }else if($hora->getDia() == 3){
                                    $dia = 'Mi';
                                }else if($hora->getDia() == 4){
                                    $dia = 'J';
                                }else{
                                    $dia = 'V';
                                }
                                $profesores[] = [
                                    'profesorpormateriaplanestudiosid' => $d['profesorpormateriaplanestudiosid'],
                                    'nivel' => $d['nivel'],
                                    'grado' => $grados,
                                    'grupo' => $gradostaller->getTallercurricularid()->getNombre(),
                                    'clavemateria' => $claves,
                                    'materia' => $materias,
                                    'nominaprofesor' => $d['numeronomina'],
                                    'nombresprofesor' => $d['nombre'],
                                    'apellidosprofesor' => $d['apellidopaterno'] . ' ' . $d['apellidomaterno'],
                                    'horainicio' => $hora->getHorainicio()->format('H:i'),
                                    'horafin' => $hora->getHorafin()->format('H:i'),
                                    'salon' => $hora->getSalon(),
                                    'dia' => $dia,
                                ];
                            }
                        }else{
                            $profesores[] = [
                                'profesorpormateriaplanestudiosid' => $d['profesorpormateriaplanestudiosid'],
                                'nivel' => $d['nivel'],
                                'grado' => $grados,
                                'grupo' => $gradostaller->getTallercurricularid()->getNombre(),
                                'clavemateria' => $claves,
                                'materia' => $materias,
                                'nominaprofesor' => $d['numeronomina'],
                                'nombresprofesor' => $d['nombre'],
                                'apellidosprofesor' => $d['apellidopaterno'] . ' ' . $d['apellidomaterno'],
                                'horainicio' => '',
                                'horafin' => '',
                                'salon' => '',
                                'dia' => '',
                            ];
                        }
                    }
                }else{
                    $materia = $dbm->getRepositorioById('Materia', 'materiaid', $d['materiaid']);
                    $horarios = $dbm->getRepositoriosById('CeHorario', 'profesorpormateriaplanestudiosid', $d['profesorpormateriaplanestudiosid']);

                    if(count($horarios) > 0){
                        foreach($horarios as $hora){
                            $dia = 'L';
                            if($hora->getDia() == 1){
                                $dia = 'L';
                            }else if($hora->getDia() == 2){
                                $dia = 'M';
                            }else if($hora->getDia() == 3){
                                $dia = 'Mi';
                            }else if($hora->getDia() == 4){
                                $dia = 'J';
                            }else{
                                $dia = 'V';
                            }
                            $profesores[] = [
                                'profesorpormateriaplanestudiosid' => $d['profesorpormateriaplanestudiosid'],
                                'nivel' => $d['nivel'],
                                'grado' => $d['grado'],
                                'grupo' => $d['grupo'],
                                'clavemateria' => $materia->getClave(),
                                'materia' => $materia->getNombre(),
                                'nominaprofesor' => $d['numeronomina'],
                                'nombresprofesor' => $d['nombre'],
                                'apellidosprofesor' => $d['apellidopaterno'] . ' ' . $d['apellidomaterno'],
                                'horainicio' => $hora->getHorainicio()->format('H:i'),
                                'horafin' => $hora->getHorafin()->format('H:i'),
                                'salon' => $hora->getSalon(),
                                'dia' => $dia,
                            ];
                        }
                    }else{
                        $profesores[] = [
                            'profesorpormateriaplanestudiosid' => $d['profesorpormateriaplanestudiosid'],
                            'nivel' => $d['nivel'],
                            'grado' => $d['grado'],
                            'grupo' => $d['grupo'],
                            'clavemateria' => $materia->getClave(),
                            'materia' => $materia->getNombre(),
                            'nominaprofesor' => $d['numeronomina'],
                            'nombresprofesor' => $d['nombre'],
                            'apellidosprofesor' => $d['apellidopaterno'] . ' ' . $d['apellidomaterno'],
                            'horainicio' => '',
                            'horafin' => '',
                            'salon' => '',
                            'dia' => '',
                        ];
                    }
                }
            }

            if(count($profesores) == 0){
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            sort($profesores);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 50; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $finalPath = $root . $randomString . ".xlsx";

            $objPHPExcel = new PHPExcel();

            $headers = array(
                'Identificador',
                'Nivel',
                'Grado',
                'Grupo',
                'Clave Materia',
                'Nombre Materia',
                'Nómina Profesor',
                'Nombre Profesor',
                'Apellidos Profesor',
                'Hora Inicio',
                'Hora Fin',
                'Salón',
                'Día (L/M/Mi/J/V)',
            );

            $objPHPExcel->setActiveSheetIndex(0);
            $letters = [
                'A',
                'B',
                'C',
                'D',
                'E',
                'F',
                'G',
                'H',
                'I',
                'J',
                'K',
                'L',
                'M',
            ];

            foreach($headers as $key => $header){
                $letter = $letters[$key];
                $objPHPExcel->getActiveSheet()->setCellValue($letter . '1', $header);
                $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
            }

            $days = [
                'L',
                'M',
                'Mi',
                'J',
                'V',
            ];

            $horas = [
                '07:30',
                '08:20',
                '09:10',
                '10:00',
                '10:30',
                '11:20',
                '12:10',
                '12:30',
                '13:20',
                '14:10'
            ];
            foreach($days as $key => $day){
                $objPHPExcel->addNamedRange(
                    new PHPExcel_NamedRange(
                        $day, 
                        $objPHPExcel->getActiveSheet(), 'N' . '1:' . 'N' . count($profesores)
                    )
                );
                $objPHPExcel->getActiveSheet()
                ->getColumnDimension('Q')
                ->setVisible(false);
                $objPHPExcel->getActiveSheet()
                ->setCellValue('Q' . ($key+1), $day);
            }
            $objPHPExcel->addNamedRange(
                new PHPExcel_NamedRange(
                    'Days', 
                    $objPHPExcel->getActiveSheet(), 'Q' . '1:' . 'Q' . count($days)
                )
            );
            $k = 1;
            foreach($profesores as $value){
                $key = 0;
                foreach($value as $v){
                    $letter = $letters[$key];
                    $kk = ($k + 1);
                    $objPHPExcel->getActiveSheet()->setCellValue($letter . $kk, $v);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
                    if($letter == 'J'){
                        $objPHPExcel->getActiveSheet()->getStyle($letter . $kk)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3);
                    }
                    if($letter == 'K'){
                        $objPHPExcel->getActiveSheet()->getStyle($letter . $kk)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3);
                    }
                    // if($letter == 'M'){
                    //     $objValidation = $objPHPExcel->getActiveSheet()
                    //         ->getCell($letter . $kk)
                    //         ->getDataValidation();
                    //     $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
                    //         ->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
                    //         ->setAllowBlank(false)
                    //         ->setShowInputMessage(true)
                    //         ->setShowErrorMessage(true)
                    //         ->setShowDropDown(true)
                    //         ->setErrorTitle('Input error')
                    //         ->setError('El día no aparece en la lista.')
                    //         ->setPromptTitle('Selecciona un día de la lista')
                    //         ->setPrompt('Por favor selecciona un día de la lista.')
                    //         ->setFormula1('=Days');
                    // }

                    $key++;
                }
                $k++;
            }

            

            /* this section lock for all sheet */
            //$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);

            /*  and this section unlock cell rage('A2:Z2') from locked sheet */
            //$objPHPExcel->getActiveSheet()->getStyle('J1:M' . (count($profesores) + 1))->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($finalPath);

            // $writer = new XLSXWriter();
            // $writer->writeSheet($profesores, null, array(
            //     'Grupo'=>'string',
            //     'Grado'=>'string',
            //     'Clave Materia'=>'string',
            //     'Nombre Materia'=>'string',
            //     'Nómina Profesor'=>'string',
            //     'Nombre Profesor'=>'string',
            //     'Apellidos Profesor'=>'string',
            //     'Hora Clase'=>'string',
            //     'Salón'=>'string',
            //     'Día (L/M/Mi/J/V)'=>'string',
            // ));
            // $writer->writeToFile($finalPath);

            $final = file_get_contents($finalPath);

            $response = new \Symfony\Component\HttpFoundation\Response(
                //$pdf["formato"],
                $final,
                200,
                array(
                    'Content-Type' => "application/vnd.ms-excel;" .  $nivel->getNombre() . '-' . $grado->getGrado() . '-layout.xlsx',
                    'Content-Length' => filesize($finalPath),
                    //'Content-Length' => $pdf["tamano"]
                )
            );

            unlink($finalPath);

            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Regresa el horario del alumno
     * @Rest\Post("/api/Controlescolar/ImportarHorarios/TablaHorario", name="getTablaHorario")
     */
    public function getTablaHorario()
    {
        try {
            $respuesta=[];
            $filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $cicloactual=$dbm->getRepositorioById("Ciclo","actual",1);
            $horario = $dbm->BuscarTablaHorario($filtros);
            $talleres = $dbm->getTalleres($filtros);
            foreach($talleres as $taller){
                $data = $filtros;
                $data['groupby'] = true;
                $data['tallerid'] = $taller['tallercurricularid'];
                $tall = $dbm->BuscarTablaHorario($data);
                foreach($tall as $t){
                    $t['taller'] = true;
                    $horario[] = $t;
                }
            }
            $horainicial="24:00";
            $horas = [];
            $tipo = [];
            $horafinal="00:00";
            foreach ($horario as $hora){
                if($hora['taller'] !== true){
                    $grupokey=false;
                    foreach ($grupos as $key => $grupo) {
                        if ( $key==$hora["grupoid"]) {
                            $grupokey=$key;
                            break;
                        }
                    }
                    if ($grupokey=== false){
                        $grupos[$hora["grupoid"]]=$hora["grupo"];
                    }
                    $diasalumno[$hora["dia"]][]=$hora;
                    if ($hora["horainicio"]<$horainicial){
                        $horainicial=$hora["horainicio"];
                    }
                    if ($hora["horafin"]>$horafinal){
                        $horafinal=$hora["horafin"];
                    }
                }
            }
            $date1 = new \DateTime($horainicial);
            $date2 = new \DateTime($horafinal);
            $diff = $date2->diff($date1);
            $cuantashoras= $diff->format('%h');
            // for ($i=0;$i<$cuantashoras;$i++){
            //     $b=$date1->format('H')+$i;
            //     $e=$b+1;
            //     $horas[]=["inicio"=>sprintf("%02d", $b).":00","fin"=>sprintf("%02d", $e).":00"];
            // }
            foreach($horario as $h){
                $find = false;
                foreach($horas as $hh){
                    if($hh['inicio'] == $h['horainicio'] && $hh['fin'] == $h['horafin']){
                        $find = true;
                    }
                }
                if(!$find){
                    $horas[]=["inicio"=>$h['horainicio'],"fin"=>$h['horafin']];
                }
            }
            sort($horas);
            $dias=[["dia"=>1,"nombre"=>"Lunes"],["dia"=>2,"nombre"=>"Martes"],["dia"=>3,"nombre"=>"Miercoles"],["dia"=>4,"nombre"=>"Jueves"],["dia"=>5,"nombre"=>"Viernes"]];
            // if (count($grupos)==1){
            //     foreach ($horas as $key=>$hora){
            //         $respuesta[$key]["hora"]=$hora["inicio"]." - ".$hora["fin"];
            //         foreach ($dias as $dia){
            //             foreach ($diasalumno as $diaalumno){
            //                 foreach ($diaalumno as $da){
            //                     if ($dia["dia"]==$da["dia"] && $da["horainicio"]==$hora["inicio"] && $da["horafin"]==$hora["fin"]) {
            //                         $item=["materia"=>$da["materia"],"inicio"=>' ',"fin"=>' ', 'all' => $da];
            //                         $respuesta[$key][$dia["nombre"]][]=$item;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // }else{
            // }
            foreach ($grupos as $grupoid=>$grupo){
                $grupoentidad=$dbm->getRepositorioById("CeGrupo","grupoid",$grupoid);
                if ($grupoentidad->getTipogrupoid()->getTipogrupoid()==1){
                    $indice=$grupoid;
                    $respuesta[$indice]["grupo"]=$grupoentidad->getGradoid()->getNivelid()->getNombre()." ".$grupoentidad->getGradoid()->getGrado()." ".$grupoentidad->getNombre();
                }else{
                    $grupoorigen=$dbm->getRepositorioById("CeGrupoorigenporsubgrupo","grupoid",$grupoid);
                    $indice=$grupoorigen->getGrupoorigenid()->getGrupoid();
                }
                
                foreach ($horas as $key=>$hora){
                    $respuesta[$indice]["horario"][$key]["hora"]=$hora["inicio"]." - ".$hora["fin"];
                    foreach ($dias as $dia){
                        foreach ($diasalumno as $diaalumno){
                            foreach ($diaalumno as $da){
                                if ($grupoid==$da["grupoid"] && $dia["dia"]==$da["dia"] && $da["horainicio"]==$hora["inicio"] && $da["horafin"]==$hora["fin"]) {
                                    $respuesta[$indice]["planestudioid"] = $da['planestudioid'];
                                    $respuesta[$indice]["gradoid"] = $grupoentidad->getGradoid()->getGradoid();
                                    $gn = $da["materia"];
                                    $item=["materia"=>$gn,'mat' => $da['materia'], "inicio"=>' ',"fin"=>' ', 'all' => $da];
                                    $find = false;
                                    foreach($respuesta[$indice]["horario"][$key][$dia["nombre"]] as $hh){
                                        if($hh['mat'] == $da['materia']){
                                            $find = true;
                                        }
                                    }
                                    if(!$find){
                                        $respuesta[$indice]["horario"][$key][$dia["nombre"]][]=$item;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            foreach($horario as $h){
                if($h['taller'] == true){
                    $grupoentidad=$dbm->getRepositorioById("CeTallercurricular","tallercurricularid",$h['grupoid']);
                    $grados=$dbm->getRepositoriosById("CeGradoportallercurricular","tallercurricularid",$h['grupoid']);
                    $alumnos = $dbm->getRepositoriosById("CeAlumnocicloportaller","tallercurricularid",$h['grupoid']);

                    $gruposTaller = [];

                    foreach($alumnos as $al){
                        $aciclo = $dbm->getRepositorioById("CeAlumnocicloporgrupo","alumnoporcicloid",$al->getAlumnoporcicloid()->getAlumnoporcicloid());

                        if($aciclo){
                            $nombre = $al->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNombre()." ".$al->getAlumnoporcicloid()->getGradoid()->getGrado()." ".$aciclo->getGrupoid()->getNombre();

                            $find = false;

                            foreach($gruposTaller as $g){
                                if($g == $nombre){
                                    $find = true;
                                }
                            }

                            if(!$find){
                                $gruposTaller[] = $nombre;
                            }
                        }
                    }
                    
                    foreach($grados as $g){
                        if(count($gruposTaller) == 0){
                            foreach($respuesta as $key => $r){
                                if($h['planestudioid'] == $r['planestudioid'] && $g->getGradoid()->getGradoid() == $r['gradoid']){
                                    $indice = $key;
                                    foreach ($dias as $dia){
                                        foreach ($horas as $key=>$hora){
                                            if ($dia["dia"]==$h["dia"] && $h["horainicio"]==$hora["inicio"] && $h["horafin"]==$hora["fin"]) {
                                                
                                                $gn = $h["materia"];
    
                                                $h['grupo'] = $gn;
                                                
                                                $item=["materia"=>$gn,'mat' => $h['materia'], "inicio"=>' ',"fin"=>' ', 'all' => $h];
                                                $find = false;
                                                foreach($respuesta[$indice]["horario"][$key][$dia["nombre"]] as $hh){
                                                    if($hh['mat'] == $h['materia'] && $hh['all']['grupo'] == $h['materia']){
                                                        $find = true;
                                                    }
                                                }
                                                if(!$find){
                                                    $respuesta[$indice]["horario"][$key][$dia["nombre"]][]=$item;
                                                }
                                            }
                                        }
                                    }
                                    
                                }
                            }
                        }else{
                            foreach($gruposTaller as $gt){
                                foreach($respuesta as $key => $r){
                                    if($r['grupo'] == $gt){
                                        $indice = $key;
                                        foreach ($dias as $dia){
                                            foreach ($horas as $key=>$hora){
                                                if ($dia["dia"]==$h["dia"] && $h["horainicio"]==$hora["inicio"] && $h["horafin"]==$hora["fin"]) {
                                                    
                                                    $gn = $h["materia"];
        
                                                    $h['grupo'] = $gn;

                                                    $gn = ' ';
                                                    
                                                    $item=["materia"=>$gn,'mat' => $h['materia'], "inicio"=>' ',"fin"=>' ', 'all' => $h];
                                                    $find = false;
                                                    foreach($respuesta[$indice]["horario"][$key][$dia["nombre"]] as $hh){
                                                        if($hh['mat'] == $h['materia'] && $hh['all']['grupo'] == $h['materia']){
                                                            $find = true;
                                                        }
                                                    }
                                                    if(!$find){
                                                        $respuesta[$indice]["horario"][$key][$dia["nombre"]][]=$item;
                                                    }
                                                }
                                            }
                                        }
                                        
                                    }
                                } 
                            }
                        }
                        
                    }
                }
            }
            
            $respuesta=array_values($respuesta);
            usort($respuesta, function($a, $b) {
                return $a['grupo']> $b['grupo']? 1 : -1;
            });
            array_reverse($respuesta);

            $res = [];
            foreach($respuesta as $r){
                $find = false;
                $ro = [
                    'grupo' => $r['grupo'],
                    'horario' => []
                ];
                foreach($r['horario'] as $rr){
                    if($rr['Lunes'] || $rr['Martes'] || $rr['Miercoles'] || $rr['Jueves'] || $rr['Viernes']){
                        $ro['horario'][] = $rr;
                    }
                }
                $res[] = $ro;
            }
            if(count($res) == 0){
                return new View('No se encontraron resultados', Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($res, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     *  Regresa el horario del alumno
     * @Rest\Post("/api/Controlescolar/ImportarHorarios/TablaHorarioAlumno", name="getTablaHorarioAlumno")
     */
    public function getTablaHorarioAlumno()
    {
        try {
            $respuesta=[];
            $filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $cicloactual = $dbm->BuscarAlumnosA([
                'alumnoid' => $filtros['alumnoid']
            ]);            

            $alumnociclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $cicloactual[0]['alumnoporcicloid']);
            $gruposAl = $dbm->getRepositoriosById('CeAlumnocicloporgrupo', 'alumnoporcicloid', $alumnociclo->getAlumnoporcicloid());

            $filtros["cicloid"] = $filtros["cicloid"] ? $filtros["cicloid"] : $alumnociclo->getCicloid()->getCicloid();

            $horarioS = [];

            foreach($gruposAl as $grupo){
                $h = $dbm->BuscarTablaHorario([
                    'cicloid' => $alumnociclo->getCicloid()->getCicloid(),
                    'nivelid' => $alumnociclo->getGradoid()->getNivelid()->getNivelid(),
                    'gradoid' => $alumnociclo->getGradoid()->getGradoid(),
                    'grupoid' => $grupo->getGrupoid()->getGrupoid(),
                    'alumnoid' => $alumnociclo->getAlumnoid()->getAlumnoid(),
                ]);
                foreach($h as $hh){
                    $horarioS[] = $hh;
                }
            }

            $talleresAl = $dbm->getRepositoriosById('CeAlumnocicloportaller', 'alumnoporcicloid', $alumnociclo->getAlumnoporcicloid());


            foreach($talleresAl as $taller){
                $grado = $dbm->getOneByParametersRepositorio('CeGradoportallercurricular', [
                    'tallercurricularid' => $taller->getTallercurricularid()->getTallercurricularid(),
                    'gradoid' => $alumnociclo->getGradoid()->getGradoid(),
                ]);

                if($grado){
                    $h = $dbm->BuscarTablaHorario([
                        'cicloid' => $alumnociclo->getCicloid()->getCicloid(),
                        'nivelid' => $alumnociclo->getGradoid()->getNivelid()->getNivelid(),
                        'gradoid' => $alumnociclo->getGradoid()->getGradoid(),
                        'tallerid' => $taller->getTallercurricularid()->getTallercurricularid(),
                        'alumnoid' => $alumnociclo->getAlumnoid()->getAlumnoid(),
                    ]);
                    foreach($h as $hh){
                        $horarioS[] = $hh;
                    }
                }
            }

            $horario = $dbm->BuscarTablaHorario($filtros);
            $talleres = $dbm->getTalleres($filtros);
            foreach($talleres as $taller){
                $data = $filtros;
                $data['groupby'] = true;
                $data['tallerid'] = $taller['tallercurricularid'];
                $tall = $dbm->BuscarTablaHorario($data);
                foreach($tall as $t){
                    $t['taller'] = true;
                    $horario[] = $t;
                }
            }
            $horainicial="24:00";
            $horas = [];
            $tipo = [];
            $horafinal="00:00";
            foreach ($horario as $hora){
                if($hora['taller'] !== true){
                    $grupokey=false;
                    foreach ($grupos as $key => $grupo) {
                        if ( $key==$hora["grupoid"]) {
                            $grupokey=$key;
                            break;
                        }
                    }
                    if ($grupokey=== false){
                        $grupos[$hora["grupoid"]]=$hora["grupo"];
                    }
                    $diasalumno[$hora["dia"]][]=$hora;
                    if ($hora["horainicio"]<$horainicial){
                        $horainicial=$hora["horainicio"];
                    }
                    if ($hora["horafin"]>$horafinal){
                        $horafinal=$hora["horafin"];
                    }
                }
            }
            $date1 = new \DateTime($horainicial);
            $date2 = new \DateTime($horafinal);
            $diff = $date2->diff($date1);
            $cuantashoras= $diff->format('%h');
            // for ($i=0;$i<$cuantashoras;$i++){
            //     $b=$date1->format('H')+$i;
            //     $e=$b+1;
            //     $horas[]=["inicio"=>sprintf("%02d", $b).":00","fin"=>sprintf("%02d", $e).":00"];
            // }
            foreach($horario as $h){
                $find = false;
                foreach($horas as $hh){
                    if($hh['inicio'] == $h['horainicio'] && $hh['fin'] == $h['horafin']){
                        $find = true;
                    }
                }
                if(!$find){
                    $horas[]=["inicio"=>$h['horainicio'],"fin"=>$h['horafin']];
                }
            }
            sort($horas);
            $dias=[["dia"=>1,"nombre"=>"Lunes"],["dia"=>2,"nombre"=>"Martes"],["dia"=>3,"nombre"=>"Miercoles"],["dia"=>4,"nombre"=>"Jueves"],["dia"=>5,"nombre"=>"Viernes"]];
            // if (count($grupos)==1){
            //     foreach ($horas as $key=>$hora){
            //         $respuesta[$key]["hora"]=$hora["inicio"]." - ".$hora["fin"];
            //         foreach ($dias as $dia){
            //             foreach ($diasalumno as $diaalumno){
            //                 foreach ($diaalumno as $da){
            //                     if ($dia["dia"]==$da["dia"] && $da["horainicio"]==$hora["inicio"] && $da["horafin"]==$hora["fin"]) {
            //                         $item=["materia"=>$da["materia"],"inicio"=>' ',"fin"=>' ', 'all' => $da];
            //                         $respuesta[$key][$dia["nombre"]][]=$item;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // }else{
            // }
            foreach ($grupos as $grupoid=>$grupo){
                $grupoentidad=$dbm->getRepositorioById("CeGrupo","grupoid",$grupoid);
                if ($grupoentidad->getTipogrupoid()->getTipogrupoid()==1){
                    $indice=$grupoid;
                    $respuesta[$indice]["grupo"]=$grupoentidad->getGradoid()->getNivelid()->getNombre()." ".$grupoentidad->getGradoid()->getGrado()." ".$grupoentidad->getNombre();
                }else{
                    $grupoorigen=$dbm->getRepositorioById("CeGrupoorigenporsubgrupo","grupoid",$grupoid);
                    $indice=$grupoorigen->getGrupoorigenid()->getGrupoid();
                }
                
                foreach ($horas as $key=>$hora){
                    $respuesta[$indice]["horario"][$key]["hora"]=$hora["inicio"]." - ".$hora["fin"];
                    foreach ($dias as $dia){
                        foreach ($diasalumno as $diaalumno){
                            foreach ($diaalumno as $da){
                                if ($grupoid==$da["grupoid"] && $dia["dia"]==$da["dia"] && $da["horainicio"]==$hora["inicio"] && $da["horafin"]==$hora["fin"]) {
                                    $respuesta[$indice]["planestudioid"] = $da['planestudioid'];
                                    $respuesta[$indice]["gradoid"] = $grupoentidad->getGradoid()->getGradoid();
                                    $gn = $da["materia"];
                                    $item=["materia"=>$gn,'mat' => $da['materia'], "inicio"=>' ',"fin"=>' '];

                                    $item = array_merge($item, $da);
                                    $find = false;
                                    foreach($respuesta[$indice]["horario"][$key][$dia["nombre"]] as $hh){
                                        if($hh['mat'] == $da['materia']){
                                            $find = true;
                                        }
                                    }
                                    if(!$find){
                                        $respuesta[$indice]["horario"][$key][$dia["nombre"]][]=$item;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            foreach($horario as $h){
                if($h['taller'] == true){
                    $grupoentidad=$dbm->getRepositorioById("CeTallercurricular","tallercurricularid",$h['grupoid']);
                    $grados=$dbm->getRepositoriosById("CeGradoportallercurricular","tallercurricularid",$h['grupoid']);
                    $alumnos = $dbm->getRepositoriosById("CeAlumnocicloportaller","tallercurricularid",$h['grupoid']);

                    $gruposTaller = [];

                    foreach($alumnos as $al){
                        $aciclo = $dbm->getRepositorioById("CeAlumnocicloporgrupo","alumnoporcicloid",$al->getAlumnoporcicloid()->getAlumnoporcicloid());

                        if($aciclo){
                            $nombre = $al->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNombre()." ".$al->getAlumnoporcicloid()->getGradoid()->getGrado()." ".$aciclo->getGrupoid()->getNombre();

                            $find = false;

                            foreach($gruposTaller as $g){
                                if($g == $nombre){
                                    $find = true;
                                }
                            }

                            if(!$find){
                                $gruposTaller[] = $nombre;
                            }
                        }
                    }
                    
                    foreach($grados as $g){
                        if(count($gruposTaller) == 0){
                            foreach($respuesta as $key => $r){
                                if($h['planestudioid'] == $r['planestudioid'] && $g->getGradoid()->getGradoid() == $r['gradoid']){
                                    $indice = $key;
                                    foreach ($dias as $dia){
                                        foreach ($horas as $key=>$hora){
                                            if ($dia["dia"]==$h["dia"] && $h["horainicio"]==$hora["inicio"] && $h["horafin"]==$hora["fin"]) {
                                                
                                                $gn = $h["materia"];
    
                                                $h['grupo'] = $gn;
                                                
                                                $item=["materia"=>$gn,'mat' => $h['materia'], "inicio"=>' ',"fin"=>' '];
                                                $item = array_merge($item, $h);
                                                $find = false;
                                                foreach($respuesta[$indice]["horario"][$key][$dia["nombre"]] as $hh){
                                                    if($hh['mat'] == $h['materia'] && $hh['all']['grupo'] == $h['materia']){
                                                        $find = true;
                                                    }
                                                }
                                                if(!$find){
                                                    $respuesta[$indice]["horario"][$key][$dia["nombre"]][]=$item;
                                                }
                                            }
                                        }
                                    }
                                    
                                }
                            }
                        }else{
                            foreach($gruposTaller as $gt){
                                foreach($respuesta as $key => $r){
                                    if($r['grupo'] == $gt){
                                        $indice = $key;
                                        foreach ($dias as $dia){
                                            foreach ($horas as $key=>$hora){
                                                if ($dia["dia"]==$h["dia"] && $h["horainicio"]==$hora["inicio"] && $h["horafin"]==$hora["fin"]) {
                                                    
                                                    foreach($talleresAl as $t){
                                                        if($t->getTallercurricularid()->getTallercurricularid() == $h['grupoid'] && $t->getTallercurricularid()->getProfesorid()->getProfesorid() == $h['profesorid']){
                                                            $gn = $h["materia"];
        
                                                            $h['grupo'] = $gn;

                                                            $gn = ' ';
                                                            
                                                            $item=["materia"=>$gn,'mat' => $h['materia'], "inicio"=>' ',"fin"=>' '];
                                                            $item = array_merge($item, $h);
                                                            $find = false;
                                                            foreach($respuesta[$indice]["horario"][$key][$dia["nombre"]] as $hh){
                                                                if($hh['mat'] == $h['materia'] && $hh['all']['grupo'] == $h['materia']){
                                                                    $find = true;
                                                                }
                                                            }
                                                            if(!$find){
                                                                $respuesta[$indice]["horario"][$key][$dia["nombre"]][]=$item;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        
                                    }
                                } 
                            }
                        }
                        
                    }
                }
            }

            function my_array_unique($array, $keep_key_assoc = false){
                $duplicate_keys = array();
                $tmp = array();       
            
                foreach ($array as $key => $val){
                    // convert objects to arrays, in_array() does not support objects
                    if (is_object($val))
                        $val = (array)$val;
            
                    if (!in_array($val, $tmp))
                        $tmp[] = $val;
                    else
                        $duplicate_keys[] = $key;
                }
            
                foreach ($duplicate_keys as $key)
                    unset($array[$key]);
            
                return $keep_key_assoc ? $array : array_values($array);
            }
            
            $respuesta=array_values($respuesta);
            usort($respuesta, function($a, $b) {
                return $a['grupo']> $b['grupo']? 1 : -1;
            });
            array_reverse($respuesta);

            $res = [];
            foreach($respuesta as $r){
                $find = false;
                $ro = [
                    'grupo' => $r['grupo'],
                    'horario' => []
                ];
                foreach($r['horario'] as $rr){
                    if($rr['Lunes'] || $rr['Martes'] || $rr['Miercoles'] || $rr['Jueves'] || $rr['Viernes']){
                        $ro['horario'][] = $rr;
                    }
                }
                $res[] = $ro;
            }
            
            if(count($res) == 0){
                return new View('No se encontraron resultados', Response::HTTP_PARTIAL_CONTENT);
            }
            $result = [];
            foreach($res[0]['horario'] as $h){
                $Lunes = [];

                foreach($h['Lunes'] as $hh){
                    $find = false;
                    foreach($Lunes as $l){
                        if($hh['grupoid'] == $l['grupoid']){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $Lunes[] = $hh;
                    }
                }

                $h['Lunes'] = $Lunes;
                $Martes = [];

                foreach($h['Martes'] as $hh){
                    $find = false;
                    foreach($Martes as $l){
                        if($hh['grupoid'] == $l['grupoid']){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $Martes[] = $hh;
                    }
                }

                $h['Martes'] = $Martes;
                $Miercoles = [];

                foreach($h['Miercoles'] as $hh){
                    $find = false;
                    foreach($Miercoles as $l){
                        if($hh['grupoid'] == $l['grupoid']){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $Miercoles[] = $hh;
                    }
                }

                $h['Miercoles'] = $Miercoles;
                $Jueves = [];

                foreach($h['Jueves'] as $hh){
                    $find = false;
                    foreach($Jueves as $l){
                        if($hh['grupoid'] == $l['grupoid']){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $Jueves[] = $hh;
                    }
                }

                $h['Jueves'] = $Jueves;
                $Viernes = [];

                foreach($h['Viernes'] as $hh){
                    $find = false;
                    foreach($Viernes as $l){
                        if($hh['grupoid'] == $l['grupoid']){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $Viernes[] = $hh;
                    }
                }

                $h['Viernes'] = $Viernes;
                $result[] = $h;
            }
            return new View([$result], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}