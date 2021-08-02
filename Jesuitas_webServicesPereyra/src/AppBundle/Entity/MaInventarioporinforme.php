<?php

namespace AppBundle\Entity;

/**
 * MaInventarioporinforme
 */
class MaInventarioporinforme
{
    /**
     * @var integer
     */
    private $cantidad;

    /**
     * @var integer
     */
    private $inventarioporinformeid;

    /**
     * @var \AppBundle\Entity\MaInforme
     */
    private $informeid;

    /**
     * @var \AppBundle\Entity\MaInventario
     */
    private $inventarioid;


    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return MaInventarioporinforme
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Get inventarioporinformeid
     *
     * @return integer
     */
    public function getInventarioporinformeid()
    {
        return $this->inventarioporinformeid;
    }

    /**
     * Set informeid
     *
     * @param \AppBundle\Entity\MaInforme $informeid
     *
     * @return MaInventarioporinforme
     */
    public function setInformeid(\AppBundle\Entity\MaInforme $informeid = null)
    {
        $this->informeid = $informeid;

        return $this;
    }

    /**
     * Get informeid
     *
     * @return \AppBundle\Entity\MaInforme
     */
    public function getInformeid()
    {
        return $this->informeid;
    }

    /**
     * Set inventarioid
     *
     * @param \AppBundle\Entity\MaInventario $inventarioid
     *
     * @return MaInventarioporinforme
     */
    public function setInventarioid(\AppBundle\Entity\MaInventario $inventarioid = null)
    {
        $this->inventarioid = $inventarioid;

        return $this;
    }

    /**
     * Get inventarioid
     *
     * @return \AppBundle\Entity\MaInventario
     */
    public function getInventarioid()
    {
        return $this->inventarioid;
    }
}

