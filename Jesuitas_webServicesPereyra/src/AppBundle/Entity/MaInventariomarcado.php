<?php

namespace AppBundle\Entity;

/**
 * MaInventariomarcado
 */
class MaInventariomarcado
{
    /**
     * @var boolean
     */
    private $hecho;

    /**
     * @var boolean
     */
    private $archivado;

    /**
     * @var integer
     */
    private $inventariomarcadoid;

    /**
     * @var \AppBundle\Entity\MaInforme
     */
    private $informeid;

    /**
     * @var \AppBundle\Entity\MaInventario
     */
    private $inventarioid;


    /**
     * Set hecho
     *
     * @param boolean $hecho
     *
     * @return MaInventariomarcado
     */
    public function setHecho($hecho)
    {
        $this->hecho = $hecho;

        return $this;
    }

    /**
     * Get hecho
     *
     * @return boolean
     */
    public function getHecho()
    {
        return $this->hecho;
    }

    /**
     * Set archivado
     *
     * @param boolean $archivado
     *
     * @return MaInventariomarcado
     */
    public function setArchivado($archivado)
    {
        $this->archivado = $archivado;

        return $this;
    }

    /**
     * Get archivado
     *
     * @return boolean
     */
    public function getArchivado()
    {
        return $this->archivado;
    }

    /**
     * Get inventariomarcadoid
     *
     * @return integer
     */
    public function getInventariomarcadoid()
    {
        return $this->inventariomarcadoid;
    }

    /**
     * Set informeid
     *
     * @param \AppBundle\Entity\MaInforme $informeid
     *
     * @return MaInventariomarcado
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
     * @return MaInventariomarcado
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

