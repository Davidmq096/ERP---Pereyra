<?php

namespace AppBundle\Entity;

/**
 * LuContratopormes
 */
class LuContratopormes
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $contratopormesid;

    /**
     * @var \AppBundle\Entity\LuContrato
     */
    private $contratoid;

    /**
     * @var \AppBundle\Entity\CjDocumentoporpagar
     */
    private $documentoporpagarid;

    /**
     * @var \AppBundle\Entity\LuContratoestatuspago
     */
    private $contratoestatuspagoid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return LuContratopormes
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Get contratopormesid
     *
     * @return integer
     */
    public function getContratopormesid()
    {
        return $this->contratopormesid;
    }

    /**
     * Set contratoid
     *
     * @param \AppBundle\Entity\LuContrato $contratoid
     *
     * @return LuContratopormes
     */
    public function setContratoid(\AppBundle\Entity\LuContrato $contratoid = null)
    {
        $this->contratoid = $contratoid;

        return $this;
    }

    /**
     * Get contratoid
     *
     * @return \AppBundle\Entity\LuContrato
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }

    /**
     * Set documentoporpagarid
     *
     * @param \AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid
     *
     * @return LuContratopormes
     */
    public function setDocumentoporpagarid(\AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid = null)
    {
        $this->documentoporpagarid = $documentoporpagarid;

        return $this;
    }

    /**
     * Get documentoporpagarid
     *
     * @return \AppBundle\Entity\CjDocumentoporpagar
     */
    public function getDocumentoporpagarid()
    {
        return $this->documentoporpagarid;
    }

    /**
     * Set contratoestatuspagoid
     *
     * @param \AppBundle\Entity\LuContratoestatuspago $contratoestatuspagoid
     *
     * @return LuContratopormes
     */
    public function setContratoestatuspagoid(\AppBundle\Entity\LuContratoestatuspago $contratoestatuspagoid = null)
    {
        $this->contratoestatuspagoid = $contratoestatuspagoid;

        return $this;
    }

    /**
     * Get contratoestatuspagoid
     *
     * @return \AppBundle\Entity\LuContratoestatuspago
     */
    public function getContratoestatuspagoid()
    {
        return $this->contratoestatuspagoid;
    }
}

