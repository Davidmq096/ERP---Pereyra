<?php

namespace AppBundle\Entity;

/**
 * CeTalleropcionregistro
 */
class CeTalleropcionregistro
{
    /**
     * @var integer
     */
    private $notalleres;

    /**
     * @var boolean
     */
    private $prioridad;

    /**
     * @var integer
     */
    private $talleropcionregistroid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set notalleres
     *
     * @param integer $notalleres
     *
     * @return CeTalleropcionregistro
     */
    public function setNotalleres($notalleres)
    {
        $this->notalleres = $notalleres;

        return $this;
    }

    /**
     * Get notalleres
     *
     * @return integer
     */
    public function getNotalleres()
    {
        return $this->notalleres;
    }

    /**
     * Set prioridad
     *
     * @param boolean $prioridad
     *
     * @return CeTalleropcionregistro
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return boolean
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Get talleropcionregistroid
     *
     * @return integer
     */
    public function getTalleropcionregistroid()
    {
        return $this->talleropcionregistroid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeTalleropcionregistro
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }
}

