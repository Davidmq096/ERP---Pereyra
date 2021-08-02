import {Component, OnInit, Input, Output, EventEmitter} from "@angular/core";
import {AppState} from "app/app.service";
import {FormGroup, FormControl, FormBuilder, Validators} from "@angular/forms";
import {parametrosModal} from './../../modal/modalsolicitud';
import {Helpers} from "app/app.helpers";

declare let Messenger: any;

@Component({
    selector: "inmueble",
    templateUrl: "inmueble.component.html",
    providers: [AppState]
})
export class InmuebleComponent implements OnInit {
    @Input() sistema: any;
    @Input() editable: boolean;
    @Input() solicitudid: number;
    @Input() selectestatusinmueble: any;
    @Input() datospropiedades: any[];
    @Input() numberMask;
    @Output() output = new EventEmitter();
    @Input() parametrosModal: parametrosModal;

    nuevo: any = false;
    forminmueble: FormGroup;
    submitted: boolean;
    estatus: any;


    //En el contructor se declara la llamada a los servicios
    constructor(private URLBase: AppState, private _httpService: AppState, private _help: Helpers, private _fb: FormBuilder) {
    }

    ngOnInit(): void {
        this.forminmueble = this._fb.group({
            ubicacion: [, <any> Validators.required],
            mtsterreno: [, <any> Validators.required],
            mtsconstruccion: [, <any> Validators.required],
            solicitudid: [this.solicitudid],
            tipopropiedad: [, <any> Validators.required],
            estatusid: [, <any> Validators.required],
            valoraproximado: [, <any> Validators.required],
            propiedadanombrede: [, <any> Validators.required],
            creditoanombrede: [, <any> Validators.required],
            domicilioactual: [false],
            portal: 1
        });

        this.forminmueble.get('domicilioactual').valueChanges.subscribe((domicilio) => {
            if (domicilio && this.sistema == 2) {
                this.forminmueble.get('ubicacion').setValidators(null);
                this.forminmueble.get('ubicacion').updateValueAndValidity();
            } else {
                this.forminmueble.get('ubicacion').setValidators(<any> Validators.required);
                this.forminmueble.get('ubicacion').updateValueAndValidity();
            }

        })
    }

    transformartexto(forname: FormControl) {
        let texto: string = forname.value;
        if (texto) {
            forname.setValue(this.sistema == 1 ? texto.toUpperCase() : this._help.capitalize(texto));
        }
    }


    removeinmueble() {
        this.submitted = false;
        this.nuevo = false;
        this.estatus = null;
        this.forminmueble.reset({solicitudid: this.solicitudid, portal: 1});
    }

    validaEstatus() {
        this.estatus = this.forminmueble.get("estatusid").value;
        if (this.estatus == 1 || this.estatus ==3) {
            this.forminmueble.controls["creditoanombrede"].setValue(null);
            this.forminmueble.controls["propiedadanombrede"].setValidators(Validators.required);
            this.forminmueble.controls["propiedadanombrede"].updateValueAndValidity();

            this.forminmueble.controls["creditoanombrede"].setValidators(null);
            this.forminmueble.controls["creditoanombrede"].updateValueAndValidity();
        }
        else {
            this.forminmueble.controls["propiedadanombrede"].setValue(null);
            this.forminmueble.controls["creditoanombrede"].setValidators(Validators.required);
            this.forminmueble.controls["creditoanombrede"].updateValueAndValidity();

            this.forminmueble.controls["propiedadanombrede"].setValidators(null);
            this.forminmueble.controls["propiedadanombrede"].updateValueAndValidity();
        }
    }

    guardarInmueble() {
        if (this.sistema == 2) {
            this.forminmueble.get('mtsconstruccion').setValidators(null);
            this.forminmueble.get('mtsconstruccion').updateValueAndValidity();
        }
        this.submitted = true;
        if (this.forminmueble.invalid) {
            return false;
        }

        this._httpService.postElemento("Becas/SolicitudBeca/SituacionEconomica/Propiedadesfamiliares", this.forminmueble.value,null,true).subscribe(
            res => {
                if (res.status == 200) {
                    this.removeinmueble();
                    this.datospropiedades = res.body;
                    Messenger().post({
                        message: "Se ha guardado el registro con éxito",
                        type: "success",
                        showCloseButton: true
                    });
                    this.parametrosModal.pestanaSituacionEconomica.datospropiedades = res.body;
                    this.output.next(this.datospropiedades);
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
                //console.log(err);
            }
        );
    }

    deletePropiedad(c) {
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
                        var id = c.propiedadfamiliaid;
                        this._httpService.deleteElemento("Becas/SolicitudBeca/SituacionEconomica/Propiedadesfamiliares", id).subscribe(
                            result => {
                                if (result.status == 200) {
                                    this.datospropiedades = result.body
                                    Messenger().post({
                                        message: "Se ha eliminado el registro exitosamente",
                                        type: "success",
                                        showCloseButton: true
                                    });
                                    this.parametrosModal.pestanaSituacionEconomica.datospropiedades = result.body;
                                    this.output.next(this.datospropiedades);
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
