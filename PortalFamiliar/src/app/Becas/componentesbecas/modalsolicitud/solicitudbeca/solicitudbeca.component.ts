import {AfterContentInit, Component, OnInit, Output, EventEmitter, Input, ChangeDetectorRef} from "@angular/core";
import {AppState} from "app/app.service";
import {FormGroup, FormControl, FormBuilder, Validators} from "@angular/forms";
import {parametrosModal} from "app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud";
import {TelefonoService} from "app/Servicios/Telefono.Service";
import {Helpers} from "app/app.helpers";
declare let Messenger: any;

@Component({
    selector: "solicitudbeca",
    templateUrl: "solicitudbeca.component.html",
    providers: [AppState]
})
export class SolicitudBecaComponent implements OnInit, AfterContentInit {
    @Input() parametrosModal: parametrosModal;
    @Output() output = new EventEmitter();
    cambio: boolean;
    @Output() accionGuardar = new EventEmitter();
    sistema: number;

    //formulario1
    Formalumnosfamilia: FormGroup;
    FormGuardar: FormGroup;
    submitted: boolean;
    familia: String;
    familiaalumnos: any;
    selectAlumno: any[];

    SelectEstado: any[] = [];
    SelectCiudadModal: any[] = [];
    SelectEstadoFull: any[] = [];
    SelectCiudadFull: any[];
    coloniaSelectfull: any[] = [];

    otracolonia: boolean = false;

    coloniasel: any;
    estadosel: any;
    ciudadsel: any;
    existecp: boolean;

    //-- mascaras --
    maskCP = [/\d/, /\d/, /\d/, /\d/, /\d/];

    lada1: any;
    telefono: any;
    telefonotemp: any;

