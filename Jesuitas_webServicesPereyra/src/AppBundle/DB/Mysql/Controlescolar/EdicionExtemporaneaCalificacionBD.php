<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Asignacion materia
 *
 * @author Rubén
 */
class EdicionExtemporaneaCalificacionBD extends BaseDBManager
{
    /*
     * Método para obtener filtrar las solicitudes de edción extemporanea
     */
    public function ObtenerSolicitudesEdicionExtemporanea($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("see.solicitudedicionextemporaneaid,
        ee.nombre as estatusnombre,
        (CASE WHEN mat.materiaid IS NULL THEN  me.materiaid ELSE mat.materiaid END) materiaid, 
        (CASE WHEN mat.nombre IS NULL THEN  me.nombre ELSE mat.nombre END) as materia,
        DATE_FORMAT(see.fechainicio, '%d/%m/%Y' ) as fechainicio, DATE_FORMAT(see.fechafin, '%d/%m/%Y' ) as fechafin,
        DATE_FORMAT(see.horafin, '%H:%i') as horafin,
        (CASE WHEN gru.nombre IS NULL THEN  ctac.nombre ELSE gru.nombre END) as grupo, 
        (CASE WHEN g.grado IS NULL THEN grtc.grado ELSE g.grado END) as grado, 
        (CASE WHEN n.nombre IS NULL THEN ne.nombre ELSE n.nombre END) as nivel, c.nombre as ciclo,
        pei.periodoevaluacionid, pei.descripcion as periodoevaluacion, 
        u.usuarioid, p.personaid, pr.profesorid,
        (
            CASE
                WHEN p.personaid IS NOT NULL
                THEN concat_ws(' ', p.nombre, p.apellidopaterno, p.apellidomaterno)
                WHEN pr.profesorid IS NOT NULL
                THEN concat_ws(' ', pr.nombre, pr.apellidopaterno, pr.apellidomaterno)
                ELSE '-'
            END
          ) as solicitante,
          DATE_FORMAT(see.fechaultimocambio, '%d/%m/%Y' ) fechaultimocambio,
        (
            CASE
                WHEN pu.personaid IS NOT NULL
                THEN concat_ws(' ', pu.nombre, pu.apellidopaterno, pu.apellidomaterno)
                WHEN pru.profesorid IS NOT NULL
                THEN concat_ws(' ', pru.nombre, pru.apellidopaterno, pru.apellidomaterno)
                ELSE '-'
            END
          ) as usuarioultimocambio,
        GroupConcat(DISTINCT a.matricula) as matriculas")
            ->from("AppBundle:CeSolicitudedicionextemporanea", "see")
            ->Join(
                'AppBundle:CeAlumnoporsolicitudedicionextemporanea',
                'apsee',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'see.solicitudedicionextemporaneaid = apsee.solicitudedicionextemporaneaid'
            )
            ->Join(
                'AppBundle:CeEstatusextemporanea',
                'ee',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'ee.estatusextemporaneaid = see.estatusextemporaneaid'
            )
            ->Join(
                'AppBundle:CePeriodoevaluacion',
                'pe',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'pe.periodoevaluacionid = pe.periodoevaluacionid'
            )
            ->Join(
                'AppBundle:CeAlumno',
                'a',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'a.alumnoid = apsee.alumnoid'
            )
            ->Join(
                'AppBundle:Usuario',
                'u',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'u.usuarioid = see.solicitanteid'
            )
            ->leftJoin(
                'AppBundle:Persona',
                'p',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'p.personaid = u.personaid'
            )
            ->leftJoin(
                'AppBundle:CeProfesor',
                'pr',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'pr.profesorid = u.profesorid'
            )
            ->leftJoin(
                'AppBundle:Usuario',
                'us',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'us.usuarioid = see.usuarioultimocambioid'
            )
            ->leftJoin(
                'AppBundle:Persona',
                'pu',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'pu.personaid = us.personaid'
            )
            ->leftJoin(
                'AppBundle:CeProfesor',
                'pru',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'pru.profesorid = us.profesorid'
            )
            ->Join(
                'AppBundle:CeProfesorpormateriaplanestudios',
                'ppmpe',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'ppmpe.profesorpormateriaplanestudiosid = see.profesorpormateriaplanestudiosid'
            )
            ->leftJoin(
                'AppBundle:CeMateriaporplanestudios',
                'mpes',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'mpes.materiaporplanestudioid = ppmpe.materiaporplanestudioid'
            )
            ->leftJoin(
                'AppBundle:Materia',
                'mat',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'mat.materiaid = mpes.materiaid'
            )
            ->leftJoin(
                'AppBundle:CeTallercurricular',
                'ctac',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'ctac.tallercurricularid = ppmpe.tallerid'
            )
            ->leftJoin(
                'AppBundle:CeGradoportallercurricular',
                'gtc',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'gtc.tallercurricularid = ctac.tallercurricularid'
            )
            ->leftJoin(
                'AppBundle:CeMateriaporplanestudios',
                'mpest',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'mpest.materiaporplanestudioid = gtc.materiaporplanestudioid'
            )
            ->leftJoin(
                'AppBundle:Materia',
                'me',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'me.materiaid = mpest.materiaid'
            )
            ->leftJoin(
                'AppBundle:CeGrupo',
                'gru',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'ppmpe.grupoid = gru.grupoid'
            )
            ->leftJoin(
                'AppBundle:Grado',
                'g',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'g.gradoid = gru.gradoid'
            )
            ->leftJoin(
                'AppBundle:Grado',
                'grtc',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'grtc.gradoid = gtc.gradoid'
            )
            ->leftJoin(
                'AppBundle:Nivel',
                'n',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'n.nivelid = g.nivelid'
            )
            ->leftJoin(
                'AppBundle:Nivel',
                'ne',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'ne.nivelid = grtc.nivelid'
            )
            ->leftJoin(
                'AppBundle:CePeriodoevaluacion',
                'pei',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'pei.periodoevaluacionid = see.periodoevaluacionid'
            )
            ->leftJoin(
                'AppBundle:CeConjuntoperiodoevaluacion',
                'cpe',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'cpe.conjuntoperiodoevaluacionid = pei.conjuntoperiodoevaluacionid'
            )
            ->leftJoin(
                'AppBundle:Ciclo',
                'c',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'c.cicloid = cpe.cicloid'
            )
            ->groupBy('see.solicitudedicionextemporaneaid');


        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid IN (:cicloid)')
                ->setParameter('cicloid', $filtros['cicloid']);
        }
        if (!empty($filtros['nivelid'])) {

            $result->andWhere('n.nivelid IN (:nivelid) or ne.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (!empty($filtros['gradoid'])) {

            $result->andWhere('g.gradoid IN (:gradoid) or grtc.gradoid IN (:gradoid) ')
                ->setParameter('gradoid', $filtros['gradoid']);
        }

        if (!empty($filtros['grupoid'])) {

            $result->andWhere('gru.grupoid IN (:grupoid)')
                ->setParameter('grupoid', $filtros['grupoid']);
        }

        if (isset($filtros['profesorpormateriaplanestudiosid'])) {
            $result->andWhere('ppmpe.profesorpormateriaplanestudiosid =' . $filtros['profesorpormateriaplanestudiosid']);
        }

        if (isset($filtros['materiaid'])) {

            $result->andWhere('mat.materiaid IN (:materiaid) or me.materiaid IN (:materiaid)')
                ->setParameter('materiaid', $filtros['materiaid']);
        }

        if (isset($filtros['periodoevaluacionid'])) {
            $result->andWhere('pei.periodoevaluacionid =' . $filtros['periodoevaluacionid']);
        }

        if (isset($filtros['estatusextemporaneaid'])) {
            $result->andWhere('ee.estatusextemporaneaid =' . $filtros['estatusextemporaneaid']);
        }

        if (isset($filtros['matricula'])) {
            $result->andWhere('a.matricula =' . $filtros['matricula']);
        }

        if (isset($filtros['solicitudedicionextemporaneaid'])) {
            $result->andWhere('see.solicitudedicionextemporaneaid =' . $filtros['solicitudedicionextemporaneaid']);
        }

        if (isset($filtros['usuarioid'])) {
            $result->andWhere('u.usuarioid =' . $filtros['usuarioid']);
        }

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    /*
     * Método para obtener los estatus de los periodos de evaluación
     */
    public function obtenerAlumnosEdicionExtemporaneaExistentes($filtros)
    {
        $qb = $this->em->createQueryBuilder();

        $result = $qb->select("see")
            ->from("AppBundle:CeSolicitudedicionextemporanea", "see")
            ->join(
                'AppBundle:CeEstatusextemporanea',
                'ee',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'ee.estatusextemporaneaid = see.estatusextemporaneaid'
            )
            ->join(
                'AppBundle:CeAlumnoporsolicitudedicionextemporanea',
                'asee',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'see.solicitudedicionextemporaneaid = asee.solicitudedicionextemporaneaid'
            )
            ->Where('ee.estatusextemporaneaid = ' . $filtros['estatusextemporaneaid'])
            ->andWhere(
                $qb->expr()
                    ->in('see.alumnoid', $filtros['alumnosid'])
            );

        return $result->getQuery()->getResult();
    }

    /*
     * Método para obtener los alumnos de las solicitudes de edición extemporanea
     */
    public function ObtenerAlumnosEdicionExtemporanea($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("DISTINCT (
            CASE
                WHEN acpg.numerolista IS NOT NULL
                THEN acpg.numerolista
                ELSE '-'
            END
          ) as numerolista,
        a.matricula, CONCAT_WS(' ', a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) as nombre ,
        a.alumnoid, IDENTITY(apc.cicloid) as cicloid, g.gradoid, n.nivelid, s.semestreid, gr.grupoid, g.gradoid, 
        m.materiaid, pe.periodoevaluacionid")
            ->from("AppBundle:CeAlumno", "a")
            ->join(
                'AppBundle:CeAlumnoporciclo',
                'apc',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'apc.alumnoid = a.alumnoid'
            )
            ->join(
                'AppBundle:CeCiclopornivel',
                'cpn',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'cpn.cicloid = apc.cicloid'
            )
            ->join(
                'AppBundle:Nivel',
                'n',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'n.nivelid = cpn.nivelid'
            )
            ->join(
                'AppBundle:Grado',
                'g',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'g.nivelid = g.nivelid'
            )
            ->join(
                'AppBundle:CeGrupo',
                'gr',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'gr.gradoid = g.gradoid'
            )
            ->join(
                'AppBundle:CeAlumnocicloporgrupo',
                'acpg',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'acpg.alumnoporcicloid = apc.alumnoporcicloid'
            )
            ->leftJoin(
                'AppBundle:CeSemestre',
                's',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                's.semestreid = g.semestreid'
            )
            ->leftJoin(
                'AppBundle:CeConjuntoperiodoevaluacion',
                'cpe',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'cpe.cicloid = apc.cicloid'
            )
            ->leftJoin(
                'AppBundle:CePeriodoevaluacion',
                'pe',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'pe.conjuntoperiodoevaluacionid = pe.conjuntoperiodoevaluacionid'
            )
            ->leftJoin(
                'AppBundle:CeCriterioevaluacion',
                'ce',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'ce.periodoevaluacionid = pe.periodoevaluacionid'
            )
            ->leftJoin(
                'AppBundle:CeCriterioevaluaciongrupo',
                'ceg',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'ceg.criterioevaluacionid = ce.criterioevaluacionid and ceg .periodoevaluacionid= pe.periodoevaluacionid'
            )
            ->leftJoin(
                'AppBundle:CeProfesorpormateriaplanestudios',
                'ppmpe',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'ppmpe.grupoid = gr.grupoid'
            )
            ->leftJoin(
                'AppBundle:CeMateriaporplanestudios',
                'mppe',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'mppe.materiaporplanestudioid = ppmpe.materiaporplanestudioid'
            )
            ->leftJoin(
                'AppBundle:Materia',
                'm',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'm.materiaid = mppe.materiaid'
            )
            ->groupBy('a.alumnoid');

        if (isset($filtros['cicloid'])) {
            $result->andWhere('cpn.cicloid =' . $filtros['cicloid']);
        }

        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid =' . $filtros['nivelid']);
        }

        if (isset($filtros['semestreid'])) {
            $result->andWhere('s.semestreid =' . $filtros['semestreid']);
        }

        if (isset($filtros['grupoid'])) {
            $result->andWhere('acpg.grupoid =' . $filtros['grupoid']);
        }

        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid =' . $filtros['gradoid']);
        }

        if (isset($filtros['materiaid'])) {
            $result->andWhere('m.materiaid =' . $filtros['materiaid']);
        }

        if (isset($filtros['periodoevaluacionid'])) {
            $result->andWhere('pe.periodoevaluacionid =' . $filtros['periodoevaluacionid']);
        }

        return $result->getQuery()->getResult();
    }

