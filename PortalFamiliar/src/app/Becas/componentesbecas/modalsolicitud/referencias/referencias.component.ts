
import {Component, OnInit, Input, Output, EventEmitter, AfterViewInit, AfterContentInit, ChangeDetectorRef} from "@angular/core";
import {AppState} from "app/app.service";
import {FormGroup, FormControl, FormBuilder, Validators} from "@angular/forms";
import {parametrosModal} from "app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud";
import {saveAs as importedSaveAs} from "file-saver";
import {TelefonoService} from "app/Servicios/Telefono.Service";
import {Helpers} from "app/app.helpers";

declare let Messenger: any;

@Component({
    selector: "referencias",
    templateUrl: "referencias.component.html",
    providers: [AppState]
})
export class ReferenciasComponent implements OnInit, AfterViewInit, AfterContentInit {
    @Input() parametrosModal: parametrosModal;
    @Output() output = new EventEmitter();
    @Output() accionGuardar = new EventEmitter();
    accion: boolean;

    sistema: number;
    //mascaras
    public ladaMask = ["(", /[1-9]/, /\d/, ")"];
    public telefonoMask = [/\d/, /\d/, /\d/, /\d/, "-", /\d/, /\d/, /\d/, /\d/];


    Formreferencias: FormGroup;
    submitted: boolean;
    datospersonas: any[] = [];
    persona: boolean = false;

    cambio: boolean;


    Formguardar: FormGroup;
    submitted2: boolean;

