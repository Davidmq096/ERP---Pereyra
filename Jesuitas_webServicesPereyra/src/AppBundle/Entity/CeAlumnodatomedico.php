<?php

namespace AppBundle\Entity;

/**
 * CeAlumnodatomedico
 */
class CeAlumnodatomedico
{
    /**
     * @var string
     */
    private $padece;

    /**
     * @var string
     */
    private $alergico;

    /**
     * @var string
     */
    private $antecedentefamiliar;

    /**
     * @var string
     */
    private $autorizoantihistaminico;

    /**
     * @var string
     */
    private $examenvista;

    /**
     * @var string
     */
    private $lentes;

    /**
     * @var string
     */
    private $examenauditivo;

    /**
     * @var string
     */
    private $aparatoauditivo;

    /**
     * @var string
     */
    private $examenortopedicos;

    /**
     * @var string
     */
    private $aditamentoortopedico;

    /**
     * @var string
     */
    private $peso;

    /**
     * @var string
     */
    private $talla;

    /**
     * @var string
     */
    private $enfermedadcronica;

    /**
     * @var string
     */
    private $medicamentoregularidad;

    /**
     * @var string
     */
    private $alergicosustancias;

    /**
     * @var string
     */
    private $medicamentoadministrar;

    /**
     * @var string
     */
    private $analgesicosantinflamatorios;

    /**
     * @var string
     */
    private $antigripalesantihistaminicos;

    /**
     * @var string
     */
    private $antiacidos;

    /**
     * @var string
     */
    private $antiespasmodicos;

    /**
     * @var string
     */
    private $materialcuracion;

    /**
     * @var string
     */
    private $unguentos;

    /**
     * @var string
     */
    private $remediosalternativos;

    /**
     * @var string
     */
    private $nombreautoriza;

    /**
     * @var string
     */
    private $firma;

    /**
     * @var string
     */
    private $personaatiende;

    /**
     * @var string
     */
    private $telefonopersonaatiende;

    /**
     * @var string
     */
    private $contactoemergencianombre;

    /**
     * @var string
     */
    private $contactoemergenciatelefono;

    /**
     * @var string
     */
    private $contactoemergenciaemail;

    /**
     * @var string
     */
    private $otraalergia;

    /**
     * @var string
     */
    private $padeceenfermedadcuidanombre;

    /**
     * @var string
     */
    private $padeceenfermedadcuidatelefono;

    /**
     * @var string
     */
    private $padeceenfermedadcuidadescripcion;

    /**
     * @var string
     */
    private $descripcionantecedenteimportante;

    /**
     * @var integer
     */
    private $alumnodatomedicoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Parentesco
     */
    private $contactoemergenciaparentesco;

    /**
     * @var \AppBundle\Entity\Tiposanguineo
     */
    private $tiposangineo;


    /**
     * Set padece
     *
     * @param string $padece
     *
     * @return CeAlumnodatomedico
     */
    public function setPadece($padece)
    {
        $this->padece = $padece;

        return $this;
    }

    /**
     * Get padece
     *
     * @return string
     */
    public function getPadece()
    {
        return $this->padece;
    }

    /**
     * Set alergico
     *
     * @param string $alergico
     *
     * @return CeAlumnodatomedico
     */
    public function setAlergico($alergico)
    {
        $this->alergico = $alergico;

        return $this;
    }

    /**
     * Get alergico
     *
     * @return string
     */
    public function getAlergico()
    {
        return $this->alergico;
    }

    /**
     * Set antecedentefamiliar
     *
     * @param string $antecedentefamiliar
     *
     * @return CeAlumnodatomedico
     */
    public function setAntecedentefamiliar($antecedentefamiliar)
    {
        $this->antecedentefamiliar = $antecedentefamiliar;

        return $this;
    }

    /**
     * Get antecedentefamiliar
     *
     * @return string
     */
    public function getAntecedentefamiliar()
    {
        return $this->antecedentefamiliar;
    }

    /**
     * Set autorizoantihistaminico
     *
     * @param string $autorizoantihistaminico
     *
     * @return CeAlumnodatomedico
     */
    public function setAutorizoantihistaminico($autorizoantihistaminico)
    {
        $this->autorizoantihistaminico = $autorizoantihistaminico;

        return $this;
    }

    /**
     * Get autorizoantihistaminico
     *
     * @return string
     */
    public function getAutorizoantihistaminico()
    {
        return $this->autorizoantihistaminico;
    }

    /**
     * Set examenvista
     *
     * @param string $examenvista
     *
     * @return CeAlumnodatomedico
     */
    public function setExamenvista($examenvista)
    {
        $this->examenvista = $examenvista;

        return $this;
    }

    /**
     * Get examenvista
     *
     * @return string
     */
    public function getExamenvista()
    {
        return $this->examenvista;
    }

