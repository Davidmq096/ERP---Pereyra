import {AfterViewInit, AfterContentInit, Output, EventEmitter, Component, OnInit, Input} from "@angular/core";
import {saveAs as importedSaveAs} from "file-saver";
import {AppState} from "app/app.service";
import {FormGroup, FormBuilder, Validators, FormArray} from "@angular/forms";
import createNumberMask from 'text-mask-addons/dist/createNumberMask';

import {parametrosModal} from "app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud";

declare let Messenger: any;

@Component({
    selector: "sitacioneconomica",
    templateUrl: "situacioneconomica.component.html",
    providers: [AppState]
})
export class SituacionEconomicaComponent implements OnInit, AfterViewInit, AfterContentInit {
    @Input() parametrosModal: parametrosModal;
    @Output() output = new EventEmitter();
    @Output() accionGuardar = new EventEmitter();
    cambio: boolean;

    //variable que indica si el sistema es lux o ciencias
    sistema: any;
    nombre: string;
    //-- mascaras --
    yearMask = [/\d/, /\d/, /\d/, /\d/];
    numberMask = createNumberMask({
        prefix: '',
        suffix: '',
        includeThousandsSeparator: true,
        thousandsSeparatorSymbol: ',',
        allowDecimal: false,
        decimalSymbol: '',
        decimalLimit: 0,
        integerLimit: null,
        requireDecimal: false,
        allowNegative: false,
        allowLeadingZeroes: false
    });
    numberMaskNoComma = createNumberMask({
        prefix: '',
        suffix: '',
        includeThousandsSeparator: true,
        thousandsSeparatorSymbol: '',
        allowDecimal: false,
        decimalSymbol: '',
        decimalLimit: 0,
        integerLimit: null,
        requireDecimal: false,
        allowNegative: false,
        allowLeadingZeroes: false
    });


    //Select
    selectTipocuentabanco: any[];
    selectEstatusvehiculo: any[];
    selectestatusinmueble: any[];
    selectTipocredito: any[];

    //Array tablas
    datosdeudasycreditos: any[];
    datosbancos: any[];
    datosvehiculos: any[];
    datospropiedades: any[];

    //Formulario
    formulario: FormGroup;
    submitted: boolean;

    totalegresos: number;
    totalingreso: number;
    total: number;//total tabla

    //En el contructor se declara la llamada a los servicios
    constructor(private URLBase: AppState, private _httpService: AppState, private _fb: FormBuilder) {
        this.sistema = this._httpService.sistema;
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.formulario = this._fb.group({
            solicitudid: [this.parametrosModal.solicitudid],
            escuela: [this.sistema],
            ingresos: this.sistema == 2 ? this._fb.group({
                ingresospadre: [, <any> Validators.required],
                ingresosmadre: [, <any> Validators.required],
                otrosfamiliares: [, <any> Validators.required],
                otrosingresos: [, <any> Validators.required]
            }) : this._fb.array([], Validators.compose([<any> Validators.required, <any> Validators.minLength(1)])),
            egresos: this.sistema == 1 ?
                this._fb.group({
                    egresomensualid: [],
                    alimentacion: [],
                    mantenimientoautos: [],
                    gastosdiversion: [],
                    renta: [],
                    telefonofijo: [],
                    inscripcioncolegios: [],
                    hipoteca: [],
                    telefonomovil: [],
                    colegiaturas: [],
                    predial: [],
                    television: [],
                    segurovida: [],
                    empleadadomestica: [],
                    gas: [],
                    seguroautos: [],
                    gastosmedicos: [],
                    agua: [],
                    segurogastosmedicos: [],
                    transporteurbano: [],
                    luz: [],
                    clasesextra: [],
                    especifiqueclasesextra: [],
                    mantenimientofraccionamiento: [],
                    gasolina: [],
                    otros1: [],
                    especifiqueotros1: [],
                    clubdeportivogimnasio: [],
                    vestido: [],
                    otros2: [],
                    especifiqueotros2: [],
                    // gimnasio: [],
                    vacaciones: [],
                    //otros3: [],
                    // especifiqueotros3: []
                }) : this._fb.group({
                    egresosfamiliares: [, <any> Validators.required],
                }),
            situacion: this._fb.group({
                descripcionsituacionfamiliar: [, <any> Validators.required]
            })
        });

        if (this.parametrosModal.pestanaSituacionEconomica.formulario) {
            this.selectestatusinmueble = this.parametrosModal.pestanaSituacionEconomica.selectestatusinmueble;
            this.selectEstatusvehiculo = this.parametrosModal.pestanaSituacionEconomica.selectEstatusvehiculo;
            this.selectTipocredito = this.parametrosModal.pestanaSituacionEconomica.selectTipocredito;
            this.selectTipocuentabanco = this.parametrosModal.pestanaSituacionEconomica.selectTipocuentabanco;
            this.datosbancos = this.parametrosModal.pestanaSituacionEconomica.datosbancos;
            this.datospropiedades = this.parametrosModal.pestanaSituacionEconomica.datospropiedades;
            this.datosvehiculos = this.parametrosModal.pestanaSituacionEconomica.datosvehiculos;
            this.datosdeudasycreditos = this.parametrosModal.pestanaSituacionEconomica.datosdeudasycreditos;
            this.formulario.patchValue(this.parametrosModal.pestanaSituacionEconomica.formulario);
            let form = (this.parametrosModal.pestanaSituacionEconomica.formulario as any);
            if (this.sistema == 1) {
                let b;
                (form.ingresos as any[]).forEach((ingreso) => {
                    b = this.formulario.get("ingresos") as FormArray;
                    if (ingreso.parentescoid) {
                        b.push(this.getvaloresform(ingreso, 'padres'));
                    } else {
                        b.push(this.getvaloresform(ingreso, 'otros'));
                    }
                });
            }

            this.formulario.get('egresos').valueChanges.subscribe((egresos: any) => {
                this.sumaegresos(egresos);
            });

            this.formulario.get('ingresos').valueChanges.subscribe((ingresospadre: any) => {
                this.sumaingresos(ingresospadre);
            });

            if (this.datosdeudasycreditos) {
                this.total = this.datosdeudasycreditos.reduce((a, b) => a + Number(b.pagomensual), 0);
            }

            this.sumaingresos(this.formulario.get('ingresos').value);
            this.sumaegresos(this.formulario.get('egresos').value);

            this.formulario.valueChanges.subscribe(() => {
                this.cambio = true;
            })
        }


    }

