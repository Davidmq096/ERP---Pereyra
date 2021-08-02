<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use Doctrine\Common\Persistence\ObjectManager;
use DBDatabaseManager;

use AppBundle\DB\Mysql\Pagos\PagosDB;

class DbmPagos extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'pagos' => new PagosDB($em)
        ));
    }

    /*
    * Metodo para buscar edeudos pagados
    */
    public function BuscarDcocumentosPagados($filtros)
    {
        return $this->dbManagers['pagos']->BuscarDcocumentosPagados($filtros);
    }

        /*
    * Metodo para buscar inscripciones
    */
    public function BuscarDcocumentosInscripcion($filtros)
    {
        return $this->dbManagers['pagos']->BuscarDcocumentosInscripcion($filtros);
    }
    /*
    * Metodo para buscar colegiaturas
    */
    public function BuscarDocumentosPorPagarColegiatura($filtros)
    {
        return $this->dbManagers['pagos']->BuscarDocumentosPorPagarColegiatura($filtros);
    }

        /*
    * Metodo para buscar adeudos diferentes de colegiatura e inscripciones
    */
    public function BuscarDcocumentosOtros($filtros)
    {
        return $this->dbManagers['pagos']->BuscarDcocumentosOtros($filtros);
    }
}
