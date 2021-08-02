export class OrfandadModel {
    //datos del alumno
    public matricula: any;
    public nombre: string;   
    public apellidopaterno: string;
    public apellidomaterno: string;
    public grado: string;
    public nivel: string;
    public adeudo: string;
       
    constructor() {
        this.matricula = null;
        this.nombre = null;
        this.apellidopaterno = null;
        this.apellidomaterno =  null;
        this.grado = null;
        this.nivel = null;
        this.adeudo = null;
    }
}