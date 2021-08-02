export class solicitud {
    public folio: string;
    public clavesolicitud: string;
    public correo: string;
    public aceptado: boolean;
    public listaespera: boolean;
    public pendiente: number;
    public nombrepersonacaptura: string;
    public parentescopersonacaptura: string;
    public solicitudadmisionid: number;
 

    constructor() {
        this.folio = null;
        this.clavesolicitud = null;
        this.correo = null;
        this.aceptado = null;
        this.listaespera = null;
        this.pendiente = null;
        this.nombrepersonacaptura = null;
        this.parentescopersonacaptura = null;
        this.solicitudadmisionid = null;     
    }
}


