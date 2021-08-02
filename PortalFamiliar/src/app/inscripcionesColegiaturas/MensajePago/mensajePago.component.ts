import {AfterViewInit, ViewEncapsulation, Component, OnInit, ViewChild} from '@angular/core';
import {Defer} from "./mensajePago.model";
import {ModalDirective} from "ng2-bootstrap/modal";

@Component({
    selector: 'mensajePago',
    templateUrl: './mensajePago.template.html',
})

export class MensajePagoComponent
{
    private dialogoRespuesta:any;
    documentos:Array<any>;
    fechavencida:Array<any>;
    optPago:string;

    //modales
    @ViewChild('mensajePagoModal') mensajePago: ModalDirective;
    @ViewChild('mensajePagoFechaProrroga') mensajePagoFechaProrroga: ModalDirective;

    constructor()
    {

    }

    ngOnInit()
    {
        this.mensajePago.onHidden.subscribe(() =>
        {
            this.dialogoRespuesta.resolve(this.optPago);
        });
    }

    AbrirModal(documento)
    {
        this.dialogoRespuesta = new Defer<boolean>();

        this.documentos = documento;

        for(let d of this.documentos)
        {
            d.SaldoInteresTotal = d.SaldoTotal + d.InteresTotal;
            d.DescuentoVal =(d.descuentodoc*1).toFixed(2);
            d.Total = d.SaldoInteresTotal - parseFloat(d.DescuentoVal);
        }

        this.mensajePago.show();

        return this.dialogoRespuesta.promise;
    }

    TeminarMensaje()
    {
        this.optPago = "pagar";
        this.documentos = [];
        this.mensajePago.hide();
    }

    CerrarModal()
    {
        this.optPago = "cerrar";
        this.documentos = [];
        this.mensajePago.hide();
    }


    AbrirModalFechaProrroga(documento)
    {
        this.fechavencida = documento;
        this.mensajePagoFechaProrroga.show();
    }

    CerrarModalFechaVencida()
    {
        this.mensajePagoFechaProrroga.hide();
    }
}