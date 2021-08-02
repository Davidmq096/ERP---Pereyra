<?php

namespace AppBundle\Entity;

/**
 * AdContactodatomedico
 */
class AdContactodatomedico
{
    /**
     * @var string
     */
    private $contactoemergencianombre;

    /**
     * @var string
     */
    private $contactoemergenciatelefono;

    /**
     * @var string
     */
    private $contactoemergenciaemail;

    /**
     * @var integer
     */
    private $contactoemergenciaparentesco;

    /**
     * @var integer
     */
    private $contactodatomedicoid;

    /**
     * @var \AppBundle\Entity\Datomedico
     */
    private $datomedicoid;


    /**
     * Set contactoemergencianombre
     *
     * @param string $contactoemergencianombre
     *
     * @return AdContactodatomedico
     */
    public function setContactoemergencianombre($contactoemergencianombre)
    {
        $this->contactoemergencianombre = $contactoemergencianombre;

        return $this;
    }

    /**
     * Get contactoemergencianombre
     *
     * @return string
     */
    public function getContactoemergencianombre()
    {
        return $this->contactoemergencianombre;
    }

    /**
     * Set contactoemergenciatelefono
     *
     * @param string $contactoemergenciatelefono
     *
     * @return AdContactodatomedico
     */
    public function setContactoemergenciatelefono($contactoemergenciatelefono)
    {
        $this->contactoemergenciatelefono = $contactoemergenciatelefono;

        return $this;
    }

    /**
     * Get contactoemergenciatelefono
     *
     * @return string
     */
    public function getContactoemergenciatelefono()
    {
        return $this->contactoemergenciatelefono;
    }

    /**
     * Set contactoemergenciaemail
     *
     * @param string $contactoemergenciaemail
     *
     * @return AdContactodatomedico
     */
    public function setContactoemergenciaemail($contactoemergenciaemail)
    {
        $this->contactoemergenciaemail = $contactoemergenciaemail;

        return $this;
    }

    /**
     * Get contactoemergenciaemail
     *
     * @return string
     */
    public function getContactoemergenciaemail()
    {
        return $this->contactoemergenciaemail;
    }

    /**
     * Set contactoemergenciaparentesco
     *
     * @param integer $contactoemergenciaparentesco
     *
     * @return AdContactodatomedico
     */
    public function setContactoemergenciaparentesco($contactoemergenciaparentesco)
    {
        $this->contactoemergenciaparentesco = $contactoemergenciaparentesco;

        return $this;
    }

    /**
     * Get contactoemergenciaparentesco
     *
     * @return integer
     */
    public function getContactoemergenciaparentesco()
    {
        return $this->contactoemergenciaparentesco;
    }

    /**
     * Get contactodatomedicoid
     *
     * @return integer
     */
    public function getContactodatomedicoid()
    {
        return $this->contactodatomedicoid;
    }

    /**
     * Set datomedicoid
     *
     * @param \AppBundle\Entity\Datomedico $datomedicoid
     *
     * @return AdContactodatomedico
     */
    public function setDatomedicoid(\AppBundle\Entity\Datomedico $datomedicoid = null)
    {
        $this->datomedicoid = $datomedicoid;

        return $this;
    }

    /**
     * Get datomedicoid
     *
     * @return \AppBundle\Entity\Datomedico
     */
    public function getDatomedicoid()
    {
        return $this->datomedicoid;
    }
}