    /*
     * Método para obtener datos del usuario
     */
    public function ObtenerUsuario($filtros)
    {
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare('SELECT * FROM vw_usuarios WHERE usuarioid=' . $filtros);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /*
     * Método para obtener datos del los Alumnos
     */
    public function ObtenerAlumnos($id)
    {

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ac.alumnoporcicloid, a.matricula, CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) as nombre, Case WHEN g.grupoid IS NULL THEN act.numerolista ELSE acg.numerolista END numerolista")
            ->from("AppBundle:CeAlumnoporsolicitudedicionextemporanea", 'ase')
            ->innerJoin('ase.solicitudedicionextemporaneaid', 'se')
            ->innerJoin('ase.alumnoid', 'a')

            ->innerJoin('se.profesorpormateriaplanestudiosid', 'p')

            ->leftJoin('p.grupoid', 'g')
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "g.grupoid = acg.grupoid")

            ->leftJoin('p.tallerid', 't')
            ->leftJoin("AppBundle:CeAlumnocicloportaller", "act", Expr\Join::WITH, "t.tallercurricularid = act.tallercurricularid")

            ->innerJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and (acg.alumnoporcicloid = ac.alumnoporcicloid or act.alumnoporcicloid = ac.alumnoporcicloid)")
            
            ->groupBy('a.alumnoid');

