export class BecaModel {
    //datos del alumno
    public alumnoid: any;
    public nivelid: any;   
    public tipobecaid: any;
    public fechainicio: any;
    public porcentajebecaid: any;
    public gradoid: any;   
    public cicloid: any;
    public estatusid: any;
       
    constructor() {
     this.alumnoid = null;
     this.nivelid = null;   
     this.tipobecaid = null;
     this.fechainicio = null;
     this.porcentajebecaid = null;
     this.gradoid = null;  
     this.cicloid = null;
     this.estatusid = null;
    }
}

export class EdicionBeca{
    //datos del alumno
    //public alumnoid: any;
    //public nivelid: any;
    //public tipobecaid: any;
    public fechasolicitud: any;
    public porcentajebecaid: any;
    //public gradoid: any;
    //public cicloid: any;
    public observaciones: any;
    public estatusid: any;
    public motivo: any;
    public becaid: any;
       
    constructor() {
    // this.alumnoid = null;
     //this.nivelid = null;
    // this.tipobecaid = null;
     this.fechasolicitud = null;
     this.porcentajebecaid = null;
        this.estatusid = null;
        this.motivo = null;
        this.becaid = null;
        //this.gradoid = null;
    // this.cicloid = null;
    }
}
