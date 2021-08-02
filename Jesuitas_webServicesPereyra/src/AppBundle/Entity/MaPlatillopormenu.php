<?php

namespace AppBundle\Entity;

/**
 * MaPlatillopormenu
 */
class MaPlatillopormenu
{
    /**
     * @var integer
     */
    private $orden;

    /**
     * @var integer
     */
    private $platillopormenuid;

    /**
     * @var \AppBundle\Entity\MaMenu
     */
    private $menuid;

    /**
     * @var \AppBundle\Entity\MaPlatillo
     */
    private $platilloid;


    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return MaPlatillopormenu
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Get platillopormenuid
     *
     * @return integer
     */
    public function getPlatillopormenuid()
    {
        return $this->platillopormenuid;
    }

    /**
     * Set menuid
     *
     * @param \AppBundle\Entity\MaMenu $menuid
     *
     * @return MaPlatillopormenu
     */
    public function setMenuid(\AppBundle\Entity\MaMenu $menuid = null)
    {
        $this->menuid = $menuid;

        return $this;
    }

    /**
     * Get menuid
     *
     * @return \AppBundle\Entity\MaMenu
     */
    public function getMenuid()
    {
        return $this->menuid;
    }

    /**
     * Set platilloid
     *
     * @param \AppBundle\Entity\MaPlatillo $platilloid
     *
     * @return MaPlatillopormenu
     */
    public function setPlatilloid(\AppBundle\Entity\MaPlatillo $platilloid = null)
    {
        $this->platilloid = $platilloid;

        return $this;
    }

    /**
     * Get platilloid
     *
     * @return \AppBundle\Entity\MaPlatillo
     */
    public function getPlatilloid()
    {
        return $this->platilloid;
    }
}

