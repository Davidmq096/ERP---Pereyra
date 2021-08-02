<?php

namespace AppBundle\Entity;

/**
 * RiGradopordocumento
 */
class RiGradopordocumento
{
    /**
     * @var integer
     */
    private $gradopordocumento;

    /**
     * @var \AppBundle\Entity\RiDocumento
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get gradopordocumento
     *
     * @return integer
     */
    public function getGradopordocumento()
    {
        return $this->gradopordocumento;
    }

    /**
     * Set documentoid
     *
     * @param \AppBundle\Entity\RiDocumento $documentoid
     *
     * @return RiGradopordocumento
     */
    public function setDocumentoid(\AppBundle\Entity\RiDocumento $documentoid = null)
    {
        $this->documentoid = $documentoid;

        return $this;
    }

    /**
     * Get documentoid
     *
     * @return \AppBundle\Entity\RiDocumento
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return RiGradopordocumento
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

