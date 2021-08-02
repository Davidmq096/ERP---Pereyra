import {AfterViewInit, ViewEncapsulation, Component, OnInit, ViewChild} from '@angular/core';
import {AppState} from "app/app.service";
import {App} from "app/app.component";
import {FormGroup, FormBuilder, Validators} from '@angular/forms';

declare let Messenger: any;
declare var $: any;
declare var $window: any;
declare var Pace: any;
declare var alasql: any;
import {Subject} from 'rxjs/Rx';

@Component({
    selector: 'datoAspirante',
    templateUrl: './expediente.component.html'
})
export class General {

    constructor() {

    }

    ngOnInit() {
    }

    public inputValidateDanger(id: any, text: any) {
        $("#" + id).addClass("inputValidate");
        $("#" + id + "massageError").text(text);
        $("#" + id + "massageError").show();
    }
    /* Funcion para validar campos */
    inputValidateSuccess(id: any) {
        $("#" + id).removeClass("inputValidate");
        $("#" + id + "massageError").hide();
    }

    documentStar() {
        $("html, body").animate({scrollTop: 0}, 500);
    }

    /* funcion para visualizar los mensajes generales (Exitoso) */
    mensajeSuccess(text: any) {
        // console.debug("entra funcion");
        $("#success-alert").alert();
        $("#text-messageSucess").text(text);
        $("#success-alert").fadeIn();
        setTimeout(() => {
            $("#success-alert").fadeOut();
        }, 3000);
    };
    /* funcion para visualizar los mensajes generales (Error) */
    mensajeDanger(text: any) {
        // console.debug("entra funcion");
        $("#danger-alert").alert();
        $("#text-messageDanger").text(text);
        $("#danger-alert").fadeIn();
        setTimeout(() => {
            $("#danger-alert").fadeOut();
        }, 3000);
    };

}
