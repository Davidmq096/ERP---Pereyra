<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use AppBundle\DB\Mysql\PagoLinea\PagoLineaDB;
use AppBundle\DB\Mysql\DocumentoDB;


class DbmPagoLinea extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'pagolinea' => new PagoLineaDB($em),
            'documento' => new DocumentoDB($em),
        ));
    }
    
    /*
     * Obtiene el tipo de documento 1 = colegiatura e inscripciones, 2 = otros
     */
    public function GetTipoDocumento($referencia) 
    {
        return $this->dbManagers['pagolinea']->GetTipoDocumento($referencia);
    }
    
    /*
     * Obtiene el tipo de documento 1 = colegiatura e inscripciones, 2 = otros para el servicio de LUX
     */
    public function GetTipoDocumentoLUX($documento, $matricula) 
    {
        return $this->dbManagers['pagolinea']->GetTipoDocumentoLUX($documento, $matricula);
    }
    
    
    /*
     * Obtiene el folio de un pago
     */
    public function GetFolioPago($cajaid) 
    {
        return $this->dbManagers['pagolinea']->GetFolioPago($cajaid);
    }
    
    /*
     * Ordena un arreglo por una propiedad
     */
    public function OrdenarArreglo($array, $on, $order) 
    {
        return $this->dbManagers['pagolinea']->OrdenarArreglo($array, $on, $order);
    }
    
    /*
     * Obtiene los documentos por pagar dependiendo de su documento, alumnoid y ciclo
     */
    public function getDocumentosPorPagarPorDocumento($documento, $alumnoid, $cicloid) 
    {
        return $this->dbManagers['documento']->getDocumentosPorPagarPorDocumento($documento, $alumnoid, $cicloid);
    }
    
    public function verificarFolioBitacora() 
    {
        return $this->dbManagers['pagolinea']->verificarFolioBitacora();
    }

}