    lada1: any;
    ladacontacto: any;
    telefono: any;
    telefonocontacto: any;

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private URLBase: AppState, private _help: Helpers, private _fb: FormBuilder, private cdr: ChangeDetectorRef, public telefonoService: TelefonoService) {
        this.sistema = this._httpService.sistema;
    }

    //Metodo de inicio
    ngOnInit(): void {


        this.Formreferencias = this._fb.group({
            solicitudid: [],
            nombrecompleto: [],
            telefonocelular: ["", Validators.required],
            ladatelefonocelular: [, <any> Validators.compose([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))])],
            telefonofijo: ["", Validators.required],
            ladatelefonofijo: [, <any> Validators.compose([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))])],
            ocupacion: []
        });


        this.Formguardar = this._fb.group({
            solicitudid: [],
            visitaestudiosocioeconomico: []
        });


    }

    ngAfterViewInit() {

        this.Formreferencias.get('ladatelefonocelular').valueChanges.subscribe((lada) => {
            if (lada) {
                let p;
                if (lada.length == 5) {
                    p = '^\\d{3}.\\d{4}$';
                } else {
                    p = '^\\d{4}.\\d{4}$';
                }
                this.Formreferencias.get("telefonocelular").setValidators(Validators.compose([Validators.required, Validators.pattern(new RegExp(p))]));
                this.Formreferencias.get("telefonocelular").updateValueAndValidity();
                this.lada1 = lada;
                let telefono = this.Formreferencias.get('telefonocelular').value;
                if (telefono && telefono.match(p)) {
                    return null;
                } else {
                    return {telefono: false}
                }
            }

        });


        this.Formreferencias.get('ladatelefonofijo').valueChanges.subscribe((lada) => {
            if (lada == "(") {
                this.Formreferencias.get('ladatelefonofijo').setValue(null);
            }
            if (lada && lada != "(") {
                if (this.sistema == 2) {
                    this.Formreferencias.get('ladatelefonofijo').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                    this.Formreferencias.get('ladatelefonofijo').updateValueAndValidity({emitEvent: false});
                }
                let p;
                if (lada.length == 5) {
                    p = '^\\d{3}.\\d{4}$';
                } else {
                    p = '^\\d{4}.\\d{4}$';
                }
                this.Formreferencias.get("telefonofijo").setValidators(Validators.compose([Validators.required, Validators.pattern(new RegExp(p))]));
                this.Formreferencias.get("telefonofijo").updateValueAndValidity({emitEvent: false});
                this.ladacontacto = lada;
                let telefono = this.Formreferencias.get('telefonofijo').value;
                if (telefono && telefono.match(p)) {
                    return null;
                } else {
                    return {telefono: false}
                }

            } else if (!this.Formreferencias.get("telefonofijo").value && this.sistema == 2) {
                this.Formreferencias.get('ladatelefonofijo').setValidators(null);
                this.Formreferencias.get('ladatelefonofijo').updateValueAndValidity({emitEvent: false});
                this.Formreferencias.get('telefonofijo').setValidators(null);
                this.Formreferencias.get('telefonofijo').updateValueAndValidity({onlySelf: true, emitEvent: false});

            } else if (this.sistema == 2 && lada == "") {
                if (this.Formreferencias.get('telefonofijo').value) {
                    this.Formreferencias.get('ladatelefonofijo').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                    this.Formreferencias.get('ladatelefonofijo').updateValueAndValidity({onlySelf: true, emitEvent: false});
                } else {
                    this.Formreferencias.get('ladatelefonofijo').setValidators(null);
                    this.Formreferencias.get('ladatelefonofijo').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }

            }
        });


        this.Formreferencias.get('telefonofijo').valueChanges.subscribe((tel) => {
            let p;
            if (this.sistema == 2) {
                let lada = this.Formreferencias.get('ladatelefonofijo').value;
                if (lada && lada != "(") {
                    this.Formreferencias.get('ladatelefonofijo').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                    this.Formreferencias.get('ladatelefonofijo').updateValueAndValidity({emitEvent: false});

                    if (lada.length == 5) {
                        p = '^\\d{3}.\\d{4}$';
                    } else {
                        p = '^\\d{4}.\\d{4}$';
                    }
                    this.Formreferencias.get("telefonofijo").setValidators(Validators.compose([Validators.required, Validators.pattern(new RegExp(p))]));
                    this.Formreferencias.get("telefonofijo").updateValueAndValidity({emitEvent: false});
                    let telefono = this.Formreferencias.get('telefonofijo').value;
                    if (telefono && telefono.match(p)) {
                        return null;
                    } else {
                        return {telefono: false}
                    }

                }
            }

            if (tel) {
                this.Formreferencias.get('ladatelefonofijo').setValidators(<any> Validators.required);
                this.Formreferencias.get('ladatelefonofijo').updateValueAndValidity({onlySelf: true, emitEvent: false});
            } else {
                if (this.Formreferencias.get('ladatelefonofijo').value) {
                    this.Formreferencias.get('telefonofijo').setValidators(Validators.compose([Validators.required, Validators.pattern(new RegExp(p))]));
                    this.Formreferencias.get('telefonofijo').updateValueAndValidity({onlySelf: true, emitEvent: false});
                } else {
                    this.Formreferencias.get('ladatelefonofijo').setValidators(null);
                    this.Formreferencias.get('ladatelefonofijo').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    this.Formreferencias.get('telefonofijo').setValidators(null);
                    this.Formreferencias.get('telefonofijo').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }
            }

        });



    }

    ngAfterContentInit() {

        if (this.sistema == 2) {
            this.Formreferencias.get('ladatelefonofijo').setValidators(null);
            this.Formreferencias.get('ladatelefonofijo').updateValueAndValidity({emitEvent: false});
            this.Formreferencias.get('telefonofijo').setValidators(null);
            this.Formreferencias.get('telefonofijo').updateValueAndValidity({emitEvent: false});
        }

        this.output.next(this);
        if (this.parametrosModal.pestanaReferencias.datospersonas) {
            this.datospersonas = this.parametrosModal.pestanaReferencias.datospersonas;
        } else {
            this.consultarPersona();
        }
        if (this.parametrosModal.pestanaReferencias.FormGuardar) {
            this.Formguardar.setValue(this.parametrosModal.pestanaReferencias.FormGuardar);
            this.Formguardar.get('visitaestudiosocioeconomico').valueChanges.subscribe(() => {
                this.cambio = true
            });
        } else {
            this.getvisitaestudio();
        }

        this.cdr.detectChanges();
    }

    transformartexto(forname: FormControl) {
        let texto: string = forname.value;
        if (texto) {
            forname.setValue(this.sistema == 1 ? texto.toUpperCase() : this._help.capitalize(texto));
        }
    }


    getvisitaestudio() {
        this._httpService.postElemento("SolicitudBeca/getvisita", {solicitudid: this.parametrosModal.solicitudid},null,true).subscribe(
            res => {
                if (res.status == 200) {
                    this.Formguardar.get("visitaestudiosocioeconomico").setValue(
                        res.body[0] ? res.body[0].v_visitaestudiosocioeconomico : null
                    );
                    this.parametrosModal.pestanaReferencias.FormGuardar = this.Formguardar.value;

                }
                this.Formguardar.get('visitaestudiosocioeconomico').valueChanges.subscribe(() => {
                    this.cambio = true
                });
            },
            err => {
                //handle your error here.
                console.log(err);
            }
        );
    }


    removepersona() {
        this.Formreferencias.reset();
        this.submitted2 = false;
        this.persona = false;
    }

    consultarPersona() {
        this._httpService.postElemento("SolicitudBeca/Getreferencias", {solicitudid: this.parametrosModal.solicitudid},null,true).subscribe(
            res => {
                if (res.status == 200) {
                    this.datospersonas = res.body;
                    this.parametrosModal.pestanaReferencias.datospersonas = this.datospersonas;
                } else {
                    this.parametrosModal.pestanaReferencias.datospersonas = null;
                    this.datospersonas = []
                }
            },
            err => {
                //handle your error here.
                console.log(err);
            }
        );
    }

    savePersona() {
        if (this.Formreferencias.get("telefonocelular").value == "" && this.sistema != 2 || this.Formreferencias.get("telefonocelular").value == null && this.sistema != 2) {
            this.Formreferencias.get('telefonocelular').setValidators(<any> Validators.required);
            this.Formreferencias.get('telefonocelular').updateValueAndValidity();
        }
        if (this.Formreferencias.get("telefonofijo").value == "" && this.sistema != 2 || this.Formreferencias.get("telefonofijo").value == null && this.sistema != 2) {
            this.Formreferencias.get('telefonofijo').setValidators(<any> Validators.required);
            this.Formreferencias.get('telefonofijo').updateValueAndValidity();
        } else if (this.Formreferencias.get("telefonofijo").value == "" && this.sistema == 2 || this.Formreferencias.get("telefonofijo").value == null && this.sistema == 2) {
            this.Formreferencias.get('telefonofijo').setValidators(null);
            this.Formreferencias.get('telefonofijo').updateValueAndValidity();
        }

        if (this.Formreferencias.get("ladatelefonofijo").value == "" && this.sistema == 2 || this.Formreferencias.get("ladatelefonofijo").value == null && this.sistema == 2) {
            this.Formreferencias.get('ladatelefonofijo').setValidators(null);
            this.Formreferencias.get('ladatelefonofijo').updateValueAndValidity();
        }

        this.submitted2 = true;
        if (this.Formreferencias.invalid) {
            return false;
        }
        this.Formreferencias.get("solicitudid").setValue(
            this.parametrosModal.solicitudid
        );


        this._httpService.postElemento( "SolicitudBeca/GuardarReferencias",this.Formreferencias.value,null,true
        ).subscribe(
            res => {
                if (res.status == 200) {
                    this.consultarPersona();
                    this.removepersona();
                    Messenger().post({
                        message: "Se ha guardado con éxito el registro",
                        type: "success",
                        showCloseButton: true
                    });
                } else {
                    Messenger().post({
                        message: "ya existe fondo de orfandad",
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

    deletePersona(h) {
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
                        var id = h.pr_personareferenciaid;
                        this._httpService.deleteElemento("SolicitudBeca/eliminarRef", id).subscribe(
                            result => {
                                if (result.status == 200) {
                                    this.consultarPersona();
                                    Messenger().post({
                                        message: "El registro se ha eliminado con éxito",
                                        type: "success",
                                        showCloseButton: true
                                    });
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

    guardar() {
        this.submitted = true;
        if (this.datospersonas.length < 3) {
            Messenger().post({
                message: "Debe introducir un minimo de 3 referencias",
                type: "success",
                showCloseButton: true
            });
            return false;
        }
        if (this.Formguardar.invalid) {
            return false;
        }

        this.guardarpeticion().then(() => {
            this.accionGuardar.next(true);
        });
    }

    guardarpeticion(): Promise<any> {
        var promise = new Promise((result, reject) => {
            this.Formguardar.get("solicitudid").setValue(
                this.parametrosModal.solicitudid
            );

            this._httpService.postElemento("SolicitudBeca/visitaestudios", this.Formguardar.value,null,true).subscribe(
                res => {
                    if (res.status == 200) {
                        this.parametrosModal.pestanaReferencias.datospersonas = this.datospersonas;
                        this.parametrosModal.pestanaReferencias.FormGuardar = this.Formguardar.value;

                        Messenger().post({
                            message: "Se ha guardado sección referencias",
                            type: "success",
                            showCloseButton: true
                        });

                        result();

                    } else {
                        Messenger().post({
                            message: res.body,
                            type: "success",
                            showCloseButton: true
                        });

                        reject();
                    }
                },
                err => {
                    //handle your error here.
                    console.log(err);
                    reject();
                }
            );
        });

        return promise;

    }

    descargarReglamento() {
        this._httpService.getArchivo("Becas/PeriodoBeca/formato/descargar/reglamento", this.parametrosModal.solicitudid).subscribe(
            result => {
                if (result.status == 200) {
                    importedSaveAs(result.body, "reglamento");

                } else {
                    Messenger().post({
                        message: result.body,
                        type: "success",
                        showCloseButton: true
                    });
                }
            },
            error => {
                var errorMessage = <any> error;
                Messenger().post({
                    message: "No se pudo comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
        );
    }

    descargarSolicitud() {
        this.submitted = true;
        if (this.datospersonas.length < 3) {
            Messenger().post({
                message: "Debe introducir un mnimo de 3 referencias",
                type: "success",
                showCloseButton: true
            });
            return false;
        }
        if (this.Formguardar.invalid) {
            return false;
        }

        if (!this.cambio) {
            this.descargar();
            return false;
        }
        this.guardarpeticion().then(() => {
            this.cambio = false;
            this.descargar();

        });

    }

    descargar() {
        this._httpService.getArchivo("Solicitud/DownloadFormatoSolicitudBeca/?solicitudid=" + this.parametrosModal.solicitudid + "&tipoformatoid=10&tipo=" + this.URLBase.sistema, null).subscribe(
            result => {
                if (result.status == 200) {
                    importedSaveAs(result.body, "solicitud");
                } else {
                    Messenger().post({
                        message: result.body,
                        type: "success",
                        showCloseButton: true
                    });
                }
            },
            error => {
                var errorMessage = <any> error;
                Messenger().post({
                    message: "No se pudo comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
        );
    }
}
