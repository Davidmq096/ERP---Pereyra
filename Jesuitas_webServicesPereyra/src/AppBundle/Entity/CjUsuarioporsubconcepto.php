<?php

namespace AppBundle\Entity;

/**
 * CjUsuarioporsubconcepto
 */
class CjUsuarioporsubconcepto
{
    /**
     * @var integer
     */
    private $usuarioporsubconceptoid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Get usuarioporsubconceptoid
     *
     * @return integer
     */
    public function getUsuarioporsubconceptoid()
    {
        return $this->usuarioporsubconceptoid;
    }

    /**
     * Set subconceptoid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoid
     *
     * @return CjUsuarioporsubconcepto
     */
    public function setSubconceptoid(\AppBundle\Entity\CjSubconcepto $subconceptoid = null)
    {
        $this->subconceptoid = $subconceptoid;

        return $this;
    }

    /**
     * Get subconceptoid
     *
     * @return \AppBundle\Entity\CjSubconcepto
     */
    public function getSubconceptoid()
    {
        return $this->subconceptoid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CjUsuarioporsubconcepto
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

