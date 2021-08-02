<?php

namespace AppBundle\Entity;

/**
 * CjSubconceptogrado
 */
class CjSubconceptogrado
{
    /**
     * @var integer
     */
    private $subconceptogradoid;

    /**
     * @var \AppBundle\Entity\CjDocumentosubconceptos
     */
    private $documentosubconceptosid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get subconceptogradoid
     *
     * @return integer
     */
    public function getSubconceptogradoid()
    {
        return $this->subconceptogradoid;
    }

    /**
     * Set documentosubconceptosid
     *
     * @param \AppBundle\Entity\CjDocumentosubconceptos $documentosubconceptosid
     *
     * @return CjSubconceptogrado
     */
    public function setDocumentosubconceptosid(\AppBundle\Entity\CjDocumentosubconceptos $documentosubconceptosid = null)
    {
        $this->documentosubconceptosid = $documentosubconceptosid;

        return $this;
    }

    /**
     * Get documentosubconceptosid
     *
     * @return \AppBundle\Entity\CjDocumentosubconceptos
     */
    public function getDocumentosubconceptosid()
    {
        return $this->documentosubconceptosid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CjSubconceptogrado
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

