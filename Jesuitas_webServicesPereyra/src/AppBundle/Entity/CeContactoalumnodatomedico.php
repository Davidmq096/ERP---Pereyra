<?php

namespace AppBundle\Entity;

/**
 * CeContactoalumnodatomedico
 */
class CeContactoalumnodatomedico
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
     * @var integer
     */
    private $contactoemergenciaparentesco;

    /**
     * @var string
     */
    private $contactoemergenciaemail;

    /**
     * @var integer
     */
    private $alumnodatomedicoid;

    /**
     * @var integer
     */
    private $contactoalumnodatomedicoid;


    /**
     * Set contactoemergencianombre
     *
     * @param string $contactoemergencianombre
     *
     * @return CeContactoalumnodatomedico
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
     * @return CeContactoalumnodatomedico
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
     * Set contactoemergenciaparentesco
     *
     * @param integer $contactoemergenciaparentesco
     *
     * @return CeContactoalumnodatomedico
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
     * Set contactoemergenciaemail
     *
     * @param string $contactoemergenciaemail
     *
     * @return CeContactoalumnodatomedico
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
     * Set alumnodatomedicoid
     *
     * @param integer $alumnodatomedicoid
     *
     * @return CeContactoalumnodatomedico
     */
    public function setAlumnodatomedicoid($alumnodatomedicoid)
    {
        $this->alumnodatomedicoid = $alumnodatomedicoid;

        return $this;
    }

    /**
     * Get alumnodatomedicoid
     *
     * @return integer
     */
    public function getAlumnodatomedicoid()
    {
        return $this->alumnodatomedicoid;
    }

    /**
     * Get contactoalumnodatomedicoid
     *
     * @return integer
     */
    public function getContactoalumnodatomedicoid()
    {
        return $this->contactoalumnodatomedicoid;
    }
}

