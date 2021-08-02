import {Component, EventEmitter, Input, Output, ViewChild} from '@angular/core';

import {ModalDirective} from 'ng2-bootstrap/modal';
import {AppState} from "../app.service";
import {document} from "ng2-bootstrap/utils/facade/browser";

declare let Messenger:any;

@Component({
    selector: 'solicitudCobro',
    templateUrl: './SolicitudCobro.template.html',
})
export class SolicitudCobroComponent
{
    logo:string;
    url:string = "";

    //modal
    @ViewChild('modalSolicitudCobro') modalSolicitudCobro: ModalDirective;
    @Output() ActualizarDocumentosPorPagar = new EventEmitter();

    constructor(private _httpService: AppState)
    {
        this.logo = _httpService.logobar;
    }

    ngOnInit(): void
    {

    }

    AbrirSolicitudPago(url)
    {
        this.url = url;
        this.modalSolicitudCobro.show();
    }

    CerrarModal()
    {
        this.url = "";
        this.ActualizarDocumentosPorPagar.emit();
        this.modalSolicitudCobro.hide();
    }

}
