export class Seguridad {
    public usertoken: number;
    public ventanaid: string;
    public ciclo: number[];
    public nivel: number[];
    public grado: number[];
    public accesos: {
        consultar: boolean,
        agregar: boolean,
        editar: boolean,
        eliminar: boolean,
        exportar: boolean,
        descargar: boolean,
        copia: boolean,
        pasarotrociclo: boolean,
        evaluacion: boolean,
        editarevaluacion: boolean,
        imprimir: boolean,
        pasarsolicitud: boolean,
        importar: boolean,
        evaluador: boolean,
        restablecercontraseña: boolean,
        solicitarvalidacion: boolean,
        validar: boolean,
        rechazar: boolean,
        reservar: boolean,
        liberar: boolean,
        restringidos: any,
        edicionespecial: number
        Autorizar: boolean,
        Rechazar: boolean,
        profesor: boolean
    }

    constructor() {
        this.usertoken = null;
        this.ventanaid = null;
        this.ciclo = null;
        this.nivel = null;
        this.grado = null;
        this.accesos = {
            consultar: null,
            agregar: null,
            editar: null,
            eliminar: null,
            exportar: null,
            descargar: null,
            copia: null,
            pasarotrociclo: null,
            evaluacion: null,
            editarevaluacion: null,
            imprimir: null,
            pasarsolicitud: null,
            importar: null,
            evaluador: null,
            restablecercontraseña: null,
            solicitarvalidacion: null,
            validar: null,
            rechazar: null,
            reservar: null,
            liberar: null,
            restringidos: null,
            edicionespecial: null,
            Autorizar: null,
            Rechazar: null,
            profesor: null
        }
    }

    public logout(){
        localStorage.clear();
        window.location.href="#/Seguridad/Login";
    }
}