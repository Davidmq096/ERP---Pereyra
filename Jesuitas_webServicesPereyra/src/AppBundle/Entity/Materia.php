<?php

namespace AppBundle\Entity;

/**
 * Materia
 */
class Materia
{
    /**
     * @var string
     */
    private $clave;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $nombreingles;

    /**
     * @var string
     */
    private $nombrecortoingles;

    /**
     * @var string
     */
    private $nombreexterno;

    /**
     * @var integer
     */
    private $essubmateria;

    /**
     * @var string
     */
    private $colorsubmaterias;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $materiaid;

    /**
     * @var \AppBundle\Entity\CeAreaacademica
     */
    private $areaacademicaid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiapadreid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\CeClasificadorparaescolares
     */
    private $clasificadorparaescolaresid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiapredecesoraid;


    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return Materia
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Materia
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return Materia
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set nombreingles
     *
     * @param string $nombreingles
     *
     * @return Materia
     */
    public function setNombreingles($nombreingles)
    {
        $this->nombreingles = $nombreingles;

        return $this;
    }

    /**
     * Get nombreingles
     *
     * @return string
     */
    public function getNombreingles()
    {
        return $this->nombreingles;
    }

    /**
     * Set nombrecortoingles
     *
     * @param string $nombrecortoingles
     *
     * @return Materia
     */
    public function setNombrecortoingles($nombrecortoingles)
    {
        $this->nombrecortoingles = $nombrecortoingles;

        return $this;
    }

    /**
     * Get nombrecortoingles
     *
     * @return string
     */
    public function getNombrecortoingles()
    {
        return $this->nombrecortoingles;
    }

    /**
     * Set nombreexterno
     *
     * @param string $nombreexterno
     *
     * @return Materia
     */
    public function setNombreexterno($nombreexterno)
    {
        $this->nombreexterno = $nombreexterno;

        return $this;
    }

    /**
     * Get nombreexterno
     *
     * @return string
     */
    public function getNombreexterno()
    {
        return $this->nombreexterno;
    }

    /**
     * Set essubmateria
     *
     * @param integer $essubmateria
     *
     * @return Materia
     */
    public function setEssubmateria($essubmateria)
    {
        $this->essubmateria = $essubmateria;

        return $this;
    }

    /**
     * Get essubmateria
     *
     * @return integer
     */
    public function getEssubmateria()
    {
        return $this->essubmateria;
    }

    /**
     * Set colorsubmaterias
     *
     * @param string $colorsubmaterias
     *
     * @return Materia
     */
    public function setColorsubmaterias($colorsubmaterias)
    {
        $this->colorsubmaterias = $colorsubmaterias;

        return $this;
    }

    /**
     * Get colorsubmaterias
     *
     * @return string
     */
    public function getColorsubmaterias()
    {
        return $this->colorsubmaterias;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Materia
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get materiaid
     *
     * @return integer
     */
    public function getMateriaid()
    {
        return $this->materiaid;
    }

    /**
     * Set areaacademicaid
     *
     * @param \AppBundle\Entity\CeAreaacademica $areaacademicaid
     *
     * @return Materia
     */
    public function setAreaacademicaid(\AppBundle\Entity\CeAreaacademica $areaacademicaid = null)
    {
        $this->areaacademicaid = $areaacademicaid;

        return $this;
    }

    /**
     * Get areaacademicaid
     *
     * @return \AppBundle\Entity\CeAreaacademica
     */
    public function getAreaacademicaid()
    {
        return $this->areaacademicaid;
    }

    /**
     * Set materiapadreid
     *
     * @param \AppBundle\Entity\Materia $materiapadreid
     *
     * @return Materia
     */
    public function setMateriapadreid(\AppBundle\Entity\Materia $materiapadreid = null)
    {
        $this->materiapadreid = $materiapadreid;

        return $this;
    }

    /**
     * Get materiapadreid
     *
     * @return \AppBundle\Entity\Materia
     */
    public function getMateriapadreid()
    {
        return $this->materiapadreid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return Materia
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }

    /**
     * Set clasificadorparaescolaresid
     *
     * @param \AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolaresid
     *
     * @return Materia
     */
    public function setClasificadorparaescolaresid(\AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolaresid = null)
    {
        $this->clasificadorparaescolaresid = $clasificadorparaescolaresid;

        return $this;
    }

    /**
     * Get clasificadorparaescolaresid
     *
     * @return \AppBundle\Entity\CeClasificadorparaescolares
     */
    public function getClasificadorparaescolaresid()
    {
        return $this->clasificadorparaescolaresid;
    }

    /**
     * Set materiapredecesoraid
     *
     * @param \AppBundle\Entity\Materia $materiapredecesoraid
     *
     * @return Materia
     */
    public function setMateriapredecesoraid(\AppBundle\Entity\Materia $materiapredecesoraid = null)
    {
        $this->materiapredecesoraid = $materiapredecesoraid;

        return $this;
    }

    /**
     * Get materiapredecesoraid
     *
     * @return \AppBundle\Entity\Materia
     */
    public function getMateriapredecesoraid()
    {
        return $this->materiapredecesoraid;
    }
}

