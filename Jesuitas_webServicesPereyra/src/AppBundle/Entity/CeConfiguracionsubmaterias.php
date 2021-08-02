<?php

namespace AppBundle\Entity;

/**
 * CeConfiguracionsubmaterias
 */
class CeConfiguracionsubmaterias
{
    /**
     * @var integer
     */
    private $porcentajecalificacion;

    /**
     * @var integer
     */
    private $configuracionsubmateriasid;

    /**
     * @var \AppBundle\Entity\CeFormaconfiguracionsubmateria
     */
    private $formaconfiguracionsubmateriaid;

    /**
     * @var \AppBundle\Entity\Materia
     */
    private $materiaid;


    /**
     * Set porcentajecalificacion
     *
     * @param integer $porcentajecalificacion
     *
     * @return CeConfiguracionsubmaterias
     */
    public function setPorcentajecalificacion($porcentajecalificacion)
    {
        $this->porcentajecalificacion = $porcentajecalificacion;

        return $this;
    }

    /**
     * Get porcentajecalificacion
     *
     * @return integer
     */
    public function getPorcentajecalificacion()
    {
        return $this->porcentajecalificacion;
    }

    /**
     * Get configuracionsubmateriasid
     *
     * @return integer
     */
    public function getConfiguracionsubmateriasid()
    {
        return $this->configuracionsubmateriasid;
    }

    /**
     * Set formaconfiguracionsubmateriaid
     *
     * @param \AppBundle\Entity\CeFormaconfiguracionsubmateria $formaconfiguracionsubmateriaid
     *
     * @return CeConfiguracionsubmaterias
     */
    public function setFormaconfiguracionsubmateriaid(\AppBundle\Entity\CeFormaconfiguracionsubmateria $formaconfiguracionsubmateriaid = null)
    {
        $this->formaconfiguracionsubmateriaid = $formaconfiguracionsubmateriaid;

        return $this;
    }

    /**
     * Get formaconfiguracionsubmateriaid
     *
     * @return \AppBundle\Entity\CeFormaconfiguracionsubmateria
     */
    public function getFormaconfiguracionsubmateriaid()
    {
        return $this->formaconfiguracionsubmateriaid;
    }

    /**
     * Set materiaid
     *
     * @param \AppBundle\Entity\Materia $materiaid
     *
     * @return CeConfiguracionsubmaterias
     */
    public function setMateriaid(\AppBundle\Entity\Materia $materiaid = null)
    {
        $this->materiaid = $materiaid;

        return $this;
    }

    /**
     * Get materiaid
     *
     * @return \AppBundle\Entity\Materia
     */
    public function getMateriaid()
    {
        return $this->materiaid;
    }
}

