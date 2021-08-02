<?php

namespace AppBundle\Entity;

/**
 * CeMaterialporalumnocicloportallerextracurricular
 */
class CeMaterialporalumnocicloportallerextracurricular
{
    /**
     * @var string
     */
    private $talla;

    /**
     * @var \DateTime
     */
    private $fechaentrega = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     */
    private $materialporalumnocicloportallerextracurricularid;

    /**
     * @var \AppBundle\Entity\CeMaterialportallerextracurricular
     */
    private $materialportallerextracurricularid;

    /**
     * @var \AppBundle\Entity\CeAlumnocicloportallerextra
     */
    private $alumnocicloportallerextraid;


    /**
     * Set talla
     *
     * @param string $talla
     *
     * @return CeMaterialporalumnocicloportallerextracurricular
     */
    public function setTalla($talla)
    {
        $this->talla = $talla;

        return $this;
    }

    /**
     * Get talla
     *
     * @return string
     */
    public function getTalla()
    {
        return $this->talla;
    }

    /**
     * Set fechaentrega
     *
     * @param \DateTime $fechaentrega
     *
     * @return CeMaterialporalumnocicloportallerextracurricular
     */
    public function setFechaentrega($fechaentrega)
    {
        $this->fechaentrega = $fechaentrega;

        return $this;
    }

    /**
     * Get fechaentrega
     *
     * @return \DateTime
     */
    public function getFechaentrega()
    {
        return $this->fechaentrega;
    }

    /**
     * Get materialporalumnocicloportallerextracurricularid
     *
     * @return integer
     */
    public function getMaterialporalumnocicloportallerextracurricularid()
    {
        return $this->materialporalumnocicloportallerextracurricularid;
    }

    /**
     * Set materialportallerextracurricularid
     *
     * @param \AppBundle\Entity\CeMaterialportallerextracurricular $materialportallerextracurricularid
     *
     * @return CeMaterialporalumnocicloportallerextracurricular
     */
    public function setMaterialportallerextracurricularid(\AppBundle\Entity\CeMaterialportallerextracurricular $materialportallerextracurricularid = null)
    {
        $this->materialportallerextracurricularid = $materialportallerextracurricularid;

        return $this;
    }

    /**
     * Get materialportallerextracurricularid
     *
     * @return \AppBundle\Entity\CeMaterialportallerextracurricular
     */
    public function getMaterialportallerextracurricularid()
    {
        return $this->materialportallerextracurricularid;
    }

    /**
     * Set alumnocicloportallerextraid
     *
     * @param \AppBundle\Entity\CeAlumnocicloportallerextra $alumnocicloportallerextraid
     *
     * @return CeMaterialporalumnocicloportallerextracurricular
     */
    public function setAlumnocicloportallerextraid(\AppBundle\Entity\CeAlumnocicloportallerextra $alumnocicloportallerextraid = null)
    {
        $this->alumnocicloportallerextraid = $alumnocicloportallerextraid;

        return $this;
    }

    /**
     * Get alumnocicloportallerextraid
     *
     * @return \AppBundle\Entity\CeAlumnocicloportallerextra
     */
    public function getAlumnocicloportallerextraid()
    {
        return $this->alumnocicloportallerextraid;
    }
}