    constructor(private _httpService: AppState, private _help: Helpers, private _fb: FormBuilder, private cdr: ChangeDetectorRef, public telefonoService: TelefonoService) {
        this.sistema = this._httpService.sistema;
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.Formalumnosfamilia = this._fb.group({
            alumno: [],
            paisid: [],
            estadoid: [, <any> Validators.required],
            municipioid: [, <any> Validators.required],
            coloniaid: [, <any> Validators.required],
            codigopostal: [, <any> Validators.required],
            calle: [, <any> Validators.required],
            numeroexterior: [, <any> Validators.required],
            numerointerior: [],
            otracolonia: [],
            entrecalles: [, <any> Validators.required],
            telefonocasa: [, <any> Validators.required],
            lada: [, <any> Validators.required]
        });


        this.Formalumnosfamilia.get('lada').valueChanges.subscribe((lada) => {
            if (lada == "(") {
                this.Formalumnosfamilia.get('lada').setValue(null);
            }
            if (lada && lada != "(") {
                this.Formalumnosfamilia.get('lada').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                this.Formalumnosfamilia.get('lada').updateValueAndValidity({emitEvent: false});
                let p;
                if (lada.length == 5) {
                    p = '^\\d{3}.\\d{4}$';
                } else {
                    p = '^\\d{4}.\\d{4}$';
                }
                this.Formalumnosfamilia.get("telefonocasa").setValidators(Validators.compose([Validators.required, Validators.pattern(new RegExp(p))]));
                this.Formalumnosfamilia.get("telefonocasa").updateValueAndValidity({emitEvent: false});
                let telefono = this.Formalumnosfamilia.get('telefonocasa').value;
                if (telefono && telefono.match(p)) {
                    return null;
                } else {
                    return {telefono: false}
                }

            } else if (!this.Formalumnosfamilia.get('lada').value && !this.Formalumnosfamilia.get("telefonocasa").value) {
                this.Formalumnosfamilia.get('lada').setValidators(null);
                this.Formalumnosfamilia.get('lada').updateValueAndValidity({emitEvent: false});
                this.Formalumnosfamilia.get('telefonocasa').setValidators(null);
                this.Formalumnosfamilia.get('telefonocasa').updateValueAndValidity({onlySelf: true, emitEvent: false});

            } else if (lada == "") {
                if (this.Formalumnosfamilia.get('telefonocasa').value) {
                    this.Formalumnosfamilia.get('lada').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                    this.Formalumnosfamilia.get('lada').updateValueAndValidity({onlySelf: true, emitEvent: false});
                } else {
                    this.Formalumnosfamilia.get('lada').setValidators(null);
                    this.Formalumnosfamilia.get('lada').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }

            }
        });

        this.Formalumnosfamilia.get('telefonocasa').valueChanges.subscribe((tel) => {
            let p;
            let lada = this.Formalumnosfamilia.get('lada').value;
            if (lada && lada != "(") {
                this.Formalumnosfamilia.get('lada').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                this.Formalumnosfamilia.get('lada').updateValueAndValidity({emitEvent: false});

                if (lada.length == 5) {
                    p = '^\\d{3}.\\d{4}$';
                } else {
                    p = '^\\d{4}.\\d{4}$';
                }
                this.Formalumnosfamilia.get("telefonocasa").setValidators(Validators.compose([Validators.required, Validators.pattern(new RegExp(p))]));
                this.Formalumnosfamilia.get("telefonocasa").updateValueAndValidity({emitEvent: false});
                let telefono = this.Formalumnosfamilia.get('telefonocasa').value;
                if (telefono && telefono.match(p)) {
                    return null;
                } else {
                    return {telefono: false}
                }

            }
            if (tel) {
                this.Formalumnosfamilia.get('lada').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
                this.Formalumnosfamilia.get('lada').updateValueAndValidity({onlySelf: true, emitEvent: false});
            } else {
                if (this.Formalumnosfamilia.get('lada').value) {
                    this.Formalumnosfamilia.get("telefonocasa").setValidators(Validators.compose([Validators.required, Validators.pattern(new RegExp(p))]));
                    this.Formalumnosfamilia.get("telefonocasa").updateValueAndValidity({emitEvent: false});
                } else {
                    this.Formalumnosfamilia.get('lada').setValidators(null);
                    this.Formalumnosfamilia.get('lada').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    this.Formalumnosfamilia.get('telefonocasa').setValidators(null);
                    this.Formalumnosfamilia.get('telefonocasa').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }
            }

        });


        this.Formalumnosfamilia.get('coloniaid').valueChanges.subscribe((coloniaid: number) => {
            if (coloniaid == -1) {
                this.Formalumnosfamilia.get('otracolonia').setValidators(<any> Validators.required);
            } else {
                this.Formalumnosfamilia.get('otracolonia').setValidators(null);
            }
            this.Formalumnosfamilia.get('otracolonia').updateValueAndValidity();
        })
        this.FormGuardar = this._fb.group({
            solicitudid: [],
            paisid: [],
            estadoid: [],
            municipioid: [],
            coloniaid: [],
            codigopostal: [],
            calle: [],
            numeroexterior: [],
            numerointerior: [],
            otracolonia: [],
            entrecalles: [],
            telefonocasa: []
        });

        this.coloniasel = null;
        this.estadosel = null;
        this.ciudadsel = null;
        this.existecp = false;
    }

    ngAfterContentInit() {
        this.output.next(this);
        if (!this.parametrosModal.pestanaSolicitud.familiaalumnos && !this.parametrosModal.pestanaSolicitud.selectAlumno) {
            this.datosIniciales();
        } else {
            this.selectAlumno = this.parametrosModal.pestanaSolicitud.selectAlumno;
            this.familiaalumnos = this.parametrosModal.pestanaSolicitud.familiaalumnos;
            this.familia = this.parametrosModal.pespadres.datos;
        }
        if (!this.parametrosModal.pestanaSolicitud.SelectEstadoFull) {
            this.GetEstado();
        } else {
            this.SelectEstadoFull = this.parametrosModal.pestanaSolicitud.SelectEstadoFull;
            if (!this.parametrosModal.pestanaSolicitud.domicilios) {
                this.getdomicilio();
            } else {
                this.Formalumnosfamilia.setValue(this.parametrosModal.pestanaSolicitud.domicilios);
                this.telefonotemp = (this.parametrosModal.pestanaSolicitud.domicilios as any).telefonocasa;
                this.busquedaPorCp2();

            }
        }

        //this.cdr.detectChanges();
    }

