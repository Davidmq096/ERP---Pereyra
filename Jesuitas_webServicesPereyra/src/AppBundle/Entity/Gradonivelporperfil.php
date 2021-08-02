<?php

namespace AppBundle\Entity;

/**
 * Gradonivelporperfil
 */
class Gradonivelporperfil
{
    /**
     * @var integer
     */
    private $gradonivelporperfilid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\Perfil
     */
    private $perfilid;


    /**
     * Get gradonivelporperfilid
     *
     * @return integer
     */
    public function getGradonivelporperfilid()
    {
        return $this->gradonivelporperfilid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return Gradonivelporperfil
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

    /**
     * Set perfilid
     *
     * @param \AppBundle\Entity\Perfil $perfilid
     *
     * @return Gradonivelporperfil
     */
    public function setPerfilid(\AppBundle\Entity\Perfil $perfilid = null)
    {
        $this->perfilid = $perfilid;

        return $this;
    }

    /**
     * Get perfilid
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getPerfilid()
    {
        return $this->perfilid;
    }
}

