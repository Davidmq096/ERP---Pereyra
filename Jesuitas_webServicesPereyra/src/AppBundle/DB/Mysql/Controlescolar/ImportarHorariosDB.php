<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

class ImportarHorariosDB extends BaseDBManager
{
    public function getFiltros($filtros, $all){
        
        if($all){
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("pr.profesorid, p.profesorpormateriaplanestudiosid, pr.numeronomina, CONCAT(pr.apellidopaterno, ' ', pr.apellidomaterno,' ',pr.nombre) as nombre, CONCAT(pr.numeronomina,'-',pr.apellidopaterno, ' ', pr.apellidomaterno,' ',pr.nombre) as full, pr.apellidopaterno, pr.apellidomaterno, pr.nombre as primernombre")
            ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
            ->leftJoin("p.materiaporplanestudioid", "m")
            ->leftJoin("m.planestudioid", "mpe")
            ->innerJoin("p.profesorid", "pr")
            ->leftJoin("p.grupoid", "gru")
            ->leftJoin("p.tallerid", "ta")
            ->leftJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=ta.tallercurricularid");
            $result->Where('gru.cicloid = ' . $filtros['cicloid'])
             ->orWhere('ta.cicloid = ' . $filtros['cicloid']);
            $result->andWhere('gru.gradoid in(' . implode(',', $filtros['gradoid']) . ') or gce.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
            $profesores = $result->getQuery()->getResult();
    
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("case
              when pma.materiaid is not null then
                pma.clave
              else
                ma.clave
              end as clave,
          case
              when pma.materiaid is not null then
                pma.nombre
              else
                ma.nombre
              end as nombre,
              case
              when pma.materiaid is not null then
                pma.materiaid
              else
                ma.materiaid
              end as materiaid, CONCAT(case
              when pma.materiaid is not null then
                pma.clave
              else
                ma.clave
              end, ' - ', case
              when pma.materiaid is not null then
                pma.nombre
              else
                ma.nombre
              end) as full")
            ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
            ->leftJoin("p.materiaporplanestudioid", "m")
            ->leftJoin("m.planestudioid", "mpe")
            ->leftJoin("p.materiaid", "pma")
            ->leftJoin("m.materiaid", "ma")
            ->innerJoin("p.profesorid", "pr")
            ->leftJoin("p.grupoid", "gru")
            ->leftJoin("p.tallerid", "ta")
            ->leftJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=ta.tallercurricularid");
            $result->Where('gru.cicloid = ' . $filtros['cicloid'])
            ->orWhere('ta.cicloid = ' . $filtros['cicloid']);
            $result->andWhere('mpe.gradoid in(' . implode(',', $filtros['gradoid']) . ') or gce.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
            $result->groupBy('pma.materiaid, ma.materiaid');
            $materias = $result->getQuery()->getResult();
    
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select('g.grupoid, g.nombre')
            ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
            ->leftJoin("p.materiaporplanestudioid", "m")
            ->leftJoin("m.planestudioid", "mpe")
            ->innerJoin("p.grupoid", "g")
            ->innerJoin("p.profesorid", "pr")
            ->leftJoin("p.grupoid", "gru")
            ->leftJoin("p.tallerid", "ta");
            $result->Where('gru.cicloid = ' . $filtros['cicloid'])
             ->orWhere('ta.cicloid = ' . $filtros['cicloid']);
            $result->andWhere('mpe.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
            $result->groupBy('g.grupoid');
            $grupos = $result->getQuery()->getResult();
    
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select('ta.tallercurricularid, ta.tallercurricularid ID, ta.nombre')
            ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
            ->leftJoin("p.materiaporplanestudioid", "m")
            ->leftJoin("m.planestudioid", "mpe")
            ->innerJoin("p.tallerid", "ta")
            ->innerJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=ta.tallercurricularid")
            ->innerJoin("p.profesorid", "pr");
            $result->Where('ta.cicloid = ' . $filtros['cicloid']);
            $result->andWhere('gce.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
            $result->groupBy('ta.tallercurricularid');
            $talleres = $result->getQuery()->getResult();
            

            foreach($talleres as $taller){
                $qb = $this->em->createQueryBuilder();
                $result = $qb->select("mm.clave,mm.nombre,mm.materiaid, CONCAT(mm.clave,' - ',mm.nombre) as full")
                ->from("AppBundle:CeGradoportallercurricular", 'g')
                ->innerJoin("g.materiaporplanestudioid", "m")
                ->innerJoin("m.materiaid", 'mm');
                $result->andWhere('g.tallercurricularid = ' . $taller['ID']);
                $result->andWhere('g.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
                $result->groupBy('mm.materiaid');
                $ms = $result->getQuery()->getResult();
                foreach($ms as $m){
                    $materias[] = $m;
                }
            }
    
        }else{
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select('pr.numeronomina, pr.nombre, pr.apellidopaterno, pr.apellidomaterno')
            ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
            ->leftJoin("p.materiaporplanestudioid", "m")
            ->leftJoin("m.planestudioid", "mpe")
            ->innerJoin("p.profesorid", "pr")
            ->leftJoin("p.grupoid", "gru")
            ->leftJoin("p.tallerid", "ta")
            ->leftJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=ta.tallercurricularid");
            $result->Where('gru.cicloid = ' . $filtros['cicloid'])
             ->orWhere('ta.cicloid = ' . $filtros['cicloid']);
            $result->andWhere('gru.gradoid in(' . implode(',', $filtros['gradoid']) . ') or gce.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
            $profesores = $result->getQuery()->getResult();

            $qb = $this->em->createQueryBuilder();
            $result = $qb->select('case
            when pma.materiaid is not null then
                pma.clave
            else
                ma.clave
            end as Clave,
        case
            when pma.materiaid is not null then
                pma.nombre
            else
                ma.nombre
            end as Nombre')
            ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
            ->leftJoin("p.materiaporplanestudioid", "m")
            ->leftJoin("m.planestudioid", "mpe")
            ->leftJoin("p.materiaid", "pma")
            ->leftJoin("m.materiaid", "ma")
            ->innerJoin("p.profesorid", "pr")
            ->leftJoin("p.grupoid", "gru")
            ->leftJoin("p.tallerid", "ta")
            ->leftJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=ta.tallercurricularid");
            $result->Where('gru.cicloid = ' . $filtros['cicloid'])
             ->orWhere('ta.cicloid = ' . $filtros['cicloid']);
            $result->andWhere('mpe.gradoid in(' . implode(',', $filtros['gradoid']) . ') or gce.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
            $result->groupBy('pma.materiaid, ma.materiaid');
            $materias = $result->getQuery()->getResult();

            $qb = $this->em->createQueryBuilder();
            $result = $qb->select('g.grupoid ID, g.nombre')
            ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
            ->innerJoin("p.materiaporplanestudioid", "m")
            ->innerJoin("m.planestudioid", "mpe")
            ->innerJoin("p.grupoid", "g")
            ->innerJoin("p.profesorid", "pr")
            ->leftJoin("p.grupoid", "gru")
            ->leftJoin("p.tallerid", "ta");
            $result->Where('gru.cicloid = ' . $filtros['cicloid'])
             ->orWhere('ta.cicloid = ' . $filtros['cicloid']);
            $result->andWhere('mpe.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
            $result->groupBy('g.grupoid');
            $grupos = $result->getQuery()->getResult();

            $qb = $this->em->createQueryBuilder();
            $result = $qb->select('ta.tallercurricularid,ta.tallercurricularid ID, ta.nombre')
            ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
            ->leftJoin("p.materiaporplanestudioid", "m")
            ->leftJoin("m.planestudioid", "mpe")
            ->innerJoin("p.tallerid", "ta")
            ->innerJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=ta.tallercurricularid")
            ->innerJoin("p.profesorid", "pr");
            $result->Where('ta.cicloid = ' . $filtros['cicloid']);
            $result->andWhere('gce.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
            $result->groupBy('ta.tallercurricularid');
            $talleres = $result->getQuery()->getResult();

            foreach($talleres as $taller){
                $qb = $this->em->createQueryBuilder();
                $result = $qb->select("mm.clave as Clave, mm.nombre as Nombre")
                ->from("AppBundle:CeGradoportallercurricular", 'g')
                ->innerJoin("g.materiaporplanestudioid", "m")
                ->innerJoin("m.materiaid", 'mm');
                $result->andWhere('g.tallercurricularid = ' . $taller['ID']);
                $result->andWhere('g.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
                $result->groupBy('mm.materiaid');
                $ms = $result->getQuery()->getResult();
                foreach($ms as $m){
                    $materias[] = $m;
                }
            }

        }


        return [
            'profesores' => $profesores,
            'materias' => $materias,
            'grupos' => $grupos,
            'talleres' => $talleres
        ];
    }

    public function getProfesoresPorHorario($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('case
        when ta.tallercurricularid is not null then
            0
        when pma.materiaid is not null then
          pma.materiaid
        else
          ma.materiaid
        end as materiaid,ta.tallercurricularid,gru.nombre grupo,case when gra.gradoid is not null then gra.grado else grag.grado end as grado,pr.numeronomina, pr.nombre, pr.apellidopaterno,pr.apellidomaterno,p.profesorpormateriaplanestudiosid, case when n.nivelid is not null then n.nombre else nn.nombre end nivel')
        ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
        ->leftJoin("p.materiaporplanestudioid", "m")
        ->leftJoin("m.planestudioid", "mpe")
        ->leftJoin("mpe.gradoid", "gra")
        ->leftJoin("gra.nivelid", "n")
        ->leftJoin("p.grupoid", "gru")
        ->leftJoin("p.tallerid", "ta")
        ->leftJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=ta.tallercurricularid")
        ->leftJoin("gce.gradoid", "grag")
        ->leftJoin("grag.nivelid", "nn")
        ->leftJoin("gru.cicloid", "c")
        ->leftJoin("ta.cicloid", "cc")
        ->leftJoin("p.materiaid", "pma")
        ->leftJoin("m.materiaid", "ma")
        ->innerJoin("p.profesorid", "pr");
        $result->Where('c.cicloid = ' . $filtros['cicloid'] . ' or cc.cicloid = ' . $filtros['cicloid']);
        $result->andWhere('gra.gradoid in(' . implode(',', $filtros['gradoid']) . ') or gce.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
        $result->groupBy('p.profesorpormateriaplanestudiosid');
        return $result->getQuery()->getResult();
    }

    public function getTalleres($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('ta.tallercurricularid')
        ->from("AppBundle:CeTallercurricular", 'ta')
        ->innerJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=ta.tallercurricularid")
        ->innerJoin('gce.gradoid','g')
        ->innerJoin('g.nivelid','n')
        ->innerJoin('ta.cicloid','c');
        if (isset($filtros['cicloid'])){
        $result->andwhere('c.cicloid = ' . $filtros['cicloid']);
        }
        if (isset($filtros['gradoid'])){
        $result->andwhere('g.gradoid = ' . $filtros['gradoid']);
        }
        if (isset($filtros['nivelid'])){
        $result->andwhere('n.nivelid = ' . $filtros['nivelid']);
        }
        if (isset($filtros['tallerid'])){
        $result->andwhere('ta.tallercurricularid = ' . $filtros['tallerid']);
        }
        return $result->getQuery()->getResult();
    }

    public function BuscarTablaHorario($filtros){

        if($filtros['tallerid']){
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("gru.tallercurricularid grupoid,gru.nombre as grupo,mm.nombre as materia,h.dia,h.salon, DATE_FORMAT(h.horainicio, '%H:%i') as horainicio,  DATE_FORMAT(h.horafin, '%H:%i') as horafin, concat_ws(' ',pr.apellidopaterno,pr.apellidomaterno,pr.nombre) as profesor, pr.profesorid, 1 as taller,pes.planestudioid")
            ->from("AppBundle:CeHorario", 'h')
            ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe", Expr\Join::WITH, "pmpe.profesorpormateriaplanestudiosid=h.profesorpormateriaplanestudiosid")
            ->innerJoin("AppBundle:CeTallercurricular", "gru", Expr\Join::WITH, "gru.tallercurricularid=pmpe.tallerid")
            ->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid=gru.cicloid")
            ->innerJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=gru.tallercurricularid")
            ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid=gce.gradoid")
            ->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid=g.nivelid")
            ->innerJoin("gce.materiaporplanestudioid", "mpe")
            ->innerJoin("mpe.planestudioid", "pes")
            ->innerJoin("pmpe.profesorid", "pr")
            ->innerJoin("mpe.materiaid", "mm");
            if (isset($filtros['cicloid'])){
            $result->andwhere('c.cicloid = ' . $filtros['cicloid']);
            }
            if (isset($filtros['gradoid'])){
            $result->andwhere('g.gradoid = ' . $filtros['gradoid']);
            }
            if (isset($filtros['nivelid'])){
            $result->andwhere('n.nivelid = ' . $filtros['nivelid']);
            }
            if (isset($filtros['tallerid'])){
            $result->andwhere('gru.tallercurricularid = ' . $filtros['tallerid']);
            }
            $result->orderBy("h.dia,h.horainicio");
            if(!$filtros['groupby']){
                $result->groupBy("gru.tallercurricularid");
            }
            return $result->getQuery()->getResult();
        }else{
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("gru.grupoid,tg.tipogrupoid,gru.nombre as grupo,
            case
            when m.materiaid is not null then
                m.nombre
            else
                mm.nombre
            end as materia,h.dia,h.salon, DATE_FORMAT(h.horainicio, '%H:%i') as horainicio,  DATE_FORMAT(h.horafin, '%H:%i') as horafin, concat_ws(' ',pr.apellidopaterno,pr.apellidomaterno,pr.nombre) as profesor,pr.profesorid, 0 as taller, h.horarioid, n.nivelid, g.gradoid,pes.planestudioid")
            ->from("AppBundle:CeHorario", 'h')
            ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe", Expr\Join::WITH, "pmpe.profesorpormateriaplanestudiosid=h.profesorpormateriaplanestudiosid")
            ->innerJoin("AppBundle:CeGrupo", "gru", Expr\Join::WITH, "gru.grupoid=pmpe.grupoid")
            ->leftJoin("AppBundle:CeGrupoorigenporsubgrupo", "sgru", Expr\Join::WITH, "sgru.grupoid=gru.grupoid")
            ->leftJoin("AppBundle:CeGrupo", "grug", Expr\Join::WITH, "grug.grupoid=sgru.grupoorigenid")
            ->innerJoin("AppBundle:CeTipogrupo", "tg", Expr\Join::WITH, "tg.tipogrupoid=gru.tipogrupoid")
            ->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid=gru.cicloid")
            ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid=gru.gradoid")
            ->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid=g.nivelid")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acpg", Expr\Join::WITH, "acpg.grupoid=gru.grupoid or acpg.grupoid=grug.grupoid")
            ->leftJoin('acpg.alumnoporcicloid', 'ac')
            ->innerJoin("pmpe.materiaporplanestudioid", "mpe")
            ->innerJoin("mpe.planestudioid", "pes")
            ->innerJoin("pmpe.profesorid", "pr")
            ->innerJoin("mpe.materiaid", "mm")
            ->leftJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid=pmpe.materiaid");
            if (isset($filtros['cicloid'])){
            $result->andwhere('c.cicloid = ' . $filtros['cicloid']);
            }
            if (isset($filtros['gradoid'])){
            $result->andwhere('g.gradoid = ' . $filtros['gradoid']);
            }
            if (isset($filtros['nivelid'])){
            $result->andwhere('n.nivelid = ' . $filtros['nivelid']);
            }
            if (isset($filtros['alumnoid'])){
                $result->andwhere('ac.alumnoid = ' . $filtros['alumnoid']);
            }
            if (isset($filtros['grupoid'])){
            $result->andwhere('gru.grupoid = ' . $filtros['grupoid']. ' or grug.grupoid = ' . $filtros['grupoid']);
            }
            $result->orderBy("h.dia,h.horainicio")
            ->groupBy('h.dia,h.horainicio,pmpe.profesorpormateriaplanestudiosid');
            return $result->getQuery()->getResult();
        }
    }

    public function getProfesorPorMateria($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('case
        when ta.tallercurricularid is not null then
            mm.materiaid
        when pma.materiaid is not null then
          pma.materiaid
        else
          ma.materiaid
        end as materiaid,ta.tallercurricularid,gru.nombre grupo,gra.grado,pr.numeronomina, pr.nombre, pr.apellidopaterno,pr.apellidomaterno,p.profesorpormateriaplanestudiosid, n.nombre nivel, case when m.materiaporplanestudioid is not null then m.materiaporplanestudioid else maa.materiaporplanestudioid end as materiaporplanestudioid, gru.grupoid, gra.gradoid, c.cicloid')
        ->from("AppBundle:CeProfesorpormateriaplanestudios", 'p')
        ->leftJoin("p.materiaporplanestudioid", "m")
        ->leftJoin("m.planestudioid", "mpe")
        ->leftJoin("mpe.gradoid", "gra")
        ->leftJoin("gra.nivelid", "n")
        ->leftJoin("p.grupoid", "gru")
        ->leftJoin("p.tallerid", "ta")
        ->leftJoin("p.materiaid", "pma")
        ->leftJoin("gru.cicloid", "c")
        ->leftJoin("m.materiaid", "ma")
        ->leftJoin("AppBundle:CeGradoportallercurricular", "gce", Expr\Join::WITH, "gce.tallercurricularid=ta.tallercurricularid")
        ->leftJoin("gce.materiaporplanestudioid", "maa")
        ->leftJoin("maa.materiaid", "mm")
        ->leftJoin("ta.cicloid", "cc")
        ->leftJoin("p.profesorid", "pr");
        if($filtros['gradoid']){
            $result->andWhere('gra.gradoid in(' . implode(',', $filtros['gradoid']) . ')');
        }
        if($filtros['materiaid']){
            $result->andWhere('ma.materiaid = ' . $filtros['materiaid'] . ' or mm.materiaid = ' . $filtros['materiaid']);
        }
        if($filtros['grupoid']){
            $result->andWhere('gru.grupoid = ' . $filtros['grupoid']);
        }
        if($filtros['nivelid']){
            $result->andWhere('n.nivelid = ' . $filtros['nivelid']);
        }
        if($filtros['profesorpormateriaplanestudiosid']){
            $result->andWhere('p.profesorpormateriaplanestudiosid = ' . $filtros['profesorpormateriaplanestudiosid']);
        }
        return $result->getQuery()->getResult();
    }
    
    public function getALumnosportallergrupo($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('gru.grupoid, c.cicloid, a.alumnoid, ta.tallercurricularid')
        ->from("AppBundle:CeProfesorpormateriaplanestudios", "p")
        ->leftJoin("p.grupoid", "gru")
        ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "gru.grupoid = acg.grupoid")
        ->leftJoin("p.tallerid", "ta")
        ->leftJoin("AppBundle:CeAlumnocicloportaller", "act", Expr\Join::WITH, "ta.tallercurricularid = act.tallercurricularid")
        
        ->leftJoin("AppBundle:CeAlumnoporciclo", "ac" , Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid or act.alumnoporcicloid = ac.alumnoporcicloid")
        ->leftJoin("ac.alumnoid", "a")
        ->leftJoin("ac.estatusalumnocicloid", "eac")
        ->leftJoin("a.alumnoestatusid", "ae")
        ->leftJoin("ac.cicloid", "c")
        ->Where('p.profesorpormateriaplanestudiosid = :profesorpormateriaplanestudiosid')
        ->andWhere('ae.alumnoestatusid = 1 and eac.estatusalumnoporcicloid in (1,2)')
        ->setParameter("profesorpormateriaplanestudiosid", $filtros['profesorpormateriaplanestudiosid']);
        return $result->getQuery()->getResult();
    }
}
