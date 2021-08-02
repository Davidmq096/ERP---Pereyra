<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author Emmanuel Martinez
 */
class AlumnoIdiomaNivelImportarDB extends BaseDBManager {
	public function getImportadosByAlumnociclo($alumnocicloids){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("ceacin.alumnocicloporidiomanivelid AS id,"
					. "c.nombre AS ciclo,"
					. "n.nombre As nivel,"
					. "g.grado AS grado,"
					. "ceg.nombre AS grupo,"
					. "cei.nombre AS idioma,"
					. "cein.nombre AS idiomanivel,"
					. "cein.clave AS idiomanivelclave,"
					. "cea.matricula,"
					. "cea.apellidopaterno AS apaterno,"
					. "cea.apellidomaterno AS amaterno,"
					. "cea.primernombre AS nombre"
				)->from("AppBundle:CeAlumnocicloporidiomanivel","ceacin")
				->innerJoin("AppBundle:CeAlumnoporciclo","ceac","WITH","ceac.alumnoporcicloid=ceacin.alumnoporcicloid")
				->innerJoin("AppBundle:CeAlumno","cea","WITH","cea.alumnoid=ceac.alumnoid")
				->innerJoin("AppBundle:Ciclo","c","WITH","c.cicloid=ceac.cicloid")
				->innerJoin("AppBundle:Grado","g","WITH","g.gradoid=ceac.gradoid")
				->innerJoin("AppBundle:Nivel","n","WITH","n.nivelid=g.nivelid")
				->leftJoin("AppBundle:CeAlumnocicloporgrupo","ceacg","WITH","ceacg.alumnoporcicloid=ceac.alumnoporcicloid")
				->leftJoin("AppBundle:CeGrupo","ceg","WITH","ceg.grupoid=ceacg.grupoid")
				->leftJoin("AppBundle:CeIdiomanivel","cein","WITH","cein.idiomanivelid=ceacin.idiomanivelid")
				->leftJoin("AppBundle:CeIdioma","cei","WITH","cei.idiomaid=cein.idiomaid")
				->andWhere("ceacin.alumnoporcicloid IN(:alumnos)")
				->setParameter("alumnos",$alumnocicloids)
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
	public function getIdiomanivelByClave($claves){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cein.idiomanivelid")
				->from("AppBundle:CeIdiomanivel","cein")
				->andWhere("cein.activo=1")
				->andWhere("cein.clave IN(:claves)")
				->setParameter("claves",$claves)
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
}