    cambios() {
        this.Formalumnosfamilia.valueChanges.subscribe(() => {
            this.cambio = true
        });
    }


    datosIniciales() {
        this._httpService.postElemento("ConsultaSolicitudBecas/InfoFamiliaBeca", {clavefamiliarid: this.parametrosModal.clavefamiliarid},null,true).subscribe(
            res => {
                if (res.status == 200) {
                    this.familiaalumnos = res.body;
                    this.parametrosModal.pespadres.datos = res.body[0] ? (res.body[0].clavefamiliar.apellidopaterno ? res.body[0].clavefamiliar.apellidopaterno : "") + " " + (res.body[0].clavefamiliar.apellidomaterno ? res.body[0].clavefamiliar.apellidomaterno : "") : "";
                    this.familia = res.body[0] ? (res.body[0].clavefamiliar.apellidopaterno ? res.body[0].clavefamiliar.apellidopaterno : "") + " " + (res.body[0].clavefamiliar.apellidomaterno ? res.body[0].clavefamiliar.apellidomaterno : "") : "";
                    this.parametrosModal.pestanaSolicitud.familiaalumnos = this.familiaalumnos;
                    this.selectAlumno = res.body;
                    this.parametrosModal.pestanaSolicitud.selectAlumno = this.selectAlumno;
                }
            },
            err => {
                Messenger().post({
                    message: "No se pudo comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
        );
    }

    transformartexto(forname: FormControl) {
        let texto: string = forname.value;
        if (texto) {
            forname.setValue(this.sistema == 1 ? texto.toUpperCase() : this._help.capitalize(texto));
        }
    }
    GetEstado() {
        this._httpService.getElemento('Estado/484').subscribe(
            result => {
                if (result.status == 200) {
                    this.SelectEstadoFull = result.body;
                    this.parametrosModal.pestanaSolicitud.SelectEstadoFull = this.SelectEstadoFull;
                    this.SelectEstado = this.SelectEstadoFull.slice(0);
                    this.getdomicilio();
                }
            },
            error => {
                this.SelectEstadoFull = [];
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor para cargar los estados',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    getdomicilio() {
        this._httpService.postElemento( "SolicitudBeca/getdomicilio", {solicitudid: this.parametrosModal.solicitudid},null,true).
            subscribe(result => {
                if (result.status == 200) {
                    let informacion: any[] = result.body;
                    if (informacion.length > 0) {
                        let domicilio = informacion[0];
                        //let tel = domicilio.d_telefonocasa.split('-');
                        this.Formalumnosfamilia.setValue({
                            alumno: null,
                            paisid: parseInt(domicilio.p_paisid),
                            estadoid: parseInt(domicilio.estadoid),
                            municipioid: parseInt(domicilio.municipioid),
                            coloniaid: parseInt(domicilio.c_coloniaid ? domicilio.c_coloniaid : -1),
                            codigopostal: domicilio.d_codigopostal,
                            calle: domicilio.d_calle,
                            numeroexterior: domicilio.d_numeroexterior,
                            numerointerior: domicilio.d_numerointerior ? domicilio.d_numerointerior : null,
                            otracolonia: domicilio.d_otracolonia ? domicilio.d_otracolonia : null,
                            entrecalles: domicilio.d_entrecalles,
                            telefonocasa: domicilio.d_telefonocasa ? this._help.ParseTelefono(domicilio.d_telefonocasa)[1] : null,
                            lada: domicilio.d_telefonocasa ? this._help.ParseTelefono(domicilio.d_telefonocasa)[0] : null
                        });

                        //                        this.lada1 = domicilio.d_telefonocasa ? this._help.ParseTelefono(domicilio.d_telefonocasa)[0] : null;
                        //                        //this.Formalumnosfamilia.get("telefonocasa").setValue(null);
                        //                        this.telefono = domicilio.d_telefonocasa ? this._help.ParseTelefono(domicilio.d_telefonocasa)[1] : null;


                        this.busquedaPorCp2();
                    }
                    this.cambios();

                } else {
                    Messenger().post({
                        message:
                        "Aún no ha sido capturada esta información en la solicitud",
                        type: "success",
                        showCloseButton: true
                    });
                }
            });
    }

    busquedaPorCp2() {
        this.estadosel = this.Formalumnosfamilia.get('estadoid').value;
        this.ciudadsel = this.Formalumnosfamilia.get('municipioid').value;
        this.coloniasel = this.Formalumnosfamilia.get('coloniaid').value;

        this._httpService.getElemento('Colonia/GetByCP/' + this.Formalumnosfamilia.get('codigopostal').value).subscribe(
            result => {
                if (result.status == 200) {
                    this.coloniaSelectfull = result.body;

                    if (this.ValidarCodigoPostal(this.Formalumnosfamilia.get('codigopostal').value)) {
                        this.coloniaSelectfull.push({"nombre": "OTRA", "cp": 0, "coloniaid": -1});
                    }

                    for (let colonia of this.coloniaSelectfull) {
                        colonia.nombre = colonia.nombre.toUpperCase();
                    }

                    this.otracolonia = this.Formalumnosfamilia.get('coloniaid').value == -1;

                    this.SelectCiudadModal = [result.body[0].municipioid];
                    this.SelectEstado = [result.body[0].municipioid.estadoid];

                    this.existecp = true;
                }
                else {
                    this.existecp = false;
                    this.SelectCiudadModal = [];
                    this.coloniaSelectfull = [];
                    this.SelectEstado = this.SelectEstadoFull.slice(0);

                    this.loadMunicipios2(this.Formalumnosfamilia.get('estadoid').value);
                    this.coloniaSelectfull = [{"nombre": "OTRA", "cp": 0, "coloniaid": -1}];

                    this.otracolonia = true;
                }
                this.cambios();
            },
            error => {
                this._httpService.mensajeDanger('No se encontró ninguna colonia con el codigo postal ' + this.FormGuardar.get('codigopostal').value);
            });

    }

    loadMunicipios2(e: any) {
        if (e && !this.existecp) {
            this._httpService.getElemento('Ciudad/' + e).subscribe(
                result => {
                    if (result.status == 200) {
                        this.SelectCiudadModal = result.body;
                    }
                },
                error => {
                    this.SelectCiudadModal = [];
                    this.coloniaSelectfull = [];
                    Messenger().post({
                        message: 'No se pudo comunicar con el servidor de las ciudades',
                        type: 'error',
                        showCloseButton: true
                    });
                });
        }
    }

    ///Termina el prellenado

    seleccionhijo(alumnoid: number) {
        this._httpService.postElemento("SolicitudBeca/getdomicilioalumno", {alumnoid: alumnoid, clavefamiliarid: this.parametrosModal.clavefamiliarid},null,true).subscribe(
            res => {
                if (res.status == 200) {
                    let informacion = res.body;
                    if (informacion) {
                        let domicilio = informacion;
                        this.Formalumnosfamilia.setValue({
                            alumno: null,
                            paisid: parseInt(domicilio.paisid),
                            estadoid: parseInt(domicilio.estadoid),
                            municipioid: parseInt(domicilio.municipioid),
                            coloniaid: parseInt(domicilio.coloniaid ? domicilio.coloniaid : -1),
                            codigopostal: domicilio.pot_codigopostal ? domicilio.pot_codigopostal : null,
                            calle: domicilio.pot_calle ? domicilio.pot_calle : null,
                            numeroexterior: domicilio.pot_numeroexterior ? domicilio.pot_numeroexterior : null,
                            numerointerior: domicilio.pot_numerointerior ? domicilio.pot_numerointerior : null,
                            otracolonia: domicilio.pot_otracolonia ? domicilio.pot_otracolonia : null,
                            entrecalles: domicilio.pot_entrecalles ? domicilio.pot_entrecalles : null,
                            telefonocasa: null,
                            lada: null
                        });
                        this.busquedaPorCp2();
                    }
                    else {
                        Messenger().post({
                            message: "No se encontraron datos",
                            type: "success",
                            showCloseButton: true
                        })
                    }
                }
                else {
                    Messenger().post({
                        message: "No se encontraron datos",
                        type: "success",
                        showCloseButton: true
                    })
                }
            },
            err => {
                Messenger().post({
                    message: "No se pudo comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
        );
    }

    busquedaPorCp(e: any) {
        //limpiar los otros controles
        this.Formalumnosfamilia.patchValue({
            municipioid: null,
            estadoid: null,
            coloniaid: null,
        });

        this.otracolonia = false;

        this.coloniasel = null;
        this.estadosel = null;
        this.ciudadsel = null;
        this.existecp = false;

        this.SelectEstado = this.SelectEstadoFull.slice(0);

        if (!this.Formalumnosfamilia.get('codigopostal').value) {
            return;
        }

        var aux = e.replace(/\_/, "");

        if (aux.length == 5) {
            //Llamada al servicio datos iniciales
            this._httpService.getElemento('Colonia/GetByCP/' + e).subscribe(
                result => {
                    if (result.status == 200) {
                        this.coloniaSelectfull = result.body;

                        this.coloniaSelectfull.push({"nombre": "OTRA", "cp": 0, "coloniaid": -1});

                        for (let colonia of this.coloniaSelectfull) {
                            colonia.nombre = colonia.nombre.toUpperCase();
                        }

                        let listaciudades = [];
                        let listaestados = [];

                        listaciudades.push(result.body[0].municipioid);
                        listaestados.push(result.body[0].municipioid.estadoid);

                        this.SelectCiudadModal = listaciudades;
                        this.SelectEstado = listaestados;

                        this.Formalumnosfamilia.patchValue(
                            {
                                municipioid: result.body[0].municipioid.municipioid,
                                estadoid: result.body[0].municipioid.estadoid.estadoid
                            });

                        this.existecp = true;

                        this.estadosel = result.body[0].municipioid.estadoid.estadoid;
                        this.coloniasel = result.body[0].municipioid.municipioid;

                    }
                    else {
                        this.SelectCiudadModal = [];
                        this.coloniaSelectfull = [];
                        this.existecp = false;
                    }
                },
                error => {
                    this.SelectEstado = [];
                    this.SelectCiudadModal = [];
                    this.coloniaSelectfull = [];
                    this.existecp = false;
                    this._httpService.mensajeDanger('No se encontro ninguna colonia con el codigo postal ' + this.FormGuardar.get('codigopostal').value);
                }
            );
        }
        else {
            this._httpService.mensajeDanger('Es necesario ingresar el código postal');
        }
    }

    ValidarCodigoPostal(cp) {
        if (!cp) {
            return false;
        }

        var aux = cp.replace(/\_/, "");

        if (aux.length == 5) {
            return true;
        }
        else {
            return false;
        }
    }

    loadMunicipios(e: any) {
        if (e == this.estadosel) {
            return;
        }

        this.estadosel = e;
        //limpiar otros valores dependientes de estado
        this.Formalumnosfamilia.patchValue(
            {
                municipioid: null,
                coloniaid: null,
                otracolonia: null,
            });

        this.ciudadsel = null;
        this.coloniasel = null;
        this.otracolonia = false;

        if (e && !this.existecp) {
            this._httpService.getElemento('Ciudad/' + e).subscribe(
                result => {
                    if (result.status == 200) {
                        this.SelectCiudadModal = result.body;
                    }
                },
                error => {
                    this.SelectCiudadModal = [];
                    this.coloniaSelectfull = [];
                    Messenger().post({
                        message: 'No se pudo comunicar con el servidor de las ciudades',
                        type: 'error',
                        showCloseButton: true
                    });
                });
        }

    }

    loadColonias(e: any) {
        if (e == this.ciudadsel) {
            return;
        }

        this.ciudadsel = e;

        //limpiar otros valores dependientes de ciudad
        this.Formalumnosfamilia.patchValue(
            {
                coloniaid: null,
                otracolonia: null,
            });

        this.coloniasel = null;
        this.otracolonia = false;

        this.ciudadsel = e;

        if (!this.existecp && this.ValidarCodigoPostal(this.Formalumnosfamilia.get('codigopostal').value)) {
            this.coloniaSelectfull = [];
            this.coloniaSelectfull.push({"nombre": "OTRA", "cp": 0, "coloniaid": -1});
            return;
        }

        else if (e && !this.existecp) {
            this._httpService.getElemento('Colonia/' + e).subscribe(
                result => {
                    if (result.status == 200) {
                        this.coloniaSelectfull = result.body;

                        for (let colonia of this.coloniaSelectfull) {
                            colonia.nombre = colonia.nombre.toUpperCase();
                        }

                        if (this.ValidarCodigoPostal(this.Formalumnosfamilia.get('codigopostal').value)) {

                            this.coloniaSelectfull.push({"nombre": "OTRA", "cp": 0, "coloniaid": -1});
                        }
                    }
                },
                error => {
                    this.coloniaSelectfull = [];
                    Messenger().post(
                        {
                            message: 'No se pudo comunicar con el servidor de las colonias',
                            type: 'error',
                            showCloseButton: true
                        });
                });
        }
    }

    otraColonia(e: any) {
        if (e == this.coloniasel) {
            return;
        }

        this.coloniasel = e;

        if (e == -1) {
            this.otracolonia = true;
        }
        else {
            this.otracolonia = false;

            if (e && !this.existecp) {
                let coloniasel = this.coloniaSelectfull.filter(p => p.coloniaid == e);
                this.Formalumnosfamilia.patchValue(
                    {
                        codigopostal: coloniasel[0].cp.toString()
                    });
            }
        }
    }

    guardar() {

        if (!this.cambio && this.telefonotemp) {
            this.Formalumnosfamilia.get("telefonocasa").setValue(this.telefonotemp);
        }

        if (this.Formalumnosfamilia.get("telefonocasa").value == "" || this.Formalumnosfamilia.get("telefonocasa").value == null) {
            this.Formalumnosfamilia.get('telefonocasa').setValidators(<any> Validators.required);
            this.Formalumnosfamilia.get('telefonocasa').updateValueAndValidity();
        }
        this.submitted = true;

        if (this.Formalumnosfamilia.invalid) {
            Messenger().post(
                {
                    message: 'Completa correctamente todos los datos.',
                    type: 'success',
                    showCloseButton: true
                });
            return false;
        }

        this.parametrosModal.pestanaSolicitud.domicilios = this.Formalumnosfamilia.value;
        if (!this.cambio) {

            this.accionGuardar.next(true);
            return false;
        }

        let data = this.Formalumnosfamilia.value;
        //        let lada = this.Formalumnosfamilia.get("lada").value.substring(1, this.sistema == 1 ? 4 : 3);
        //        let telefono = this.Formalumnosfamilia.get("telefonocasa").value.substring(0, this.sistema == 1 ? 3 : 4) + this.Formalumnosfamilia.get("telefonocasa").value.substring(this.sistema == 1 ? 4 : 5);
        this.FormGuardar.setValue({
            otracolonia: this.otracolonia == true ? data.otracolonia : null,
            coloniaid: this.otracolonia == true ? null : data.coloniaid,
            solicitudid: this.parametrosModal.solicitudid,
            paisid: 484,
            estadoid: data.estadoid,
            municipioid: data.municipioid,
            codigopostal: data.codigopostal,
            calle: data.calle,
            numeroexterior: data.numeroexterior,
            numerointerior: data.numerointerior ? data.numerointerior : null,
            entrecalles: data.entrecalles,
            telefonocasa: this._help.UnitTelefono(this.Formalumnosfamilia.get("lada").value, this.Formalumnosfamilia.get("telefonocasa").value)
        })

        this._httpService.postElemento("SolicitudBeca/domicilio", this.FormGuardar.value,null,true).subscribe(
            res => {
                if (res.status == 200) {
                    this.accionGuardar.next(true);
                }
            },
            err => {
                Messenger().post({
                    message: "No se pudo comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
        );
    }

}
