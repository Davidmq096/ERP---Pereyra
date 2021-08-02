<?php

namespace AppBundle\Entity;

/**
 * Imagenporusurio
 */
class Imagenporusurio
{
    /**
     * @var string
     */
    private $fotografia;

    /**
     * @var integer
     */
    private $imagenporusuarioid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fotografia
     *
     * @param string $fotografia
     *
     * @return Imagenporusurio
     */
    public function setFotografia($fotografia)
    {
        $this->fotografia = $fotografia;

        return $this;
    }

    /**
     * Get fotografia
     *
     * @return string
     */
    public function getFotografia()
    {
        return $this->fotografia;
    }

    /**
     * Get imagenporusuarioid
     *
     * @return integer
     */
    public function getImagenporusuarioid()
    {
        return $this->imagenporusuarioid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return Imagenporusurio
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

