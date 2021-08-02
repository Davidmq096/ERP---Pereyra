<?php

namespace AppBundle\Entity;

/**
 * CePersonaautorizadarecoger
 */
class CePersonaautorizadarecoger
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $personaautorizadarecogerid;

    /**
     * @var \AppBundle\Entity\Parentesco
     */
    private $parentescoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CePersonaautorizadarecoger
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
     * Get personaautorizadarecogerid
     *
     * @return integer
     */
    public function getPersonaautorizadarecogerid()
    {
        return $this->personaautorizadarecogerid;
    }

    /**
     * Set parentescoid
     *
     * @param \AppBundle\Entity\Parentesco $parentescoid
     *
     * @return CePersonaautorizadarecoger
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

