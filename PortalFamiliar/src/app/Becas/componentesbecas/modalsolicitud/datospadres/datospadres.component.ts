import {Component, OnInit, AfterViewInit, AfterContentInit, Input, Output, EventEmitter, ViewChildren, ViewContainerRef, QueryList} from "@angular/core";
import {AppState} from "app/app.service";
import {Router} from "@angular/router";
import {FormGroup, FormBuilder, Validators, FormArray} from "@angular/forms";
import {Helpers} from "app/app.helpers";
import {parametrosModal} from "app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud";
import {PadreoTutorModel} from './../../../../../entity/Models/PadreoTutorModel';
declare let Messenger: any;
declare let $: any;

@Component({
    selector: "datospadres",
    templateUrl: "datospadres.component.html",
    providers: [AppState]
})

export class DatosPadresComponent implements OnInit, AfterViewInit, AfterContentInit {
    accion: boolean;
    cambio: boolean = false;
    cargado: any;
    /*parametros*/
    @Input() parametrosModal: parametrosModal;
    @Output() output = new EventEmitter();
    @ViewChildren('padres') padrecomponete;
    @Output() accionGuardar = new EventEmitter();

    //Indica si se deben validar los campos de los papas
    submitted: boolean;
    Formpadres: FormGroup;
    Formpersonaaporta: FormGroup;
    aporta: any[];
    selectParentesco: any[];
    inicia: boolean = false;

    idvive: number = 0;


    //variable que almacena el select del estado civil y "padres viven"
    estadocivil: any[];
    escolaridad: any[];

    otromas: any;
    newpersona: number = 0;

    padresviven = [{id: 1, nombre: "Juntos"}, {id: 2, nombre: "Separados"}];

    //variable que indica la situacin familiar actual
    situacionfamiliar: number;
    persona: any;
    lada2: any;

    origen: any;
    //varibale para guardar los padres
    padres: Array<any> = [];

