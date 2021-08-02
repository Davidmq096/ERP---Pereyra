<?php

namespace AppBundle\Entity;

/**
 * BcEgresomensuales
 */
class BcEgresomensuales
{
    /**
     * @var float
     */
    private $alimentacion;

    /**
     * @var float
     */
    private $mantenimientoautos;

    /**
     * @var float
     */
    private $gastosdiversion;

    /**
     * @var float
     */
    private $renta;

    /**
     * @var float
     */
    private $telefonofijo;

    /**
     * @var float
     */
    private $inscripcioncolegios;

    /**
     * @var float
     */
    private $hipoteca;

    /**
     * @var float
     */
    private $telefonomovil;

    /**
     * @var float
     */
    private $colegiaturas;

    /**
     * @var float
     */
    private $predial;

    /**
     * @var float
     */
    private $television;

    /**
     * @var float
     */
    private $segurovida;

    /**
     * @var float
     */
    private $empleadadomestica;

    /**
     * @var float
     */
    private $gas;

    /**
     * @var float
     */
    private $seguroautos;

    /**
     * @var float
     */
    private $gastosmedicos;

    /**
     * @var float
     */
    private $agua;

    /**
     * @var float
     */
    private $segurogastosmedicos;

    /**
     * @var float
     */
    private $transporteurbano;

    /**
     * @var float
     */
    private $luz;

    /**
     * @var float
     */
    private $mantenimientofraccionamiento;

    /**
     * @var float
     */
    private $clubdeportivogimnasio;

    /**
     * @var float
     */
    private $gasolina;

    /**
     * @var float
     */
    private $vestido;

    /**
     * @var float
     */
    private $vacaciones;

    /**
     * @var float
     */
    private $clasesextra;

    /**
     * @var float
     */
    private $otros1;

    /**
     * @var float
     */
    private $otros2;

    /**
     * @var string
     */
    private $especifiqueclasesextra;

    /**
     * @var string
     */
    private $especifiqueotros1;

    /**
     * @var string
     */
    private $especifiqueotros2;

    /**
     * @var integer
     */
    private $egresomensualid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudbecaid;


    /**
     * Set alimentacion
     *
     * @param float $alimentacion
     *
     * @return BcEgresomensuales
     */
    public function setAlimentacion($alimentacion)
    {
        $this->alimentacion = $alimentacion;

        return $this;
    }

    /**
     * Get alimentacion
     *
     * @return float
     */
    public function getAlimentacion()
    {
        return $this->alimentacion;
    }

    /**
     * Set mantenimientoautos
     *
     * @param float $mantenimientoautos
     *
     * @return BcEgresomensuales
     */
    public function setMantenimientoautos($mantenimientoautos)
    {
        $this->mantenimientoautos = $mantenimientoautos;

        return $this;
    }

    /**
     * Get mantenimientoautos
     *
     * @return float
     */
    public function getMantenimientoautos()
    {
        return $this->mantenimientoautos;
    }

    /**
     * Set gastosdiversion
     *
     * @param float $gastosdiversion
     *
     * @return BcEgresomensuales
     */
    public function setGastosdiversion($gastosdiversion)
    {
        $this->gastosdiversion = $gastosdiversion;

        return $this;
    }

    /**
     * Get gastosdiversion
     *
     * @return float
     */
    public function getGastosdiversion()
    {
        return $this->gastosdiversion;
    }

    /**
     * Set renta
     *
     * @param float $renta
     *
     * @return BcEgresomensuales
     */
    public function setRenta($renta)
    {
        $this->renta = $renta;

        return $this;
    }

    /**
     * Get renta
     *
     * @return float
     */
    public function getRenta()
    {
        return $this->renta;
    }

    /**
     * Set telefonofijo
     *
     * @param float $telefonofijo
     *
     * @return BcEgresomensuales
     */
    public function setTelefonofijo($telefonofijo)
    {
        $this->telefonofijo = $telefonofijo;

        return $this;
    }

    /**
     * Get telefonofijo
     *
     * @return float
     */
    public function getTelefonofijo()
    {
        return $this->telefonofijo;
    }

    /**
     * Set inscripcioncolegios
     *
     * @param float $inscripcioncolegios
     *
     * @return BcEgresomensuales
     */
    public function setInscripcioncolegios($inscripcioncolegios)
    {
        $this->inscripcioncolegios = $inscripcioncolegios;

        return $this;
    }

    /**
     * Get inscripcioncolegios
     *
     * @return float
     */
    public function getInscripcioncolegios()
    {
        return $this->inscripcioncolegios;
    }

    /**
     * Set hipoteca
     *
     * @param float $hipoteca
     *
     * @return BcEgresomensuales
     */
    public function setHipoteca($hipoteca)
    {
        $this->hipoteca = $hipoteca;

        return $this;
    }

    /**
     * Get hipoteca
     *
     * @return float
     */
    public function getHipoteca()
    {
        return $this->hipoteca;
    }

