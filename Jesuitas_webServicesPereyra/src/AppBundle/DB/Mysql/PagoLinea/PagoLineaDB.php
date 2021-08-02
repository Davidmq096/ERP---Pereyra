<?php

namespace AppBundle\DB\Mysql\PagoLinea;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;
use AppBundle\DB\DbmPagoLinea;

/**
 * Description of documento
 *
 * @author Inceptio
 */

class PagoLineaDB extends BaseDBManager
{
    
    public function GetTipoDocumento($referencia)
    {   
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("tp.tipodocumentoid")
            ->from("AppBundle:CjDocumentoporpagar", 'dp')
            ->innerJoin('dp.documentoid', 'd')
            ->innerJoin('d.tipodocumento', 'tp')
            ->andWhere('dp.referencia = :referencia or dp.referenciabanco = :referencia')
            ->setParameter('referencia', $referencia);
        $documento = $result->getQuery()->getResult();
        
        foreach($documento as &$doc)
        {
            $tipo = $doc['tipodocumentoid'];
            
            if($tipo == 1 || $tipo == 2)
            {
                return 1;
            }
        } 
        
        return 2;
    }
    
    
    public function GetTipoDocumentoLUX($documento, $matricula)
    {   
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("dp")
            ->from("AppBundle:CjDocumentoporpagar", 'dp')
            ->innerJoin('AppBundle:CeAlumno', 'a', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.alumnoid = dp.alumnoid');
            $qb->andWhere('dp.documento = :documento');
            $qb->andWhere('a.matricula = :matricula');
            $qb->setParameter('documento', $documento);
            $qb->setParameter('matricula', $matricula);
        $documento = $result->getQuery()->getResult();
        
        
        foreach($documento as &$doc)
        {
            $tipo = $doc->getDocumentoid()->getTipodocumento();
            
            if($tipo == 1 || $tipo == 2)
            {
                return 1;
            }
        }
        
        
        return 2;
    }
    
    public function GetFolioPago($cajaid)
    {
        //Folio pag    
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("MAX(p.folio) as Folio")
            ->from("AppBundle:CjPago", 'p');
            $qb->andWhere('p.cajaid = :cajaid');
            $qb->setParameter('cajaid', $cajaid);
        $foliodb = $result->getQuery()->getResult();

        $folioPago = "";

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("d")
            ->from("AppBundle:CjDotacionfolio", 'd');
            $qb->andWhere('d.cajaid = :cajaid');
            $qb->setParameter('cajaid', $cajaid);
        $dotacion = $result->getQuery()->getResult();
        
        $dotacion = $dotacion[0];

        if($foliodb)
        {
            $folioPago = $foliodb[0]["Folio"];
            $max = $dotacion->getFolioFinal();

            $guion = strpos($folioPago, '-');

            if($folioPago)
            {
                $prefijoPago = substr($folioPago, 0, $guion);
                $folioaux = substr($folioPago,  $guion+1);
                $folioaux = intval($folioaux) + 1;
            }
            else
            {
                $prefijoPago = $dotacion->getPrefijo();
                $folioaux = $dotacion->getFolioinicial();
            }


            if($folioaux > $max)
            {
                $abc = "abcdefghijklmnopqrstuvwxyz";

                $folioaux = $dotacion->getFolioinicial();

                $posPrefijo = strpos($abc, strtolower($prefijoPago)) + 1;

                $prefijoPago = strtoupper($abc[$posPrefijo]);
            }

            $coun = strlen(strval($folioaux));
            $coun = 6 - $coun;
            $folioPago = "";

            for($k=0; $k<$coun; $k++)
            {
                $folioPago .= "0";
            }

            $folioPago .= $folioaux;

            $folio = $prefijoPago."-".$folioPago;
        }
        else
        {
            $aux = strval($dotacion->getFolioinicial());
            $coun = count($aux);
            $coun = 6 - $count;
            $folioPago = "";

            for($k=0; $k<$coun; $k++)
            {
                $folioPago .= "0";
            }

            $folioPago .= $aux;

            $folio = $dotacion->getPrefijo()."-".$folioPago;
        }


        return $folio;
    }
    
    public function OrdenarArreglo($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }
            
            foreach ($sortable_array as $k => $v) 
            {
                array_push($new_array, $array[$k]);
            }
        }

        return $new_array;
    }

    public function verificarFolioBitacora() {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pf")
            ->from("AppBundle:CjPagofolio", "pf")
            ->leftJoin("AppBundle:CjPago", "p", Expr\Join::WITH, "p.folio = pf.folio")
            ->Where('p.pagoid is null');

        return $result->getQuery()->getResult();
    }
}