    //variable para identificar el sistema; 1 = lux, 2 = ciencias
    sistema: number;

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private _fb: FormBuilder, private _router: Router, private _help: Helpers, ) {
        this.sistema = this._httpService.sistema;
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.aporta = [{id: 1, nombre: "No"}, {id: 2, nombre: "Si"}];
        this.persona = 1;
        this.Formpadres = this._fb.group({
            padres: this._fb.array([]),
            otro: this._fb.array([]),
            personaaporta: 1,
            situacionfamiliarid: []
        });

        this.Formpadres.get("personaaporta").setValidators(null);
        this.Formpadres.get("personaaporta").updateValueAndValidity();
        if (!this.parametrosModal.pestanapadres.datos.padres && !this.parametrosModal.pestanapadres.estadocivil) {
            this.getpadres();
            this.getestadocicvil();
        }
        else {
            for (let padre of this.parametrosModal.pestanapadres.datos.padres) {
                if (padre.tutorid && padre.tutorid.descripcion) {
                    padre.parentesco = padre.tutorid.descripcion;
                }
                if (padre.parentesco && !padre.parentescoid) {
                    this.padres.push(padre);
                }
                if (padre.parentescoid && !padre.parentesco) {
                    for (let parentesco of this.parametrosModal.pestanapadres.selectParentesco) {

                        if (parentesco.parentescoid == padre.parentescoid.parentescoid) {
                            padre.parentesco = parentesco.descripcion;
                        }
                    }
                }
                if (padre.parentescoid) {
                    this.padres.push(padre);
                }
            }
            //
            this.Formpadres.reset();
            let situacion = this.parametrosModal.pestanapadres.datos.situacionfamiliar;
            if (situacion && situacion.situacionfamiliarid) {
                this.Formpadres.get("situacionfamiliarid").setValue(situacion.situacionfamiliarid);
            } else {
                this.Formpadres.get("situacionfamiliarid").setValue(situacion);
            }
            let b = this.Formpadres.get("padres") as FormArray;
            let padre = (this.parametrosModal.pestanapadres.datos.padres as any);
            padre.forEach((element) => {
                b.push(this.valores(element));
            });
            this.estadocivil = this.parametrosModal.pestanapadres.estadocivil;
            this.escolaridad = this.parametrosModal.pestanapadres.escolaridad;
            this.selectParentesco = this.parametrosModal.pestanapadres.selectParentesco;
            this.Formpadres.get("personaaporta").setValue(1);
            this.Formpadres.get("personaaporta").setValidators(null);
            this.Formpadres.get("personaaporta").updateValueAndValidity();
            this.contentLoaded();
        }
        this.inicia = true;
    }

    ngAfterViewInit() {



    }

    ngAfterContentInit() {
        this.output.next(this);
    }

    contentLoaded() {
        setTimeout(() => {
            this.Formpadres.valueChanges.subscribe(() => {
                this.cambio = true;
            });
        }, 0);
    }



    //-- método que obtiene los datos de los padres que ya fueron capturados; máximo 2 padres o tutores --
    getpadres() {
        this._httpService
            .getElemento("Becas/PadresOTutoresAlumno/" + this.parametrosModal.solicitudid)
            .subscribe(
            res => {
                if (res.status == 200) {
                    //Set datos
                    this.selectParentesco = res.body.parentesco;
                    this.parametrosModal.pestanapadres.selectParentesco = res.body.parentesco;
                    let b = this.Formpadres.get("padres") as FormArray;
                    let padre = res.body.padres;
                    this.origen = res.body.origen;
                    padre.forEach((element) => {
                        b.push(this.valores(element));
                    });

                    for (let padre of res.body.padres) {
                        if (padre.parentesco) {
                            this.padres.push(new PadreoTutorModel(padre, this.sistema));
                        }
                    }

                    if (res.body.situacionfamiliarid && res.body.situacionfamiliarid.situacionfamiliarid) {
                        this.Formpadres.get("situacionfamiliarid").setValue(res.body.situacionfamiliarid.situacionfamiliarid);

                    } else if (res.body.situacionfamiliarid) {
                        this.Formpadres.get("situacionfamiliarid").setValue(res.body.situacionfamiliarid);
                    } else {
                        this.Formpadres.get("situacionfamiliarid").setValue(res.body.padres.length == 2 ? res.body.situacionfamiliarid : null);
                    }



                    //Set datos a parametros modal

                    this.parametrosModal.pestanapadres.datos.padres = res.body.padres;
                    this.parametrosModal.pestanapadres.datos.situacionfamiliar = this.Formpadres.get("situacionfamiliarid").value;
                    this.cargado = true;

                    //Verificar cuando cambie este valor
                    this.contentLoaded();

                }
                else {
                    this.padres = [];
                    Messenger().post({
                        message: res.body,
                        type: "success",
                        showCloseButton: true
                    });
                }
            },
            err => {
                this.padres = [];
                Messenger().post({
                    message: "No se puede comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
            );
    }

    /**método que contiene la petición para aobtener los estados civiles */
    getestadocicvil() {
        this._httpService.getElemento("SolicitudBeca/estadocivil").subscribe(
            result => {
                if (result.status == 200) {
                    this.escolaridad = result.body.escolaridad;
                    this.estadocivil = result.body.SituacionConyugal;
                    this.parametrosModal.pestanapadres.estadocivil = result.body.SituacionConyugal;
                    this.parametrosModal.pestanapadres.escolaridad = result.body.escolaridad;
                }
                else {
                    this.estadocivil = [];
                    Messenger().post(
                        {
                            message: result.body,
                            type: "success",
                            showCloseButton: true
                        });
                }
            },
            error => {
                this.estadocivil = [];
                Messenger().post({
                    message: "No se pudo comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
        );
    }


    //-- Método que guarda la información de los padres --
    guardar() {
        this.submitted = true;
        if (this.sistema == 1 && this.Formpadres.get("personaaporta").value == null) {
            return false;
        }

        if (this.padres.length >= 2) {
            this.Formpadres.get("situacionfamiliarid").setValidators(Validators.required);
            this.Formpadres.get("situacionfamiliarid").updateValueAndValidity({emitEvent: false});
        } else {
            this.Formpadres.get("situacionfamiliarid").setValidators(null);
            this.Formpadres.get("situacionfamiliarid").updateValueAndValidity({emitEvent: false});
        }

        //this.Formpadres.get("padres").get("telempresa").setValue(this._help.UnitTelefono(padre.ladatelempresa, padre.telempresatemp));
        if (this.Formpadres.invalid) {
            Messenger().post(
                {
                    message: 'Completa correctamente todos los datos.',
                    type: 'success',
                    showCloseButton: true
                });

            return false;
        }

        if (this.origen == "ce") {
            this.cambio = true;
        }

        //-- verificar si hubo un cambio
        if (!this.cambio) {
            this.accionGuardar.next(true);
            return false;
        }


        let padres = this.Formpadres.getRawValue();
        (this.Formpadres.get('padres') as FormArray).controls = []
        let b = this.Formpadres.get("padres") as FormArray;
        if (padres.padres) {
            (padres.padres as any[]).forEach((element) => {
                let datos = this._fb.group({
                    parentescoid: element.parentescoid ? element.parentescoid : null,
                    antiguedad: element.antiguedad ? element.antiguedad : null,
                    celtemp: element.celtemp ? element.celtemp : null,
                    celular: element.celular ? element.celular : null,
                    disabled: element.disabled ? element.disabled : false,
                    domicilioempresa: element.domicilioempresa ? element.domicilioempresa : null,
                    empresa: element.empresa ? element.empresa : null,
                    escolaridadid: element.escolaridadid ? element.escolaridadid : null,
                    especificacionocupacion: element.especificacionocupacion ? element.especificacionocupacion : null,
                    extensionempresa: element.extensionempresa ? element.extensionempresa : null,
                    fechanacimiento: this.sistema == 1 ? (this._help.FechaObjetoToString(element.fechanacimiento.date)) : null,
                    horariotrabajo: element.horariotrabajo ? element.horariotrabajo : null,
                    idvive: element.idvive ? element.idvive : null,
                    ladacelular: element.ladacelular ? element.ladacelular : null,
                    ladatelempresa: element.ladatelempresa ? element.ladatelempresa : null,
                    nombre: element.nombre ? element.nombre : null,
                    nombrejefeinmediato: element.nombrejefeinmediato ? element.nombrejefeinmediato : null,
                    ocupacion: element.ocupacion ? element.ocupacion : null,
                    padresotutoresid: element.padresotutoresid ? element.padresotutoresid : null,
                    parentesco: element.parentesco ? element.parentesco : null,
                    tutorid: element.tutorid ? element.tutorid : null,
                    ramo: element.ramo ? element.ramo : null,
                    situacionconyugalid: element.situacionconyugalid ? element.situacionconyugalid : null,
                    solicitudid: element.solicitudid ? element.solicitudid : null,
                    telempresa: element.telempresa ? element.telempresa : null,
                    telempresatemp: element.telempresatemp ? element.telempresatemp : null,
                    vive: element.vive ? element.vive : null,
                });
                b.push(datos);
            });
        }


        if (padres.otro) {
            (padres.otro as any[]).forEach((element) => {
                let datos = this._fb.group({
                    parentescoid: [element.parentescoid ? element.parentescoid : null, <any> Validators.required],
                    antiguedad: element.antiguedad ? element.antiguedad : null,
                    celtemp: element.celtemp ? element.celtemp : null,
                    celular: element.celular ? element.celular : null,
                    disabled: element.disabled ? element.disabled : false,
                    domicilioempresa: element.domicilioempresa ? element.domicilioempresa : null,
                    empresa: element.empresa ? element.empresa : null,
                    escolaridadid: element.escolaridadid ? element.escolaridadid : null,
                    especificacionocupacion: element.especificacionocupacion ? element.especificacionocupacion : null,
                    extensionempresa: element.extensionempresa ? element.extensionempresa : null,
                    fechanacimiento: this.sistema == 1 ? (this._help.FechaObjetoToString(element.fechanacimiento.date)) : null,
                    horariotrabajo: element.horariotrabajo ? element.horariotrabajo : null,
                    idvive: element.idvive ? element.idvive : null,
                    ladacelular: element.ladacelular ? element.ladacelular : null,
                    ladatelempresa: element.ladatelempresa ? element.ladatelempresa : null,
                    nombre: element.nombre ? element.nombre : null,
                    nombrejefeinmediato: element.nombrejefeinmediato ? element.nombrejefeinmediato : null,
                    ocupacion: element.ocupacion ? element.ocupacion : null,
                    padresotutoresid: element.padresotutoresid ? element.padresotutoresid : null,
                    parentesco: element.parentesco ? element.parentesco : null,
                    tutorid: element.tutorid ? element.tutorid : null,
                    ramo: element.ramo ? element.ramo : null,
                    situacionconyugalid: element.situacionconyugalid ? element.situacionconyugalid : null,
                    solicitudid: element.solicitudid ? element.solicitudid : null,
                    telempresa: element.telempresa ? element.telempresa : null,
                    telempresatemp: element.telempresatemp ? element.telempresatemp : null,
                    vive: element.vive ? element.vive : null,
                });
                b.push(datos);
            });
        }
        var datos = {
            sistema: this.sistema,
            situacionfamiliarid: this.Formpadres.get("situacionfamiliarid").value,
            padres: b.value,
            clavefamiliarid: this.parametrosModal.clavefamiliarid,
            origen: this.origen
        };

        this.submitted = false;
        this._httpService.postElemento("SolicitudBeca/GuardarPadrestutores", datos, null, true).subscribe(res => {
            if (res.status == 200) {
                this.parametrosModal.pestanapadres.datos.padres = res.body.padres;
                let b = this.Formpadres.get("padres") as FormArray;
                let padre = res.body.padres;
                padre.forEach((element) => {
                    b.push(this.valores(element));
                });
                this.parametrosModal.pestanapadres.datos.situacionfamiliar = res.body.situacionfamiliarid;
                this.accionGuardar.next(true);
            }
            else {
                Messenger().post({
                    message: "No se pudo guardar la información. Intenta de nuevo más tarde.",
                    type: 'success',
                    showCloseButton: true
                });
            }
        },
            error => {
                Messenger().post(
                    {
                        message: 'No se puedo comunicar con el servidor.',
                        type: 'success',
                        showCloseButton: true
                    });
            });
    }



    valores(padre: any): FormGroup {
        this.idvive++;
        if (padre.escolaridadid && padre.escolaridadid.escolaridadid) {
            padre.escolaridadid = padre.escolaridadid.escolaridadid;
        }

        if (padre.situacionconyugalid && padre.situacionconyugalid.situacionconyugalid) {
            padre.situacionconyugalid = padre.situacionconyugalid.situacionconyugalid;
        }

        let fecha = this._help.FechaToStringObjeto(padre.fechanacimiento);
        let datos = this._fb.group({
            parentescoid: [padre.parentescoid ? padre.parentescoid : null, <any> Validators.required],
            fechanacimiento: this.sistema == 1 ? ([fecha ? {date: fecha} : null, <any> Validators.required]) : null,
            padresotutoresid: [padre.padresotutoresid ? padre.padresotutoresid : null],
            parentesco: padre.parentesco ? padre.parentesco : padre.tutor ? padre.tutor : null,
            tutorid: [padre.tutorid ? padre.tutorid : null],
            nombre: padre.nombre ? padre.nombre : null,
            vive: [padre.vive, <any> Validators.required],
            ladacelular: [padre.celular ? this._help.ParseTelefono(padre.celular)[0] : null, <any> Validators.compose([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))])],
            celular: [padre.celular ? this._help.UnitTelefono(this._help.ParseTelefono(padre.celular)[0], this._help.ParseTelefono(padre.celular)[1]) : null],
            situacionconyugalid: [padre.situacionconyugalid ? padre.situacionconyugalid : null],
            especificacionocupacion: padre.especificacionocupacion ? padre.especificacionocupacion : null,
            ramo: padre.puesto ? padre.puesto : padre.ramo ? padre.ramo : null,
            empresa: padre.empresa ? padre.empresa : null,
            horariotrabajo: padre.horariotrabajo ? padre.horariotrabajo : null,
            antiguedad: padre.antiguedad ? padre.antiguedad : null,
            ladatelempresa: [padre.telempresa ? this._help.ParseTelefono(padre.telempresa)[0] : null],
            telempresa: [padre.telempresa ? this._help.UnitTelefono(this._help.ParseTelefono(padre.telempresa)[0], this._help.ParseTelefono(padre.telempresa)[1]) : null],
            telempresatemp: padre.telempresa ? this._help.ParseTelefono(padre.telempresa)[1] : null,
            extensionempresa: padre.extensionempresa ? padre.extensionempresa : null,
            ocupacion: padre.ocupacion ? padre.ocupacion : null,
            nombrejefeinmediato: padre.nombrejefeinmediato ? padre.nombrejefeinmediato : null,
            domicilioempresa: padre.domicilioempresa ? padre.domicilioempresa : null,
            celtemp: [padre.celular ? this._help.ParseTelefono(padre.celular)[1] : null, <any> Validators.required],
            disabled: true,
            solicitudid: this.parametrosModal.solicitudid ? this.parametrosModal.solicitudid : null,
            escolaridadid: padre.escolaridadid ? padre.escolaridadid : null,
            idvive: this.idvive
        });

        datos.get('vive').valueChanges.subscribe((vive: boolean) => {
            if (!vive) {
                datos.get("ladacelular").setValidators(null);
                datos.get("ladacelular").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("celtemp").setValidators(null);
                datos.get("celtemp").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("situacionconyugalid").setValidators(null);
                datos.get("situacionconyugalid").updateValueAndValidity({onlySelf: true, emitEvent: false});

                if (this.sistema == 1) {
                    datos.get("ocupacion").setValidators(null);
                    datos.get("ocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false})
                }

                datos.get("especificacionocupacion").setValidators(null);
                datos.get("especificacionocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("ramo").setValidators(null);
                datos.get("ramo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("empresa").setValidators(null);
                datos.get("empresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("horariotrabajo").setValidators(null);
                datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("antiguedad").setValidators(null);
                datos.get("antiguedad").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("escolaridadid").setValidators(null);
                datos.get("escolaridadid").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("nombrejefeinmediato").setValidators(null);
                datos.get("nombrejefeinmediato").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("domicilioempresa").setValidators(null);
                datos.get("domicilioempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});

                if (datos.get("ladatelempresa").value || datos.get("telempresatemp").value) {
                    var p;
                    if (datos.get("ladatelempresa").value.length == 4) {
                        p = '\\d{4}.\\d{4}';
                    } else if (datos.get("ladatelempresa").value.length == 5) {
                        p = '\\d{3}.\\d{4}';
                    } else {
                        p = '\\d{10}.\\d{10}';
                    }
                    datos.get('ladatelempresa').setValidators(null);
                    datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                    datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                } else {
                    datos.get('ladatelempresa').setValidators(null);
                    datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get('telempresatemp').setValidators(null);
                    datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get('extensionempresa').setValidators(null);
                    datos.get('extensionempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }

            } else {
                if (datos.get("ocupacion").value == "Económicamente activo" || this.sistema == 2) {
                    if (this.sistema == 1) {
                        datos.get("escolaridadid").setValidators(Validators.required);
                        datos.get("escolaridadid").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("nombrejefeinmediato").setValidators(Validators.required);
                        datos.get("nombrejefeinmediato").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("domicilioempresa").setValidators(Validators.required);
                        datos.get("domicilioempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("horariotrabajo").setValidators(null);
                        datos.get("horariotrabajo").updateValueAndValidity();
                    }

                    datos.get("especificacionocupacion").setValidators(Validators.required);
                    datos.get("especificacionocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get("ramo").setValidators(Validators.required);
                    datos.get("ramo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get("empresa").setValidators(Validators.required);
                    datos.get("empresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                    if (this.sistema == 2) {
                        datos.get("horariotrabajo").setValidators(Validators.required);
                        datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                    }
                    datos.get("antiguedad").setValidators(Validators.required);
                    datos.get("antiguedad").updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                    datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }


                if (this.sistema == 1) {
                    datos.get("ocupacion").setValidators(Validators.required);
                    datos.get("ocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false})
                }
                datos.get("situacionconyugalid").setValidators(Validators.required);
                datos.get("situacionconyugalid").updateValueAndValidity({onlySelf: true, emitEvent: false});

                datos.get('ladacelular').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});


                if (datos.get("ladacelular").value) {

                    var p;
                    if (datos.get("ladacelular").value.length == 4) {
                        p = '\\d{4}.\\d{4}';
                    } else if (datos.get("ladacelular").value.length == 5) {
                        p = '\\d{3}.\\d{4}';
                    } else {
                        p = '\\d{10}.\\d{10}';
                    }
                    datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                    datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                } else {
                    p = '\\d{10}.\\d{10}';
                    datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                    datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }

                if (datos.get("ladatelempresa").value) {
                    var p;
                    if (datos.get("ladatelempresa").value.length == 4) {
                        p = '\\d{4}.\\d{4}';
                    } else if (datos.get("ladatelempresa").value.length == 5) {
                        p = '\\d{3}.\\d{4}';
                    } else {
                        p = '\\d{10}.\\d{10}';
                    }
                    datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                    datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                } else {
                    p = '\\d{10}.\\d{10}';
                    datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                    datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }

                if (this.sistema == 1) {
                    datos.get("ocupacion").setValidators(Validators.required);
                    datos.get("ocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                }

                if (this.sistema == 2) {
                    datos.get("ladatelempresa").setValidators(null);
                    datos.get("ladatelempresa").updateValueAndValidity({emitEvent: false});
                    datos.get("telempresatemp").setValidators(null);
                    datos.get("telempresatemp").updateValueAndValidity({emitEvent: false});
                    datos.get("ramo").setValidators(null);
                    datos.get("ramo").updateValueAndValidity({emitEvent: false});
                    datos.get("empresa").setValidators(null);
                    datos.get("empresa").updateValueAndValidity({emitEvent: false});
                    datos.get("horariotrabajo").setValidators(null);
                    datos.get("horariotrabajo").updateValueAndValidity({emitEvent: false});
                    datos.get("antiguedad").setValidators(null);
                    datos.get("antiguedad").updateValueAndValidity({emitEvent: false});
                }

            }
        });

        datos.get('ladacelular').valueChanges.subscribe((lada) => {
            if (lada == "(") {
                datos.get('ladacelular').setValue(null);
            }
            if (datos.get("ladacelular").value && datos.get("celtemp").value) {
                datos.get("celular").setValue(this._help.UnitTelefono(datos.get("ladacelular").value, datos.get("celtemp").value));
            } else {
                datos.get("celular").setValue(null);
            }
            let p;

            if (lada && lada != "(") {
                datos.get('ladacelular').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                datos.get("ladacelular").updateValueAndValidity({onlySelf: true, emitEvent: false});
                if (lada && lada.length == 4) {
                    p = '\\d{4}.\\d{4}';
                } else if (lada && lada.length == 5) {
                    p = '\\d{3}.\\d{4}';
                } else {
                    p = '\\d{10}.\\d{10}';
                }
                datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});


            } else if (!datos.get("celtemp").value) {
                datos.get('ladacelular').setValidators(null);
                datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get('celtemp').setValidators(null);
                datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
            } else {
                datos.get('ladacelular').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});
            }

        });

        datos.get('celtemp').valueChanges.subscribe((cel) => {
            if (datos.get("ladacelular").value && datos.get("celtemp").value) {
                datos.get("celular").setValue(this._help.UnitTelefono(datos.get("ladacelular").value, datos.get("celtemp").value));
            } else {
                datos.get("celular").setValue(null);
            }
            let p;
            let lada = datos.get("ladacelular").value;
            if (lada && lada.length == 4) {
                p = '\\d{4}.\\d{4}';
            } else if (lada && lada.length == 5) {
                p = '\\d{3}.\\d{4}';
            } else {
                p = '\\d{10}.\\d{10}';
            }
            if (cel) {
                datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get('ladacelular').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});
            } else if (!datos.get("ladacelular").value) {
                datos.get('ladacelular').setValidators(null);
                datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get('celtemp').setValidators(null);
                datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
            } else {
                datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
            }
        });

        datos.get('telempresatemp').valueChanges.subscribe((cel) => {
            if (cel && datos.get("ladatelempresa").value) {
                datos.get("telempresa").setValue(this._help.UnitTelefono(datos.get("ladatelempresa").value, datos.get("telempresatemp").value));
            } else {
                datos.get("telempresa").setValue(null);
            }
            let p;
            let lada = datos.get("ladatelempresa").value;
            if (lada && lada.length == 4) {
                p = '\\d{4}.\\d{4}';
            } else if (lada && lada.length == 5) {
                p = '\\d{3}.\\d{4}';
            } else {
                p = '\\d{10}.\\d{10}';
            }
            if (cel) {
                datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
            }
            else if (!datos.get('ladatelempresa').value) {
                datos.get('ladatelempresa').setValidators(null);
                datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get('telempresatemp').setValidators(null);
                datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
            } else {
                datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
            }
        });

        datos.get('ocupacion').valueChanges.subscribe((ocupacion) => {
            if (ocupacion == "Económicamente activo" && datos.get('vive').value) {
                if (this.sistema == 1) {
                    datos.get("escolaridadid").setValidators(Validators.required);
                    datos.get("escolaridadid").updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get("nombrejefeinmediato").setValidators(Validators.required);
                    datos.get("nombrejefeinmediato").updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get("domicilioempresa").setValidators(Validators.required);
                    datos.get("domicilioempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get("horariotrabajo").setValidators(null);
                    datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                }

                datos.get("especificacionocupacion").setValidators(Validators.required);
                datos.get("especificacionocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("ramo").setValidators(Validators.required);
                datos.get("ramo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("empresa").setValidators(Validators.required);
                datos.get("empresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("antiguedad").setValidators(Validators.required);
                datos.get("antiguedad").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
            }
            else {
                datos.get("especificacionocupacion").setValidators(null);
                datos.get("especificacionocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("ramo").setValidators(null);
                datos.get("ramo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("empresa").setValidators(null);
                datos.get("empresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("horariotrabajo").setValidators(null);
                datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("antiguedad").setValidators(null);
                datos.get("antiguedad").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("escolaridadid").setValidators(null);
                datos.get("escolaridadid").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("nombrejefeinmediato").setValidators(null);
                datos.get("nombrejefeinmediato").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("extensionempresa").setValidators(null);
                datos.get("extensionempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get("domicilioempresa").setValidators(null);
                datos.get("domicilioempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get('ladatelempresa').setValidators(null);
                datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get('telempresatemp').setValidators(null);
                datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
            }
        });

        datos.get('ladatelempresa').valueChanges.subscribe((lada) => {
            if (lada == "(") {
                datos.get('ladatelempresa').setValue(null);
            }
            if (datos.get("ladatelempresa").value && datos.get("telempresatemp").value) {
                datos.get("telempresa").setValue(this._help.UnitTelefono(datos.get("ladatelempresa").value, datos.get("telempresatemp").value))
            } else {
                datos.get("telempresa").setValue(null);
            }
            let p;
            if (lada && lada != "(") {
                datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                datos.get("ladatelempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                if (lada.length == 4) {
                    p = '\\d{4}.\\d{4}';
                } else if (lada.length == 5) {
                    p = '\\d{3}.\\d{4}';
                } else {
                    p = '\\d{10}.\\d{10}';
                }
                datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});

            } else if (!datos.get("telempresatemp").value) {
                datos.get('ladatelempresa').setValidators(null);
                datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                datos.get('telempresatemp').setValidators(null);
                datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
            } else {
                datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                datos.get("ladatelempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
            }

            datos.get('extensionempresa').valueChanges.subscribe((cel) => {
                if (cel) {
                    datos.get("telempresa").setValue(this._help.UnitTelefono(datos.get("ladatelempresa").value, datos.get("telempresatemp").value));
                    datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                    datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get('extensionempresa').setValidators(Validators.required);
                    datos.get('extensionempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }
                else if (!datos.get('ladatelempresa').value && !datos.get('telempresatemp').value && !datos.get('vive').value) {
                    datos.get('ladatelempresa').setValidators(null);
                    datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get('telempresatemp').setValidators(null);
                    datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    datos.get('extensionempresa').setValidators(null);
                    datos.get('extensionempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                } else {
                    datos.get('extensionempresa').setValidators(null);
                    datos.get('extensionempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }
            });
        });
        return datos;
    }




    addPersonaAporta(e) {
        let b;
        this.newpersona++;
        if (e == 2 || e == 3) {
            this.otromas = 2;
            if (this.newpersona == 1 || e == 3) {
                this.idvive++;
                let datos = this._fb.group({
                    parentescoid: [, <any> Validators.required],
                    fechanacimiento: [, <any> Validators.required],
                    padresotutoresid: [],
                    parentesco: [],
                    tutorid: [],
                    nombre: [],
                    vive: [true, <any> Validators.required],
                    ladacelular: [, <any> Validators.compose([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))])],
                    celular: [],
                    celtemp: [, <any> Validators.required],
                    situacionconyugalid: [],
                    especificacionocupacion: [],
                    ramo: [],
                    empresa: [],
                    horariotrabajo: [],
                    antiguedad: [],
                    ladatelempresa: [],
                    telempresa: [],
                    telempresatemp: [],
                    extensionempresa: [],
                    ocupacion: [],
                    escolaridadid: [],
                    nombrejefeinmediato: [],
                    domicilioempresa: [],
                    disabled: false,
                    solicitudid: this.parametrosModal.solicitudid ? this.parametrosModal.solicitudid : null,
                    idvive: this.idvive
                });

                datos.get('vive').valueChanges.subscribe((vive: boolean) => {
                    if (!vive) {
                        datos.get("ladacelular").setValidators(null);
                        datos.get("ladacelular").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("celtemp").setValidators(null);
                        datos.get("celtemp").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("situacionconyugalid").setValidators(null);
                        datos.get("situacionconyugalid").updateValueAndValidity({onlySelf: true, emitEvent: false});

                        if (this.sistema == 1) {
                            datos.get("ocupacion").setValidators(null);
                            datos.get("ocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false})
                        }

                        datos.get("especificacionocupacion").setValidators(null);
                        datos.get("especificacionocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("ramo").setValidators(null);
                        datos.get("ramo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("empresa").setValidators(null);
                        datos.get("empresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("horariotrabajo").setValidators(null);
                        datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("antiguedad").setValidators(null);
                        datos.get("antiguedad").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("escolaridadid").setValidators(null);
                        datos.get("escolaridadid").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("nombrejefeinmediato").setValidators(null);
                        datos.get("nombrejefeinmediato").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("domicilioempresa").setValidators(null);
                        datos.get("domicilioempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});

                        if (datos.get("ladatelempresa").value || datos.get("telempresatemp").value) {

                            var p;
                            if (datos.get("ladatelempresa").value.length == 4) {
                                p = '\\d{4}.\\d{4}';
                            } else if (datos.get("ladatelempresa").value.length == 5) {
                                p = '\\d{3}.\\d{4}';
                            } else {
                                p = '\\d{10}.\\d{10}';
                            }
                            datos.get('ladatelempresa').setValidators(null);
                            datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                            datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        } else {
                            datos.get('ladatelempresa').setValidators(null);
                            datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get('telempresatemp').setValidators(null);
                            datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get('extensionempresa').setValidators(null);
                            datos.get('extensionempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        }

                    } else {

                        if (datos.get("ocupacion").value == "Económicamente activo" || this.sistema == 2) {
                            if (this.sistema == 1) {
                                datos.get("escolaridadid").setValidators(Validators.required);
                                datos.get("escolaridadid").updateValueAndValidity({onlySelf: true, emitEvent: false});
                                datos.get("nombrejefeinmediato").setValidators(Validators.required);
                                datos.get("nombrejefeinmediato").updateValueAndValidity({onlySelf: true, emitEvent: false});
                                datos.get("domicilioempresa").setValidators(Validators.required);
                                datos.get("domicilioempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                                datos.get("horariotrabajo").setValidators(null);
                                datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                            }

                            datos.get("especificacionocupacion").setValidators(Validators.required);
                            datos.get("especificacionocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get("ramo").setValidators(Validators.required);
                            datos.get("ramo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get("empresa").setValidators(Validators.required);
                            datos.get("empresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                            if (this.sistema == 2) {
                                datos.get("horariotrabajo").setValidators(null);
                                datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                            }
                            datos.get("antiguedad").setValidators(Validators.required);
                            datos.get("antiguedad").updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                            datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        }


                        if (this.sistema == 1) {
                            datos.get("ocupacion").setValidators(Validators.required);
                            datos.get("ocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false})
                        }
                        datos.get("situacionconyugalid").setValidators(Validators.required);
                        datos.get("situacionconyugalid").updateValueAndValidity({onlySelf: true, emitEvent: false});

                        datos.get('ladacelular').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                        datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});


                        if (datos.get("ladacelular").value) {

                            var p;
                            if (datos.get("ladacelular").value.length == 4) {
                                p = '\\d{4}.\\d{4}';
                            } else if (datos.get("ladacelular").value.length == 5) {
                                p = '\\d{3}.\\d{4}';
                            } else {
                                p = '\\d{10}.\\d{10}';
                            }
                            datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                            datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        } else {
                            p = '\\d{10}.\\d{10}';
                            datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                            datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        }

                        if (datos.get("ladatelempresa").value) {
                            var p;
                            if (datos.get("ladatelempresa").value.length == 4) {
                                p = '\\d{4}.\\d{4}';
                            } else if (datos.get("ladatelempresa").value.length == 5) {
                                p = '\\d{3}.\\d{4}';
                            } else {
                                p = '\\d{10}.\\d{10}';
                            }
                            datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                            datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        } else {
                            p = '\\d{10}.\\d{10}';
                            datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                            datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        }

                        if (this.sistema == 1) {
                            datos.get("ocupacion").setValidators(Validators.required);
                            datos.get("ocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        }
                    }
                });

                datos.get('ladacelular').valueChanges.subscribe((lada) => {
                    if (lada == "(") {
                        datos.get('ladacelular').setValue(null);
                    }
                    if (datos.get("ladacelular").value && datos.get("celtemp").value) {
                        datos.get("celular").setValue(this._help.UnitTelefono(datos.get("ladacelular").value, datos.get("celtemp").value));
                    } else {
                        datos.get("celular").setValue(null);
                    }
                    let p;

                    if (lada && lada != "(") {
                        datos.get('ladacelular').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                        datos.get("ladacelular").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        if (lada.length == 4) {
                            p = '\\d{4}.\\d{4}';
                        } else if (lada.length == 5) {
                            p = '\\d{3}.\\d{4}';
                        } else {
                            p = '\\d{10}.\\d{10}';
                        }
                        datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                        datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});


                    } else if (!datos.get("celtemp").value) {
                        datos.get('ladacelular').setValidators(null);
                        datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get('celtemp').setValidators(null);
                        datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    } else {
                        datos.get('ladacelular').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                        datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    }

                });

                datos.get('celtemp').valueChanges.subscribe((cel) => {
                    if (datos.get("ladacelular").value && datos.get("celtemp").value) {
                        datos.get("celular").setValue(this._help.UnitTelefono(datos.get("ladacelular").value, datos.get("celtemp").value));
                    } else {
                        datos.get("celular").setValue(null);
                    }
                    let p;
                    let lada = datos.get("ladacelular").value;
                    if (lada && lada.length == 4) {
                        p = '\\d{4}.\\d{4}';
                    } else if (lada && lada.length == 5) {
                        p = '\\d{3}.\\d{4}';
                    } else {
                        p = '\\d{10}.\\d{10}';
                    }
                    if (cel) {
                        datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                        datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get('ladacelular').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                        datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    } else if (!datos.get("ladacelular").value) {
                        datos.get('ladacelular').setValidators(null);
                        datos.get('ladacelular').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get('celtemp').setValidators(null);
                        datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    } else {
                        datos.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                        datos.get('celtemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    }
                });

                datos.get('telempresatemp').valueChanges.subscribe((cel) => {
                    if (cel && datos.get("ladatelempresa").value) {
                        datos.get("telempresa").setValue(this._help.UnitTelefono(datos.get("ladatelempresa").value, datos.get("telempresatemp").value));
                    } else {
                        datos.get("telempresa").setValue(null);
                    }
                    let p;
                    let lada = datos.get("ladatelempresa").value;
                    if (lada && lada.length == 4) {
                        p = '\\d{4}.\\d{4}';
                    } else if (lada && lada.length == 5) {
                        p = '\\d{3}.\\d{4}';
                    } else {
                        p = '\\d{10}.\\d{10}';
                    }
                    if (cel) {
                        datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                        datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                        datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    }
                    else if (!datos.get('ladatelempresa').value) {
                        datos.get('ladatelempresa').setValidators(null);
                        datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get('telempresatemp').setValidators(null);
                        datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    } else {
                        datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                        datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    }
                });

                datos.get('ocupacion').valueChanges.subscribe((ocupacion) => {
                    if (ocupacion == "Económicamente activo" && datos.get('vive').value) {
                        if (this.sistema == 1) {
                            datos.get("escolaridadid").setValidators(Validators.required);
                            datos.get("escolaridadid").updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get("nombrejefeinmediato").setValidators(Validators.required);
                            datos.get("nombrejefeinmediato").updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get("domicilioempresa").setValidators(Validators.required);
                            datos.get("domicilioempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get("horariotrabajo").setValidators(null);
                            datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        }

                        datos.get("especificacionocupacion").setValidators(Validators.required);
                        datos.get("especificacionocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("ramo").setValidators(Validators.required);
                        datos.get("ramo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("empresa").setValidators(Validators.required);
                        datos.get("empresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        if (this.sistema == 2) {
                            datos.get("horariotrabajo").setValidators(Validators.required);
                            datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        }
                        datos.get("antiguedad").setValidators(Validators.required);
                        datos.get("antiguedad").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                        datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    }
                    else {
                        datos.get("especificacionocupacion").setValidators(null);
                        datos.get("especificacionocupacion").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("ramo").setValidators(null);
                        datos.get("ramo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("empresa").setValidators(null);
                        datos.get("empresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("horariotrabajo").setValidators(null);
                        datos.get("horariotrabajo").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("antiguedad").setValidators(null);
                        datos.get("antiguedad").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("escolaridadid").setValidators(null);
                        datos.get("escolaridadid").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("nombrejefeinmediato").setValidators(null);
                        datos.get("nombrejefeinmediato").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("extensionempresa").setValidators(null);
                        datos.get("extensionempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get("domicilioempresa").setValidators(null);
                        datos.get("domicilioempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get('ladatelempresa').setValidators(null);
                        datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get('telempresatemp').setValidators(null);
                        datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    }
                });

                datos.get('ladatelempresa').valueChanges.subscribe((lada) => {
                    if (lada == "(") {
                        datos.get('ladatelempresa').setValue(null);
                    }
                    if (datos.get("ladatelempresa").value && datos.get("telempresatemp").value) {
                        datos.get("telempresa").setValue(this._help.UnitTelefono(datos.get("ladatelempresa").value, datos.get("telempresatemp").value))
                    } else {
                        datos.get("telempresa").setValue(null);

                    }
                    let p;
                    if (lada && lada != "(") {
                        datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                        datos.get("ladatelempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                        if (lada.length == 4) {
                            p = '\\d{4}.\\d{4}';
                        } else if (lada.length == 5) {
                            p = '\\d{3}.\\d{4}';
                        } else {
                            p = '\\d{10}.\\d{10}';
                        }
                        datos.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                        datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});

                    } else if (!datos.get("telempresatemp").value) {
                        datos.get('ladatelempresa').setValidators(null);
                        datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        datos.get('telempresatemp').setValidators(null);
                        datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    } else {
                        datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                        datos.get("ladatelempresa").updateValueAndValidity({onlySelf: true, emitEvent: false});
                    }

                    datos.get('extensionempresa').valueChanges.subscribe((cel) => {
                        if (cel) {
                            datos.get("telempresa").setValue(this._help.UnitTelefono(datos.get("ladatelempresa").value, datos.get("telempresatemp").value));
                            datos.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                            datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get('extensionempresa').setValidators(Validators.required);
                            datos.get('extensionempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        }
                        else if (!datos.get('ladatelempresa').value && !datos.get('telempresatemp').value && !datos.get('vive').value) {
                            datos.get('ladatelempresa').setValidators(null);
                            datos.get('ladatelempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get('telempresatemp').setValidators(null);
                            datos.get('telempresatemp').updateValueAndValidity({onlySelf: true, emitEvent: false});
                            datos.get('extensionempresa').setValidators(null);
                            datos.get('extensionempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        } else {
                            datos.get('extensionempresa').setValidators(null);
                            datos.get('extensionempresa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                        }
                    });
                });

                b = (this.Formpadres.get("otro") as FormArray).push(datos);
            }
        } else {
            this.newpersona = 0;
            b = (this.Formpadres.get("otro") as FormArray).controls = [];
            (this.Formpadres.get("otro") as FormArray).reset();
            this.otromas = 0;
            this.submitted = false;
        }
    }

    removePersonaAporta(e) {
        (this.Formpadres.get("otro") as FormArray).removeAt(e);
        if ((this.Formpadres.get("otro").value as any[]).length == 0) {
            (this.Formpadres.get("otro") as FormArray).reset();
            this.Formpadres.get("personaaporta").setValue(1);
            this.otromas = 0;
            this.newpersona = 0;
            this.submitted = false;
        }
    }


}