    /**
     * Set lentes
     *
     * @param string $lentes
     *
     * @return CeAlumnodatomedico
     */
    public function setLentes($lentes)
    {
        $this->lentes = $lentes;

        return $this;
    }

    /**
     * Get lentes
     *
     * @return string
     */
    public function getLentes()
    {
        return $this->lentes;
    }

    /**
     * Set examenauditivo
     *
     * @param string $examenauditivo
     *
     * @return CeAlumnodatomedico
     */
    public function setExamenauditivo($examenauditivo)
    {
        $this->examenauditivo = $examenauditivo;

        return $this;
    }

    /**
     * Get examenauditivo
     *
     * @return string
     */
    public function getExamenauditivo()
    {
        return $this->examenauditivo;
    }

    /**
     * Set aparatoauditivo
     *
     * @param string $aparatoauditivo
     *
     * @return CeAlumnodatomedico
     */
    public function setAparatoauditivo($aparatoauditivo)
    {
        $this->aparatoauditivo = $aparatoauditivo;

        return $this;
    }

    /**
     * Get aparatoauditivo
     *
     * @return string
     */
    public function getAparatoauditivo()
    {
        return $this->aparatoauditivo;
    }

    /**
     * Set examenortopedicos
     *
     * @param string $examenortopedicos
     *
     * @return CeAlumnodatomedico
     */
    public function setExamenortopedicos($examenortopedicos)
    {
        $this->examenortopedicos = $examenortopedicos;

        return $this;
    }

    /**
     * Get examenortopedicos
     *
     * @return string
     */
    public function getExamenortopedicos()
    {
        return $this->examenortopedicos;
    }

    /**
     * Set aditamentoortopedico
     *
     * @param string $aditamentoortopedico
     *
     * @return CeAlumnodatomedico
     */
    public function setAditamentoortopedico($aditamentoortopedico)
    {
        $this->aditamentoortopedico = $aditamentoortopedico;

        return $this;
    }

    /**
     * Get aditamentoortopedico
     *
     * @return string
     */
    public function getAditamentoortopedico()
    {
        return $this->aditamentoortopedico;
    }

    /**
     * Set peso
     *
     * @param string $peso
     *
     * @return CeAlumnodatomedico
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return string
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set talla
     *
     * @param string $talla
     *
     * @return CeAlumnodatomedico
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
     * Set enfermedadcronica
     *
     * @param string $enfermedadcronica
     *
     * @return CeAlumnodatomedico
     */
    public function setEnfermedadcronica($enfermedadcronica)
    {
        $this->enfermedadcronica = $enfermedadcronica;

        return $this;
    }

    /**
     * Get enfermedadcronica
     *
     * @return string
     */
    public function getEnfermedadcronica()
    {
        return $this->enfermedadcronica;
    }

    /**
     * Set medicamentoregularidad
     *
     * @param string $medicamentoregularidad
     *
     * @return CeAlumnodatomedico
     */
    public function setMedicamentoregularidad($medicamentoregularidad)
    {
        $this->medicamentoregularidad = $medicamentoregularidad;

        return $this;
    }

    /**
     * Get medicamentoregularidad
     *
     * @return string
     */
    public function getMedicamentoregularidad()
    {
        return $this->medicamentoregularidad;
    }

    /**
     * Set alergicosustancias
     *
     * @param string $alergicosustancias
     *
     * @return CeAlumnodatomedico
     */
    public function setAlergicosustancias($alergicosustancias)
    {
        $this->alergicosustancias = $alergicosustancias;

        return $this;
    }

    /**
     * Get alergicosustancias
     *
     * @return string
     */
    public function getAlergicosustancias()
    {
        return $this->alergicosustancias;
    }

    /**
     * Set medicamentoadministrar
     *
     * @param string $medicamentoadministrar
     *
     * @return CeAlumnodatomedico
     */
    public function setMedicamentoadministrar($medicamentoadministrar)
    {
        $this->medicamentoadministrar = $medicamentoadministrar;

        return $this;
    }

    /**
     * Get medicamentoadministrar
     *
     * @return string
     */
    public function getMedicamentoadministrar()
    {
        return $this->medicamentoadministrar;
    }

    /**
     * Set analgesicosantinflamatorios
     *
     * @param string $analgesicosantinflamatorios
     *
     * @return CeAlumnodatomedico
     */
    public function setAnalgesicosantinflamatorios($analgesicosantinflamatorios)
    {
        $this->analgesicosantinflamatorios = $analgesicosantinflamatorios;

        return $this;
    }

    /**
     * Get analgesicosantinflamatorios
     *
     * @return string
     */
    public function getAnalgesicosantinflamatorios()
    {
        return $this->analgesicosantinflamatorios;
    }

