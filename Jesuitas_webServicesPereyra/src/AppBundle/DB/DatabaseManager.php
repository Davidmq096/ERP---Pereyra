<?php

namespace AppBundle\DB;

use AppBundle\DB\Mysql\DocumentoDB;
use AppBundle\DB\Mysql\FamiliarDB;
use AppBundle\DB\Mysql\Repositorio;
use AppBundle\DB\Mysql\SolicitudAdmisionDB;
use Doctrine\ORM\EntityManager as EM;

class DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        $this->em = $em;
        $this->dbManagers = array(
            //Funciones genericas
            'repositorio' => new Repositorio($this->em),
            //Funciones para obtener informacion de alumnos y familia
            'familiar' => new FamiliarDB($em),

            //(Resolver para quitar)
            'documento' => new DocumentoDB($this->em),
            'solicitudadmision' => new SolicitudAdmisionDB($em),
        );
    }

    /*
     * Metodo para obtener la conexion, aplica para realizar varios saves y delete
     */

    public function getEntityManager()
    {
        return $this->em;
    }

    /*
     * Metodo para obtener la conexion, aplica para realizar varios saves y delete
     */

    public function getConnection()
    {
        return $this->em->getConnection();
    }

    /*
     * Metodo para obtener todos los repositorios registrados por filtros
     */

    public function getByParametersRepositorios($entity, $filtros)
    {
        return $this->dbManagers['repositorio']->getByParametersRepositorios($entity, $filtros);
    }

    /*
     * Metodo para obtener un repositorio registrados por filtros
     */

    public function getOneByParametersRepositorio($entity, $filtros, $order = null)
    {
        return $this->dbManagers['repositorio']->getOneByParametersRepositorio($entity, $filtros, $order);
    }

    /*
     * Metodo para obtener todos los repositorio registrados
     */

    public function getRepositorios($entity)
    {
        return $this->dbManagers['repositorio']->getRepositorios($entity);
    }

    /*
     * Metodo para obtener un array con los campos indicados
     */
    public function getRepositoriosModelo($entity, $fields, $find = false, $orderby = false, $advancedfind = false, $joins = false, $group = false)
    {
        return $this->dbManagers['repositorio']->getDBRepositoriosModelo($entity, $fields, $find, $orderby, $advancedfind, $joins, $group);
    }

    /*
     * Metodo para guardar un nuevo repositorio
     */

    public function saveRepositorio($entity)
    {
        return $this->dbManagers['repositorio']->saveRepositorio($entity);
    }

        /*
     * Metodo para guardar muchos repositorios
     */

    public function saveBulkRepositorio($entity)
    {
        return $this->dbManagers['repositorio']->saveBulkRepositorio($entity);
    }

    /*
     * Metodo para guardar un nuevo repositorio
     */

    public function mergeRepositorio($entity)
    {
        return $this->dbManagers['repositorio']->mergeRepositorio($entity);
    }

    /*
     * Metodo para obtener un repositorio en especifico por Id
     */
    public function getRepositorioById($entity, $idText, $id, $order = null)
    {
        return $this->dbManagers['repositorio']->getRepositorioById($entity, $idText, $id, $order);
    }

    /*
     * Metodo para obtener una lista de repositorios por Id
     */
    public function getRepositoriosById($entity, $idText, $id, $order = null)
    {
        return $this->dbManagers['repositorio']->getRepositoriosById($entity, $idText, $id, $order);
    }

    /*
     * Metodo para Eliminar un repositorio
     */
    public function removeRepositorio($entity)
    {
        return $this->dbManagers['repositorio']->removeRepositorio($entity);
    }

    /*
     * Metodo para Eliminar varios repositorios repositorio
     */

    public function removeManyRepositorio($entity, $idText, $id)
    {
        return $this->dbManagers['repositorio']->removeManyRepositorio($entity, $idText, $id);
    }

    /*
     * Metodo para eliminar muchos repositorios
     */

    public function removeBulkRepositorio($entity)
    {
        return $this->dbManagers['repositorio']->removeBulkRepositorio($entity);
    }












    //Metodo para buscar padres o tutores por apellido de familia
    public function BuscarPadrePorApellido($filtros)
    {
        return $this->dbManagers['familiar']->BuscarPadrePorApellido($filtros);
    }

    //Metodo para buscar alumnos por matricula de la misma familia
    public function BuscarAlumnosMismaFamilia($filtros)
    {
        return $this->dbManagers['familiar']->BuscarAlumnosMismaFamilia($filtros);
    }


    //Funcion para buscar alumnos y sus familias con filtros de busqueda (matricula, ap.paterno, ap.materno)
    public function BuscarAlumnosPorFamilias($filtros)
    {
        return $this->dbManagers['familiar']->BuscarAlumnosPorFamilias($filtros);
    }


    /* -------------  Se van a quitar apartir de aqui --------------
     * Metodo para select de vista solicitud por el id de la solicitud
     */

    public function getTodosEStados()
    {
        return $this->dbManagers['solicitudadmision']->getTodosEStados();
    }

    public function getTodosMunicipios()
    {
        return $this->dbManagers['solicitudadmision']->getTodosMunicipios();
    }

    public function getTodasColoniasByCp($cp)
    {
        return $this->dbManagers['solicitudadmision']->getTodasColoniasByCp($cp);
    }



    /*
     * Funcion para obtener las personas por fiiltros de busqueda
     */

    public function getClavePersonasByFilter($filters)
    {
        return $this->dbManagers['solicitudadmision']->getClavePersonasByFilter($filters);
    }



    //Funcion para obtener los datos de facturacion para el portal familiar
    public function getAlumnosPEG($id)
    {
        return $this->dbManagers['familiar']->getAlumnosPEG($id);
    }

    //Funcion para obtener los datos de facturacion para el portal familiar
    public function getDatosFacturacion($id)
    {
        return $this->dbManagers['familiar']->getDatosFacturacion($id);
    }
    //Funcion para obtener los datos de los alumnos por el Id del padre o tutor
    public function getAlumnosByPadreOTutorId($id, $filtros)
    {
        return $this->dbManagers['familiar']->getAlumnosByPadreOTutorId($id, $filtros);
    }
    //Funcion para obtener los datos de los alumnos por el Id del padre o tutor
    public function getReporteByAlumno($id)
    {
        return $this->dbManagers['familiar']->getReporteByAlumno($id);
    }
    //Funcion para obtener los documentos de los alumnos por la clave de su padre o tutor
    public function getAlumnosDocumentosPorPagarByPadreOTutorId($id, $IsInsCol)
    {
        return $this->dbManagers['documento']->getAlumnosDocumentosPorPagarByPadreOTutorId($id, $IsInsCol);
    }
    //Funcion para obtener los documentos de los alumnos por su clave
    public function getAlumnosDocumentosPorPagarByAlumnoId($id, $IsInsCol)
    {
        return $this->dbManagers['documento']->getAlumnosDocumentosPorPagarByAlumnoId($id, $IsInsCol);
    }
    //Funcion para obtener los documentos pagados de los alumnos por la clave del alumno
    public function getDocumentosPagadosByAlumnoId($id)
    {
        return $this->dbManagers['documento']->getDocumentosPagadosByAlumnoId($id);
    }
    //Funcion para obtener los documentos pagados de los alumnos por la clave de su padre o tutor
    public function getDocumentosPagadosByPadreOTutorId($id)
    {
        return $this->dbManagers['documento']->getDocumentosPagadosByPadreOTutorId($id);
    }

    //Funcion para obtener los documentos pagadps de los alumnos por cada padre o tutor
    public function getDocumentosParaFacturacionByPadreOTutorId($id, $empresaid)
    {
        return $this->dbManagers['documento']->getDocumentosParaFacturacionByPadreOTutorId($id, $empresaid);
    }

    //Funcion para los conceptos de un pago
    public function GetConceptoPago($id)
    {
        return $this->dbManagers['documento']->getConceptoPago($id);
    }
}
