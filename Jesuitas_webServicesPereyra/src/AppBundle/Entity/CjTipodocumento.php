<?php

namespace AppBundle\Entity;

/**
 * CjTipodocumento
 */
class CjTipodocumento
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $serie;

    /**
     * @var integer
     */
    private $tipodocumentoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjTipodocumento
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
     * Set serie
     *
     * @param string $serie
     *
     * @return CjTipodocumento
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Get tipodocumentoid
     *
     * @return integer
     */
    public function getTipodocumentoid()
    {
        return $this->tipodocumentoid;
    }
}