    /**
     * Set telefonomovil
     *
     * @param float $telefonomovil
     *
     * @return BcEgresomensuales
     */
    public function setTelefonomovil($telefonomovil)
    {
        $this->telefonomovil = $telefonomovil;

        return $this;
    }

    /**
     * Get telefonomovil
     *
     * @return float
     */
    public function getTelefonomovil()
    {
        return $this->telefonomovil;
    }

    /**
     * Set colegiaturas
     *
     * @param float $colegiaturas
     *
     * @return BcEgresomensuales
     */
    public function setColegiaturas($colegiaturas)
    {
        $this->colegiaturas = $colegiaturas;

        return $this;
    }

    /**
     * Get colegiaturas
     *
     * @return float
     */
    public function getColegiaturas()
    {
        return $this->colegiaturas;
    }

    /**
     * Set predial
     *
     * @param float $predial
     *
     * @return BcEgresomensuales
     */
    public function setPredial($predial)
    {
        $this->predial = $predial;

        return $this;
    }

    /**
     * Get predial
     *
     * @return float
     */
    public function getPredial()
    {
        return $this->predial;
    }

    /**
     * Set television
     *
     * @param float $television
     *
     * @return BcEgresomensuales
     */
    public function setTelevision($television)
    {
        $this->television = $television;

        return $this;
    }

    /**
     * Get television
     *
     * @return float
     */
    public function getTelevision()
    {
        return $this->television;
    }

    /**
     * Set segurovida
     *
     * @param float $segurovida
     *
     * @return BcEgresomensuales
     */
    public function setSegurovida($segurovida)
    {
        $this->segurovida = $segurovida;

        return $this;
    }

    /**
     * Get segurovida
     *
     * @return float
     */
    public function getSegurovida()
    {
        return $this->segurovida;
    }

    /**
     * Set empleadadomestica
     *
     * @param float $empleadadomestica
     *
     * @return BcEgresomensuales
     */
    public function setEmpleadadomestica($empleadadomestica)
    {
        $this->empleadadomestica = $empleadadomestica;

        return $this;
    }

    /**
     * Get empleadadomestica
     *
     * @return float
     */
    public function getEmpleadadomestica()
    {
        return $this->empleadadomestica;
    }

    /**
     * Set gas
     *
     * @param float $gas
     *
     * @return BcEgresomensuales
     */
    public function setGas($gas)
    {
        $this->gas = $gas;

        return $this;
    }

    /**
     * Get gas
     *
     * @return float
     */
    public function getGas()
    {
        return $this->gas;
    }

    /**
     * Set seguroautos
     *
     * @param float $seguroautos
     *
     * @return BcEgresomensuales
     */
    public function setSeguroautos($seguroautos)
    {
        $this->seguroautos = $seguroautos;

        return $this;
    }

    /**
     * Get seguroautos
     *
     * @return float
     */
    public function getSeguroautos()
    {
        return $this->seguroautos;
    }

    /**
     * Set gastosmedicos
     *
     * @param float $gastosmedicos
     *
     * @return BcEgresomensuales
     */
    public function setGastosmedicos($gastosmedicos)
    {
        $this->gastosmedicos = $gastosmedicos;

        return $this;
    }

    /**
     * Get gastosmedicos
     *
     * @return float
     */
    public function getGastosmedicos()
    {
        return $this->gastosmedicos;
    }

    /**
     * Set agua
     *
     * @param float $agua
     *
     * @return BcEgresomensuales
     */
    public function setAgua($agua)
    {
        $this->agua = $agua;

        return $this;
    }

    /**
     * Get agua
     *
     * @return float
     */
    public function getAgua()
    {
        return $this->agua;
    }

    /**
     * Set segurogastosmedicos
     *
     * @param float $segurogastosmedicos
     *
     * @return BcEgresomensuales
     */
    public function setSegurogastosmedicos($segurogastosmedicos)
    {
        $this->segurogastosmedicos = $segurogastosmedicos;

        return $this;
    }

    /**
     * Get segurogastosmedicos
     *
     * @return float
     */
    public function getSegurogastosmedicos()
    {
        return $this->segurogastosmedicos;
    }

    /**
     * Set transporteurbano
     *
     * @param float $transporteurbano
     *
     * @return BcEgresomensuales
     */
    public function setTransporteurbano($transporteurbano)
    {
        $this->transporteurbano = $transporteurbano;

        return $this;
    }

    /**
     * Get transporteurbano
     *
     * @return float
     */
    public function getTransporteurbano()
    {
        return $this->transporteurbano;
    }

    /**
     * Set luz
     *
     * @param float $luz
     *
     * @return BcEgresomensuales
     */
    public function setLuz($luz)
    {
        $this->luz = $luz;

        return $this;
    }

    /**
     * Get luz
     *
     * @return float
     */
    public function getLuz()
    {
        return $this->luz;
    }

    /**
     * Set mantenimientofraccionamiento
     *
     * @param float $mantenimientofraccionamiento
     *
     * @return BcEgresomensuales
     */
    public function setMantenimientofraccionamiento($mantenimientofraccionamiento)
    {
        $this->mantenimientofraccionamiento = $mantenimientofraccionamiento;

        return $this;
    }

