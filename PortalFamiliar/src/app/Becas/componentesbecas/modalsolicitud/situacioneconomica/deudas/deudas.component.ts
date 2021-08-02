import {parametrosModal} from './../../modal/modalsolicitud';
import {Component, OnInit, Input, Output, EventEmitter} from "@angular/core";
import {AppState} from "app/app.service";
import {FormGroup, FormControl, FormBuilder, Validators} from "@angular/forms";
import {Helpers} from "app/app.helpers";

declare let Messenger: any;

@Component({
    selector: "deudas",
    templateUrl: "deudas.component.html",
    providers: [AppState]
})
export class DeudasComponent implements OnInit {
    @Input() editable: boolean;
    @Input() solicitudid: number;
    @Input() sistema: any;
    @Input() datosdeudasycreditos: any[];
    @Input() selectTipocredito: any[];
    @Input() total: number;
    @Output() output = new EventEmitter();
    @Input() parametrosModal: parametrosModal;
    //Deusas y creditos
    nuevo: boolean = false;
    formdeudacredito: FormGroup;
    submitted: boolean;


    //En el contructor se declara la llamada a los servicios
    constructor(private URLBase: AppState, private _httpService: AppState, private _help: Helpers, private _fb: FormBuilder) {
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.formdeudacredito = this._fb.group({
            pagomensual: [, <any> Validators.required],
            solicitudid: [this.solicitudid],
            bancoinstitucion: [, <any> Validators.required],
            tipocreditoid: [, <any> Validators.required],
            limitecredito: [, <any> Validators.required],
            importetotal: [, <any> Validators.required],
            portal: 1
        });

    }

    transformartexto(forname: FormControl) {
        let texto: string = forname.value;
        if (texto) {
            forname.setValue(this.sistema == 1 ? texto.toUpperCase() : this._help.capitalize(texto));
        }
    }

    removecredito() {
        this.submitted = false;
        this.nuevo = false;
        this.formdeudacredito.reset({solicitudid: this.solicitudid, portal: 1});
    }

    savecredito() {
        this.submitted = true;
        if (this.formdeudacredito.invalid) {
            return false;
        }
        this._httpService.postElemento("Becas/SolicitudBeca/SituacionEconomica/DeudasCreditos", this.formdeudacredito.value,null,true).subscribe(
            res => {
                if (res.status == 200) {
                    this.removecredito();
                    this.datosdeudasycreditos = res.body;
                    this.total = this.datosdeudasycreditos.reduce((a, b) => a + Number(b.pagomensual), 0);
                    this.output.next(this.datosdeudasycreditos);
                    Messenger().post({
                        message: "Se ha guardado el registro con éxito",
                        type: "success",
                        showCloseButton: true
                    });
                    this.parametrosModal.pestanaSituacionEconomica.datosdeudasycreditos = res.body;
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

    deleteDeuda(c) {
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
                        var id = c.deudascreditosid;
                        this._httpService.deleteElemento("Becas/SolicitudBeca/SituacionEconomica/DeudasCreditos", id).subscribe(
                            result => {
                                if (result.status == 200) {
                                    this.datosdeudasycreditos = result.body;
                                    this.total = this.datosdeudasycreditos.reduce((a, b) => a + Number(b.pagomensual), 0);
                                    this.output.next(this.datosdeudasycreditos);
                                    Messenger().post({
                                        message: "Se ha eliminado el registro exitosamente",
                                        type: "success",
                                        showCloseButton: true
                                    });
                                    this.parametrosModal.pestanaSituacionEconomica.datosdeudasycreditos = result.body;
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
