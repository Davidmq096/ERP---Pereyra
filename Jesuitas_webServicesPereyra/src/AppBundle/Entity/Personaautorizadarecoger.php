<?php

namespace AppBundle\Entity;

/**
 * Personaautorizadarecoger
 */
class Personaautorizadarecoger
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $personaautorizadarecoger;

    /**
     * @var \AppBundle\Entity\Datoaspirante
     */
    private $datoaspiranteid;

    /**
     * @var \AppBundle\Entity\Parentesco
     */
    private $parentescoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Personaautorizadarecoger
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
     * Get personaautorizadarecoger
     *
     * @return integer
     */
    public function getPersonaautorizadarecoger()
    {
        return $this->personaautorizadarecoger;
    }

    /**
     * Set datoaspiranteid
     *
     * @param \AppBundle\Entity\Datoaspirante $datoaspiranteid
     *
     * @return Personaautorizadarecoger
     */
    public function setDatoaspiranteid(\AppBundle\Entity\Datoaspirante $datoaspiranteid = null)
    {
        $this->datoaspiranteid = $datoaspiranteid;

        return $this;
    }

    /**
     * Get datoaspiranteid
     *
     * @return \AppBundle\Entity\Datoaspirante
     */
    public function getDatoaspiranteid()
    {
        return $this->datoaspiranteid;
    }

    /**
     * Set parentescoid
     *
     * @param \AppBundle\Entity\Parentesco $parentescoid
     *
     * @return Personaautorizadarecoger
     */
    public function setParentescoid(\AppBundle\Entity\Parentesco $parentescoid = null)
    {
        $this->parentescoid = $parentescoid;

        return $this;
    }

    /**
     * Get parentescoid
     *
     * @return \AppBundle\Entity\Parentesco
     */
    public function getParentescoid()
    {
        return $this->parentescoid;
    }
}

