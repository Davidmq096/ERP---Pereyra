<?php

namespace AppBundle\Controller\Admisiones\ModalSolicitud;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class AreaMedicaController extends FOSRestController
{

    /**
     * Reotorna valores iniciales
     * @Rest\Get("/api/Solicitud/datoMedico", name="datoMedicoHome")
     */
    public function datoMedicoAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);        
        
        $Sanguineo = $dbm->getRepositorios('Tiposanguineo');
        $Parentesco = $dbm->getRepositorios('Parentesco');
        $Alergias = $dbm->getRepositorios('Alergia');
        $Antecedentefamiliarimportante = $dbm->getRepositorios('Antecedentefamiliarimportante');

        $antigripales = $dbm->getRepositoriosById('Medicamento', 'antigripal', 1);
        $analgesicos = $dbm->getRepositoriosById('Medicamento', 'analgesico', 1);
        $antispasmodicos = $dbm->getRepositoriosById('Medicamento', 'antispasmodico', 1);
        $materiales = $dbm->getRepositoriosById('Medicamento', 'materialcuracion', 1);
        $unguentos = $dbm->getRepositoriosById('Medicamento', 'unguento', 1);
        $remedios = $dbm->getRepositoriosById('Medicamento', 'remediosalternativo', 1);
        $antiacidos = $dbm->getRepositoriosById('Medicamento', 'antiacidos', 1);

        $solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $Tutores = $dbm->getRepositorioById('Padresotutores', 'solicitudadmisionid', $solicitud->getSolicitudadmisionid());
        $datomedico = $dbm->getRepositorioById('Datomedico', 'datosaspiranteid', $solicitud->getDatoaspiranteid()->getDatoaspiranteid());
        $contactoDatomedico = $dbm->getRepositoriosById('AdContactoemergencia', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $SolicitudByAlergico = $dbm->getRepositoriosById('Datomedicoporalergia', 'datomedicoid', $datomedico->getDatomedicoid());
        $SolicitudByAntecedentes = $dbm->getRepositoriosById('Datomedicoantecedente', 'datomedicoid', $datomedico->getDatomedicoid());

        $return = array('solicitud' => $solicitud, 'datomedico' => $datomedico, 'sanguineo' => $Sanguineo, 'antigripales' => $antigripales, 'analgesicos' => $analgesicos,
            'antispasmodicos' => $antispasmodicos, 'materiales' => $materiales, 'unguentos' => $unguentos, 'remedios' => $remedios, 'antiacidos' => $antiacidos, 'tutores' => $Tutores, 'parentesco' => $Parentesco, 'alergiasL' => $Alergias, 'antecedenteimportantes' => $Antecedentefamiliarimportante, 'solicitudAlergias' => $SolicitudByAlergico, 'solicitudAntecedente' => $SolicitudByAntecedentes, 'contactomedico' => $contactoDatomedico);
        return new View($return, Response::HTTP_OK);
    }


    /**
     * Guarda los valores de los datos medicos
     * @Rest\Post("/api/Solicitud/datoMedico" , name="GuardarDatomedico")
     */
    public function SaveDatoMedico()
    {
        try {
            $data = $_REQUEST;
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
            $Datoaspirante = $dbm->getRepositorioById('Datoaspirante', 'datoaspiranteid', $data['datoaspiranteid']);
            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'datoaspiranteid', $data['datoaspiranteid']);
            $Datomedico = $dbm->getRepositorioById('Datomedico', 'datosaspiranteid', $data['datoaspiranteid']);
            //$Datomedico = new Datomedico();
            $Datomedico->setPadece(empty($data['enfermedad']) ? null : $data['enfermedad']);

            $Datomedico->setPadeceenfermedadcuidanombre(empty($data['enfermedadNombre']) ? null : $data['enfermedadNombre']);
            $Datomedico->setPadeceenfermedadcuidatelefono(empty($data['enfermedadTelefono']) ? null : $data['enfermedadTelefono']);
            $Datomedico->setPadeceenfermedadcuidadescripcion(empty($data['enfermedadDescripcion']) ? null : $data['enfermedadDescripcion']);

            //$Datomedico->setAlergico(empty($data['alergia1']) ? null : $data['alergia1']);
            //$Datomedico->setAntecedentefamiliar(empty($data['antecedente']) ? null : $data['antecedente']);
            $Datomedico->setExamenauditivo(empty($data['auditivo']) ? null : $data['auditivo']);

            $Datomedico->setAparatoauditivo(empty($data['aparatoAuditivo']) ? null : $data['aparatoAuditivo']);

            $Datomedico->setExamenortopedicos(empty($data['ortopedico']) ? null : $data['ortopedico']);
            $Datomedico->setEnfermedadcronica(empty($data['cronica']) ? null : $data['cronica']);
            $Datomedico->setTalla(empty($data['talla']) ? null : $data['talla']);
            $Datomedico->setAlergicosustancias(empty($data['sustancia']) ? null : $data['sustancia']);
            $Datomedico->setMaterialcuracion(empty($data['curacion']) ? null : $data['curacion']);
            $Datomedico->setUnguentos(empty($data['unguento']) ? null : $data['unguento']);
            $Datomedico->setNombreautoriza(empty($data['autoriza']) ? null : $data['autoriza']);
            $Datomedico->setFirma(empty($data['autorizacion']) ? null : $data['autorizacion']);
            $Datomedico->setAutorizoantihistaminico(empty($data['autorizo']) ? null : $data['autorizo']);
            $Datomedico->setExamenvista(empty($data['vista']) ? null : $data['vista']);
            $Datomedico->setLentes(empty($data['lentes']) ? null : $data['lentes']);
            $Datomedico->setAditamentosortopedico(empty($data['ortopedico1']) ? null : $data['ortopedico1']);
            //$Datomedico->setTiposanguinio(empty($data['sanguineo']) ? null : $data['sanguineo']);
            if (!empty($data['sanguineo'])) {
                $sanguineo = $dbm->getRepositorioById('Tiposanguineo', 'tiposanguineoid', $data['sanguineo']);
                $Datomedico->setTiposanguinio($sanguineo);
                //$Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setParentescoid($Parentesco);
            }
            // if (!empty($data['parentescoCE'])) {
            //     $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $data['parentescoCE']);
            //     $Datomedico->setContactoemergenciaparentesco($parentesco
            //     );
            // }
            $Datomedico->setPeso(empty($data['peso']) ? null : $data['peso']);
            $Datomedico->setMedicamentoregularidad(empty($data['medicamento']) ? null : $data['medicamento']);
            $Datomedico->setMedicamentoadministrar(empty($data['medicamento1']) ? null : $data['medicamento1']);
            $Datomedico->setAnalgesicosantinflamatorios(empty($data['analgesicos']) ? null : $data['analgesicos']);
            $Datomedico->setAntigripalesantihistaminicos(empty($data['antigripales']) ? null : $data['antigripales']);
            $Datomedico->setAntiacidos(empty($data['Antiacidos']) ? null : $data['Antiacidos']);

            $Datomedico->setRemediosalternativos(empty($data['remediosAlternos']) ? null : $data['remediosAlternos']);
            $Datomedico->setAntiespasmodicos(empty($data['atispasmodico']) ? null : $data['atispasmodico']);

            foreach($data['contactomedico'] as $contacto){
                if(empty($contacto['contactoId'])){
                    $contactoDatomedico = new \AppBundle\Entity\AdContactoemergencia();
                    $contactoDatomedico->setNombre(empty($contacto['nombreCE']) ? null : $contacto['nombreCE']);
                    $contactoDatomedico->setEmail(empty($contacto['emailCE']) ? null : $contacto['emailCE']);
                    if($contacto['parentescoCE']){
                        $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $contacto['parentescoCE']);
                        if($parentesco){
                            $contactoDatomedico->setParentescoid($parentesco);
                        }
                    }
                    $contactoDatomedico->setSolicitudadmisionid($Solicitud);
                    $lada = str_replace(')','',str_replace('(', '', $contacto['ladatelCE']));
                    $tel = str_replace('-','', $contacto['comteltemp']);
                    $contactoDatomedico->setTelefono(empty($contacto['ladatelCE']) ? null : $lada . '-' . $tel);
                    $dbm->saveRepositorio($contactoDatomedico);
                }else{
                    $contactoDatomedico = $dbm->getRepositorioById('AdContactoemergencia', 'contactoemergenciaid', $contacto['contactoId']);
                    $contactoDatomedico->setNombre(empty($contacto['nombreCE']) ? null : $contacto['nombreCE']);
                    $contactoDatomedico->setEmail(empty($contacto['emailCE']) ? null : $contacto['emailCE']);
                    if($contacto['parentescoCE']){
                        $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $contacto['parentescoCE']);
                        if($parentesco){
                            $contactoDatomedico->setParentescoid($parentesco);
                        }
                    }
                    $contactoDatomedico->setSolicitudadmisionid($Solicitud);
                    $lada = str_replace(')','',str_replace('(', '', $contacto['ladatelCE']));
                    $tel = str_replace('-','', $contacto['comteltemp']);
                    $contactoDatomedico->setTelefono(empty($contacto['ladatelCE']) ? null : $lada . '-' . $tel);
                    $dbm->saveRepositorio($contactoDatomedico);
                }
            }
            foreach($data['eliminados'] as $eliminado){
                $contactoDatomedico = $dbm->getRepositorioById('AdContactoemergencia', 'contactoemergenciaid', $eliminado);
                if($contactoDatomedico){
                    $dbm->removeRepositorio($contactoDatomedico);
                }
            }
            // $Datomedico->setContactoemergencianombre('-');
            // $Datomedico->setContactoemergenciatelefono('-');
            // $Datomedico->setContactoemergenciaemail('-');


            $Datomedico->setOtraalergia(empty($data['otraAlergia']) ? null : $data['otraAlergia']);

            $arrayAlergiasSave = $dbm->getRepositoriosById('Datomedicoporalergia', 'datomedicoid', $Datomedico->getDatomedicoid());
            foreach ($arrayAlergiasSave as $n) {
                $dbm->removeRepositorio($n);
            }

            $arrayAlergias = ($data['alergia1']);
            foreach ($arrayAlergias as $val) {
                $DxA = new \AppBundle\Entity\Datomedicoporalergia();
                $AlergiaEntity = $dbm->getRepositorioById('Alergia', 'alergiaid', $val);
                $DxA->setAlergiaid($AlergiaEntity);
                $DxA->setDatomedicoid($Datomedico);
                $dbm->saveRepositorio($DxA);
            }

            $Datomedico->setDescripcionantecedenteimportante(empty($data['descripcionAntecedente']) ? null : $data['descripcionAntecedente']);

            $arrayAntecedentesSave = $dbm->getRepositoriosById('Datomedicoantecedente', 'datomedicoid', $Datomedico->getDatomedicoid());
            foreach ($arrayAntecedentesSave as $a) {
                $dbm->removeRepositorio($a);
            }

            $arrayAntecedentes = ($data['antecedente']);
            foreach ($arrayAntecedentes as $valA) {
                $DxAn = new \AppBundle\Entity\Datomedicoantecedente();
                $AntecedenteEntity = $dbm->getRepositorioById('Antecedentefamiliarimportante', 'antecedentefamiliarimportanteid', $valA);
                $DxAn->setAntecedentefamiliarimportanteid($AntecedenteEntity);
                $DxAn->setDatomedicoid($Datomedico);
                $dbm->saveRepositorio($DxAn);
            }

            $Datomedico->setDatosaspiranteid($Datoaspirante);
            if($data['version']==1){
                $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
                $EstatusS = $dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', 8);
                $Solicitud->setEstatussolicitudid($EstatusS);
                $dbm->saveRepositorio($Solicitud);
            }

            $dbm->saveRepositorio($Datomedico);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View("No se pudo guardar el registro ", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     *
     * @Rest\Get("/api/Alumno/Data/ContactoMedico/{id}", name="consultaContactos")
     */
    public function consultaContactos($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $alumnos =  $dbm->getRepositoriosById('CeContactoemergencia', 'alumnoid', $id);
            return new View($alumnos, Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * verifica si ya guardo area medica para ciencias
     * @Rest\Post("/api/Solicitud/areaMedicaCiencias" , name="areamedicaGuardarArea")
     */
    public function SaveArea()
    {
        $data = $_REQUEST;
        $dbm = $this->get("db_manager");
        if($data['datosaspiranteid']){
            $Datomedico = $dbm->getRepositorioById('Datomedico', 'datosaspiranteid', $data['datosaspiranteid']);
            if($Datomedico){
                return new View(true, Response::HTTP_OK);
            }else{
                return new View('Debe guardar Area médica', Response::HTTP_OK);
            }
        }
    }



     /**
     * verifica si ya guardo area medica para ciencias
     * @Rest\Post("/api/Alumno/Guardar/ContactoMedico" , name="guardarContactoMedico")
     */
    public function guardarContactoMedico()
    {
        try{
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);    
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
            $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid']);
            if($alumno){
                foreach($data['contactos'] as $contacto){
                    if(empty($contacto['contactoemergenciaid'])){
                        $contactoDatomedico = new \AppBundle\Entity\CeContactoemergencia();
                        $contactoDatomedico->setNombre(empty($contacto['nombre']) ? null : $contacto['nombre']);
                        $contactoDatomedico->setEmail(empty($contacto['email']) ? null : $contacto['email']);
                        if($contacto['parentescoid']){
                            $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $contacto['parentescoid']);
                            if($parentesco){
                                $contactoDatomedico->setParentescoid($parentesco);
                            }
                        }
                        $contactoDatomedico->setAlumnoid($alumno);
                        $contactoDatomedico->setTelefono(empty($contacto['telefonocontacto']) ? null : $contacto['telefonocontacto']);
                    }else{
                        $contactoDatomedico = $dbm->getRepositorioById('CeContactoemergencia', 'contactoemergenciaid', $contacto['contactoemergenciaid']);
                        $contactoDatomedico->setNombre(empty($contacto['nombre']) ? null : $contacto['nombre']);
                        $contactoDatomedico->setEmail(empty($contacto['email']) ? null : $contacto['email']);
                        if($contacto['parentescoid']){
                            $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $contacto['parentescoid']);
                            if($parentesco){
                                $contactoDatomedico->setParentescoid($parentesco);
                            }
                        }
                        $contactoDatomedico->setAlumnoid($alumno);
                        $contactoDatomedico->setTelefono(empty($contacto['telefonocontacto']) ? null : $contacto['telefonocontacto']);
                    }
                    $dbm->saveRepositorio($contactoDatomedico);
                }
                foreach($data['eliminados'] as $eliminado){
                    $contactoDatomedico = $dbm->getRepositorioById('CeContactoemergencia', 'contactoemergenciaid', $eliminado);
                    if($contactoDatomedico){
                        $dbm->removeRepositorio($contactoDatomedico);
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se han guardado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View("No se pudo guardar el registro ", Response::HTTP_NOT_FOUND);
        }
    }
}