    ngAfterViewInit(): void {
        if (!this.parametrosModal.pestanaSituacionEconomica.formulario) {
            if (this.sistema == 1) {
                this.getegresosmensuales();
            } else {
                this.datosGenerales();
            }
        }
    }

    ngAfterContentInit() {
        this.output.next(this);
    }


    //devuelve valores de egresos capturados para insituto lux
    getegresosmensuales() {
        var id = this.parametrosModal.solicitudid;
        this._httpService.getElemento("Becas/SolicitudBeca/SituacionEconomica/EgresosMensuales/" + id).subscribe(
            result => {
                if (result.status == 200) {
                    if (result.body.egresomensual[0]) {

                        this.formulario.get('egresos').patchValue({
                            alimentacion: result.body.egresomensual[0].alimentacion,
                            mantenimientoautos: result.body.egresomensual[0].mantenimientoautos,
                            agua: result.body.egresomensual[0].agua,
                            segurogastosmedicos: result.body.egresomensual[0].segurogastosmedicos,
                            gastosdiversion: result.body.egresomensual[0].gastosdiversion,
                            renta: result.body.egresomensual[0].renta,
                            telefonofijo: result.body.egresomensual[0].telefonofijo,
                            inscripcioncolegios: result.body.egresomensual[0].inscripcioncolegios,
                            hipoteca: result.body.egresomensual[0].hipoteca,
                            telefonomovil: result.body.egresomensual[0].telefonomovil,
                            colegiaturas: result.body.egresomensual[0].colegiaturas,
                            predial: result.body.egresomensual[0].predial,
                            television: result.body.egresomensual[0].television,
                            segurovida: result.body.egresomensual[0].segurovida,
                            empleadadomestica: result.body.egresomensual[0].empleadadomestica,
                            gas: result.body.egresomensual[0].gas,
                            seguroautos: result.body.egresomensual[0].seguroautos,
                            gastosmedicos: result.body.egresomensual[0].gastosmedicos,
                            transporteurbano: result.body.egresomensual[0].transporteurbano,
                            luz: result.body.egresomensual[0].luz,
                            clasesextra: result.body.egresomensual[0].clasesextra,
                            especifiqueclasesextra: result.body.egresomensual[0].especifiqueclasesextra,
                            mantenimientofraccionamiento: result.body.egresomensual[0].mantenimientofraccionamiento,
                            gasolina: result.body.egresomensual[0].gasolina,
                            otros1: result.body.egresomensual[0].otros1,
                            especifiqueotros1: result.body.egresomensual[0].especifiqueotros1,
                            clubdeportivogimnasio: result.body.egresomensual[0].clubdeportivogimnasio,
                            vestido: result.body.egresomensual[0].vestido,
                            otros2: result.body.egresomensual[0].otros2,
                            especifiqueotros2: result.body.egresomensual[0].especifiqueotros2,
                            // gimnasio: result.body.egresomensual[0].gimnasio,
                            vacaciones: result.body.egresomensual[0].vacaciones,
                            //otros3: result.body.egresomensual[0].otros3,
                            // especifiqueotros3: result.body.egresomensual[0].especifiqueotros3,
                            egresomensualid: result.body.egresomensual[0].egresomensualid
                        });
                    }


                    this.formulario.get('egresos').valueChanges.subscribe((egresos: any) => {
                        this.sumaegresos(egresos);
                    });

                    this.datosGenerales();

                } else {
                    Messenger().post({
                        message: result.body,
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

    datosGenerales() {
        var id = this.parametrosModal.solicitudid;
        this._httpService.getElemento("Becas/SolicitudBeca/SituacionEconomica/ObtenerSituacionEconomica/" + id + "?portal=1" + "&escuela=" + this.sistema).subscribe(
            result => {
                if (result.status == 200) {
                    let situacion = result.body.ingresofamiliar;
                    if (situacion && this.sistema == 1) {
                        let b;
                        for (let i = 0; i < situacion.length; i++) {
                            b = this.formulario.get("ingresos") as FormArray;
                            if (situacion[i].parentescoid) {
                                b.push(this.valoresform(situacion[i], 'padres'));
                            } else {
                                b.push(this.valoresform(situacion[i], 'otros'));
                            }
                        }


                    }


                    if (situacion && this.sistema == 2) {
                        this.formulario.get('ingresos').patchValue({
                            ingresospadre: situacion.ingresospadre,
                            ingresosmadre: situacion.ingresosmadre,
                            otrosfamiliares: situacion.otrosfamiliares,
                            otrosingresos: situacion.otrosingresos
                        });

                    }

                    this.formulario.get('ingresos').valueChanges.subscribe((ingresospadre: any) => {
                        this.sumaingresos(ingresospadre);
                    });
                    if (this.sistema == 2) {
                        if (situacion) {
                            this.formulario.get('egresos').patchValue({
                                egresosfamiliares: situacion.egresosfamiliares
                            });

                        }
                        this.formulario.get('egresos').valueChanges.subscribe((egresos: any) => {
                            this.sumaegresos(egresos);
                        });
                    }
                    //Situacion familiar
                    if (result.body.situacionfamiliar.length != 0) {
                        this.formulario.get('situacion').setValue({
                            descripcionsituacionfamiliar: result.body.situacionfamiliar ? result.body.situacionfamiliar[0].descripcionsituacionfamiliar : null
                        })
                    }
                    if (result.body.deudascreditos.length != 0) {
                        this.total = result.body.deudascreditos.reduce((a, b) => a + Number(b.pagomensual), 0);
                        this.datosdeudasycreditos = result.body.deudascreditos;
                        this.parametrosModal.pestanaSituacionEconomica.datosdeudasycreditos = result.body.deudascreditos;
                    }
                    this.sumaingresos(this.formulario.get('ingresos').value);
                    this.sumaegresos(this.formulario.get('egresos').value);


                    //Deudas y credito
                    this.selectTipocredito = result.body.tipocredito;
                    this.parametrosModal.pestanaSituacionEconomica.selectTipocredito = result.body.tipocredito;

                    //Inmueble
                    this.selectestatusinmueble = (result.body.estatuspropiedad as any[]).filter(x => x.instituto == 3 || x.instituto == this.sistema);
                    this.parametrosModal.pestanaSituacionEconomica.selectestatusinmueble = (result.body.estatuspropiedad as any[]).filter(x => x.instituto == 3 || x.instituto == this.sistema);
                    if (result.body.propiedadesfamiliares.length != 0) {
                        this.datospropiedades = result.body.propiedadesfamiliares;
                        this.parametrosModal.pestanaSituacionEconomica.datospropiedades = result.body.propiedadesfamiliares;
                    } else {
                        this.datospropiedades = [];

                    }
                    //Veiculos
                    this.selectEstatusvehiculo = result.body.estatusvehiculo;
                    this.parametrosModal.pestanaSituacionEconomica.selectEstatusvehiculo = result.body.estatusvehiculo;
                    if (result.body.vehiculos.length != 0) {
                        this.datosvehiculos = result.body.vehiculos;
                        this.parametrosModal.pestanaSituacionEconomica.datosvehiculos = result.body.vehiculos;
                    }
                    //Banco
                    this.selectTipocuentabanco = result.body.tipocuentabanco;
                    this.parametrosModal.pestanaSituacionEconomica.selectTipocuentabanco = result.body.tipocuentabanco;
                    if (result.body.cuentabanco.length != 0) {
                        this.datosbancos = result.body.cuentabanco;
                        this.parametrosModal.pestanaSituacionEconomica.datosbancos = result.body.cuentabanco;
                    }

                    this.parametrosModal.pestanaSituacionEconomica.formulario = this.formulario.value;

                    this.formulario.valueChanges.subscribe(() => {
                        this.cambio = true;
                    })

                } else {
                    Messenger().post({
                        message: result.body,
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


    getvaloresform(datos: any, identificador: string): FormGroup {
        let item;
        if (identificador == 'padres') {
            item = this._fb.group({
                nombre: datos.nombre,
                parentescoid: datos.parentescoid ? datos.parentescoid : null,
                ingresosluxid: [datos.ingresosluxid ? datos.ingresosluxid : null],
                padresotutoresid: datos.padresotutoresid ? datos.padresotutoresid : null,
                ingresomensualbruto: [datos.ingresomensualbruto || datos.ingresomensualbruto == 0 ? datos.ingresomensualbruto : null],
                ingresomensualneto: [datos.ingresomensualneto || datos.ingresomensualneto == 0 ? datos.ingresomensualneto : null],
                rentas: [datos.rentas || datos.rentas == 0 ? datos.rentas : null],
                donativo: [datos.donativo || datos.donativo == 0 ? datos.donativo : null],
                otrosingresos: [datos.otrosingresos || datos.otrosingresos == 0 ? datos.otrosingresos : null],
                fondodeahorro: [datos.fondodeahorro || datos.fondodeahorro == 0 ? datos.fondodeahorro : null],
                aguinaldo: [datos.aguinaldo || datos.aguinaldo == 0 ? datos.aguinaldo : null],
                utilidades: [datos.utilidades || datos.utilidades == 0 ? datos.utilidades : null],
                interesesporinversion: [datos.interesesporinversion || datos.interesesporinversion == 0 ? datos.interesesporinversion : null]
            });
        } else {
            item = this._fb.group({
                nombre: datos.nombre,
                parentescoid: datos.parentescoid ? datos.parentescoid : null,
                ingresosluxid: [datos.ingresosluxid ? datos.ingresosluxid : null],
                padresotutoresid: datos.padresotutoresid ? datos.padresotutoresid : null,
                ingresomensualbruto: [datos.ingresomensualbruto || datos.ingresomensualbruto == 0 ? datos.ingresomensualbruto : null],
                ingresomensualneto: [datos.ingresomensualneto || datos.ingresomensualneto == 0 ? datos.ingresomensualneto : null],
                rentas: [datos.rentas || datos.rentas == 0 ? datos.rentas : null],
                donativo: [datos.donativo || datos.donativo == 0 ? datos.donativo : null],
                otrosingresos: [datos.otrosingresos || datos.otrosingresos == 0 ? datos.otrosingresos : null],
                fondodeahorro: [datos.fondodeahorro || datos.fondodeahorro == 0 ? datos.fondodeahorro : null],
                aguinaldo: [datos.aguinaldo || datos.aguinaldo == 0 ? datos.aguinaldo : null],
                utilidades: [datos.utilidades || datos.utilidades == 0 ? datos.utilidades : null],
                interesesporinversion: [datos.interesesporinversion || datos.interesesporinversion == 0 ? datos.interesesporinversion : null]
            });
        }

        return item;
    }


    valoresform(datos: any, identificador: string): FormGroup {
        let item;
        if (identificador == 'padres') {
            item = this._fb.group({
                nombre: datos.parentescoid.descripcion,
                parentescoid: datos.parentescoid.parentescoid,
                ingresosluxid: [datos.ingresosluxid ? datos.ingresosluxid.ingresosluxid : null],
                padresotutoresid: datos.padresotutoresid ? datos.padresotutoresid : null,
                ingresomensualbruto: [datos.ingresosluxid ? datos.ingresosluxid.ingresomensualbruto : null],
                ingresomensualneto: [datos.ingresosluxid ? datos.ingresosluxid.ingresomensualneto : null],
                rentas: [datos.ingresosluxid ? datos.ingresosluxid.rentas : null],
                donativo: [datos.ingresosluxid ? datos.ingresosluxid.donativo : null],
                otrosingresos: [datos.ingresosluxid ? datos.ingresosluxid.otrosingresos : null],
                fondodeahorro: [datos.ingresosluxid ? datos.ingresosluxid.fondodeahorro : null],
                aguinaldo: [datos.ingresosluxid ? datos.ingresosluxid.aguinaldo : null],
                utilidades: [datos.ingresosluxid ? datos.ingresosluxid.utilidades : null],
                interesesporinversion:  [datos.ingresosluxid ? datos.ingresosluxid.interesesporinversion : null],

            });
        } else {
            item = this._fb.group({
                nombre: datos.nombre,
                parentescoid: null,
                ingresosluxid: [datos.ingresosluxid ? datos.ingresosluxid.ingresosluxid : null],
                padresotutoresid: datos.padresotutoresid ? datos.padresotutoresid : null,
                ingresomensualbruto: [datos.ingresosluxid ? datos.ingresosluxid.ingresomensualbruto : null],
                ingresomensualneto: [datos.ingresosluxid ? datos.ingresosluxid.ingresomensualneto : null],
                rentas: [datos.ingresosluxid ? datos.ingresosluxid.rentas : null],
                donativo: [datos.ingresosluxid ? datos.ingresosluxid.donativo : null],
                otrosingresos: [datos.ingresosluxid ? datos.ingresosluxid.otrosingresos : null],
                fondodeahorro: [datos.ingresosluxid ? datos.ingresosluxid.fondodeahorro : null],
                aguinaldo: [datos.ingresosluxid ? datos.ingresosluxid.aguinaldo : null],
                utilidades: [datos.ingresosluxid ? datos.ingresosluxid.utilidades : null],
                  interesesporinversion:  [datos.ingresosluxid ? datos.ingresosluxid.interesesporinversion : null],
            });
        }

        return item;
    }




    actualizardeudas(deudas: any) {
        this.datosdeudasycreditos = deudas;
        this.sumaegresos(this.formulario.get('egresos').value);
    }

    //Sumas totales de ingresos y egresos
    sumaingresos(item) {
        if (this.sistema == 2) {
            this.totalingreso =
                Number(item.ingresospadre) +
                Number(item.otrosfamiliares) +
                Number(item.ingresosmadre) +
                Number(item.otrosingresos);
        } else {
            let suma = 0;
            (item as any[]).forEach(element => {
                suma += //Number(element.ingresomensualbruto ? element.ingresomensualbruto : 0) +
                    Number(element.ingresomensualneto ? element.ingresomensualneto : 0) +
                    Number(element.rentas ? element.rentas : 0) +
                    Number(element.donativo ? element.donativo : 0) +
                    Number(element.otrosingresos ? element.otrosingresos : 0) +
                    Number(element.utilidades ? (element.utilidades / 12) : 0) +
                    Number(element.fondodeahorro ? (element.fondodeahorro / 12) : 0) +
                    Number(element.aguinaldo ? (element.aguinaldo / 12) : 0) +
                    Number(element.interesesporinversion ? element.interesesporinversion : 0);

            });
            this.totalingreso = suma;
        }
    }


    sumaegresos(item: any) {
        if (this.sistema == 2) {
            this.totalegresos = Number(this.formulario.get('egresos').get("egresosfamiliares").value) +
                (this.datosdeudasycreditos ? this.datosdeudasycreditos.reduce((a, b) => a + Number(b.pagomensual), 0) : 0);
        } else {
            this.totalegresos =
                Number(item.alimentacion ? item.alimentacion : 0) +
                Number(item.mantenimientoautos ? item.mantenimientoautos : 0) +
                Number(item.gastosdiversion ? item.gastosdiversion : 0) +
                Number(item.renta ? item.renta : 0) +
                Number(item.telefonofijo ? item.telefonofijo : 0) +
                Number(item.inscripcioncolegios ? item.inscripcioncolegios : 0) +
                Number(item.hipoteca ? item.hipoteca : 0) +
                Number(item.telefonomovil ? item.telefonomovil : 0) +
                Number(item.colegiaturas ? item.colegiaturas : 0) +
                Number(item.predial ? item.predial : 0) +
                Number(item.television ? item.television : 0) +
                Number(item.segurovida ? item.segurovida : 0) +
                Number(item.empleadadomestica ? item.empleadadomestica : 0) +
                Number(item.gas ? item.gas : 0) +
                Number(item.seguroautos ? item.seguroautos : 0) +
                Number(item.gastosmedicos ? item.gastosmedicos : 0) +
                Number(item.agua ? item.agua : 0) +
                Number(item.segurogastosmedicos ? item.segurogastosmedicos : 0) +
                Number(item.transporteurbano ? item.transporteurbano : 0) +
                Number(item.luz ? item.luz : 0) +
                Number(item.clasesextra ? item.clasesextra : 0) +
                Number(item.gasolina ? item.gasolina : 0) +
                Number(item.mantenimientofraccionamiento ? item.mantenimientofraccionamiento : 0) +
                Number(item.otros1 ? item.otros1 : 0) +
                Number(item.clubdeportivogimnasio ? item.clubdeportivogimnasio : 0) +
                Number(item.vestido ? item.vestido : 0) +
                Number(item.otros2 ? item.otros2 : 0) +
                Number(item.vacaciones ? item.vacaciones : 0) + (this.datosdeudasycreditos ? this.datosdeudasycreditos.reduce((a, b) => a + Number(b.pagomensual), 0) : 0);
        }
    }


    familiaresdirectos(respuesta) {
    }


    guardar() {
        this.submitted = true;
        if ((this.totalingreso) <= 0
        ) {
            Messenger().post({
                message: "El total de ingresos debe ser mayor a cero.",
                type: "success",
                showCloseButton: true
            });
            return false;
        }
        if ((this.totalegresos) <= 0) {
            Messenger().post({
                message: "El total de egresos debe ser mayor a cero.",
                type: "success",
                showCloseButton: true
            });
            return false;
        }
        if (this.datospropiedades.length == 0 && this.sistema == 2) {
            Messenger().post({
                message: "Debe capturar al menos una propiedad o inmueble de la familia",
                type: "success",
                showCloseButton: true
            });
            return false;
        }

        if (this.formulario.get('ingresos').invalid || this.formulario.get('situacion').invalid || this.formulario.get('egresos').invalid) {
            Messenger().post(
                {
                    message: 'Completa correctamente todos los datos.',
                    type: 'success',
                    showCloseButton: true
                });
            return false;
        }

        this.guardarpeticion().then(() => {
            this.accionGuardar.next(true);
        });

    }

    guardarpeticion(): Promise<any> {
        var promise = new Promise((result, reject) => {
            this.formulario.get("solicitudid").setValue(this.parametrosModal.solicitudid);
            this._httpService.postElemento("Becas/SolicitudBeca/SituacionEconomica", this.formulario.value, null, true).subscribe(
                res => {
                    if (res.status == 200) {
                        this.parametrosModal.pestanaSituacionEconomica.formulario = this.formulario.value;
                        result();
                    } else {
                        Messenger().post({
                            message: "Ocurrio un error al guardar el registro",
                            type: "success",
                            showCloseButton: true
                        });
                        reject();
                    }
                },
                err => {
                    //handle your error here.
                    console.log(err);
                }
            );
        });

        return promise;
    }


    /***********************Descarga de archivos*****************************/
    descargarReglamento() {
        let reglamento;
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

    descargar() {
        this._httpService.getArchivo("Solicitud/DownloadFormatoSolicitudBeca/?solicitudid=" + this.parametrosModal.solicitudid + "&tipoformatoid=10&tipo=" + this.URLBase.sistema, null).subscribe(
            result => {
                if (result.status == 200) {
                    importedSaveAs(result.body, "solicitud");
                } else {
                    Messenger().post({
                        message: 'No hay un formato disponible',
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

        if ((this.totalingreso) <= 0) {
            Messenger().post({
                message: "El total de ingresos debe ser mayor a cero.",
                type: "success",
                showCloseButton: true
            });
            return false;
        }
        if ((this.totalegresos) <= 0) {
            Messenger().post({
                message: "El total de egresos debe ser mayor a cero.",
                type: "success",
                showCloseButton: true
            });
            return false;
        }
        if (this.datospropiedades.length == 0 && this.sistema == 2) {
            Messenger().post({
                message: "Debe capturar al menos una propiedad o inmueble de la familia",
                type: "success",
                showCloseButton: true
            });
            return false;
        }

        if (this.formulario.get('ingresos').invalid || this.formulario.get('situacion').invalid || this.formulario.get('egresos').invalid) {
            Messenger().post(
                {
                    message: 'Completa correctamente todos los datos.',
                    type: 'success',
                    showCloseButton: true
                });
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


}
