export class Alumno {
    alumnoid: number;
    matricula: string;
    nombre: string;
    apellidopaterno: string;
    apellidomaterno: string;
    nivelid?: number;
    nivel: string;
    gradoid?: number;
    grado: string;
    grupo: string;
    estatusid?: number;
    estatus: string;
    adeudo?: string;
    tipobaja?: string;
    motivobaja?: string;

    constructor() {
        this.alumnoid = null;
        this.matricula = null;
        this.nombre = null;
        this.apellidopaterno = null;
        this.apellidomaterno = null;
        this.nivelid = null;
        this.nivel = null;
        this.gradoid = null;
        this.grado = null;
        this.grupo = null;
        this.estatusid = null;
        this.estatus = null;
        this.adeudo = null;
        this.tipobaja = null;
        this.motivobaja = null;
    }

}