    /**
     * Set antigripalesantihistaminicos
     *
     * @param string $antigripalesantihistaminicos
     *
     * @return CeAlumnodatomedico
     */
    public function setAntigripalesantihistaminicos($antigripalesantihistaminicos)
    {
        $this->antigripalesantihistaminicos = $antigripalesantihistaminicos;

        return $this;
    }

    /**
     * Get antigripalesantihistaminicos
     *
     * @return string
     */
    public function getAntigripalesantihistaminicos()
    {
        return $this->antigripalesantihistaminicos;
    }

    /**
     * Set antiacidos
     *
     * @param string $antiacidos
     *
     * @return CeAlumnodatomedico
     */
    public function setAntiacidos($antiacidos)
    {
        $this->antiacidos = $antiacidos;

        return $this;
    }

    /**
     * Get antiacidos
     *
     * @return string
     */
    public function getAntiacidos()
    {
        return $this->antiacidos;
    }

    /**
     * Set antiespasmodicos
     *
     * @param string $antiespasmodicos
     *
     * @return CeAlumnodatomedico
     */
    public function setAntiespasmodicos($antiespasmodicos)
    {
        $this->antiespasmodicos = $antiespasmodicos;

        return $this;
    }

    /**
     * Get antiespasmodicos
     *
     * @return string
     */
    public function getAntiespasmodicos()
    {
        return $this->antiespasmodicos;
    }

    /**
     * Set materialcuracion
     *
     * @param string $materialcuracion
     *
     * @return CeAlumnodatomedico
     */
    public function setMaterialcuracion($materialcuracion)
    {
        $this->materialcuracion = $materialcuracion;

        return $this;
    }

    /**
     * Get materialcuracion
     *
     * @return string
     */
    public function getMaterialcuracion()
    {
        return $this->materialcuracion;
    }

    /**
     * Set unguentos
     *
     * @param string $unguentos
     *
     * @return CeAlumnodatomedico
     */
    public function setUnguentos($unguentos)
    {
        $this->unguentos = $unguentos;

        return $this;
    }

    /**
     * Get unguentos
     *
     * @return string
     */
    public function getUnguentos()
    {
        return $this->unguentos;
    }

    /**
     * Set remediosalternativos
     *
     * @param string $remediosalternativos
     *
     * @return CeAlumnodatomedico
     */
    public function setRemediosalternativos($remediosalternativos)
    {
        $this->remediosalternativos = $remediosalternativos;

        return $this;
    }

    /**
     * Get remediosalternativos
     *
     * @return string
     */
    public function getRemediosalternativos()
    {
        return $this->remediosalternativos;
    }

    /**
     * Set nombreautoriza
     *
     * @param string $nombreautoriza
     *
     * @return CeAlumnodatomedico
     */
    public function setNombreautoriza($nombreautoriza)
    {
        $this->nombreautoriza = $nombreautoriza;

        return $this;
    }

    /**
     * Get nombreautoriza
     *
     * @return string
     */
    public function getNombreautoriza()
    {
        return $this->nombreautoriza;
    }

    /**
     * Set firma
     *
     * @param string $firma
     *
     * @return CeAlumnodatomedico
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma
     *
     * @return string
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set personaatiende
     *
     * @param string $personaatiende
     *
     * @return CeAlumnodatomedico
     */
    public function setPersonaatiende($personaatiende)
    {
        $this->personaatiende = $personaatiende;

        return $this;
    }

    /**
     * Get personaatiende
     *
     * @return string
     */
    public function getPersonaatiende()
    {
        return $this->personaatiende;
    }

    /**
     * Set telefonopersonaatiende
     *
     * @param string $telefonopersonaatiende
     *
     * @return CeAlumnodatomedico
     */
    public function setTelefonopersonaatiende($telefonopersonaatiende)
    {
        $this->telefonopersonaatiende = $telefonopersonaatiende;

        return $this;
    }

    /**
     * Get telefonopersonaatiende
     *
     * @return string
     */
    public function getTelefonopersonaatiende()
    {
        return $this->telefonopersonaatiende;
    }

    /**
     * Set contactoemergencianombre
     *
     * @param string $contactoemergencianombre
     *
     * @return CeAlumnodatomedico
     */
    public function setContactoemergencianombre($contactoemergencianombre)
    {
        $this->contactoemergencianombre = $contactoemergencianombre;

        return $this;
    }

    /**
     * Get contactoemergencianombre
     *
     * @return string
     */
    public function getContactoemergencianombre()
    {
        return $this->contactoemergencianombre;
    }

    /**
     * Set contactoemergenciatelefono
     *
     * @param string $contactoemergenciatelefono
     *
     * @return CeAlumnodatomedico
     */
    public function setContactoemergenciatelefono($contactoemergenciatelefono)
    {
        $this->contactoemergenciatelefono = $contactoemergenciatelefono;

        return $this;
    }