        if (isset($id)) {
            $result->andWhere('se.solicitudedicionextemporaneaid in (:id)')
                ->setParameter('id', $id);
        }

        return $result->getQuery()->getResult();
    }

    /*
     * Método para obtener datos del los Alumnos
     */
    public function ObtenerAlumnosPermitidos($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $fecha = date('Y-m-d H:m:s');

        if (isset($filtros['alumnosids'])) {
            $result = $qb->select("IDENTITY(apsee.alumnoid) as alumnoid, CONCAT(DATE_FORMAT(see.fechainicio,'%d/%m/%Y'),' a ', DATE_FORMAT(see.fechafin,'%d/%m/%Y'),' hasta ', DATE_FORMAT(see.horafin,'%H:%i')) as fecha")
                ->from("AppBundle:CeSolicitudedicionextemporanea", "see")
                ->Join(
                    'AppBundle:CeAlumnoporsolicitudedicionextemporanea',
                    'apsee',
                    \Doctrine\ORM\Query\Expr\Join::WITH,
                    'see.solicitudedicionextemporaneaid = apsee.solicitudedicionextemporaneaid'
                )
                ->leftJoin(
                    'AppBundle:CeProfesorpormateriaplanestudios',
                    'ppmpe',
                    \Doctrine\ORM\Query\Expr\Join::WITH,
                    'ppmpe.profesorpormateriaplanestudiosid = see.profesorpormateriaplanestudiosid'
                )
                ->Join(
                    'AppBundle:CeEstatusextemporanea',
                    'ee',
                    \Doctrine\ORM\Query\Expr\Join::WITH,
                    'ee.estatusextemporaneaid = see.estatusextemporaneaid'
                )

                ->andWhere("see.estatusextemporaneaid in (1,2) OR (see.estatusextemporaneaid in (4) and CONCAT(see.fechafin, ' ' , see.horafin) >= '" . $fecha . "')")
                //->Where("CONCAT(see.fechafin, ' ' , see.horafin) >= '" . $fecha . "'")
            ;
        } else {
            $result = $qb->select("see.solicitudedicionextemporaneaid, IDENTITY(apsee.alumnoid) as alumnoid, CONCAT(DATE_FORMAT(see.fechainicio,'%d/%m/%Y'),' a ', DATE_FORMAT(see.fechafin,'%d/%m/%Y'),' hasta ', DATE_FORMAT(see.horafin,'%H:%i')) as fecha")
                ->from("AppBundle:CeSolicitudedicionextemporanea", "see")
                ->Join(
                    'AppBundle:CeAlumnoporsolicitudedicionextemporanea',
                    'apsee',
                    \Doctrine\ORM\Query\Expr\Join::WITH,
                    'see.solicitudedicionextemporaneaid = apsee.solicitudedicionextemporaneaid'
                )
                ->leftJoin(
                    'AppBundle:CeProfesorpormateriaplanestudios',
                    'ppmpe',
                    \Doctrine\ORM\Query\Expr\Join::WITH,
                    'ppmpe.profesorpormateriaplanestudiosid = see.profesorpormateriaplanestudiosid'
                )
                ->Join(
                    'AppBundle:CeEstatusextemporanea',
                    'ee',
                    \Doctrine\ORM\Query\Expr\Join::WITH,
                    'ee.estatusextemporaneaid = see.estatusextemporaneaid and see.estatusextemporaneaid = 4'
                )
                ->Where("see.fechainicio <= '" . $fecha . "' AND CONCAT(see.fechafin, ' ' , see.horafin) >= '" . $fecha . "'");
        }

        if (isset($filtros['periodoevaluacionid'])) {
            $result->andWhere('see.periodoevaluacionid =' . $filtros['periodoevaluacionid']);
        }

        if (isset($filtros['profesorpormateriaplanestudiosid'])) {
            $result->andWhere('ppmpe.profesorpormateriaplanestudiosid =' . $filtros['profesorpormateriaplanestudiosid']);
        }


        if (isset($filtros['alumnosids'])) {
            $result->andWhere('apsee.alumnoid IN (:ids)');
            $result->setParameter('ids', $filtros['alumnosids']);
        }

        return $result->getQuery()->getResult();
    }
}
