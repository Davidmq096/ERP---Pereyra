<?php

namespace AppBundle\Entity;

/**
 * CeContactoemergencia
 */
class CeContactoemergencia
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $contactoemergenciaid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Parentesco
     */
    private $parentescoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeContactoemergencia
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return CeContactoemergencia
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return CeContactoemergencia
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get contactoemergenciaid
     *
     * @return integer
     */
    public function getContactoemergenciaid()
    {
        return $this->contactoemergenciaid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeContactoemergencia
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set parentescoid
     *
     * @param \AppBundle\Entity\Parentesco $parentescoid
     *
     * @return CeContactoemergencia
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

