<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Armado de talleres
 *
 * @author David Medina
 */
class ArmadoTallerCurricularDB extends BaseDBManager
{

    public function getMateriasporalumno ($gradoid, $cicloid) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("gtc.gradoportallercurricularid, mp.materiaporplanestudioid, m.nombre, cl.clasificadorparaescolaresid")
        ->from("AppBundle:CeGradoportallercurricular", 'gtc')
        ->innerJoin("AppBundle:CeTallercurricular", "tc", Expr\Join::WITH, "tc.tallercurricularid = gtc.tallercurricularid")
        ->innerJoin("AppBundle:CeMateriaporplanestudios", "mp", Expr\Join::WITH, "mp.materiaporplanestudioid = gtc.materiaporplanestudioid")
        ->innerJoin("AppBundle:Materia", "m", Expr\Join::WITH, "mp.materiaid = m.materiaid")
        ->innerJoin("tc.cicloid", "c")
        ->innerJoin("m.clasificadorparaescolaresid", "cl")
        ->andWhere('tc.inscripcionweb = 1')
        ->andWhere('c.cicloid =' . $cicloid)
        ->andWhere('gtc.gradoid =' . $gradoid)
        ->groupBy('mp.materiaporplanestudioid');

        return $result->getQuery()->getResult();
    }

    public function getTalleresPorMateriaplanestudio ($materiaid, $cicloid) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("tc.tallercurricularid, tc.nombre, cl.clasificadorparaescolaresid, tc.descripcion")
        ->from("AppBundle:CeGradoportallercurricular", 'gtc')      
        ->innerJoin("AppBundle:CeTallercurricular", "tc", Expr\Join::WITH, "tc.tallercurricularid = gtc.tallercurricularid")
        ->innerJoin("AppBundle:CeMateriaporplanestudios", "mp", Expr\Join::WITH, "mp.materiaporplanestudioid = gtc.materiaporplanestudioid")
        ->innerJoin("tc.cicloid", "c")
        ->innerJoin("tc.clasificadorparaescolaresid", "cl")
        ->andWhere('mp.materiaporplanestudioid =' . $materiaid)
        ->andWhere('c.cicloid =' . $cicloid)
        ->andWhere('tc.inscripcionweb = 1');
        return $result->getQuery()->getResult();
    }
    
    public function BuscarPreregistrotalleres($id) 
    {
        try 
        {
            $conn = $this->em->getConnection();
            $stmt = $conn->prepare("select * from ce_alumnociclopreregistroportaller acp
            where acp.alumnoporcicloid = :id 
            order by acp.alumnociclopreregistroportallerid desc");
            $stmt->execute(array('id' => $id));
            $result = $stmt->fetchAll(); 
            return $result;          
        } 
        catch (Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function BuscarTallerescursadosporalumno($id) 
    {
        try 
        {
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("ac.alumnoporcicloid, act.vigente, t.tallercurricularid ")
            ->from("AppBundle:CeAlumnocicloportaller", 'act')      
            ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoporcicloid = act.alumnoporcicloid")
            ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = ac.alumnoid")
            ->innerJoin("AppBundle:CeTallercurricular", "t", Expr\Join::WITH, "t.tallercurricularid = act.tallercurricularid")
            ->andWhere('a.alumnoid =' . $id);
            return $result->getQuery()->getResult();         
        } 
        catch (Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function getTalleresCurriculares($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("t.nombre, c.nombre ciclo, c.cicloid,t.tallercurricularid, ce.nombre clasificadorparaescolares, ce.clasificadorparaescolaresid, t.cupo, t.cupomaxmasculino, t.cupomaxfemenino, t.inscripcionweb, ta.nombre talleranteriornombre, ta.tallercurricularid talleranteriorid, t.descripcion, t.orden, count(apt.alumnocicloportallerid) asignados, g.gradoid, GroupConcat(distinct g.gradoid) grados, GroupConcat(distinct n.nivelid) niveles")
        ->from("AppBundle:CeTallercurricular", 't')
        ->leftJoin("AppBundle:CeAlumnocicloportaller","apt", \Doctrine\ORM\Query\Expr\Join::WITH,'apt.tallercurricularid = t.tallercurricularid and apt.vigente = 1')
        ->leftJoin("AppBundle:CeGradoportallercurricular","gpt", \Doctrine\ORM\Query\Expr\Join::WITH,'gpt.tallercurricularid = t.tallercurricularid')
        ->leftJoin('apt.alumnoporcicloid', 'ac')
        ->leftJoin('ac.alumnoid', 'a')
        ->leftJoin('gpt.gradoid', 'g')
        ->leftJoin('g.nivelid', 'n')
        ->innerJoin('t.cicloid','c')
        ->innerJoin('t.clasificadorparaescolaresid','ce')
        ->leftJoin('t.talleranteriorid','ta');
        if($filtros['cicloid']){
            $result->andWhere('c.cicloid = ' . $filtros['cicloid']);
        }
        

        if($filtros['orden']){
            $result->where('t.orden is null');
        }else{
            $result->where('t.orden is not null')
            ->andWhere('gpt.gradoid = ' . $filtros['gradoid'])
            ->andWhere('gpt.materiaporplanestudioid = ' . $filtros['materiaid'])
            ->orderBy('t.orden');
        }



        $result->groupBy('t.tallercurricularid');
        $talleres = $result->getQuery()->getResult();

        foreach($talleres as &$taller){
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("count(a.alumnoid) femenino")
            ->from("AppBundle:CeAlumnocicloportaller", 'ac')
            ->innerJoin('ac.alumnoporcicloid','acc')
            ->innerJoin('acc.alumnoid','a')
            ->where("a.sexo = 'F'")
            ->andWhere('ac.tallercurricularid = ' .$taller['tallercurricularid'])
            ->andWhere('ac.vigente = 1')
            ->groupBy('ac.tallercurricularid');
            $femenino = $result->getQuery()->getResult()[0]['femenino'];
            $taller['femenino'] = ($femenino ? $femenino : 0);

            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("count(a.alumnoid) masculino")
            ->from("AppBundle:CeAlumnocicloportaller", 'ac')
            ->innerJoin('ac.alumnoporcicloid','acc')
            ->innerJoin('acc.alumnoid','a')
            ->where("a.sexo = 'M'")
            ->andWhere('ac.tallercurricularid = ' .$taller['tallercurricularid'])
            ->andWhere('ac.vigente = 1')
            ->groupBy('ac.tallercurricularid');
            $masculino = $result->getQuery()->getResult()[0]['masculino'];
            $taller['masculino'] = ($masculino ? $masculino : 0);
        }

        return $talleres;
    }
    
    public function getAlumnosPorTallerCurricular($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("g.gradoid,mt.materiaporplanestudioid,t.tallercurricularid,i.idiomanivelid,c.cicloid,m.nombre materia, t.nombre taller, g.grado, c.nombre ciclo, i.nombre idiomanivel, i.clave idiomaclave, i.orden idiomaorden, id.nombre idioma, id.idiomaid, cl.clasificadorparaescolaresid, t.inscripcionweb")
        ->from("AppBundle:CeTallercurricular", 't')
        ->innerJoin('t.cicloid','c')
        ->innerJoin("AppBundle:CeGradoportallercurricular","gt", \Doctrine\ORM\Query\Expr\Join::WITH,'gt.tallercurricularid = t.tallercurricularid')
        ->innerJoin('gt.gradoid','g')
        ->leftJoin("AppBundle:CeAlumnocicloportaller","acpt", \Doctrine\ORM\Query\Expr\Join::WITH,'acpt.tallercurricularid = t.tallercurricularid') 
        ->leftJoin("AppBundle:CeAlumnoporciclo","ac", \Doctrine\ORM\Query\Expr\Join::WITH,'ac.alumnoporcicloid = acpt.alumnoporcicloid')
        ->leftJoin("AppBundle:CeAlumno","a", \Doctrine\ORM\Query\Expr\Join::WITH,'a.alumnoid = ac.alumnoid')
        ->leftJoin('t.clasificadorparaescolaresid','cl')
        ->leftJoin('gt.materiaporplanestudioid','mt')
        ->leftJoin('mt.materiaid','m')
        ->leftJoin('gt.idiomanivelid','i')
        ->leftJoin('i.idiomaid','id')
        ->andWhere('c.cicloid = ' . $filtros['cicloid'])

        ->groupBy('t.tallercurricularid, g.gradoid');
        if (isset($filtros['tallercurricularid'])) {
            $result->andWhere('t.tallercurricularid = ' . $filtros['tallercurricularid']);
        }
        if (isset($filtros['matricula'])) {
            $result->andWhere('a.matricula = ' . $filtros['matricula']);
        }
        $grados = $result->getQuery()->getResult();
        $asignados = [];
        $porasignar = [];
        foreach($grados as &$grado){
           
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("n.nivelid, act.numerolista, ac.alumnoporcicloid,a.alumnoid, a.matricula, case when a.sexo = 'M' then 'Masculino' else 'Femenino' end sexo, concat(a.apellidopaterno,' ',a.apellidomaterno,' ',case when a.segundonombre is not null then a.segundonombre else '' end,' ',a.primernombre) nombrecompleto, n.nombre nivel, g.grado, g.gradoid, gr.nombre grupo, gr.grupoid, acct.prioridad, e.nombre estatus, act.alumnocicloportallerid")
            ->from("AppBundle:CeAlumnoporciclo", 'ac')
            ->innerJoin('ac.alumnoid','a')
            ->innerJoin('a.alumnoestatusid','e')
            ->innerJoin('ac.cicloid','c')
            ->innerJoin("AppBundle:CeAlumnocicloportaller","act", \Doctrine\ORM\Query\Expr\Join::WITH,'act.alumnoporcicloid = ac.alumnoporcicloid')
            ->innerJoin("AppBundle:CeTallercurricular","t", \Doctrine\ORM\Query\Expr\Join::WITH,'t.tallercurricularid = act.tallercurricularid')
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo","acg", \Doctrine\ORM\Query\Expr\Join::WITH,'acg.alumnoporcicloid = ac.alumnoporcicloid')
            ->leftJoin("AppBundle:CeAlumnociclopreregistroportaller","acct", \Doctrine\ORM\Query\Expr\Join::WITH,'acct.alumnoporcicloid = ac.alumnoporcicloid')
            ->innerJoin('ac.gradoid','g')
            ->leftJoin('acg.grupoid','gr')
            ->innerJoin('g.nivelid','n')
            ->where('g.gradoid = ' .$grado['gradoid'])
            ->andWhere('c.cicloid = ' .$grado['cicloid'])
            ->andWhere('ac.estatusalumnocicloid in (1,2)')
            ->groupBy('a.alumnoid')
            ->orderBy('a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre');
            if (isset($filtros['tallercurricularid'])) {
                $result->andWhere('act.tallercurricularid = ' .$filtros['tallercurricularid']);
            }
            if (isset($filtros['matricula'])) {
                $result->andWhere('a.matricula = ' .$filtros['matricula'] . ' and act.tallercurricularid =' . $grado['tallercurricularid']);
            }
            $alumnosA = $result->getQuery()->getResult();

            foreach($alumnosA as $alumno){
                $alumno['materiaid'] = $grado['materiaporplanestudioid'];
                $alumno['materia'] = $grado['materia'];
                $alumno['idiomanivelid'] = $grado['idiomanivelid'];
                $alumno['idiomanivel'] = $grado['idiomanivel'];
                $alumno['idiomaclave'] = $grado['idiomaclave'];
                $alumno['idiomaorden'] = $grado['idiomaorden'];
                $alumno['idioma'] = $grado['idioma'];
                $alumno['idiomaid'] = $grado['idiomaid'];
                $alumno['clasificadorparaescolaresid'] = $grado['clasificadorparaescolaresid'];
                $alumno['taller'] = $grado['taller'];
                $alumno['tallercurricularid'] = $grado['tallercurricularid'];
                $qb = $this->em->createQueryBuilder();
                $result = $qb->select("t.tallercurricularid, t.nombre taller, acct.prioridad")
                ->from("AppBundle:CeAlumnociclopreregistroportaller","acct")
                ->innerJoin('acct.tallercurricularid','t')

                ->where('acct.alumnoporcicloid = ' . $alumno['alumnoporcicloid']);
                $talleresA = $result->getQuery()->getResult();
                $alumno['talleres'] = [];
                foreach($talleresA as $t){
                    if($t['tallercurricularid'] !== $grado['tallercurricularid']){
                        $alumno['talleres'][] = $t;
                    }
                }
                $find = false;
                foreach($asignados as $a){
                    if(!isset($filtros['matricula'])){
                        if($a['alumnoid'] == $alumno['alumnoid']){
                            $find = true;
                        }
                    }
                }
                if(!$find){
                    $asignados[] = $alumno; 
                }
            }
            if(!isset($filtros['matricula'])){
                if($grado['clasificadorparaescolaresid'] == 3){

                    $qb = $this->em->createQueryBuilder();
                    $result = $qb->select("n.nivelid, acct.numerolista, ac.alumnoporcicloid,a.alumnoid, a.matricula, case when a.sexo = 'M' then 'Masculino' else 'Femenino' end sexo, concat(a.apellidopaterno,' ',a.apellidomaterno,' ',case when a.segundonombre is not null then a.segundonombre else '' end,' ',a.primernombre) nombrecompleto, n.nombre nivel, g.grado, g.gradoid, gr.nombre grupo, gr.grupoid, case when acct.vigente is not null then 1 else 0 end asignado, e.nombre estatus, acct.alumnocicloportallerid,tasa.tallercurricularid")
                    ->from("AppBundle:CeAlumnoporciclo", 'ac')
                    ->innerJoin('ac.alumnoid','a')
                    ->innerJoin('a.alumnoestatusid','e')
                    ->innerJoin('ac.cicloid','c')
                    ->innerJoin("AppBundle:CeAlumnocicloporidiomanivel","act", \Doctrine\ORM\Query\Expr\Join::WITH,'act.alumnoporcicloid = ac.alumnoporcicloid')
                    ->leftJoin("AppBundle:CeAlumnocicloportaller","acct", \Doctrine\ORM\Query\Expr\Join::WITH,'acct.alumnoporcicloid = ac.alumnoporcicloid')
                    ->leftJoin("AppBundle:CeAlumnocicloporgrupo","acg", \Doctrine\ORM\Query\Expr\Join::WITH,'acg.alumnoporcicloid = ac.alumnoporcicloid')
                    ->innerJoin('ac.gradoid','g')
                    ->leftJoin('acg.grupoid','gr')
                    ->leftJoin('acct.tallercurricularid','tasa')
                    ->innerJoin('g.nivelid','n')
                    //->andWhere('g.gradoid = ' . $grado['gradoid'])
                    ->andWhere('act.idiomanivelid = ' . $grado['idiomanivelid'])
                    ->andWhere('c.cicloid = ' . $filtros['cicloid'])
                    ->andWhere('ac.estatusalumnocicloid in (1,2)')
                    ->groupBy('a.alumnoid');

                    $alumnosP = $result->getQuery()->getResult();

                    $grado['porasignar'] = [];

                    
                    foreach($alumnosP as $alumno){
                        $find = false;
                        foreach($porasignar as $p){
                            if($alumno['alumnoid'] ==  $p['alumnoid']){
                                $find = true;
                            }
                        }
                        if(!$find){
                            if($alumno['asignado'] == '0' || !$alumno['alumnocicloportallerid']){
                                $alumno['materiaid'] = $grado['materiaporplanestudioid'];
                                $alumno['materia'] = $grado['materia'];
                                $alumno['idiomanivelid'] = $grado['idiomanivelid'];
                                $alumno['idiomanivel'] = $grado['idiomanivel'];
                                $alumno['idiomaclave'] = $grado['idiomaclave'];
                                $alumno['idiomaorden'] = $grado['idiomaorden'];
                                $alumno['idioma'] = $grado['idioma'];
                                $alumno['idiomaid'] = $grado['idiomaid'];
                                $alumno['clasificadorparaescolaresid'] = $grado['clasificadorparaescolaresid'];
                                $alumno['taller'] = $grado['taller'];
                                $alumno['tallercurricularid'] = $grado['tallercurricularid'];
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller, acct.prioridad")
                                ->from("AppBundle:CeAlumnociclopreregistroportaller","acct")
                                ->innerJoin('acct.tallercurricularid','t')
                                ->where('acct.alumnoporcicloid = ' . $alumno['alumnoporcicloid']);
                                $talleresA = $result->getQuery()->getResult();
                                $alumno['talleres'] = [];
                                foreach($talleresA as $t){
                                    if($t['tallercurricularid'] !== $grado['tallercurricularid']){
                                        $alumno['talleres'][] = $t;
                                    }
                                }
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller")
                                ->from("AppBundle:CeAlumnocicloportaller","act")
                                ->innerJoin('act.tallercurricularid','t')
                                ->innerJoin("AppBundle:CeGradoportallercurricular","gt", \Doctrine\ORM\Query\Expr\Join::WITH,'gt.tallercurricularid = t.tallercurricularid')
                                ->innerJoin('gt.materiaporplanestudioid','m')
                                ->where('act.alumnoporcicloid = ' . $alumno['alumnoporcicloid'])
                                ->andWhere('gt.materiaporplanestudioid = ' . $grado['materiaporplanestudioid']);
                                $tallerespormateria = $result->getQuery()->getResult();
                                if(count($tallerespormateria) == 0){
                                    $find = false;
                                    foreach($porasignar as $a){
                                        if($a['alumnoid'] == $alumno['alumnoid']){
                                            $find = true;
                                        }
                                    }
                                    if(!$find){
                                        $porasignar[] = $alumno; 
                                    }
                                }
                            }else{
                                $alumno['materiaid'] = $grado['materiaporplanestudioid'];
                                $alumno['materia'] = $grado['materia'];
                                $alumno['idiomanivelid'] = $grado['idiomanivelid'];
                                $alumno['idiomanivel'] = $grado['idiomanivel'];
                                $alumno['idiomaclave'] = $grado['idiomaclave'];
                                $alumno['idiomaorden'] = $grado['idiomaorden'];
                                $alumno['idioma'] = $grado['idioma'];
                                $alumno['idiomaid'] = $grado['idiomaid'];
                                $alumno['clasificadorparaescolaresid'] = $grado['clasificadorparaescolaresid'];
                                $alumno['taller'] = $grado['taller'];
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller, acct.prioridad")
                                ->from("AppBundle:CeAlumnociclopreregistroportaller","acct")
                                ->innerJoin('acct.tallercurricularid','t')
                                ->where('acct.alumnoporcicloid = ' . $alumno['alumnoporcicloid']);
                                $talleresA = $result->getQuery()->getResult();
                                $alumno['talleres'] = [];
                                foreach($talleresA as $t){
                                    if($t['tallercurricularid'] !== $grado['tallercurricularid']){
                                        $alumno['talleres'][] = $t;
                                    }
                                }
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller")
                                ->from("AppBundle:CeAlumnocicloportaller","act")
                                ->innerJoin('act.tallercurricularid','t')
                                ->innerJoin("AppBundle:CeGradoportallercurricular","gt", \Doctrine\ORM\Query\Expr\Join::WITH,'gt.tallercurricularid = t.tallercurricularid')
                                ->innerJoin('gt.materiaporplanestudioid','m')
                                ->where('act.alumnoporcicloid = ' . $alumno['alumnoporcicloid'])
                                ->andWhere('gt.materiaporplanestudioid = ' . $grado['materiaporplanestudioid']);
                                $tallerespormateria = $result->getQuery()->getResult();
                                $find = false;
                                foreach($asignados as $a){
                                    if($a['alumnoid'] == $alumno['alumnoid']){
                                        $find = true;
                                    }
                                }
                                if(!$find){
                                    if($filtros['tallercurricularid'] == $alumno['tallercurricularid']){
                                        $asignados[] = $alumno; 
                                    }else{
                                        $porasignar[] = $alumno; 
                                    }
                                }
                            }
                        }
                    }

                    if($grado['inscripcionweb']){
                        $qb = $this->em->createQueryBuilder();
                        $result = $qb->select("n.nivelid,acct.numerolista, ac.alumnoporcicloid,a.alumnoid, a.matricula, case when a.sexo = 'M' then 'Masculino' else 'Femenino' end sexo, concat(a.apellidopaterno,' ',a.apellidomaterno,' ',case when a.segundonombre is not null then a.segundonombre else '' end,' ',a.primernombre) nombrecompleto, n.nombre nivel, g.grado, g.gradoid, gr.nombre grupo, gr.grupoid, case when acct.vigente is not null then 1 else 0 end asignado, act.prioridad, e.nombre estatus, acct.alumnocicloportallerid")
                        ->from("AppBundle:CeAlumnoporciclo", 'ac')
                        ->innerJoin('ac.alumnoid','a')
                        ->innerJoin('a.alumnoestatusid','e')
                        ->innerJoin('ac.cicloid','c')
                        ->innerJoin("AppBundle:CeAlumnociclopreregistroportaller","act", \Doctrine\ORM\Query\Expr\Join::WITH,'act.alumnoporcicloid = ac.alumnoporcicloid')
                        ->leftJoin("AppBundle:CeAlumnocicloportaller","acct", \Doctrine\ORM\Query\Expr\Join::WITH,'acct.alumnoporcicloid = ac.alumnoporcicloid')
                        ->leftJoin("AppBundle:CeAlumnocicloporgrupo","acg", \Doctrine\ORM\Query\Expr\Join::WITH,'acg.alumnoporcicloid = ac.alumnoporcicloid')
                        ->innerJoin('ac.gradoid','g')
                        ->leftJoin('acg.grupoid','gr')
                        ->innerJoin('g.nivelid','n')
                        ->where('g.gradoid = ' .$grado['gradoid'])
                        ->andWhere('c.cicloid = ' .$grado['cicloid'])
                        ->andWhere('act.tallercurricularid = ' .$filtros['tallercurricularid'])
                        ->andWhere('ac.estatusalumnocicloid in (1,2)')
                        ->groupBy('a.alumnoid');
                        $alumnosP = $result->getQuery()->getResult();
        
                        $grado['porasignar'] = [];
        
                        foreach($alumnosP as $alumno){
                            if($alumno['asignado'] == '0' || !$alumno['alumnocicloportallerid']){
                                $alumno['materiaid'] = $grado['materiaporplanestudioid'];
                                $alumno['materia'] = $grado['materia'];
                                $alumno['idiomanivelid'] = $grado['idiomanivelid'];
                                $alumno['idiomanivel'] = $grado['idiomanivel'];
                                $alumno['idiomaclave'] = $grado['idiomaclave'];
                                $alumno['idiomaorden'] = $grado['idiomaorden'];
                                $alumno['idioma'] = $grado['idioma'];
                                $alumno['idiomaid'] = $grado['idiomaid'];
                                $alumno['clasificadorparaescolaresid'] = $grado['clasificadorparaescolaresid'];
                                $alumno['taller'] = $grado['taller'];
                                $alumno['tallercurricularid'] = $grado['tallercurricularid'];
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller, acct.prioridad")
                                ->from("AppBundle:CeAlumnociclopreregistroportaller","acct")
                                ->innerJoin('acct.tallercurricularid','t')
                                ->where('acct.alumnoporcicloid = ' . $alumno['alumnoporcicloid']);
                                $talleresA = $result->getQuery()->getResult();
                                $alumno['talleres'] = [];
                                foreach($talleresA as $t){
                                    if($t['tallercurricularid'] !== $grado['tallercurricularid']){
                                        $alumno['talleres'][] = $t;
                                    }
                                }
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller")
                                ->from("AppBundle:CeAlumnocicloportaller","act")
                                ->innerJoin('act.tallercurricularid','t')
                                ->innerJoin("AppBundle:CeGradoportallercurricular","gt", \Doctrine\ORM\Query\Expr\Join::WITH,'gt.tallercurricularid = t.tallercurricularid')
                                ->innerJoin('gt.materiaporplanestudioid','m')
                                ->where('act.alumnoporcicloid = ' . $alumno['alumnoporcicloid'])
                                ->andWhere('gt.materiaporplanestudioid = ' . $grado['materiaporplanestudioid']);
                                $tallerespormateria = $result->getQuery()->getResult();
                                if(count($tallerespormateria) == 0){
                                    $find = false;
                                    foreach($porasignar as $a){
                                        if($a['alumnoid'] == $alumno['alumnoid']){
                                            $find = true;
                                        }
                                    }
                                    if(!$find){
                                        $porasignar[] = $alumno; 
                                    }
                                }
                            }
                        }
                    }

                }else{
                    if($grado['inscripcionweb']){
                        $qb = $this->em->createQueryBuilder();
                        $result = $qb->select("n.nivelid, acct.numerolista, ac.alumnoporcicloid,a.alumnoid, a.matricula, case when a.sexo = 'M' then 'Masculino' else 'Femenino' end sexo, concat(a.apellidopaterno,' ',a.apellidomaterno,' ',case when a.segundonombre is not null then a.segundonombre else '' end,' ',a.primernombre) nombrecompleto, n.nombre nivel, g.grado, g.gradoid, gr.nombre grupo, gr.grupoid, case when acct.vigente is not null then 1 else 0 end asignado, act.prioridad, e.nombre estatus, acct.alumnocicloportallerid")
                        ->from("AppBundle:CeAlumnoporciclo", 'ac')
                        ->innerJoin('ac.alumnoid','a')
                        ->innerJoin('a.alumnoestatusid','e')
                        ->innerJoin('ac.cicloid','c')
                        ->innerJoin("AppBundle:CeAlumnociclopreregistroportaller","act", \Doctrine\ORM\Query\Expr\Join::WITH,'act.alumnoporcicloid = ac.alumnoporcicloid')
                        ->leftJoin("AppBundle:CeAlumnocicloportaller","acct", \Doctrine\ORM\Query\Expr\Join::WITH,'acct.alumnoporcicloid = ac.alumnoporcicloid')
                        ->leftJoin("AppBundle:CeAlumnocicloporgrupo","acg", \Doctrine\ORM\Query\Expr\Join::WITH,'acg.alumnoporcicloid = ac.alumnoporcicloid')
                        ->innerJoin('ac.gradoid','g')
                        ->leftJoin('acg.grupoid','gr')
                        ->innerJoin('g.nivelid','n')
                        ->where('g.gradoid = ' .$grado['gradoid'])
                        ->andWhere('c.cicloid = ' .$grado['cicloid'])
                        ->andWhere('act.tallercurricularid = ' .$filtros['tallercurricularid'])
                        ->andWhere('ac.estatusalumnocicloid in (1,2)')
                        ->groupBy('a.alumnoid');
                        $alumnosP = $result->getQuery()->getResult();

        
                        $grado['porasignar'] = [];
        
                        foreach($alumnosP as $alumno){
                            if($alumno['asignado'] == '0' || !$alumno['alumnocicloportallerid']){
                                $alumno['materiaid'] = $grado['materiaporplanestudioid'];
                                $alumno['materia'] = $grado['materia'];
                                $alumno['idiomanivelid'] = $grado['idiomanivelid'];
                                $alumno['idiomanivel'] = $grado['idiomanivel'];
                                $alumno['idiomaclave'] = $grado['idiomaclave'];
                                $alumno['idiomaorden'] = $grado['idiomaorden'];
                                $alumno['idioma'] = $grado['idioma'];
                                $alumno['idiomaid'] = $grado['idiomaid'];
                                $alumno['clasificadorparaescolaresid'] = $grado['clasificadorparaescolaresid'];
                                $alumno['taller'] = $grado['taller'];
                                $alumno['tallercurricularid'] = $grado['tallercurricularid'];
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller, acct.prioridad")
                                ->from("AppBundle:CeAlumnociclopreregistroportaller","acct")
                                ->innerJoin('acct.tallercurricularid','t')
                                ->where('acct.alumnoporcicloid = ' . $alumno['alumnoporcicloid']);
                                $talleresA = $result->getQuery()->getResult();
                                $alumno['talleres'] = [];
                                foreach($talleresA as $t){
                                    if($t['tallercurricularid'] !== $grado['tallercurricularid']){
                                        $alumno['talleres'][] = $t;
                                    }
                                }
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller")
                                ->from("AppBundle:CeAlumnocicloportaller","act")
                                ->innerJoin('act.tallercurricularid','t')
                                ->innerJoin("AppBundle:CeGradoportallercurricular","gt", \Doctrine\ORM\Query\Expr\Join::WITH,'gt.tallercurricularid = t.tallercurricularid')
                                ->innerJoin('gt.materiaporplanestudioid','m')
                                ->where('act.alumnoporcicloid = ' . $alumno['alumnoporcicloid'])
                                ->andWhere('gt.materiaporplanestudioid = ' . $grado['materiaporplanestudioid']);
                                $tallerespormateria = $result->getQuery()->getResult();
                                if(count($tallerespormateria) == 0){
                                    $find = false;
                                    foreach($porasignar as $a){
                                        if($a['alumnoid'] == $alumno['alumnoid']){
                                            $find = true;
                                        }
                                    }
                                    if(!$find){
                                        $porasignar[] = $alumno; 
                                    }
                                }
                            }
                        }
                    }else{
                        $qb = $this->em->createQueryBuilder();
                        $result = $qb->select("n.nivelid, acct.numerolista, ac.alumnoporcicloid,a.alumnoid, a.matricula, case when a.sexo = 'M' then 'Masculino' else 'Femenino' end sexo, concat(a.apellidopaterno,' ',a.apellidomaterno,' ',case when a.segundonombre is not null then a.segundonombre else '' end,' ',a.primernombre) nombrecompleto, n.nombre nivel, g.grado, g.gradoid, gr.nombre grupo, gr.grupoid, case when acct.vigente is not null then 1 else 0 end asignado, act.prioridad, e.nombre estatus, acct.alumnocicloportallerid")
                        ->from("AppBundle:CeAlumnoporciclo", 'ac')
                        ->innerJoin('ac.alumnoid','a')
                        ->innerJoin('a.alumnoestatusid','e')
                        ->innerJoin('ac.cicloid','c')
                        ->leftJoin("AppBundle:CeAlumnociclopreregistroportaller","act", \Doctrine\ORM\Query\Expr\Join::WITH,'act.alumnoporcicloid = ac.alumnoporcicloid')
                        ->leftJoin("AppBundle:CeAlumnocicloportaller","acct", \Doctrine\ORM\Query\Expr\Join::WITH,'acct.alumnoporcicloid = ac.alumnoporcicloid')
                        ->leftJoin("AppBundle:CeAlumnocicloporgrupo","acg", \Doctrine\ORM\Query\Expr\Join::WITH,'acg.alumnoporcicloid = ac.alumnoporcicloid')
                        ->innerJoin('ac.gradoid','g')
                        ->leftJoin('acg.grupoid','gr')
                        ->innerJoin('g.nivelid','n')
                        ->where('g.gradoid = ' .$grado['gradoid'])
                        ->andWhere('c.cicloid = ' .$grado['cicloid'])
                        ->andWhere('ac.estatusalumnocicloid in (1,2)')
                        ->groupBy('a.alumnoid');
                        $alumnosP = $result->getQuery()->getResult();
        
                        $grado['porasignar'] = [];
        
                        foreach($alumnosP as $alumno){
                            if($alumno['asignado'] == '0' || !$alumno['alumnocicloportallerid']){
                                $alumno['materiaid'] = $grado['materiaporplanestudioid'];
                                $alumno['materia'] = $grado['materia'];
                                $alumno['idiomanivelid'] = $grado['idiomanivelid'];
                                $alumno['idiomanivel'] = $grado['idiomanivel'];
                                $alumno['idiomaclave'] = $grado['idiomaclave'];
                                $alumno['idiomaorden'] = $grado['idiomaorden'];
                                $alumno['idioma'] = $grado['idioma'];
                                $alumno['idiomaid'] = $grado['idiomaid'];
                                $alumno['clasificadorparaescolaresid'] = $grado['clasificadorparaescolaresid'];
                                $alumno['taller'] = $grado['taller'];
                                $alumno['tallercurricularid'] = $grado['tallercurricularid'];
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller, acct.prioridad")
                                ->from("AppBundle:CeAlumnociclopreregistroportaller","acct")
                                ->innerJoin('acct.tallercurricularid','t')
                                ->where('acct.alumnoporcicloid = ' . $alumno['alumnoporcicloid']);
                                $talleresA = $result->getQuery()->getResult();
                                $alumno['talleres'] = [];
                                foreach($talleresA as $t){
                                    if($t['tallercurricularid'] !== $grado['tallercurricularid']){
                                        $alumno['talleres'][] = $t;
                                    }
                                }
                                $qb = $this->em->createQueryBuilder();
                                $result = $qb->select("t.tallercurricularid, t.nombre taller")
                                ->from("AppBundle:CeAlumnocicloportaller","act")
                                ->innerJoin('act.tallercurricularid','t')
                                ->innerJoin("AppBundle:CeGradoportallercurricular","gt", \Doctrine\ORM\Query\Expr\Join::WITH,'gt.tallercurricularid = t.tallercurricularid')
                                ->innerJoin('gt.materiaporplanestudioid','m')
                                ->where('act.alumnoporcicloid = ' . $alumno['alumnoporcicloid'])
                                ->andWhere('gt.materiaporplanestudioid = ' . $grado['materiaporplanestudioid']);
                                $tallerespormateria = $result->getQuery()->getResult();
                                if(count($tallerespormateria) == 0){
                                    $find = false;
                                    foreach($porasignar as $a){
                                        if($a['alumnoid'] == $alumno['alumnoid']){
                                            $find = true;
                                        }
                                    }
                                    if(!$find){
                                        $porasignar[] = $alumno; 
                                    }
                                }
                            }
                        }
                }
            }
        }

            
        }

        return ['asignados' => $asignados, 'porasignar' => $porasignar];
    }
    
    public function getAlumnosPorTallerCurricularRotacion($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("n.nivelid, acg.numerolista, ac.alumnoporcicloid,a.alumnoid, a.matricula, a.sexo, concat(a.apellidopaterno,' ',a.apellidomaterno,' ',case when a.segundonombre is not null then a.segundonombre else '' end,' ',a.primernombre) nombrecompleto, n.nombre nivel, g.grado, g.gradoid, gr.nombre grupo, gr.grupoid, e.nombre estatusalumnociclo, act.alumnocicloportallerid, t.tallercurricularid, a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno, act.numerolista")
        ->from("AppBundle:CeAlumnoporciclo", 'ac')
        ->innerJoin('ac.alumnoid','a')
        ->innerJoin('a.alumnoestatusid','e')
        ->innerJoin('ac.cicloid','c')
        ->leftJoin("AppBundle:CeAlumnocicloportaller","act", \Doctrine\ORM\Query\Expr\Join::WITH,'act.alumnoporcicloid = ac.alumnoporcicloid and act.tallercurricularid = ' . $filtros['tallercurricularid'] . ' and act.vigente = 1')
        ->leftJoin("AppBundle:CeAlumnocicloporgrupo","acg", \Doctrine\ORM\Query\Expr\Join::WITH,'acg.alumnoporcicloid = ac.alumnoporcicloid')
        ->innerJoin('ac.gradoid','g')
        ->leftJoin('acg.grupoid','gr')
        ->leftJoin('act.tallercurricularid','t')
        ->innerJoin('g.nivelid','n')
        ->where('g.gradoid = ' .$filtros['gradoid'])
        ->andWhere('c.cicloid = ' .$filtros['cicloid'])
        ->orderBy('act.numerolista');

        if(empty($filtros['grupoid']) || $filtros['grupoid'] == '' || $filtros['grupoid'] == 'null' ){}
        else{
            $result->andWhere('gr.grupoid = ' .$filtros['grupoid']);
        }

        $result->groupBy('a.alumnoid');
        $alumnosA = $result->getQuery()->getResult();
        $asignados = [];
        $porasignar = [];

        foreach($alumnosA as $alumno){
            if($alumno['tallercurricularid']){
                $asignados[] = $alumno;
            }else{
                $porasignar[] = $alumno;
            }
        }

        return ['asignados' => $asignados, 'porasignar' => $porasignar];
    }
}