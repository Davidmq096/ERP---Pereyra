export class FacturaModel {
    public clave: string;
    //domicilio
    public municipio: string;
    public colonia: string;
    public otraColonia: string;
    public calle: string;
    public numex: string;
    public numint: string;
    public cp: string;

    constructor() {
        this.clave = null;
        //Variables de domicilio
        this.municipio = null;
        this.colonia = null;
        this.otraColonia = null;
        this.calle = null;
        this.numex = null;
        this.numint = null;
        this.cp = null;
    }
}


