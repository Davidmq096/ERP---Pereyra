<?php

namespace AppBundle\Entity;

/**
 * CeBitacoraarmadogrupo
 */
class CeBitacoraarmadogrupo
{
    /**
     * @var string
     */
    private $alumno;

    /**
     * @var string
     */
    private $grupoanterior;

    /**
     * @var string
     */
    private $gruponuevo;

    /**
     * @var string
     */
    private $usuario;

    /**
     * @var \DateTime
     */
    private $fecha = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     */
    private $bitacoraarmadogrupoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CeGrupo
     */
    private $grupoorigenid;

    /**
     * @var \AppBundle\Entity\CeGrupo
     */
    private $grupodestinoid;

    /**
     * @var \AppBundle\Entity\CeTipomovimientobitacora
     */
    private $tipobitacoramovimientoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set alumno
     *
     * @param string $alumno
     *
     * @return CeBitacoraarmadogrupo
     */
    public function setAlumno($alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return string
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set grupoanterior
     *
     * @param string $grupoanterior
     *
     * @return CeBitacoraarmadogrupo
     */
    public function setGrupoanterior($grupoanterior)
    {
        $this->grupoanterior = $grupoanterior;

        return $this;
    }

    /**
     * Get grupoanterior
     *
     * @return string
     */
    public function getGrupoanterior()
    {
        return $this->grupoanterior;
    }

    /**
     * Set gruponuevo
     *
     * @param string $gruponuevo
     *
     * @return CeBitacoraarmadogrupo
     */
    public function setGruponuevo($gruponuevo)
    {
        $this->gruponuevo = $gruponuevo;

        return $this;
    }

    /**
     * Get gruponuevo
     *
     * @return string
     */
    public function getGruponuevo()
    {
        return $this->gruponuevo;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     *
     * @return CeBitacoraarmadogrupo
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeBitacoraarmadogrupo
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Get bitacoraarmadogrupoid
     *
     * @return integer
     */
    public function getBitacoraarmadogrupoid()
    {
        return $this->bitacoraarmadogrupoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeBitacoraarmadogrupo
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set grupoorigenid
     *
     * @param \AppBundle\Entity\CeGrupo $grupoorigenid
     *
     * @return CeBitacoraarmadogrupo
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

    /**
     * Set grupodestinoid
     *
     * @param \AppBundle\Entity\CeGrupo $grupodestinoid
     *
     * @return CeBitacoraarmadogrupo
     */
    public function setGrupodestinoid(\AppBundle\Entity\CeGrupo $grupodestinoid = null)
    {
        $this->grupodestinoid = $grupodestinoid;

        return $this;
    }

    /**
     * Get grupodestinoid
     *
     * @return \AppBundle\Entity\CeGrupo
     */
    public function getGrupodestinoid()
    {
        return $this->grupodestinoid;
    }

    /**
     * Set tipobitacoramovimientoid
     *
     * @param \AppBundle\Entity\CeTipomovimientobitacora $tipobitacoramovimientoid
     *
     * @return CeBitacoraarmadogrupo
     */
    public function setTipobitacoramovimientoid(\AppBundle\Entity\CeTipomovimientobitacora $tipobitacoramovimientoid = null)
    {
        $this->tipobitacoramovimientoid = $tipobitacoramovimientoid;

        return $this;
    }

    /**
     * Get tipobitacoramovimientoid
     *
     * @return \AppBundle\Entity\CeTipomovimientobitacora
     */
    public function getTipobitacoramovimientoid()
    {
        return $this->tipobitacoramovimientoid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeBitacoraarmadogrupo
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeBitacoraarmadogrupo
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

