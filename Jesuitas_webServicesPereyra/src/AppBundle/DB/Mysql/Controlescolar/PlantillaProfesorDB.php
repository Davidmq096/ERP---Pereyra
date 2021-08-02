<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Filtrado de Tipos de Becas
 *
 * @author Rubén
 */
class PlantillaProfesorDB extends BaseDBManager
{


    public function ReporteMaestrosMaterias($filtros)
    {

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p.profesorid, p.nombre, p.apellidopaterno, p.apellidomaterno,
        n.nivelid, n.nombre as nivel, g.gradoid, g.grado, gr.grupoid, gr.nombre as grupo,
        m.materiaid, m.clave, m.nombre as materia, m.essubmateria, mppe.horasporsemana ")
            ->from("AppBundle:CeProfesorpormateriaplanestudios", 'ppmpe')
            ->innerJoin('AppBundle:CeProfesor', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p.profesorid = ppmpe.profesorid')
            ->innerJoin('AppBundle:CeMateriaporplanestudios', 'mppe', \Doctrine\ORM\Query\Expr\Join::WITH, 'mppe.materiaporplanestudioid = ppmpe.materiaporplanestudioid')
            ->innerJoin('AppBundle:Materia', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.materiaid = mppe.materiaid')
            ->innerJoin('AppBundle:CePlanestudios', 'pe', \Doctrine\ORM\Query\Expr\Join::WITH, 'pe.planestudioid = mppe.planestudioid')
            ->innerJoin('AppBundle:CePlantillaprofesor', 'pp', \Doctrine\ORM\Query\Expr\Join::WITH, 'pp.planestudioid = pe.planestudioid and pp.estatusplantillaprofesorid = 3')
            ->innerJoin('AppBundle:Grado', 'g', \Doctrine\ORM\Query\Expr\Join::WITH, 'g.gradoid = pe.gradoid')
            ->innerJoin('AppBundle:Nivel', 'n', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.nivelid = g.nivelid')
            ->innerJoin('AppBundle:CeGrupo', 'gr', \Doctrine\ORM\Query\Expr\Join::WITH, 'gr.grupoid = ppmpe.grupoid')
            ->orderBy('p.apellidopaterno', 'asc');
        $result->andWhere('pp.plantillaprofesorid = ' . $filtros);
        return $result->getQuery()->getResult();
    }

    public function FiltrarPlantillaProfesor($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pp")
            ->from("AppBundle:CePlantillaprofesor", 'pp')
            ->andWhere("pp.planestudioid IN (
                SELECT pe.planestudioid FROM AppBundle:CePlanestudios as pe WHERE
                pe.cicloinicialid IN (
                    SELECT IDENTITY(cpn.cicloid) FROM AppBundle:CeCiclopornivel as cpn
                    WHERE cpn.nivelid in (:nivelid)
                ) AND
                pe.gradoid IN (
                    SELECT g.gradoid FROM AppBundle:Grado AS g
                    WHERE g.nivelid IN (
                        SELECT IDENTITY(ccpn.nivelid) FROM AppBundle:CeCiclopornivel as ccpn
                        WHERE ccpn.nivelid in (:nivelid)
                    ) AND g.gradoid in (:gradoid)
                ) AND
                pe.vigente = 1)")
            ->setParameter('nivelid', $filtros['nivelid'])
            ->setParameter("gradoid", $filtros['gradoid']);

        if (isset($filtros['cicloid'])) {
            $result->andWhere('pp.cicloid = ' . $filtros['cicloid']);
        }

        if (isset($filtros['planestudioid'])) {
            $result->andWhere('pp.planestudioid = ' . $filtros['planestudioid']);
        }

        if (isset($filtros['usuariosvalidan'])) {
            $result->andWhere('pp.usuariovalidaid = ' . $filtros['usuariosvalidan']);
        }

        if (isset($filtros['usuariocapturan'])) {
            $result->andWhere('pp.usuariocapturaid = ' . $filtros['usuariocapturan']);
        }

        if (isset($filtros['estatusplantillaprofesorid'])) {
            $result->andWhere('pp.estatusplantillaprofesorid = ' . $filtros['estatusplantillaprofesorid']);
        }

        return $result->getQuery()->getResult();
    }

    public function BuscarUsuarioFiltros($filtros)
    {
        try {

            $qb = $this->em->getConnection();
            if ($filtros == 1) { //1 = captura, 2 = validador
                $sql = "SELECT * FROM vw_usuarios as u WHERE u.usuarioid in (SELECT COALESCE(usuariocapturaid,'0') FROM ce_plantillaprofesor)";
            } else {
                $sql = "SELECT * FROM vw_usuarios as u WHERE u.usuarioid in (SELECT COALESCE(usuariovalidaid,'0') FROM ce_plantillaprofesor)";
            }
            $stmt = $qb->prepare($sql);
            $stmt->execute();
            $usuarios = $stmt->fetchAll();

            return $usuarios;
        } catch (Exceptio $e) {
            return null;
        }
    }

    public function FiltrarDetallePlantillaProfesorRegular($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select(" distinct
        ppmp.profesorpormateriaplanestudiosid,
        profe.profesorid as profesorid,
        CONCAT_WS(' ', profe.apellidopaterno, profe.apellidomaterno, profe.nombre) as profesor,
        profeco.profesorid as cotitularid,
        CONCAT_WS(' ', profeco.apellidopaterno, profeco.apellidomaterno, profeco.nombre) as cotitular,
        profesup.profesorid as suplenteid,
        CONCAT_WS(' ', profesup.apellidopaterno, profesup.apellidomaterno, profesup.nombre) as suplente,
        mppe.materiaporplanestudioid, m.nombre as materianombre,m.materiaid,m2.materiaid as pmpemateriaid,cpe.clasificadorparaescolaresid,cpe.nombre as clasificadorparaescolares, g.grupoid, g.nombre as gruponombre,npe.nivelparaescolaresid,npe.nombre as nivelparaescolares,
        mppe.requieremaestrotitular, mppe.requieremaestrocotitular,mppe.configurarsubmaterias,
        CASE
            WHEN fcs.formacaptura is null THEN ''
            ELSE fcs.formacaptura
        END as formacaptura,
        fcs.formaconfiguracionsubmateriaid")
            ->from("AppBundle:CePlanestudios", 'pe')
            ->innerJoin('AppBundle:CeMateriaporplanestudios','mppe', Expr\Join::WITH,'mppe.planestudioid = pe.planestudioid')
            ->leftJoin('AppBundle:CeFormaconfiguracionsubmateria','fcs',Expr\Join::WITH,'fcs.materiaporplanestudioid = mppe.materiaporplanestudioid')    
            ->leftJoin('AppBundle:Materia','m', Expr\Join::WITH,'m.materiaid = mppe.materiaid')
            ->leftJoin('AppBundle:CeClasificadorparaescolares','cpe',Expr\Join::WITH,'cpe.clasificadorparaescolaresid = m.clasificadorparaescolaresid')    
            ->innerJoin('AppBundle:CeGrupo','g',Expr\Join::WITH,'g.gradoid = pe.gradoid and g.cicloid='.$filtros["cicloid"].' and g.tipogrupoid=1')
            ->leftJoin('AppBundle:CeNivelparaescolares','npe',Expr\Join::WITH,'npe.nivelparaescolaresid = g.nivelparaescolaresid')     
            ->leftJoin('AppBundle:CePlantillaprofesor','pp',Expr\Join::WITH,'pp.planestudioid = pe.planestudioid')
            ->leftJoin('AppBundle:CeProfesorpormateriaplanestudios','ppmp',Expr\Join::WITH,'(ppmp.materiaporplanestudioid = mppe.materiaporplanestudioid and ppmp.grupoid = g.grupoid )')
            ->leftJoin('AppBundle:Materia','m2',Expr\Join::WITH,'m2.materiaid = ppmp.materiaid')  
            ->leftJoin('AppBundle:CeProfesor','profe',Expr\Join::WITH,'profe.profesorid = ppmp.profesorid')
            ->leftJoin('AppBundle:CeProfesor','profeco',Expr\Join::WITH,'profeco.profesorid = ppmp.cotitularid')
            ->leftJoin('AppBundle:CeProfesor','profesup',Expr\Join::WITH,'profesup.profesorid = ppmp.suplenteid')
            ->andWhere('pe.planestudioid = ' . $filtros["planestudioid"] . ' and mppe.configurarsubgrupos=0 and mppe.configurartaller=0')
            ->orderBy('m.nombre, g.nombre', 'ASC');
            if (isset($filtros['areaespecializacionid'])) {
                $result->andWhere('g.areaespecializacionid = ' . $filtros['areaespecializacionid']);
            }

        return $result->getQuery()->getResult();
    }

    public function FiltrarDetallePlantillaProfesorEspecial($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select(" distinct 
        ppmp.profesorpormateriaplanestudiosid,
        profe.profesorid as profesorid, CONCAT_WS(' ', profe.apellidopaterno, profe.apellidomaterno, profe.nombre) as profesor,
        profeco.profesorid as cotitularid, CONCAT_WS(' ', profeco.apellidopaterno, profeco.apellidomaterno, profeco.nombre) as cotitular,
        profesup.profesorid as suplenteid, CONCAT_WS(' ', profesup.apellidopaterno, profesup.apellidomaterno, profesup.nombre) as suplente,
        mppe.materiaporplanestudioid, m.nombre as materianombre, m.materiaid, cpe.clasificadorparaescolaresid,cpe.nombre as clasificadorparaescolares,
        g.grupoid, g.nombre as grupo, npe.nivelparaescolaresid,npe.nombre as nivelparaescolares,
        mppe.requieremaestrotitular, mppe.requieremaestrocotitular,
        CASE
            WHEN fcs.formacaptura is null THEN ''
            ELSE fcs.formacaptura
        END as formacaptura")
            ->from("AppBundle:CePlanestudios", 'pe')
            ->innerJoin('AppBundle:CeMateriaporplanestudios','mppe',Expr\Join::WITH,'mppe.planestudioid = pe.planestudioid')
            ->leftJoin('AppBundle:CeFormaconfiguracionsubmateria', 'fcs', Expr\Join::WITH, 'fcs.materiaporplanestudioid = mppe.materiaporplanestudioid')
            ->leftJoin('mppe.materiaid','m')
            ->leftJoin('m.clasificadorparaescolaresid', 'cpe')

            ->innerJoin('AppBundle:CeGrupoorigenporsubgrupo', 'sgpm', Expr\Join::WITH, 'sgpm.materiaporplanestudioid = mppe.materiaporplanestudioid')
            ->innerJoin('AppBundle:CeGrupo', 'g', Expr\Join::WITH, 'g.grupoid = sgpm.grupoid and g.cicloid='.$filtros["cicloid"].' and g.tipogrupoid = 2')
            ->leftJoin('g.nivelparaescolaresid', 'npe')


            ->leftJoin('AppBundle:CePlantillaprofesor','pp',Expr\Join::WITH,'pp.planestudioid = pe.planestudioid')
            ->leftJoin('AppBundle:CeProfesorpormateriaplanestudios','ppmp',Expr\Join::WITH,'(pp.plantillaprofesorid = ppmp.plantillaprofesorid and ppmp.grupoid = g.grupoid and ppmp.materiaporplanestudioid = mppe.materiaporplanestudioid)')
            ->leftJoin('AppBundle:CeProfesor', 'profe', Expr\Join::WITH, 'profe.profesorid = ppmp.profesorid')
            ->leftJoin('AppBundle:CeProfesor', 'profeco', Expr\Join::WITH, 'profeco.profesorid = ppmp.cotitularid')
            ->leftJoin('AppBundle:CeProfesor', 'profesup', Expr\Join::WITH, 'profesup.profesorid = ppmp.suplenteid')
            ->andWhere('pe.planestudioid = ' . $filtros["planestudioid"]. ' and mppe.configurarsubgrupos=1 and mppe.configurartaller=0')
            ->orderBy('m.nombre, g.nombre', 'ASC');

        return $result->getQuery()->getResult();
    }
}
