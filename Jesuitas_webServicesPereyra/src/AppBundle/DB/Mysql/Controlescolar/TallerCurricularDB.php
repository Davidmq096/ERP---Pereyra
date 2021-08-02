<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author David Medina
 * @author Emmanuel Martinez
 */
class TallerCurricularDB extends BaseDBManager {

    public function BuscarInfoAlumno($id) 
    {
        try 
        {
            $conn = $this->em->getConnection();
            $stmt = $conn->prepare("select ac.alumnoporcicloid, ac.cicloid, ac.gradoid, ac.estatusalumnocicloid,
            concat_ws(' ', a.primernombre, a.apellidopaterno, a.apellidomaterno) as nombrecompleto ,
            n.nombre as nivel, g.nombre as grupo, ac.cicloid, gr.gradoid, gr.grado
            from ce_alumnoporciclo ac 
            inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid = ac.alumnoporcicloid
            inner join ce_grupo g on g.grupoid = acg.grupoid
            inner join grado gr on gr.gradoid = ac.gradoid
            inner join nivel n on n.nivelid = gr.nivelid
            inner join ce_alumno a on a.alumnoid = ac.alumnoid
            where ac.alumnoid = :id order by ac.cicloid desc limit 1");
            $stmt->execute(array('id' => $id));
            $result = $stmt->fetchAll(); 
            return $result;          
        } 
        catch (Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function BuscarTalleresPorAlumno($filtros) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('e.estadoid, e.nombre, e.abreviatura, e.activo, p.paisid, p.nombre pais')
        ->from("AppBundle:Estado", 'e')
        ->innerJoin('e.paisid', 'p');  

        return $result->getQuery()->getResult();
    }

    public function getBasicTallerCurricular(){
        $qb=$this->em->createQueryBuilder();
        $qb->select("cetc.tallercurricularid AS id,"
							. "cetc.nombre"
            )->from("AppBundle:CeTallercurricular","cetc")
            ->innerJoin("AppBundle:ciclo","c","WITH","c.cicloid=cetc.cicloid")
            ->andWhere("c.activo=1")
            ->andWhere("c.actual=0")
            ->andWhere("c.siguiente=0")
            ;
        return $qb->getQuery()->getResult();
    }
    public function getBasicMateriaPlanEstudio(){
        $qb=$this->em->createQueryBuilder();
        $qb->select("cempe.materiaporplanestudioid AS id,"
							. "IDENTITY(m.clasificadorparaescolaresid) AS clasificadorparaescolaresid,"
							. "IDENTITY(cempe.planestudioid) AS planestudioid,"
							. "m.materiaid,"
							. "m.nombre"
            )->from("AppBundle:CeMateriaporplanestudios","cempe")
            ->innerJoin("AppBundle:CePlanestudios","cepe","WITH","cepe.planestudioid=cempe.planestudioid")
            ->innerJoin("AppBundle:Materia","m","WITH","m.materiaid=cempe.materiaid")
            ->andWhere("cempe.configurartaller=1")
            ->andWhere("cepe.vigente=1")
            ->andWhere("m.activo=1")
            ->orderBy("m.materiaid","ASC")
            ;
        return $qb->getQuery()->getResult();
    }
		public function getTallercurricularDataByFilter($cicloid,$nivelid=null,$gradoid=null,$planestudioid=null,$materiaid=null,$cpescolar=null){
			$data=[];
			$talleresid=[];
			$talleres=$this->getTallercurricularByCiclo($cicloid,["clasificadorparaescolaresid"=>$cpescolar]);
			foreach($talleres AS $i){
				$talleresid[]=$i['tallercurricularid'];
			}
			$grados=[];
			$gradosdata=$this->getGradotallercurricularByTallercurricular($talleresid);
			foreach($gradosdata AS $i){
				$itallerid=$i['tallercurricularid'];
                if(!isset($grados[$itallerid])){ $grados[$itallerid]=[]; }
                $find = false;
                foreach($grados[$itallerid] as $g){
                    if($i['grado'] == $g['grado']){
                        $find = true;
                    }
                }
				if(!$find){
                    $grados[$itallerid][]=$i;
                }
			}
			foreach($talleres AS $i){
				$itallerid=$i['tallercurricularid'];
				$irel=$grados[$itallerid];
				$igradoname="";
				$imaterianame="";
				foreach($irel AS $iigrado){
					$imaterianame.=$iigrado['materia'].", ";
					$igradoname.=$iigrado['nivel']." ".$iigrado['grado'].", ";
				}
				$i['rel']=$irel;
				$i['gradosname']=substr($igradoname,0,-2);
				$i['materiasname']=substr($imaterianame,0,-2);
				if((!$nivelid || $this->getTallercurricularDataEval("nivelid",$nivelid,$irel))
					&& (!$gradoid || $this->getTallercurricularDataEval("gradoid",$gradoid,$irel))
					&& (!$planestudioid || $this->getTallercurricularDataEval("planestudioid",$planestudioid,$irel))
					&& (!$materiaid || $this->getTallercurricularDataEval("materiaporplanestudioid",$materiaid,$irel))
				){
					$data[]=$i;
				}
			}
			return $data;
		}
		private function getTallercurricularDataEval($field,$value,$data){
			foreach($data As $i){
				if(isset($i[$field]) && $i[$field]==$value){
					return true;
				}
			}
			return false;
		}
		public function getTallercurricularByCiclo($cicloid,$filter=[]){
			try{
				$qb=$this->em->createQueryBuilder();
				$qb->select("cetc.tallercurricularid AS id,"
						."cetc.tallercurricularid,"
						."IDENTITY(cetc.cicloid) AS cicloid,"
						."cetc.nombre AS taller,"
						."cetc.cupo,"
						."cetc.orden,"
						."cep.profesorid,"
						."CONCAT(cep.apellidopaterno,' ',cep.apellidomaterno,' ',cep.nombre) AS profesor,"
						."CONCAT(cepsup.apellidopaterno,' ',cepsup.apellidomaterno,' ',cepsup.nombre) AS suplente,"
						."CONCAT(cepco.apellidopaterno,' ',cepco.apellidomaterno,' ',cepco.nombre) AS cotitular"
					)->from("AppBundle:CeTallercurricular", "cetc")
					->leftJoin("AppBundle:CeProfesor", "cep", "WITH", "cep.profesorid=cetc.profesorid")
					->leftJoin("AppBundle:CeProfesor", "cepsup", "WITH", "cepsup.profesorid=cetc.suplenteid")
					->leftJoin("AppBundle:CeProfesor", "cepco", "WITH", "cepco.profesorid=cetc.cotitularid")
					->andWhere("cetc.cicloid=:ciclo")
					->setParameter("ciclo", $cicloid)
				;
				if($filter['clasificadorparaescolaresid']){
					$qb->andWhere("cetc.clasificadorparaescolaresid=:clasificadoparaescolares")
						->setParameter("clasificadoparaescolares", $filter['clasificadorparaescolaresid']);
				}
				return $qb->getQuery()->getResult();
			}catch(\Exception $e){}
			return false;
		}
		public function getGradotallercurricularByTallercurricular($tallercurricularid){
			try{
				$qb=$this->em->createQueryBuilder();
				$qb->select("cegtc.gradoportallercurricularid AS id,"
						."cegtc.gradoportallercurricularid,"
						."IDENTITY(cegtc.tallercurricularid) AS tallercurricularid,"
						."IDENTITY(cempe.planestudioid) AS planestudioid,"
						."cempe.materiaporplanestudioid,"
						."m.materiaid,"
						."n.nivelid,"
						."g.gradoid,"
						."n.nombre AS nivel,"
						."g.grado AS grado,"
						."m.nombre AS materia"
					)->from("AppBundle:CeGradoportallercurricular", "cegtc")
					->innerJoin("AppBundle:CeMateriaporplanestudios", "cempe", "WITH", "cempe.materiaporplanestudioid=cegtc.materiaporplanestudioid")
					->innerJoin("AppBundle:Grado", "g", "WITH", "g.gradoid=cegtc.gradoid")
					->innerJoin("AppBundle:Nivel", "n", "WITH", "n.nivelid=g.nivelid")
					->innerJoin("AppBundle:Materia", "m", "WITH", "m.materiaid=cempe.materiaid")
					->andWhere("cegtc.tallercurricularid IN (:tallercurricular)")
					->setParameter("tallercurricular", $tallercurricularid)
				;
				return $qb->getQuery()->getResult();
			}catch(\Exception $e){}
			return false;
		}
		public function getTCGradoTallerCurricularByCicloMateria($cicloid,$materiapeid){
			try{
				$qb=$this->em->createQueryBuilder();
				$qb->select("cegtc.gradoportallercurricularid AS id,"
						."cetc.tallercurricularid,"
						."cempe.materiaporplanestudioid,"
						."m.materiaid,"
						."n.nivelid,"
						."g.gradoid,"
						."n.nombre AS nivel,"
						."g.grado AS grado,"
						."m.nombre AS materia,"
						."CONCAT(cep.apellidopaterno,' ',cep.apellidomaterno,' ',cep.nombre) AS profesor,"
						."cetc.nombre AS taller,"
						."cetc.cupo,"
						."cetc.orden"
					)->from("AppBundle:CeGradoportallercurricular", "cegtc")
					->innerJoin("AppBundle:CeTallercurricular", "cetc", "WITH", "cetc.tallercurricularid=cegtc.tallercurricularid")
					->innerJoin("AppBundle:CeMateriaporplanestudios", "cempe", "WITH", "cempe.materiaporplanestudioid=cegtc.materiaporplanestudioid")
					->innerJoin("AppBundle:Grado", "g", "WITH", "g.gradoid=cegtc.gradoid")
					->innerJoin("AppBundle:Nivel", "n", "WITH", "n.nivelid=g.nivelid")
					->innerJoin("AppBundle:Materia", "m", "WITH", "m.materiaid=cempe.materiaid")
					->innerJoin("AppBundle:CePlanestudios", "cepe", "WITH", "cepe.planestudioid=cempe.planestudioid AND cepe.gradoid=g.gradoid")
					->leftJoin("AppBundle:CeProfesor", "cep", "WITH", "cep.profesorid=cetc.profesorid")
					->andWhere("cegtc.materiaporplanestudioid=:materiape")
					->andWhere("cetc.cicloid=:ciclo")
					->setParameter("materiape", $materiapeid)
					->setParameter("ciclo", $cicloid)
				;
				return $qb->getQuery()->getResult();
			}catch(\Exception $e){}
			return false;
		}
		public function getTCTallerCurricularUsedById($tallercurricularid){
			try{
				$qb=$this->em->createQueryBuilder();
				$qb->select("IDENTITY(ceact.tallercurricularid) AS id, COUNT(ceact.alumnoporcicloid) AS inscrito")
					->from("AppBundle:CeAlumnocicloportaller", "ceact")
					->andWhere("ceact.tallercurricularid IN (:taller)")
					->andWhere("ceact.vigente=1")
					->setParameter("taller", $tallercurricularid)
					->groupBy("ceact.tallercurricularid")
				;
				return $qb->getQuery()->getResult();
			}catch(\Exception $e){}
			return false;
		}
		public function getTCTallerCurricularById($tallercurricularid){
			try{
				$qb=$this->em->createQueryBuilder();
				$qb->select("cetc.tallercurricularid AS id,"
						."IDENTITY(cetc.cicloid) AS cicloid,"
						."IDENTITY(cetc.clasificadorparaescolaresid) AS clasificadorparaescolaresid,"
						."IDENTITY(cetc.profesorid) AS profesorid,"
						."IDENTITY(cetc.suplenteid) AS suplenteid,"
						."IDENTITY(cetc.cotitularid) AS cotitularid,"
						."IDENTITY(cetc.talleranteriorid) AS talleranteriorid,"
						."cetc.nombre,"
						."cetc.descripcion,"
						."cetc.cupo,"
						."cetc.cupomaxmasculino,"
						."cetc.cupomaxfemenino,"
						."cetc.inscripcionweb,"
						."cetc.orden"
					)->from("AppBundle:CeTallercurricular", "cetc")
					->andWhere("cetc.tallercurricularid=:tallercurricular")
					->setParameter("tallercurricular", $tallercurricularid)
				;
				return $qb->getQuery()->getResult();
			}catch(\Exception $e){}
			return false;
		}
		public function getTCTallerCurricularTargetByTallerId($tallercurricularid){
			try{
				$qb=$this->em->createQueryBuilder();
				$qb->select("cegtc.gradoportallercurricularid AS id,"
						."IDENTITY(g.nivelid) AS nivelid,"
						."IDENTITY(cempe.planestudioid) AS planestudioid,"
						."IDENTITY(cegtc.tallercurricularid) AS tallercurricularid,"
						."IDENTITY(cegtc.idiomanivelid) AS idiomanivelid,"
						."g.gradoid,"
						."cempe.materiaporplanestudioid"
					)->from("AppBundle:CeGradoportallercurricular", "cegtc")
					->innerJoin("AppBundle:Grado", "g", "WITH", "g.gradoid=cegtc.gradoid")
					->innerJoin("AppBundle:CeMateriaporplanestudios", "cempe", "WITH", "cempe.materiaporplanestudioid=cegtc.materiaporplanestudioid")
					->andWhere("cegtc.tallercurricularid=:tallercurricular")
					->setParameter("tallercurricular", $tallercurricularid)
				;
				return $qb->getQuery()->getResult();
			}catch(\Exception $e){}
			return false;
		}
}