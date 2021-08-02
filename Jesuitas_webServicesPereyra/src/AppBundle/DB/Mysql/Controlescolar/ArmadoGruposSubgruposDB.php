<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;


class ArmadoGruposSubgruposDB extends BaseDBManager 
{
    public function getAlumnosCicloPorGrupo($ciclo, $grado, $grupo = NULL){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid,a.matricula,a.sexo,a.primernombre,a.segundonombre,a.apellidomaterno,a.apellidopaterno, acg.numerolista, g.nombre gruponombre, g.grupoid, tg.tipogrupoid, tg.nombre tipogruponombre, 
        CASE
            WHEN calculaAdeudo(a.alumnoid) > 0 THEN 
                CASE 
                    WHEN acu.acuerdoid IS NOT NULL THEN 'Convenio vigente' 
                    ELSE 'Con adeudo' 
                END
            ELSE 'Sin adeudo'
        END adeudo, 
        acu.acuerdoid,
    0.0 as promedio, ac.alumnoporcicloid, acg.alumnocicloporgrupo, c.clave clavefamiliar,ecc.estatusalumnoporcicloid, ir.intencionreinscribirseid")
        ->from('AppBundle:CeAlumnoporciclo','ac')
        ->innerJoin('ac.alumnoid', 'a')
        ->leftJoin('ac.intencionreinscribirseid','ir')
        ->leftJoin('AppBundle:CeEstatusalumnoporciclo','ecc',\Doctrine\ORM\Query\Expr\Join::WITH,'ecc.estatusalumnoporcicloid = ac.estatusalumnocicloid')
        ->leftJoin('AppBundle:CeAlumnoporclavefamiliar','acc',\Doctrine\ORM\Query\Expr\Join::WITH,'acc.alumnoid = a.alumnoid')
        ->leftJoin('AppBundle:CeClavefamiliar','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c.clavefamiliarid = acc.clavefamiliarid')
        ->leftJoin('AppBundle:CeAlumnocicloporgrupo','acg',\Doctrine\ORM\Query\Expr\Join::WITH,'acg.alumnoporcicloid = ac.alumnoporcicloid')
        ->leftJoin('acg.grupoid', 'g')
        ->leftJoin('g.tipogrupoid','tg')
        ->leftJoin("AppBundle:CbAlumnoporacuerdo", "aa", \Doctrine\ORM\Query\Expr\Join::WITH, "a.alumnoid = aa.alumnoid")
        ->leftJoin("AppBundle:CbAcuerdo", "acu", \Doctrine\ORM\Query\Expr\Join::WITH, "aa.acuerdoid = acu.acuerdoid AND acu.estatusacuerdoid = 1")
        ->where('ac.cicloid = ' . $ciclo)
        ->andWhere('ac.gradoid = ' . $grado)
        //->andWhere('ac.intencionreinscribirseid in (1,3)')
        //->andWhere('a.alumnoestatusid = 1')
        ->orderBy('acg.numerolista')
        ->groupBy('a.alumnoid');
        if($grupo !== NULL){
            $result->where('acg.grupoid = ' . $grupo);
        }
        $res = $result->getQuery()->getResult();
        return $res;
    }
    
    public function getAlumnosCicloPorGrupoOrigen($gruposorigen,$subgrupos, $cicloid){
        $qb = $this->em->getConnection();
        $sql = "

            select
            a.alumnoid,
            a.matricula,
            a.sexo,
            ac.gradoid,
            a.primernombre,
            a.segundonombre,
            a.apellidomaterno,
            a.apellidopaterno,
            acg.numerolista, 
            case when g.nombre is null then sg.nombre else g.nombre end as gruponombre,
            case when g.grupoid is null then sg.grupoid else g.grupoid end  as grupoid, 
            case when tg.tipogrupoid is null then stg.tipogrupoid else tg.tipogrupoid end as tipogrupoid, 
            case when tg.nombre is null then stg.nombre else tg.nombre end as tipogruponombre,
            CASE
                WHEN calculaAdeudo(a.alumnoid) > 0 THEN 
                    CASE 
                        WHEN acu.acuerdoid IS NOT NULL THEN 'Convenio vigente' 
                        ELSE 'Con adeudo' 
                    END
                ELSE 'Sin adeudo'
            END adeudo, 
            ac.alumnoporcicloid, 
            acg.alumnocicloporgrupo, 
            c.clave clavefamiliar,
            ecc.estatusalumnoporcicloid
            from ce_alumnoporciclo ac
            inner join ce_alumno a on a.alumnoid = ac.alumnoid
            inner join ce_alumnoporclavefamiliar acc on acc.alumnoid = a.alumnoid
            left join cb_alumnoporacuerdo aa on a.alumnoid = aa.alumnoid
            left join cb_acuerdo acu on aa.acuerdoid = acu.acuerdoid AND acu.estatusacuerdoid = 1
            inner join ce_clavefamiliar c on c.clavefamiliarid = acc.clavefamiliarid
            inner join ce_estatusalumnoporciclo ecc on ecc.estatusalumnoporcicloid = ac.estatusalumnocicloid
            
            inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid = ac.alumnoporcicloid
            left join ce_grupo g on g.grupoid = acg.grupoid and g.tipogrupoid = 1  and g.grupoid in (". implode(',',$gruposorigen) .")
            left join ce_tipogrupo tg on tg.tipogrupoid = g.tipogrupoid
            
            left join ce_grupo sg on sg.grupoid = acg.grupoid and sg.tipogrupoid in (2,3) and sg.grupoid in (". implode(',',$subgrupos) .")
            left join ce_grupoorigenporsubgrupo gup on gup.grupoid = sg.grupoid
            left join ce_tipogrupo stg on stg.tipogrupoid = sg.tipogrupoid
            
            where ac.intencionreinscribirseid in (1,3)  and ac.cicloid = ". $cicloid ." and (case when sg.grupoid is not null then sg.grupoid is not null else g.grupoid is not null end) 
            group by acg.alumnocicloporgrupo
            order by a.alumnoid
        
        ";
        $stmt = $qb->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getSubgrupos($subgrupos){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("g")
        ->from('AppBundle:CeGrupo','g')
        ->where('g.grupoid in ('. implode(',',$subgrupos) .')');
        return $result->getQuery()->getResult();
    }
}