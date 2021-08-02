<?php

namespace AppBundle\DB\Mysql;

use Doctrine\ORM\Query\Expr;

class Repositorio extends BaseDBManager
{
	//Guarda/Actualiza un registro de una entidad
	public function saveRepositorio($entity)
	{
		try {
			$this->em->persist($entity);
			$this->em->flush();
		} catch (\Exception $e) {
			$this->em->getConnection()->rollBack();
			$this->em->close();
			throw $e;
		}
	}

	//Guarda/Actualiza multiples registros (insercion masiva)
	public function saveBulkRepositorio($entityArray)
	{
		try {
			foreach ($entityArray as $entity) {
				$this->em->persist($entity);
			}
			$this->em->flush();
			$this->em->clear();
		} catch (\Exception $e) {
			$this->em->getConnection()->rollBack();
			$this->em->close();
			throw $e;
		}
	}

	public function mergeRepositorio($entity)
	{
		try {
			$this->em->merge($entity);
			$this->em->flush();
		} catch (\Exception $e) {
			$this->em->getConnection()->rollBack();
			$this->em->close();
			throw $e;
		}
	}
	//Elimina un registro de una entidad
	public function removeRepositorio($entity)
	{
		try {
			$this->em->remove($entity);
			$this->em->flush();
		} catch (\Exception $e) {
			$this->em->getConnection()->rollBack();
			$this->em->close();
			throw $e;
		}
	}
	//Elimina varios registros de una entidad buscando por un campo.
	public function removeManyRepositorio($entity, $idText, $id)
	{
		try {
			$qb = $this->em->createQueryBuilder()
				->delete('AppBundle:' . $entity, 'e')
				->where('e.' . $idText . ' = :condicion')
				->setParameter('condicion', $id);
			$qb->getQuery()->execute();
		} catch (\Exception $e) {
			$this->em->getConnection()->rollBack();
			$this->em->close();
			throw $e;
		}
	}

	public function removeBulkRepositorio($entityArray)
	{
		try {
			foreach ($entityArray as $entity) {
				$this->em->remove($entity);
			}
			$this->em->flush();
		} catch (\Exception $e) {
			$this->em->getConnection()->rollBack();
			$this->em->close();
			throw $e;
		}
	}


	//Busca todos los registros de una entidad
	public function getRepositorios($entity)
	{
		$repositorios = $this->em->getRepository("AppBundle:" . $entity)->findAll();
		return $repositorios;
	}
	//Busca un registro de una entidad buscando por un campo
	public function getRepositorioById($entity, $idText, $id, $order)
	{
		return $this->em->getRepository("AppBundle:" . $entity)->findOneBy(
			array($idText => $id),
			array($order ? $order : $idText => 'ASC')
		);
	}
	//Busca varios registros de una entidad buscando por un campo
	public function getRepositoriosById($entity, $idText, $id, $order)
	{
		return $this->em->getRepository("AppBundle:" . $entity)->findBy(
			array($idText => $id),
			array($order ? $order : $idText => 'ASC')
		);
	}
	//Busca un registro de una entidad buscando por varios campos
	public function getOneByParametersRepositorio($entity, $filtros, $order)
	{
		$repositorios = $this->em->getRepository("AppBundle:" . $entity)->findOneBy(
			$filtros,
			$order
		);
		return $repositorios;
	}
	//Busca varios registros de una entidad buscando por varios campos
	public function getByParametersRepositorios($entity, $filtros)
	{
		$repositorios = $this->em->getRepository("AppBundle:" . $entity)->findBy($filtros);
		return $repositorios;
	}
	//Genera una consulta dinamica (limitar a maximo 3 joins)
	public function getDBRepositoriosModelo($entity, $fields, $find = false, $orderby = false, $advancedfind = false, $joins = false, $group = false)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select($fields)->from("AppBundle:$entity", "d");
			if ($find && is_array($find)) {
				if (!$advancedfind) {
					$findt = [];
					foreach ($find as $k => $i) {
						$findt[] = [$k, [$i === NULL ? "IS NULL" : ((is_array($i) ? "IN" : "=")), $i]];
					}
					$find = $findt;
				}

				$c = 0;
				foreach ($find as $ifindraw) {
					list($k, $ifind) = $ifindraw;
					list($operator, $value) = $ifind;
					$kn = "key_$k$c";
					if ($value === NULL) {
						$qb->andWhere("d.$k $operator");
					} else {
						$qb->andWhere("d.$k $operator " . (is_array($value) ? "(:$kn)" : ":$kn"))
							->setParameter($kn, $value);
					}
					$c++;
				}
			}
			if ($joins && is_array($joins)) {
				foreach ($joins as $j) {
					$fn = (isset($j["left"]) && $j["left"] ? "leftJoin" : "innerJoin");
					$qb->$fn("AppBundle:" . $j["entidad"], $j["alias"], Expr\Join::WITH, $j["on"]);
				}
			}
			if ($orderby) {
				foreach ($orderby as $k => $i) {
					$qb->addOrderBy("d." . $k, $i);
				}
			}
			if ($group) {
				$qb->groupBy($group);
			}
			$a = $qb->getQuery()->getDql();
			$data = $qb->getQuery()->getResult();
			return $data;
		} catch (\Exception $e) {
			echo ">> Repositorio->getRepositoriosModelo: " . $e->getMessage() . "\n";
		}
		return false;
	}
}
