<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Filtrado de Tipos de Becas
 *
 * @author Rubén
 */
class EmailPadresDB extends BaseDBManager
{
    /*
     * Método para obtener los correos de los padres de los alumnos por ciclo y otros filtros
     */
    public function ObtenerCorreosPadresAlumnos($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $ultimociclo = $qb->select('Case WHEN max(ccca.cicloid) IS NULL THEN max(ccc.cicloid) ELSE max(ccca.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu")
            ->innerJoin("acu.cicloid", "ccc")
            ->leftJoin("AppBundle:Ciclo", "ccca", Expr\Join::WITH, "acu.cicloid = ccca.cicloid and ccca.actual = 1")
            ->where("acu.alumnoid = a.alumnoid")
            ->groupBy('acu.alumnoid');

        $qb = $this->em->createQueryBuilder();
        $gradoactual = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = (" . $ultimociclo . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("DISTINCT n.nombre as nivel , g.grado, gr.nombre as grupo, a.matricula, cf.clave familia,
        concat_ws(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) as alumnonombre,
        concat_ws(' ', potp.apellidopaterno, potp.apellidomaterno, potp.nombre) as padrenombre, 
        potp.telefono as telefonopadre, potp.celular as celularpadre,
        (
            CASE 
                WHEN up.usuarioid IS NULL
                THEN potp.correo
                ELSE up.cuenta
            END
          ) as correopadre,
        
          concat_ws(' ', potm.nombre, potm.apellidopaterno, potm.apellidomaterno) as madrenombre,
          potm.telefono as telefonomadre, potm.celular as celularmadre,
        (
            CASE 
                WHEN um.usuarioid IS NULL
                THEN potm.correo
                ELSE um.cuenta
            END
          ) as correomadre,
          CASE WHEN a.fechaactualizacion < pa.fechainicio then 0 else 1 end as actualizado,
          DATE_FORMAT(a.fechaactualizacion, '%d/%m/%Y') as fechaactualizacion
          ")
            ->from("AppBundle:CeClavefamiliar", "cf")
            ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'apcf', Expr\Join::WITH, 'apcf.clavefamiliarid = cf.clavefamiliarid')
            ->innerJoin('AppBundle:CeAlumno', 'a', Expr\Join::WITH, 'a.alumnoid = apcf.alumnoid and a.alumnoestatusid = 1')
            ->innerJoin('AppBundle:CeAlumnoporciclo', 'apc', Expr\Join::WITH, "apc.alumnoid = a.alumnoid and apc.estatusalumnocicloid in (1,2) and apc.gradoid = (" . $gradoactual . ")")
            ->leftJoin('apc.cicloid', 'c')
            ->leftJoin('apc.gradoid', 'g')
            ->leftJoin('g.nivelid', 'n')
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnoporcicloid = apc.alumnoporcicloid")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid AND gr.tipogrupoid = 1")
            
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'potcf', Expr\Join::WITH, 'potcf.clavefamiliarid = cf.clavefamiliarid  and (potcf.tutorid = 1 or potcf.tutorid = 3)')
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'potcff', Expr\Join::WITH, 'potcff.clavefamiliarid = cf.clavefamiliarid  and (potcff.tutorid = 2 or potcff.tutorid = 4)')
            ->leftJoin('AppBundle:CePadresotutores', 'potp', Expr\Join::WITH, 'potcf.padresotutoresid = potp.padresotutoresid')
            ->leftJoin('AppBundle:Usuario', 'up', Expr\Join::WITH, 'potp.padresotutoresid = up.padreotutorid')

            ->leftJoin('AppBundle:CePadresotutores', 'potm', Expr\Join::WITH, 'potcff.padresotutoresid = potm.padresotutoresid')
            ->leftJoin('AppBundle:Usuario', 'um', Expr\Join::WITH, 'potm.padresotutoresid = um.padreotutorid')
            ->groupBy('a.alumnoid')
            ->Join('AppBundle:CePeriodoactualizacion', 'pa', Expr\Join::WITH, 'pa.activo = 1');
        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid in(:niveles)');
            $result->setParameter('niveles', $filtros['nivelid']);
        }

        if (isset($filtros['grupoid'])) {
            $result->andWhere('gr.grupoid =' . $filtros['grupoid']);
        }

        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid in(:grados)');
            $result->setParameter('grados', $filtros['gradoid']);
        }

        if (isset($filtros['matricula'])) {
            $filtros['matricula'] = trim($filtros['matricula']);
            $result->andWhere('a.matricula like \'%' . $filtros['matricula'] . '%\'');
        }

        if (isset($filtros['nombre'])) {
            $result->andWhere('a.primernombre like \'%' . $filtros['nombre'] . '%\'');
        }

        if (isset($filtros['apellidopaterno'])) {
            $result->andWhere('a.apellidopaterno like \'%' . $filtros['apellidopaterno'] . '%\'');
        }

        if (isset($filtros['apellidomaterno'])) {
            $result->andWhere('a.apellidomaterno like \'%' . $filtros['apellidomaterno'] . '%\'');
        }

        return $result->getQuery()->getResult();
    }


    

        /*
     * Método para obtener los correos de los padres de los alumnos por ciclo y otros filtros
     */
    public function ObtenerCorreosPadresFamilia($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $ultimociclo = $qb->select('Case WHEN max(ccca.cicloid) IS NULL THEN max(ccc.cicloid) ELSE max(ccca.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu")
            ->innerJoin("acu.cicloid", "ccc")
            ->leftJoin("AppBundle:Ciclo", "ccca", Expr\Join::WITH, "acu.cicloid = ccca.cicloid and ccca.actual = 1")
            ->where("acu.alumnoid = a.alumnoid")
            ->groupBy('acu.alumnoid');

        $qb = $this->em->createQueryBuilder();
        $ultimociclo2 = $qb->select('Case WHEN max(ccca5.cicloid) IS NULL THEN max(ccc5.cicloid) ELSE max(ccca5.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu5")
            ->innerJoin("acu5.cicloid", "ccc5")
            ->leftJoin("AppBundle:Ciclo", "ccca5", Expr\Join::WITH, "acu5.cicloid = ccca5.cicloid and ccca5.actual = 1")
            ->where("acu5.alumnoid = a.alumnoid")
            ->groupBy('acu5.alumnoid');    

        $qb = $this->em->createQueryBuilder();
        $gradoactual = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = (" . $ultimociclo . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $nivel = $qb->select("groupconcat(n3.nombre order by ac3.alumnoporcicloid separator ', <br>')")
            ->from("AppBundle:CeAlumnoporciclo", "ac3")
            ->innerJoin("ac3.gradoid", "g3")
            ->innerJoin("g3.nivelid", "n3")
            ->where("FIND_IN_SET(ac3.alumnoporcicloid, groupconcat(distinct apc.alumnoporcicloid)) != 0")
            ->getQuery()->getDQL();    

        $qb = $this->em->createQueryBuilder();
        $grado = $qb->select("groupconcat(g5.grado order by ac5.alumnoporcicloid separator ', <br>')")
            ->from("AppBundle:CeAlumnoporciclo", "ac5")
            ->innerJoin("ac5.gradoid", "g5")
            ->where("FIND_IN_SET(ac5.alumnoporcicloid, groupconcat(distinct apc.alumnoporcicloid)) != 0")
            ->getQuery()->getDQL();     
            
        $qb = $this->em->createQueryBuilder();
        $grupo = $qb->select("groupconcat(gx6.nombre order by ac6.alumnoporcicloid separator ', <br>')")
            ->from("AppBundle:CeAlumnoporciclo", "ac6")
            ->innerJoin("AppBundle:CeAlumnocicloporgrupo", "acg6", Expr\Join::WITH, "ac6.alumnoporcicloid = acg6.alumnoporcicloid")
            ->innerJoin("AppBundle:CeGrupo", "gx6", Expr\Join::WITH, "gx6.grupoid = acg6.grupoid and gx6.tipogrupoid = 1")
            ->where("FIND_IN_SET(ac6.alumnoporcicloid, groupconcat(distinct apc.alumnoporcicloid)) != 0")
            ->getQuery()->getDQL();     

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("groupconcat(distinct apc.alumnoporcicloid) as ac, 
        count(distinct a.alumnoid) alumnos,
        groupconcat(distinct a.matricula order by apc.alumnoporcicloid separator ', <br>' ) matricula, 
        groupconcat(distinct concat_ws(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) order by apc.alumnoporcicloid separator ', <br>') as alumnonombre,
        cf.clave familia,
        concat_ws(' ', potp.apellidopaterno, potp.apellidomaterno, potp.nombre) as padrenombre, 
        potp.telefono as telefonopadre, potp.celular as celularpadre,
        (
            CASE 
                WHEN up.usuarioid IS NULL
                THEN potp.correo
                ELSE up.cuenta
            END
          ) as correopadre,
        
          concat_ws(' ', potm.nombre, potm.apellidopaterno, potm.apellidomaterno) as madrenombre,
          potm.telefono as telefonomadre, potm.celular as celularmadre,
        (
            CASE 
                WHEN um.usuarioid IS NULL
                THEN potm.correo
                ELSE um.cuenta
            END
          ) as correomadre,
          CASE WHEN a.fechaactualizacion < pa.fechainicio then 0 else 1 end as actualizado,
          DATE_FORMAT(a.fechaactualizacion, '%d/%m/%Y') as fechaactualizacion
          ")
            ->addSelect("(" . $nivel . ") as nivel")
            ->addSelect("(" . $grado . ") as grado")
            ->addSelect("(" . $grupo . ") as grupo")
            ->from("AppBundle:CeClavefamiliar", "cf")
            ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'apcf', Expr\Join::WITH, 'apcf.clavefamiliarid = cf.clavefamiliarid')
            ->innerJoin('AppBundle:CeAlumno', 'a', Expr\Join::WITH, 'a.alumnoid = apcf.alumnoid and a.alumnoestatusid = 1')
            ->innerJoin('AppBundle:CeAlumnoporciclo', 'apc', Expr\Join::WITH, "apc.alumnoid = a.alumnoid and apc.estatusalumnocicloid in (1,2) and apc.cicloid = (" . $ultimociclo2 . ")" ."and apc.gradoid = (" . $gradoactual . ")")
            ->leftJoin('apc.cicloid', 'c')
            ->leftJoin('apc.gradoid', 'g')
            ->leftJoin('g.nivelid', 'n')
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnoporcicloid = apc.alumnoporcicloid")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid AND gr.tipogrupoid = 1")
            
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'potcf', Expr\Join::WITH, 'potcf.clavefamiliarid = cf.clavefamiliarid  and (potcf.tutorid = 1 or potcf.tutorid = 3)')
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'potcff', Expr\Join::WITH, 'potcff.clavefamiliarid = cf.clavefamiliarid  and (potcff.tutorid = 2 or potcff.tutorid = 4)')
            ->leftJoin('AppBundle:CePadresotutores', 'potp', Expr\Join::WITH, 'potcf.padresotutoresid = potp.padresotutoresid')
            ->leftJoin('AppBundle:Usuario', 'up', Expr\Join::WITH, 'potp.padresotutoresid = up.padreotutorid')

            ->leftJoin('AppBundle:CePadresotutores', 'potm', Expr\Join::WITH, 'potcff.padresotutoresid = potm.padresotutoresid')
            ->leftJoin('AppBundle:Usuario', 'um', Expr\Join::WITH, 'potm.padresotutoresid = um.padreotutorid')
            ->groupBy('cf.clavefamiliarid')
            ->Join('AppBundle:CePeriodoactualizacion', 'pa', Expr\Join::WITH, 'pa.activo = 1');
        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid in(:niveles)');
            $result->setParameter('niveles', $filtros['nivelid']);
        }

        if (isset($filtros['grupoid'])) {
            $result->andWhere('gr.grupoid =' . $filtros['grupoid']);
        }

        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid in(:grados)');
            $result->setParameter('grados', $filtros['gradoid']);
        }

        if (isset($filtros['matricula'])) {
            $filtros['matricula'] = trim($filtros['matricula']);
            $result->andWhere('a.matricula like \'%' . $filtros['matricula'] . '%\'');
        }

        if (isset($filtros['nombre'])) {
            $result->andWhere('a.primernombre like \'%' . $filtros['nombre'] . '%\'');
        }

        if (isset($filtros['apellidopaterno'])) {
            $result->andWhere('a.apellidopaterno like \'%' . $filtros['apellidopaterno'] . '%\'');
        }

        if (isset($filtros['apellidomaterno'])) {
            $result->andWhere('a.apellidomaterno like \'%' . $filtros['apellidomaterno'] . '%\'');
        }

        return $result->getQuery()->getResult();
    }

    /*
     * Método para obtener los correos de los padres de los alumnos por ciclo y otros filtros
     */
    public function ObtenerAlumnosDatos($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid,a.matricula as clave,concat_ws(' ',a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as nombre,a.curp,GroupConcat(DISTINCT na.nombre SEPARATOR ', ') as nacionalidad,
        CASE
            WHEN a.sexo='M' THEN 'Masculino'
            WHEN a.sexo='F' THEN 'Femenino'
            ELSE ''
        END as sexo,
        gru.nombre as grupo,acg.numerolista,eac.nombre as estatus,concat(pb.descripcion,'%') as porcentajebeca,DATE_FORMAT(ac.fechabaja, '%d/%m/%Y') fechabaja,
        ad.calle as domicilio,ad.colonia,ad.codigopostal,at.telefono,m.nombre as ciudad, DATE_FORMAT(a.fechanacimiento, '%d/%m/%Y') fechanacimiento,
        concat_ws(' ',ptpadre.apellidopaterno,ptpadre.apellidomaterno,ptpadre.nombre) as nombrepadre,ptpadre.correo as emailpadre,
        concat_ws(' ',ptmadre.apellidopaterno,ptmadre.apellidomaterno,ptmadre.nombre) as nombremadre,ptmadre.correo as emailmadre,adm.contactoemergenciatelefono,
        a.alumnoid,g.grado,n.nombre as nivel,n.nivelid,g.gradoid,gru.grupoid,foto.foto, a.hijopersonal, ae1.alumnoestatusid ")
            ->from("AppBundle:CeAlumno", "a")
            ->innerJoin('a.alumnoestatusid', 'ae1')
            ->innerJoin('AppBundle:CeAlumnoporciclo', 'ac', \Doctrine\ORM\Query\Expr\Join::WITH, 'ac.alumnoid=a.alumnoid')
            ->leftJoin('AppBundle:CeAlumnociclofoto', 'foto', \Doctrine\ORM\Query\Expr\Join::WITH, 'foto.alumnoporcicloid=ac.alumnoporcicloid')
            ->innerJoin('AppBundle:CeEstatusalumnoporciclo', 'eac', \Doctrine\ORM\Query\Expr\Join::WITH, 'eac.estatusalumnoporcicloid=ac.estatusalumnocicloid')
            ->innerJoin('AppBundle:CeAlumnocicloporgrupo', 'acg', \Doctrine\ORM\Query\Expr\Join::WITH, 'acg.alumnoporcicloid=ac.alumnoporcicloid')
            ->innerJoin('AppBundle:Grado', 'g', \Doctrine\ORM\Query\Expr\Join::WITH, 'g.gradoid=ac.gradoid')
            ->innerJoin('AppBundle:Nivel', 'n', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.nivelid=g.nivelid')
            ->innerJoin('AppBundle:CeGrupo', 'gru', \Doctrine\ORM\Query\Expr\Join::WITH, 'gru.grupoid=acg.grupoid')
            ->leftJoin('AppBundle:CeNacionalidadporalumno', 'naa', \Doctrine\ORM\Query\Expr\Join::WITH, 'naa.alumnoid=a.alumnoid')
            ->leftJoin('AppBundle:Nacionalidad', 'na', \Doctrine\ORM\Query\Expr\Join::WITH, 'na.nacionalidadid=naa.nacionalidadid')
            ->leftJoin('AppBundle:BcBecas', 'b', \Doctrine\ORM\Query\Expr\Join::WITH, 'b.alumnoid=a.alumnoid and b.cicloid=ac.cicloid')
            ->leftJoin('AppBundle:BcPorcentajebeca', 'pb', \Doctrine\ORM\Query\Expr\Join::WITH, 'pb.porcentajebecaid=b.porcentajebecaid')
            ->leftJoin('AppBundle:CeAlumnodomicilio', 'ad', \Doctrine\ORM\Query\Expr\Join::WITH, 'ad.alumnoid = a.alumnoid')
            ->leftJoin('AppBundle:Municipio', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.municipioid=ad.ciudad')
            ->leftJoin('AppBundle:CeAlumnotelefono', 'at', \Doctrine\ORM\Query\Expr\Join::WITH, 'at.alumnoid = a.alumnoid')
            ->leftJoin('AppBundle:CeAlumnoporclavefamiliar', 'acf', \Doctrine\ORM\Query\Expr\Join::WITH, 'acf.alumnoid=a.alumnoid')
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'padre', \Doctrine\ORM\Query\Expr\Join::WITH, 'padre.clavefamiliarid=acf.clavefamiliarid and padre.tutorid=1')
            ->leftJoin('AppBundle:CePadresotutores', 'ptpadre', \Doctrine\ORM\Query\Expr\Join::WITH, 'ptpadre.padresotutoresid=padre.padresotutoresid')
            ->leftJoin('AppBundle:Usuario', 'upadre', \Doctrine\ORM\Query\Expr\Join::WITH, 'ptpadre.padresotutoresid=upadre.padreotutorid')
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'madre', \Doctrine\ORM\Query\Expr\Join::WITH, 'madre.clavefamiliarid=acf.clavefamiliarid and madre.tutorid=2')
            ->leftJoin('AppBundle:CePadresotutores', 'ptmadre', \Doctrine\ORM\Query\Expr\Join::WITH, 'ptmadre.padresotutoresid=madre.padresotutoresid')
            ->leftJoin('AppBundle:Usuario', 'umadre', \Doctrine\ORM\Query\Expr\Join::WITH, 'ptmadre.padresotutoresid=umadre.padreotutorid')
            ->leftJoin('AppBundle:CeAlumnodatomedico', 'adm', \Doctrine\ORM\Query\Expr\Join::WITH, 'adm.alumnoid=a.alumnoid')
            ->groupBy("a.alumnoid")
            ->orderBy("a.apellidopaterno, a.apellidomaterno, a.primernombre");
        if (isset($filtros['cicloid'])) {
            $result->andWhere('ac.cicloid =' . $filtros['cicloid']);
        }

        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid =' . $filtros['nivelid']);
        }

        if (isset($filtros['grupoid'])) {
            $result->andWhere('gru.grupoid =' . $filtros['grupoid']);
        }

        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid =' . $filtros['gradoid']);
        }

        if (isset($filtros['matricula'])) {
            $result->andWhere('a.matricula like \'%' . $filtros['matricula'] . '%\'');
        }

        if (isset($filtros['nombre'])) {
            $result->andWhere('a.primernombre like \'%' . $filtros['nombre'] . '%\'');
        }

        if (isset($filtros['apellidopaterno'])) {
            $result->andWhere('a.apellidopaterno like \'%' . $filtros['apellidopaterno'] . '%\'');
        }

        if (isset($filtros['apellidomaterno'])) {
            $result->andWhere('a.apellidomaterno like \'%' . $filtros['apellidomaterno'] . '%\'');
        }

        return $result->getQuery()->getResult();
    }
}
