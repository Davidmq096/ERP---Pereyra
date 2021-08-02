<?php

namespace AppBundle\Entity;

/**
 * Usuarioporperfil
 */
class Usuarioporperfil
{
    /**
     * @var integer
     */
    private $usuarioporperfilid;

    /**
     * @var \AppBundle\Entity\Perfil
     */
    private $perfilid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Get usuarioporperfilid
     *
     * @return integer
     */
    public function getUsuarioporperfilid()
    {
        return $this->usuarioporperfilid;
    }

    /**
     * Set perfilid
     *
     * @param \AppBundle\Entity\Perfil $perfilid
     *
     * @return Usuarioporperfil
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

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return Usuarioporperfil
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

