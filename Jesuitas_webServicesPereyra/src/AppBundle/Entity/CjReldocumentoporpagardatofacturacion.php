<?php

namespace AppBundle\Entity;

/**
 * CjReldocumentoporpagardatofacturacion
 */
class CjReldocumentoporpagardatofacturacion
{
    /**
     * @var integer
     */
    private $padresotutoresfacturacionid;

    /**
     * @var integer
     */
    private $reldocumentoporpagardatofacturacionid;

    /**
     * @var \AppBundle\Entity\CjDocumentoporpagar
     */
    private $documentoporpagarid;


    /**
     * Set padresotutoresfacturacionid
     *
     * @param integer $padresotutoresfacturacionid
     *
     * @return CjReldocumentoporpagardatofacturacion
     */
    public function setPadresotutoresfacturacionid($padresotutoresfacturacionid)
    {
        $this->padresotutoresfacturacionid = $padresotutoresfacturacionid;

        return $this;
    }

    /**
     * Get padresotutoresfacturacionid
     *
     * @return integer
     */
    public function getPadresotutoresfacturacionid()
    {
        return $this->padresotutoresfacturacionid;
    }

    /**
     * Get reldocumentoporpagardatofacturacionid
     *
     * @return integer
     */
    public function getReldocumentoporpagardatofacturacionid()
    {
        return $this->reldocumentoporpagardatofacturacionid;
    }

    /**
     * Set documentoporpagarid
     *
     * @param \AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid
     *
     * @return CjReldocumentoporpagardatofacturacion
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
}

