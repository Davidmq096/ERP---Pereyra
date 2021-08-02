<?php

namespace AppBundle\Entity;

/**
 * EmpleadoshijosTemp
 */
class EmpleadoshijosTemp
{
    /**
     * @var string
     */
    private $nonomina;

    /**
     * @var string
     */
    private $nombreempleado;

    /**
     * @var string
     */
    private $paternoempleado;

    /**
     * @var string
     */
    private $maternoempleado;

    /**
     * @var string
     */
    private $matricula;

    /**
     * @var string
     */
    private $nombrealumno;

    /**
     * @var string
     */
    private $paternoalumno;

    /**
     * @var string
     */
    private $maternoalumno;

    /**
     * @var integer
     */
    private $padreotutorid;

    /**
     * @var integer
     */
    private $pk;


    /**
     * Set nonomina
     *
     * @param string $nonomina
     *
     * @return EmpleadoshijosTemp
     */
    public function setNonomina($nonomina)
    {
        $this->nonomina = $nonomina;

        return $this;
    }

    /**
     * Get nonomina
     *
     * @return string
     */
    public function getNonomina()
    {
        return $this->nonomina;
    }

    /**
     * Set nombreempleado
     *
     * @param string $nombreempleado
     *
     * @return EmpleadoshijosTemp
     */
    public function setNombreempleado($nombreempleado)
    {
        $this->nombreempleado = $nombreempleado;

        return $this;
    }

    /**
     * Get nombreempleado
     *
     * @return string
     */
    public function getNombreempleado()
    {
        return $this->nombreempleado;
    }

    /**
     * Set paternoempleado
     *
     * @param string $paternoempleado
     *
     * @return EmpleadoshijosTemp
     */
    public function setPaternoempleado($paternoempleado)
    {
        $this->paternoempleado = $paternoempleado;

        return $this;
    }

    /**
     * Get paternoempleado
     *
     * @return string
     */
    public function getPaternoempleado()
    {
        return $this->paternoempleado;
    }

    /**
     * Set maternoempleado
     *
     * @param string $maternoempleado
     *
     * @return EmpleadoshijosTemp
     */
    public function setMaternoempleado($maternoempleado)
    {
        $this->maternoempleado = $maternoempleado;

        return $this;
    }

    /**
     * Get maternoempleado
     *
     * @return string
     */
    public function getMaternoempleado()
    {
        return $this->maternoempleado;
    }

    /**
     * Set matricula
     *
     * @param string $matricula
     *
     * @return EmpleadoshijosTemp
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set nombrealumno
     *
     * @param string $nombrealumno
     *
     * @return EmpleadoshijosTemp
     */
    public function setNombrealumno($nombrealumno)
    {
        $this->nombrealumno = $nombrealumno;

        return $this;
    }

    /**
     * Get nombrealumno
     *
     * @return string
     */
    public function getNombrealumno()
    {
        return $this->nombrealumno;
    }

    /**
     * Set paternoalumno
     *
     * @param string $paternoalumno
     *
     * @return EmpleadoshijosTemp
     */
    public function setPaternoalumno($paternoalumno)
    {
        $this->paternoalumno = $paternoalumno;

        return $this;
    }

    /**
     * Get paternoalumno
     *
     * @return string
     */
    public function getPaternoalumno()
    {
        return $this->paternoalumno;
    }

    /**
     * Set maternoalumno
     *
     * @param string $maternoalumno
     *
     * @return EmpleadoshijosTemp
     */
    public function setMaternoalumno($maternoalumno)
    {
        $this->maternoalumno = $maternoalumno;

        return $this;
    }

    /**
     * Get maternoalumno
     *
     * @return string
     */
    public function getMaternoalumno()
    {
        return $this->maternoalumno;
    }

    /**
     * Set padreotutorid
     *
     * @param integer $padreotutorid
     *
     * @return EmpleadoshijosTemp
     */
    public function setPadreotutorid($padreotutorid)
    {
        $this->padreotutorid = $padreotutorid;

        return $this;
    }

    /**
     * Get padreotutorid
     *
     * @return integer
     */
    public function getPadreotutorid()
    {
        return $this->padreotutorid;
    }

    /**
     * Get pk
     *
     * @return integer
     */
    public function getPk()
    {
        return $this->pk;
    }
}

