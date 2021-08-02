<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Filtrado de Tipos de Becas
 *
 * @author Rubén
 */
class TipoBajaDB extends BaseDBManager
{
    public function Buscartiposbaja($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("tb")
            ->from("AppBundle:CeTipobaja", 'tb')
            ->groupby('tb.tipobajaid');


            if (isset($filtros['descripcion'])) {
                $escape=array("_","%");
                $escapados=array("\_","\%");
                $filtros['descripcion']=str_replace($escape,$escapados,$filtros['descripcion']);
                $result->andWhere('tb.nombre like :descripcion')
                    ->setParameter('descripcion', '%' . $filtros['descripcion'] . '%');
            }
            if (isset($filtros['activo'])) {
                $result->andWhere('tb.activo =' . $filtros['activo']);
            }

        return $result->getQuery()->getResult();
    }

    public function eliminartipodebaja($filtros)
    {
        try {
            $qb = $this->em->getConnection();
            $sql = "DELETE FROM ce_tipobaja WHERE TipoBajaId=?";
            $stmt = $qb->prepare($sql);
            $stmt->execute([$filtros['tipobajaid']]);

            return true;
        } catch (Exceptio $e) {
            return false;
        }



    }

}