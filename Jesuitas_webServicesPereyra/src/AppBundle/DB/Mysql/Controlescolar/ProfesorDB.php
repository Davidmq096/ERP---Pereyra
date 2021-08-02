<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Filtrado de Tipos de Becas
 *
 * @author Rubén
 */
class ProfesorDB extends BaseDBManager
{
    public function BuscarProfesorfiltro($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p")
            ->from("AppBundle:CeProfesor", 'p');
        /* ->Join(
        'AppBundle:CeProfesorpornivel',
        'ppn',
        \Doctrine\ORM\Query\Expr\Join::WITH,
        'ppn.profesorid = p.profesorid')
        ->orderBy('p.apellidopaterno, p.apellidomaterno, p.nombre', 'asc');*/

        if (isset($filtros['nombre'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['nombre'] = str_replace($escape, $escapados, $filtros['nombre']);
            $result->andWhere('p.nombre like :nombre')
                ->setParameter('nombre', '%' . $filtros['nombre'] . '%');
        }
        if (isset($filtros['appaterno'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['appaterno'] = str_replace($escape, $escapados, $filtros['appaterno']);
            $result->andWhere('p.apellidopaterno like :appaterno')
                ->setParameter('appaterno', '%' . $filtros['appaterno'] . '%');
        }
        if (isset($filtros['apmaterno'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['apmaterno'] = str_replace($escape, $escapados, $filtros['apmaterno']);
            $result->andWhere('p.apellidomaterno like :apmaterno')
                ->setParameter('apmaterno', '%' . $filtros['apmaterno'] . '%');
        }
        if (isset($filtros['nonomina'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['nonomina'] = str_replace($escape, $escapados, $filtros['nonomina']);
            $result->andWhere('p.numeronomina like :nonomina')
                ->setParameter('nonomina', '%' . $filtros['nonomina'] . '%');
        }
        if (isset($filtros['estatusid'])) {
            $result->andWhere('p.estatusempleadoid =' . $filtros['estatusid']);
        }
        if (isset($filtros['curp'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['curp'] = str_replace($escape, $escapados, $filtros['curp']);
            $result->andWhere('p.curp like :curp')
                ->setParameter('curp', '%' . $filtros['curp'] . '%');
        }
        if (isset($filtros['profesorid'])) {
            $result->andWhere('p.profesorid=' . $filtros['profesorid']);
        }

        return $result->getQuery()->getResult();
    }

    public function BuscarProfesorfiltroNivel($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p.profesorid, Concat_ws(' ', p.apellidopaterno, p.apellidomaterno, p.nombre) nombre")
            ->from("AppBundle:CeProfesor", 'p')
            ->Join('AppBundle:CeProfesorpornivel', 'ppn', \Doctrine\ORM\Query\Expr\Join::WITH, 'ppn.profesorid = p.profesorid')
            ->orderBy('p.apellidopaterno, p.apellidomaterno, p.nombre', 'asc');
        if (isset($filtros['nivelid'])) {
            $result->andWhere('ppn.nivelid =' . $filtros['nivelid']);
        }
        if (isset($filtros['cicloid'])) {
            $result->andWhere('ppn.cicloid =' . $filtros['cicloid']);
        }

        return $result->getQuery()->getResult();
    }

    public function BuscarMunicipioCP($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("m")
            ->from("AppBundle:Municipio", 'm')
            ->innerJoin("AppBundle:Colonia", 'c', Expr\Join::WITH, "c.municipioid = m.municipioid");
        if (isset($filtros['cp'])) {
            $result->andWhere('c.cp = :cp')
                ->setParameter('cp', $filtros['cp']);
        }
        return $result->getQuery()->getResult();
    }

    public function BuscarCP($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c")
            ->from("AppBundle:Estado", 'e')
            ->innerJoin("AppBundle:Municipio", 'm', Expr\Join::WITH, "m.estadoid = e.estadoid")
            ->innerJoin("AppBundle:Colonia", 'c', Expr\Join::WITH, "c.municipioid = m.municipioid");
        if (isset($filtros['cp'])) {
            $result->andWhere('c.cp = :cp')
                ->setParameter('cp', $filtros['cp']);
        }
        return $result->getQuery()->getResult();
    }

    public function BuscarFotoProfesor($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p.fotografia")
            ->from("AppBundle:CeProfesor", 'p')
            ->andWhere('p.profesorid = :profesorid')
            ->setParameter('profesorid', $filtros['profesorid']);
        return $result->getQuery()->getResult();
    }

    public function BuscarFechainiciolaboralprofesor($id)
    {
        $primerciclo = $this->em->createQueryBuilder()->select('MIN(c.cicloid)')
        ->from("AppBundle:CeProfesorpormateriaplanestudios", "pmpe")
        ->leftJoin("pmpe.grupoid", "g")
        ->leftJoin("pmpe.tallerid", "t")
        ->leftJoin("AppBundle:Ciclo", 'c', Expr\Join::WITH, "c.cicloid = g.cicloid or c.cicloid = t.cicloid")
        ->where("pmpe.profesorid = $id");


        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("MIN(cc.fechainicio) as fecha")
            ->from("AppBundle:Ciclo", 'c1')
            ->innerJoin("AppBundle:CeCiclopornivel", 'cc', Expr\Join::WITH, "cc.cicloid = c1.cicloid")
            ->Where("c1.cicloid = (" . $primerciclo . ")");
        return $result->getQuery()->getResult();
    }

    public function ProfesorReportInfo() {
        $conn = $this->em->getConnection();
        $filtro = " ";
        $stmt = $conn->prepare("SELECT 
        pr.profesorid,
        pr.Curp ,
        pr.Rfc,
        pr.nombre ,
        pr.ApellidoPaterno,
        pr.ApellidoMaterno,
        TIMESTAMPDIFF(YEAR,pr.FechaNacimiento,CURDATE()) AS edad,
        DATE_FORMAT(pr.FechaNacimiento, '%d/%m/%Y') as FechaNacimiento,
        pr.genero,
        e.Nombre AS estado,
      
         DATE_FORMAT(pr.experienciasep, '%d/%m/%Y') AS experienciaacademica,
        (SELECT cc.FechaInicio FROM ce_profesorpormateriaplanestudios cp
          LEFT JOIN ce_grupo cg ON cg.GrupoId = cp.GrupoId
          LEFT JOIN ce_tallerextracurricular ct ON ct.TallerExtracurricularId = cp.TallerId
          LEFT JOIN ciclo c ON c.CicloId = ct.CicloId OR c.CicloId = cg.CicloId
          LEFT JOIN ce_ciclopornivel cc ON cc.CicloId = c.CicloId WHERE cp.ProfesorId = pr.ProfesorId limit 1) AS fechainiciolaboral,
      
        (SELECT CASE WHEN m1.nombre is not null then GROUP_CONCAT(DISTINCT m1.Nombre ORDER BY cc.FechaInicio asc SEPARATOR '\n') else '' end FROM ce_profesorpormateriaplanestudios cp1
        LEFT JOIN ce_grupo cg ON cg.GrupoId = cp1.GrupoId
        LEFT JOIN ce_tallercurricular ct1 ON ct1.TallerCurricularId = cp1.TallerId
        LEFT JOIN ce_gradoportallercurricular  cg1 ON ct1.TallerCurricularId = cg1.TallerCurricularId
        LEFT JOIN ce_materiaporplanestudios cm1 ON cm1.MateriaPorPlanEstudioId = cp1.MateriaPorPlanEstudioId OR cm1.MateriaPorPlanEstudioId = cg1.MateriaPorPlanEstudioId
        LEFT JOIN ciclo c2 ON c2.CicloId = cg.CicloId OR c2.CicloId = ct1.CicloId
        LEFT JOIN ce_ciclopornivel cc ON cc.CicloId = c2.CicloId
        LEFT JOIN materia m1 ON m1.MateriaId = cm1.MateriaId WHERE cp1.ProfesorId = pr.ProfesorId ) AS asignatura,
      
        '' AS fechaasignatura,
        GROUP_CONCAT(DISTINCT e1.Descripcion  ORDER BY e1.EscolaridadId SEPARATOR '\n') AS gradoacademico,
        GROUP_CONCAT(DISTINCT ce.InstitucionEducativa ORDER BY ce.EstudioProfesorId SEPARATOR '\n') AS nombregrado,
        GROUP_CONCAT( ee2.Nombre SEPARATOR '\n') AS estatusempleado,
        CONCAT_WS(' ', pr.autorizaciondgb, '\n') AS autorizaciondgbsep,
        GROUP_CONCAT(CASE WHEN ce.EstatusEstudioId = 2 THEN 'SI' ELSE 'NO' END ORDER BY ce.EstudioProfesorId SEPARATOR '\n') AS titulado,
        '' as cargo,
          GROUP_CONCAT(DISTINCT CASE WHEN ce.CedulaProfesional IS NOT NULL THEN ce.CedulaProfesional ELSE '-' END ORDER BY ce.EstudioProfesorId SEPARATOR '\n') AS celula,
        '' as estatuscargo,
        '' AS tiempo
      
       FROM ce_profesor pr
       LEFT JOIN estado e ON pr.EstadoId = e.EstadoId
        LEFT JOIN ce_estudiosprofesor ce ON ce.ProfesorId = pr.ProfesorId
        LEFT JOIN escolaridad e1 ON e1.EscolaridadId = ce.escolaridadid
        LEFT JOIN ce_estatusempleado ce1 ON ce1.EstatusEmpleadoId = pr.EstatusEmpleadoId
        LEFT JOIN ce_estatusestudio ee2 on ee2.estatusestudioid = ce.estatusestudioid 
      
        GROUP BY pr.ProfesorId ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function loadHorarioMateria($profesorid) {
        $conn = $this->em->getConnection();
        $filtro = " ";
        $stmt = $conn->prepare("SELECT cc.fechainicio, DATE_FORMAT(cc.FechaInicio, '%d/%m/%Y') as FechaInicio FROM ce_profesor cp
        LEFT JOIN ce_profesorpormateriaplanestudios cp1 ON cp.ProfesorId = cp1.ProfesorId
        LEFT JOIN ce_grupo cg ON cg.GrupoId = cp1.GrupoId
        LEFT JOIN ce_tallercurricular ct1 ON ct1.TallerCurricularId = cp1.TallerId
        LEFT JOIN ce_gradoportallercurricular  cg1 ON ct1.TallerCurricularId = cg1.TallerCurricularId
        LEFT JOIN ce_materiaporplanestudios cm1 ON cm1.MateriaPorPlanEstudioId = cp1.MateriaPorPlanEstudioId OR cm1.MateriaPorPlanEstudioId = cg1.MateriaPorPlanEstudioId
        LEFT JOIN ciclo c2 ON c2.CicloId = cg.CicloId OR c2.CicloId = ct1.CicloId
        LEFT JOIN ce_ciclopornivel cc ON cc.CicloId = c2.CicloId
        LEFT JOIN ce_materiaporplanestudios cm ON cm.MateriaPorPlanEstudioId = cp1.MateriaPorPlanEstudioId
        LEFT JOIN materia m ON m.MateriaId = cm1.MateriaId 
        
        WHERE cp.ProfesorId = $profesorid
        GROUP BY m.Nombre
        ORDER BY cast(cc.fechainicio as date) ASC
          ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