    /**
     * Get mantenimientofraccionamiento
     *
     * @return float
     */
    public function getMantenimientofraccionamiento()
    {
        return $this->mantenimientofraccionamiento;
    }

    /**
     * Set clubdeportivogimnasio
     *
     * @param float $clubdeportivogimnasio
     *
     * @return BcEgresomensuales
     */
    public function setClubdeportivogimnasio($clubdeportivogimnasio)
    {
        $this->clubdeportivogimnasio = $clubdeportivogimnasio;

        return $this;
    }

    /**
     * Get clubdeportivogimnasio
     *
     * @return float
     */
    public function getClubdeportivogimnasio()
    {
        return $this->clubdeportivogimnasio;
    }

    /**
     * Set gasolina
     *
     * @param float $gasolina
     *
     * @return BcEgresomensuales
     */
    public function setGasolina($gasolina)
    {
        $this->gasolina = $gasolina;

        return $this;
    }

    /**
     * Get gasolina
     *
     * @return float
     */
    public function getGasolina()
    {
        return $this->gasolina;
    }

    /**
     * Set vestido
     *
     * @param float $vestido
     *
     * @return BcEgresomensuales
     */
    public function setVestido($vestido)
    {
        $this->vestido = $vestido;

        return $this;
    }

    /**
     * Get vestido
     *
     * @return float
     */
    public function getVestido()
    {
        return $this->vestido;
    }

    /**
     * Set vacaciones
     *
     * @param float $vacaciones
     *
     * @return BcEgresomensuales
     */
    public function setVacaciones($vacaciones)
    {
        $this->vacaciones = $vacaciones;

        return $this;
    }

    /**
     * Get vacaciones
     *
     * @return float
     */
    public function getVacaciones()
    {
        return $this->vacaciones;
    }

    /**
     * Set clasesextra
     *
     * @param float $clasesextra
     *
     * @return BcEgresomensuales
     */
    public function setClasesextra($clasesextra)
    {
        $this->clasesextra = $clasesextra;

        return $this;
    }

    /**
     * Get clasesextra
     *
     * @return float
     */
    public function getClasesextra()
    {
        return $this->clasesextra;
    }

    /**
     * Set otros1
     *
     * @param float $otros1
     *
     * @return BcEgresomensuales
     */
    public function setOtros1($otros1)
    {
        $this->otros1 = $otros1;

        return $this;
    }

    /**
     * Get otros1
     *
     * @return float
     */
    public function getOtros1()
    {
        return $this->otros1;
    }

    /**
     * Set otros2
     *
     * @param float $otros2
     *
     * @return BcEgresomensuales
     */
    public function setOtros2($otros2)
    {
        $this->otros2 = $otros2;

        return $this;
    }

    /**
     * Get otros2
     *
     * @return float
     */
    public function getOtros2()
    {
        return $this->otros2;
    }

    /**
     * Set especifiqueclasesextra
     *
     * @param string $especifiqueclasesextra
     *
     * @return BcEgresomensuales
     */
    public function setEspecifiqueclasesextra($especifiqueclasesextra)
    {
        $this->especifiqueclasesextra = $especifiqueclasesextra;

        return $this;
    }

    /**
     * Get especifiqueclasesextra
     *
     * @return string
     */
    public function getEspecifiqueclasesextra()
    {
        return $this->especifiqueclasesextra;
    }

    /**
     * Set especifiqueotros1
     *
     * @param string $especifiqueotros1
     *
     * @return BcEgresomensuales
     */
    public function setEspecifiqueotros1($especifiqueotros1)
    {
        $this->especifiqueotros1 = $especifiqueotros1;

        return $this;
    }

    /**
     * Get especifiqueotros1
     *
     * @return string
     */
    public function getEspecifiqueotros1()
    {
        return $this->especifiqueotros1;
    }

    /**
     * Set especifiqueotros2
     *
     * @param string $especifiqueotros2
     *
     * @return BcEgresomensuales
     */
    public function setEspecifiqueotros2($especifiqueotros2)
    {
        $this->especifiqueotros2 = $especifiqueotros2;

        return $this;
    }

    /**
     * Get especifiqueotros2
     *
     * @return string
     */
    public function getEspecifiqueotros2()
    {
        return $this->especifiqueotros2;
    }

    /**
     * Get egresomensualid
     *
     * @return integer
     */
    public function getEgresomensualid()
    {
        return $this->egresomensualid;
    }

    /**
     * Set solicitudbecaid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudbecaid
     *
     * @return BcEgresomensuales
     */
    public function setSolicitudbecaid(\AppBundle\Entity\BcSolicitudbeca $solicitudbecaid = null)
    {
        $this->solicitudbecaid = $solicitudbecaid;

        return $this;
    }

    /**
     * Get solicitudbecaid
     *
     * @return \AppBundle\Entity\BcSolicitudbeca
     */
    public function getSolicitudbecaid()
    {
        return $this->solicitudbecaid;
    }
}

