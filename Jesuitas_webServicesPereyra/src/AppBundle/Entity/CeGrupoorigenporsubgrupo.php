<?php

namespace AppBundle\Entity;

/**
 * CeGrupoorigenporsubgrupo
 */
class CeGrupoorigenporsubgrupo
{
    /**
     * @var integer
     */
    private $grupoorigenporsubgrupoid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;

    /**
     * @var \AppBundle\Entity\CeGrupo
     */
    private $grupoid;

    /**
     * @var \AppBundle\Entity\CeGrupo
     */
    private $grupoorigenid;


    /**
     * Get grupoorigenporsubgrupoid
     *
     * @return integer
     */
    public function getGrupoorigenporsubgrupoid()
    {
        return $this->grupoorigenporsubgrupoid;
    }

    /**
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeGrupoorigenporsubgrupo
     */
    public function setMateriaporplanestudioid(\AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid = null)
    {
        $this->materiaporplanestudioid = $materiaporplanestudioid;

        return $this;
    }

    /**
     * Get materiaporplanestudioid
     *
     * @return \AppBundle\Entity\CeMateriaporplanestudios
     */
    public function getMateriaporplanestudioid()
    {
        return $this->materiaporplanestudioid;
    }

    /**
     * Set grupoid
     *
     * @param \AppBundle\Entity\CeGrupo $grupoid
     *
     * @return CeGrupoorigenporsubgrupo
     */
    public function setGrupoid(\AppBundle\Entity\CeGrupo $grupoid = null)
    {
        $this->grupoid = $grupoid;

        return $this;
    }

    /**
     * Get grupoid
     *
     * @return \AppBundle\Entity\CeGrupo
     */
    public function getGrupoid()
    {
        return $this->grupoid;
    }

    /**
     * Set grupoorigenid
     *
     * @param \AppBundle\Entity\CeGrupo $grupoorigenid
     *
     * @return CeGrupoorigenporsubgrupo
     */
    public function setGrupoorigenid(\AppBundle\Entity\CeGrupo $grupoorigenid = null)
    {
        $this->grupoorigenid = $grupoorigenid;

        return $this;
    }

    /**
     * Get grupoorigenid
     *
     * @return \AppBundle\Entity\CeGrupo
     */
    public function getGrupoorigenid()
    {
        return $this->grupoorigenid;
    }
}

