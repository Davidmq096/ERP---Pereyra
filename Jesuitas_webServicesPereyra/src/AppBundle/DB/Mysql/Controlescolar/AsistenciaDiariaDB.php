<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Asistencia diaria
 *
 * @author david
 */
class AsistenciaDiariaDB extends BaseDBManager {

	public function GetAsistenciasDiariaDetail($ids) {
        $qb = $this->em->createQueryBuilder();
		$result = $qb->select("
		SUM(CASE WHEN ta.tipoasistenciaid = 1 then 1 else 0 end) as tas,
		SUM(CASE WHEN ta.tipoasistenciaid = 2 then 1 else 0 end) as tis,
		SUM(CASE WHEN ta.tipoasistenciaid = 3 then 1 else 0 end) as trs,
  		SUM(CASE WHEN ta.tipoasistenciaid IN(1,2,3) AND ta.estatusinasistenciaid = 3 then 1 else 0 end) as tjs,
		SUM(CASE WHEN ta.tipoasistenciaid IN(1,2,3) AND ta.estatusinasistenciaid = 2 then 1 else 0 end) as tcs,
		SUM(CASE WHEN ta.tipoasistenciaid = 4 then 1 else 0 end) as ts
		")
        ->from("AppBundle:CeAsistenciapordia","ta")
        ->andWhere('ta.asistenciapordiaid IN (:ids)')
        ->setParameter('ids', $ids);
       
        return $result->getQuery()->getResult();
    }

    public function BuscarIProfesorTitular($id) 
    {
        try 
        {
            $conn = $this->em->getConnection();
            $stmt = $conn->prepare("SELECT p.profesorid, u.usuarioid, concat_ws(' ', p.apellidopaterno, p.apellidomaterno, p.nombre) as nombre, COUNT(cp.ProfesorId) AS total FROM ce_profesorpormateriaplanestudios cp
            INNER JOIN ce_profesor p ON p.ProfesorId = cp.ProfesorId
            LEFT JOIN ce_materiaporplanestudios cm  ON cm.MateriaPorPlanEstudioId = cp.MateriaPorPlanEstudioId
            LEFT JOIN ce_alumnocicloporgrupo acg ON acg.GrupoId = cp.GrupoId
            LEFT JOIN ce_grupo cg ON cg.grupoid = cp.GrupoId
            LEFT JOIN ce_alumnocicloportaller act ON act.TallerCurricularId = cp.TallerId AND act.Vigente = 1
            LEFT JOIN ce_alumnoporciclo ac ON ac.AlumnoPorCicloId = act.AlumnoPorCicloId OR ac.AlumnoPorCicloId = acg.AlumnoPorCicloId
            LEFT JOIN ce_gradoportallercurricular gtc ON gtc.TallerCurricularId = cp.TallerId AND gtc.GradoId = ac.GradoId
            LEFT JOIN ce_materiaporplanestudios mpe ON mpe.MateriaPorPlanEstudioId = cm.MateriaPorPlanEstudioId OR mpe.MateriaPorPlanEstudioId = gtc.MateriaPorPlanEstudioId
            LEFT JOIN ce_planestudios pe ON pe.PlanEstudioId = mpe.PlanEstudioId AND pe.AreaespecializacionId = cg.AreaespecializacionId
            LEFT JOIN materia m ON m.MateriaId = mpe.MateriaId
            LEFT JOIN usuario u ON u.profesorid = p.profesorid
            WHERE cg.GrupoId = :id
            GROUP BY p.ProfesorId
            ORDER BY total DESC LIMIT 1;");
            $stmt->execute(array('id' => $id));
            $result = $stmt->fetchAll(); 
            return $result;          
        } 
        catch (Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
      
        }
    }
}