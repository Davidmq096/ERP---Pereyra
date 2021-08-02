<?php
namespace AppBundle\DB\Mysql;
use Doctrine\ORM\EntityManager as EM;

/**
 * Gestor para acceder a dataBaseManager 
 * @author inceptio
 */
class BaseDBManager {
    protected $em;
    public function __construct(EM $em){ $this->em=$em; }
    public function getEm(){ return $this->em; }
    public function setEm($em){ $this->em=$em; }
}