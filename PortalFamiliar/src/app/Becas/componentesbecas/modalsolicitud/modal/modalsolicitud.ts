export class parametrosModal {
    public matricula: any;
    public solicitudid: number;
    public clavefamiliarid: number;
    public alumnodictamen: any;
    public spa_becarecomendada: any;
    public alumnoid: number;
    public entidad: any;
    public pestana: number;
    public buscar: boolean;
    public guardar: boolean;
    public editable: boolean;
    public estatusid: any;
    public configpestana: {
        datospadres: {visible: boolean, editable: boolean},
        dependienteseconomicos: {visible: boolean, editable: boolean},
        dictaminacion: {visible: boolean, editable: boolean},
        documentos: {visible: boolean, editable: boolean},
        estudiosocioeconomico: {visible: boolean, editable: boolean},
        referencias: {visible: boolean, editable: boolean},
        situacioneconomica: {visible: boolean, editable: boolean},
        solicitudbeca: {visible: boolean, editable: boolean},
    }

    public pestanaSolicitud: {
        familiaalumnos: any[],
        selectAlumno: any[],
        SelectEstadoFull: any[],
        domicilios: any[]
    };

    public pestanapadres: {
        datos: {padres: any[], situacionfamiliar: any},
        estadocivil: any[],
        escolaridad: any[],
        selectParentesco: any[],
    };

    public pespadres: {
        datos: any;
    };

    public pestanaDependientesEconomicos: {
        datosgenerales: any[],
        datoshijos: any[],
        datosotrosdp: any[]
    }

    public pestanaReferencias: {
        datospersonas: any[],
        FormGuardar: any[]
    }

    public pestanaSituacionEconomica: {
        selectTipocuentabanco: any[],
        selectEstatusvehiculo: any[],
        selectestatusinmueble: any[],
        selectTipocredito: any[],
        datosdeudasycreditos: any[],
        datosbancos: any[],
        datosvehiculos: any[],
        datospropiedades: any[],
        formulario: any[]
    }

    public examenesarray: any[];
    public multimediaarray: any[];
    public respuestasarray: any[];
    public select: {
        /*padres*/
        selectOcupacion: any[],
        selectParentesco: any[],
        selectCivil: any[],
        /*dependientes*/
        /*dictaminacion*/
        selectCiclo: any[],
        selectTipobeca: any[],
        selectPorcentajes: any[],
        /*documentos*/
        options: any[],
        /*estudiosocioeconomico*/
        selectpropiedad: any[],
        /*referrencias*/
        selectEstatus: any[]
    };
    constructor() {
        this.entidad = {};
        this.pestana = null;
        this.estatusid = null;
        this.buscar = false;
        this.guardar = null;
        this.configpestana = {
            datospadres: {visible: null, editable: null},
            dependienteseconomicos: {visible: null, editable: null},
            dictaminacion: {visible: null, editable: null},
            documentos: {visible: null, editable: null},
            estudiosocioeconomico: {visible: null, editable: null},
            referencias: {visible: null, editable: null},
            situacioneconomica: {visible: null, editable: null},
            solicitudbeca: {visible: null, editable: null},
        }
        this.pestanapadres = {
            datos: {padres: null, situacionfamiliar: null},
            estadocivil: null,
            escolaridad: null,
            selectParentesco:null
        };
        
        this.pespadres = {
            datos: null
        }

        this.pestanaSolicitud = {
            familiaalumnos: null,
            selectAlumno: null,
            SelectEstadoFull: null,
            domicilios: null
        }
        this.pestanaReferencias = {
            datospersonas: null,
            FormGuardar: null
        }
        this.pestanaDependientesEconomicos = {
            datosgenerales: null,
            datoshijos: null,
            datosotrosdp: null
        }

        this.pestanaSituacionEconomica = {
            selectTipocuentabanco: null,
            selectEstatusvehiculo: null,
            selectestatusinmueble: null,
            selectTipocredito: null,
            datosdeudasycreditos: null,
            datosbancos: null,
            datosvehiculos: null,
            datospropiedades: null,
            formulario: null
        }
        this.examenesarray = null;
        this.multimediaarray = null;
        this.respuestasarray = null;
        this.select = {
            selectOcupacion: null,
            selectParentesco: null,
            selectCivil: null,
            selectCiclo: null,
            selectTipobeca: null,
            selectPorcentajes: null,
            options: null,
            selectpropiedad: null,
            selectEstatus: null

        };
    }

}




