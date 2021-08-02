<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author Emmanuel Martinez
 */
class IdiomaNivelDB extends BaseDBManager {
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