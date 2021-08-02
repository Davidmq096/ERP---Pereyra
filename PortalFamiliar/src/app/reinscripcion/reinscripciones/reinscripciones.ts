import {FormGroup, Form} from '@angular/forms';
export class Reinscripciones {
    padretutorid: number;
    alumno: any;
    catalogos: {
        arrayPagocolegiaturas: any[];
        arrayPagoadelantada: any[];
        arrayInscripcion: any[];
        arrayDocumentos: any[];
        arrayTipopago: any[];
        s3: any;
    }
    formPaso1: any;
    formPaso2: any;
    tamanoMaximo: any;

    constructor() {
        this.padretutorid = null;
        this.alumno = null;
        this.catalogos = {
            arrayPagocolegiaturas: [],
            arrayPagoadelantada: [],
            arrayInscripcion: [],
            arrayDocumentos: [],
            arrayTipopago: [],
            s3: null
        }
        this.formPaso1 = null;
        this.formPaso2 = null;
        this.tamanoMaximo = null;
    }

}