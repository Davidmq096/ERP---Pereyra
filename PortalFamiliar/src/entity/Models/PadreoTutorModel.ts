
export class PadreoTutorModel {
    //datos del padre o tutor
    public padresotutoresid: number;
    public nombre: string;
    public vive: string;
    public ocupacion: string;
    public puesto: string;
    public horariotrabajo: string;
    public antiguedad: string;
    public situacionconyugalid: string;
    public ladacelular: string;
    public celular: string;
    public ladatelempresa: string;
    public telempresa: string;
    public empresa: string;
    public especificacionocupacion: string;
    public parentesco: string;
    public extensionempresa: string;

    sistema: number;

    constructor(init: Partial<PadreoTutorModel>, sistema:number) {
        this.sistema = sistema;
        Object.assign(this, init);

        this.ladacelular = this.GetLadaTelefono(this.celular);
        this.celular = this.GetTelefonoTelefono(this.celular);

        this.ladatelempresa = this.GetLadaTelefono(this.telempresa);
        this.telempresa = this.GetTelefonoTelefono(this.telempresa);
    }

    GetLadaTelefono(tel:string) {
        if (!tel) {
            return "";
        }
        else {
            return tel.split('-')[0];
        }
    }

    GetTelefonoTelefono(tel:string) {
        if (!tel) {
            return "";
        }
        else {
            return  tel.split('-')[1];
        }
    }
}
