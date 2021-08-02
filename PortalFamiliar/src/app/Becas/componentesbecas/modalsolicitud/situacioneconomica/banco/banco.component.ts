import {Component, OnInit, Input} from "@angular/core";
import {AppState} from "app/app.service";
import {FormGroup, FormControl, FormBuilder, Validators} from "@angular/forms";
import {parametrosModal} from './../../modal/modalsolicitud';
import {Helpers} from "app/app.helpers";

declare let Messenger: any;

@Component({
    selector: "banco",
    templateUrl: "banco.component.html",
    providers: [AppState]
})
export class BancoComponent implements OnInit {
    @Input() editable: boolean;
    @Input() sistema: any;
    @Input() solicitudid: number;
    @Input() selectTipocuentabanco: any[];
    @Input() datosbancos: any[];
    @Input() numberMaskNoComma;
    @Input() parametrosModal: parametrosModal;

    //Banco
    formbanco: FormGroup;
    submitted: boolean;
    nuevo: any = false;

    constructor(private URLBase: AppState, private _httpService: AppState, private _help: Helpers, private _fb: FormBuilder) {
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.formbanco = this._fb.group({
            tipocuentabancoid: [, <any> Validators.required],
            bancoinstitucion: [, <any> Validators.required],
            saldoactual: [, <any> Validators.required],
            //numerocuenta: [, <any>Validators.required],
            solicitudbecaid: [this.solicitudid],
            portal: 1
        });

    }

    cancelar() {
        this.submitted = false;
        this.nuevo = false;
        this.formbanco.reset({solicitudbecaid: this.solicitudid, portal: 1});
    }

    transformartexto(forname: FormControl) {
        let texto: string = forname.value;
        if (texto) {
        forname.setValue(this.sistema == 1 ? texto.toUpperCase() : this._help.capitalize(texto));
        }
    }

    savebanco() {
        this.submitted = true;
        if (this.formbanco.invalid) {
            return false;
        }
        let datos = {datos: JSON.stringify(this.formbanco.value)};
        this.URLBase.postElemento("Becas/SolicitudBeca/SituacionEconomica/CuentaBanco", datos).subscribe(
            res => {
                if (res.status == 200) {
                    this.cancelar();
                    this.datosbancos = res.body;
                    Messenger().post({
                        message: "Se ha guardado el registro con éxito",
                        type: "success",
                        showCloseButton: true
                    });
                    this.parametrosModal.pestanaSituacionEconomica.datosbancos = res.body;
                } else {
                    Messenger().post({
                        message: "Ocurrio un error al guardar el registro",
                        type: "success",
                        showCloseButton: true
                    });
                }
            },
            err => {
                //handle your error here.
                console.log(err);
            }
        );
    }

    deletebanco(c) {
        let msg = Messenger({
            extraClasses: "messenger-fixed messenger-on-top"
        }).post({
            message: `¿Está seguro que desea eliminar el registro?`,
            hideAfter: false,
            actions: {
                cancel: {
                    label: "Cancelar",
                    action: () => {
                        msg.hide();
                    }
                },
                confirm: {
                    label: "Aceptar",
                    action: () => {
                        msg.hide();
                        var id = c.cuentabancoid;
                        this._httpService.deleteElemento("Becas/SolicitudBeca/SituacionEconomica/CuentaBanco", id).subscribe(
                            result => {
                                if (result.status == 200) {
                                    this.datosbancos = result.body;
                                    Messenger().post({
                                        message: "Se ha eliminado exitosamente",
                                        type: "success",
                                        showCloseButton: true
                                    });
                                    this.parametrosModal.pestanaSituacionEconomica.datosbancos = result.body;
                                } else {
                                    Messenger().post({
                                        message: "Ocurrio un error al eliminar el registro",
                                        type: "success",
                                        showCloseButton: true
                                    });
                                }
                            },
                            error => {
                                Messenger().post({
                                    message: "No se pudo comunicar con el servidor",
                                    type: "error",
                                    showCloseButton: true
                                });
                            }
                        );
                    }
                }
            }
        });
    }


}
