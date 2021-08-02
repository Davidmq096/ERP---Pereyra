import {Nivel} from './nivel';

export class Grado {
    public gradoid: number;
    public nivelid: Nivel;
    public grado: string;
    public activo: boolean;

    constructor() {
        this.gradoid = null;
        this.nivelid = null;
        this.grado = null;
        this.activo = true;
    }
}




