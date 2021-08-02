<?php

namespace AppBundle\DB\Mysql\Becas;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;
/**
 * Description of Filtrado de Alta alumnos
 *
 * @author David
 */

class AltaAlumnosDB extends BaseDBManager
{

    public function BuscarSolicitudes($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("bs")
            ->from("AppBundle:BcBecasporsolicitud", "bs")
            ->innerJoin("bs.solicitudid", "sa")
            ->innerJoin("bs.becaid", "b")
            ->innerJoin("b.alumnoid", "a");

            if (isset($filtros['solicitudid'])) {
                $result->andWhere('sa.solicitudid = :solicitudid')
                    ->setParameter('solicitudid', $filtros['solicitudid']);
            }
            if (isset($filtros['alumnoid'])) {
                $result->andWhere('a.alumnoid = :alumnoid')
                    ->setParameter('alumnoid', $filtros['alumnoid']);
            }
        return $result->getQuery()->getResult();
    }

    public function agregarAlumnos($filtros) {
        try {
            $conn = $this->em->getConnection();
            $stmt = $conn->prepare('CALL convierteaspiranteenalumno(:matricula, :solicitudadmisionid)');
            $stmt->bindParam(':matricula',  $filtros['matricula']);
            $stmt->bindParam(':solicitudadmisionid',  $filtros['solicitudadmisionid']);
            $stmt->execute(array('matricula' => $filtros['matricula'], 'solicitudadmisionid' => $filtros['solicitudadmisionid'])); 
            
            $conn = $this->em->getConnection();
            $stmt = $conn->prepare('CALL ce_alumnoportalfamiliar_crear(:matricula)');
            $stmt->bindParam(':matricula',  $filtros['matricula']);
            $stmt->execute(array('matricula' => $filtros['matricula']));     

            $conn = $this->em->getConnection();
            $stmt = $conn->prepare('CALL ce_alumnohijopersonalportalfamiliar(:matricula)');
            $stmt->bindParam(':matricula',  $filtros['matricula']);            
            $stmt->execute(array('matricula' => $filtros['matricula'])); 
        } catch (Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }  
    }

}