    /**
     * Get contactoemergenciatelefono
     *
     * @return string
     */
    public function getContactoemergenciatelefono()
    {
        return $this->contactoemergenciatelefono;
    }

    /**
     * Set contactoemergenciaemail
     *
     * @param string $contactoemergenciaemail
     *
     * @return CeAlumnodatomedico
     */
    public function setContactoemergenciaemail($contactoemergenciaemail)
    {
        $this->contactoemergenciaemail = $contactoemergenciaemail;

        return $this;
    }

    /**
     * Get contactoemergenciaemail
     *
     * @return string
     */
    public function getContactoemergenciaemail()
    {
        return $this->contactoemergenciaemail;
    }

    /**
     * Set otraalergia
     *
     * @param string $otraalergia
     *
     * @return CeAlumnodatomedico
     */
    public function setOtraalergia($otraalergia)
    {
        $this->otraalergia = $otraalergia;

        return $this;
    }

    /**
     * Get otraalergia
     *
     * @return string
     */
    public function getOtraalergia()
    {
        return $this->otraalergia;
    }

    /**
     * Set padeceenfermedadcuidanombre
     *
     * @param string $padeceenfermedadcuidanombre
     *
     * @return CeAlumnodatomedico
     */
    public function setPadeceenfermedadcuidanombre($padeceenfermedadcuidanombre)
    {
        $this->padeceenfermedadcuidanombre = $padeceenfermedadcuidanombre;

        return $this;
    }

    /**
     * Get padeceenfermedadcuidanombre
     *
     * @return string
     */
    public function getPadeceenfermedadcuidanombre()
    {
        return $this->padeceenfermedadcuidanombre;
    }

    /**
     * Set padeceenfermedadcuidatelefono
     *
     * @param string $padeceenfermedadcuidatelefono
     *
     * @return CeAlumnodatomedico
     */
    public function setPadeceenfermedadcuidatelefono($padeceenfermedadcuidatelefono)
    {
        $this->padeceenfermedadcuidatelefono = $padeceenfermedadcuidatelefono;

        return $this;
    }

    /**
     * Get padeceenfermedadcuidatelefono
     *
     * @return string
     */
    public function getPadeceenfermedadcuidatelefono()
    {
        return $this->padeceenfermedadcuidatelefono;
    }

    /**
     * Set padeceenfermedadcuidadescripcion
     *
     * @param string $padeceenfermedadcuidadescripcion
     *
     * @return CeAlumnodatomedico
     */
    public function setPadeceenfermedadcuidadescripcion($padeceenfermedadcuidadescripcion)
    {
        $this->padeceenfermedadcuidadescripcion = $padeceenfermedadcuidadescripcion;

        return $this;
    }

    /**
     * Get padeceenfermedadcuidadescripcion
     *
     * @return string
     */
    public function getPadeceenfermedadcuidadescripcion()
    {
        return $this->padeceenfermedadcuidadescripcion;
    }

    /**
     * Set descripcionantecedenteimportante
     *
     * @param string $descripcionantecedenteimportante
     *
     * @return CeAlumnodatomedico
     */
    public function setDescripcionantecedenteimportante($descripcionantecedenteimportante)
    {
        $this->descripcionantecedenteimportante = $descripcionantecedenteimportante;

        return $this;
    }

    /**
     * Get descripcionantecedenteimportante
     *
     * @return string
     */
    public function getDescripcionantecedenteimportante()
    {
        return $this->descripcionantecedenteimportante;
    }

    /**
     * Get alumnodatomedicoid
     *
     * @return integer
     */
    public function getAlumnodatomedicoid()
    {
        return $this->alumnodatomedicoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnodatomedico
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
     * Set contactoemergenciaparentesco
     *
     * @param \AppBundle\Entity\Parentesco $contactoemergenciaparentesco
     *
     * @return CeAlumnodatomedico
     */
    public function setContactoemergenciaparentesco(\AppBundle\Entity\Parentesco $contactoemergenciaparentesco = null)
    {
        $this->contactoemergenciaparentesco = $contactoemergenciaparentesco;

        return $this;
    }

    /**
     * Get contactoemergenciaparentesco
     *
     * @return \AppBundle\Entity\Parentesco
     */
    public function getContactoemergenciaparentesco()
    {
        return $this->contactoemergenciaparentesco;
    }

    /**
     * Set tiposangineo
     *
     * @param \AppBundle\Entity\Tiposanguineo $tiposangineo
     *
     * @return CeAlumnodatomedico
     */
    public function setTiposangineo(\AppBundle\Entity\Tiposanguineo $tiposangineo = null)
    {
        $this->tiposangineo = $tiposangineo;

        return $this;
    }

    /**
     * Get tiposangineo
     *
     * @return \AppBundle\Entity\Tiposanguineo
     */
    public function getTiposangineo()
    {
        return $this->tiposangineo;
    }
}

