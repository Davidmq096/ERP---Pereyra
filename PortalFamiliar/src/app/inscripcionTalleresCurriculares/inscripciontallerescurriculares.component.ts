import { AfterViewInit, AfterContentInit, ViewEncapsulation, Component, OnInit, ViewChild } from '@angular/core';
import { AppState } from 'app/app.service';
import { Router, Event as RouterEvent, NavigationEnd } from '@angular/router';
import { FormGroup, FormBuilder, Validators, FormArray, FormControl } from '@angular/forms';
import { ModalDirective } from 'ng2-bootstrap/modal';
import { Subject } from 'rxjs/Rx';
import createNumberMask from "text-mask-addons/dist/createNumberMask";
import {StorageService} from 'app/Servicios/storage.service';


declare let Messenger: any;
declare let alasql: any;
declare var $: any;

@Component({
    selector: 'inscripciontallerescurriculares',
    templateUrl: './inscripciontallerescurriculares.component.html',
    encapsulation: ViewEncapsulation.None,
})
export class InscripcionTallerCurricularComponent implements OnInit, AfterViewInit {
    alumno: any;
    configuracion: any;
    configuracionopcion: any;
    arraymaterias: any[] = [];
    preregistrotaller: any;
    arrayperiodoinscripcion: any[] = [];
    capturadisponible: boolean;
    fechaactual: string;

    configuraciontaller: any;
    opcionregistro: any;
    accion: boolean;
    editable: boolean = false;
    submitted: boolean;
    submittedreglamento: boolean;
    dtOptions: any = {};
    dtTrigger = new Subject();
    exportar: any;
    temp: any;
    arraytaller: any[] = [];
    arraysec: any[] = [];
    datostabla: any[] = [];
    padreotutorid: any;
    objetoalumno: any;
    arrayseleccionado: any[] = [];
    arraytalleres: any[] = [];
    selectAlumno: any[] = [];
    alumnoid: any;
    usuarioid: any;
    sistema: any;
    router: Router;
    datosBanco: any;

    FormGuardar: FormGroup;
    FormReglamento: FormGroup;
    FormAlumno: FormGroup;

    seleccionado: boolean = false;

    mostrarboton: boolean = false;

    numberMask = createNumberMask({
        prefix: "",
        suffix: "",
        includeThousandsSeparator: false,
        thousandsSeparatorSymbol: "",
        allowDecimal: false,
        decimalSymbol: "",
        decimalLimit: "",
        integerLimit: 3,
        requireDecimal: false,
        allowNegative: false,
        allowLeadingZeroes: false
    });

    mostrar: boolean = false;
    tallerdescripcion:any;

    @ViewChild('modalinscripcion') public modalinscripcion: ModalDirective;

    @ViewChild('solicitudCobro') public solicitudCobro;

    @ViewChild('modalPago') public modalPago: ModalDirective;

    constructor(private URLBase: AppState, private _httpService: AppState, private _fb: FormBuilder, private _router: Router, private storage: StorageService) {
        this.padreotutorid = this.storage.getItem('PadresOTutoresId');
        this.usuarioid = this.storage.getItem('UsuarioId');
        this.sistema = this._httpService.sistema;
    }
    //Metodo de inicio
    ngOnInit(): void {
        $.fn.widgster.Constructor.DEFAULTS.bodySelector = '.widget-body form';
        $('.widget').widgster();
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({
                animated: "fadeIn",
                placement: "top",
                html: true
            });
        });

        this.dtOptions = {
            dom: 'Blfrtip',
            buttons: [{
                extend: 'excel',
                title: 'tallercurricular',
                exportOptions: { orthogonal: 'sort', columns: [1] }
            }],
            initComplete: () => {
                var botones = $('.dt-buttons').hide();
                this.exportar = function () {
                    botones.find('.buttons-excel').click();
                }
            },
            language: { url: "./assets/datatable/Spanish.json" },
            columnDefs: [{ "targets": [0, 10], "searchable": false, "orderable": false }]
        };

        let hoy = new Date();
        this.fechaactual = (hoy.getFullYear() + '-' + (hoy.getMonth() + 1) + '-' + hoy.getDate());

        this.FormGuardar = this._fb.group({
            alumnoid: [, <any>Validators.required],
            preregistrotallerid: [],
            opciontaller: this._fb.array([])
        });


        this.arraytaller = [
            { id: 0, ciclo: "2018 - 2019", taller: "Música", profesor: "Huerta Godínez Abraham", costo: 250, l: "12:00 - 13:00", m: "15:00 - 16:00", mi: "10:00 - 11:00", descripcion: "Curso músical para todas las edades, incialización musical, coro, lírica", fechavencimiento: "22/06/2019 - 17:20" },
            { id: 1, ciclo: "2018 - 2019", taller: "Dibujo", profesor: "Pérez Mora Andrea", costo: 200, j: "12:00 - 13:00", v: "15:00 - 16:00", l: "14:00 - 15:00", descripcion: "Taller de dibujo básico", fechavencimiento: "24/06/2019 - 12:00" },
            { id: 2, ciclo: "2018 - 2019", taller: "Pintura", profesor: "Godínez Lucatero Javier", costo: 100, l: "15:00 - 16:00", descripcion: "Pintura aguada, acrílica, al óleo, lápices de colores, carboncillo", fechavencimiento: "25/06/2019 - 23:59" },
            { id: 3, ciclo: "2018 - 2019", taller: "Teatro", profesor: "Gúzman Alvés Katia", costo: 350, l: "17:00 - 18:00", m: "13:00 - 14:00", mi: "12:00 - 13:00", j: "17:00 - 19:00", descripcion: "Pintura aguada, acrílica, al óleo, lápices de colores, carboncillo", fechavencimiento: "27/06/2019 - 15:00" },
            { id: 4, ciclo: "2018 - 2019", taller: "Karate", profesor: "Sanchez Escobar Alejandra", costo: 100, m: "17:00 - 18:00", descripcion: "Iniciación al karate" },

        ]

        this.tallerdescripcion={};

    }


    ngAfterViewInit() {
        this.dtTrigger.next();
        $(function () {
            $("table tr").click(function () {
                $("table tr").removeClass('selectedRow');
                $(this).addClass('selectedRow');
            });
        });
        this.datosIniciales();
    }

    datosIniciales() {
        let alumnos = [];
        this._httpService.getElemento('portalfamiliar/hijos/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    let alumnos = result.body;
                    for (let i = 0; i < (result.body as any[]).length; i++) {
                        alumnos[i].nombrecompleto = (result.body[i].apellidopaterno ? result.body[i].apellidopaterno : null) + ' ' +
                            (result.body[i].apellidomaterno ? result.body[i].apellidomaterno : null) + ' ' +
                            (result.body[i].apellidopaterno ? result.body[i].primernombre : null)
                    }
                    this.selectAlumno = alumnos;

                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    buscarTalleres(id) {
        if (!id) {
            this.mostrar = false;
            return false;
        }
        this.editable = false;
        this.submitted = false;
        let alumno = this.selectAlumno.find(x => x.alumnoid == id);
        this.FormGuardar = this._fb.group({
            alumnoid: [alumno? alumno.alumnoid : null, <any>Validators.required],
            preregistrotallerid: [],
            opciontaller: this._fb.array([])
        });
        this.alumnoid = id;
        let objeto = {
            alumnoid: alumno.alumnoid,
            gradoid: alumno.gradoid,
            cicloid: alumno.cicloid
        }
        let data = $.param(objeto)
        let talleres = [];
        this._httpService.getElemento('Controlescolar/preregistrocurricular/' + this.alumnoid).subscribe(
            result => {
                if (result.status == 200) {
                    this.alumno = result.body.alumno ? result.body.alumno[0] : null;
                    this.configuracion = result.body.configuracion;
                    this.configuracionopcion = result.body.configuracionopcion ? result.body.configuracionopcion[0] : null;
                    this.arraymaterias = result.body.materias;
                    this.preregistrotaller = result.body.preregistrotaller ? result.body.preregistrotaller : null;
                    if (this.preregistrotaller.length > 0) {
                        this.editable = true;
                    }
                    this.arrayperiodoinscripcion = result.body.periodoinscripcion;
                    this.FormGuardar.get('alumnoid').setValue(this.alumnoid);

                    this.mostrar = true;
                    this.objetoalumno = result.body.alumno[0];


                    if (this.configuracion.length > 0) {
                        this.capturadisponible = this.periododisponible(this.fechaactual, this.parseFecha(this.configuracion[0].fechapreregistroinicio), this.parseFecha(this.configuracion[0].fechapreregistrofin));
                    }

                    if (this.alumno.estatusalumnocicloid == "3") {
                        this.capturadisponible = false;
                    }

                    this.ValidarPeriodoClasificador();

                    //Cargamos las materias con sus opciones y talleres correspondientes 
                    let b = this.FormGuardar.get("opciontaller") as FormArray;

                    for (let i = 0; i < this.arraymaterias.length; i++) {
                        let preregistro = this._fb.group({ // Creamos un formulario con las opciones correspondientes de la materia
                            materia: [this.arraymaterias[i].nombre], // nombre de la materia
                            talleres: [this.arraymaterias[i].talleres], //Talleres que contiene cada materia
                            opciones: this._fb.array([]), // Creamos un array secundario donde estarán todas las opciones por materia
                        });

                        for (let s of this.arraymaterias[i].talleres) {
                            this.arraytalleres.push(s);
                        }

                        b.push(preregistro);
                        this.AsignarOpcionTaller(i, this.arraymaterias[i].talleres, parseInt(this.alumno.alumnoporcicloid));
                        this.AsignarValorMateria();

                    }

                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );

    }

    periododisponible(fecha, fechainicio, fechafin) {
        var rango = new Date(fecha) >= new Date(fechainicio) && new Date(fecha) <= new Date(fechafin);
        return rango;
    }

    ValidarPeriodoClasificador() {
        let disponible;
        if (this.arraymaterias.length > 0 && this.arrayperiodoinscripcion.length > 0) {
            for (let i = 0; i < this.arraymaterias.length; i++) {
                let periodo = this.arrayperiodoinscripcion.find(x => x.clasificadorparaescolaresid.clasificadorparaescolaresid
                    == this.arraymaterias[i].clasificadorparaescolaresid);

                if (this.alumno.estatusalumnocicloid && this.alumno.estatusalumnocicloid == "1") {
                    disponible = this.periododisponible(this.fechaactual,
                        this.parseFecha(periodo ? periodo.fechanuevoingresoinicio : null),
                        this.parseFecha(periodo ? periodo.fechanuevoingresofin : null));

                    if (!disponible) {
                        (this.arraymaterias as any[]).splice(i, 1);
                        i = i - 1;
                    }

                } else if (this.alumno.estatusalumnocicloid && this.alumno.estatusalumnocicloid == "2") {
                    disponible = this.periododisponible(this.fechaactual,
                        this.parseFecha(periodo ? periodo.fechareingresoinicio : null),
                        this.parseFecha(periodo ? periodo.fechareingresofin : null));

                    if (!disponible) {
                        (this.arraymaterias as any[]).splice(i, 1);
                        i = i - 1;
                    }
                }

            }
        }
    }

    AsignarOpcionTaller(index, talleres, alumnocicloid) {
        let form = (this.FormGuardar.get("opciontaller") as FormArray);
        let f = ((form.controls[index] as FormGroup).controls.opciones as FormArray)

        if (this.configuracionopcion) {
            for(let i of talleres){
                this.tallerdescripcion[i.tallercurricularid]=i.descripcion;
            }
            for (let i = 0; i < this.configuracionopcion.notalleres; i++) {
                let preregistro = this._fb.group({
                    preregistroid: [],
                    alumnoporcicloid: [alumnocicloid],
                    tallercurricularid: [, <any>Validators.required],
                    fechapreregistro: [],
                    prioridad: [i + 1],
                    usuarioid: [this.usuarioid],
                    talleres: [talleres]
                });
                f.push(preregistro);
            }
        }
    }

    AsignarValorMateria() {
        for (let j = 0; j < this.FormGuardar.get("opciontaller").value.length; j++) {
            let arrayopciones = ((((this.FormGuardar.controls.opciontaller as FormArray).controls[j] as FormGroup).controls
                .opciones as FormArray)).controls;
            for (let k = 0; k < arrayopciones.length; k++) {
                for (let i = 0; i < this.preregistrotaller.length; i++) {
                    let talleres = (arrayopciones[k] as FormGroup).controls.talleres.value;
                    let seleccionado = (talleres as any[]).find(x => x.tallercurricularid == this.preregistrotaller[i].TallerCurricularId);
                    seleccionado ? (arrayopciones[k] as FormGroup).controls.tallercurricularid.setValue(seleccionado.tallercurricularid) : null;
                    this.selectedTaller(j, null, null);
                }
            }
        }
    }
    parseFecha(fecha: string) {
        let array = fecha.split('T');
        return array[0];
    }
    selectedTaller(index, row, val) {
        let form = (this.FormGuardar.get("opciontaller") as FormArray);
        let opciones = (form.controls[index] as FormGroup).controls.opciones.value;
        let seleccionados = [];
        let array = opciones;
        for (let a of array) {
            if (a.tallercurricularid) {
                seleccionados.push(a.tallercurricularid);
            }
        }

        let disponibles = this.arraymaterias[index].talleres.filter(function (item) {
            return seleccionados.indexOf(item.tallercurricularid) == -1;
        });

        let arrayopciones = ((((this.FormGuardar.controls.opciontaller as FormArray).controls[index] as FormGroup).controls
            .opciones as FormArray));

        for (let j = 0; j < arrayopciones.value.length; j++) {
            let data = [...disponibles],
                control = (arrayopciones.controls[j] as FormGroup).controls.tallercurricularid as FormControl,
                seleccionado = this.arraymaterias[index].talleres.find(x => x.tallercurricularid == control.value);
            seleccionado ? data.push(seleccionado) : null;

            (((((this.FormGuardar.controls.opciontaller as FormArray).controls[index] as FormGroup).controls
                .opciones as FormArray).controls[j] as FormGroup).controls.talleres.setValue(data));
            seleccionado ? control.setValue(seleccionado.tallercurricularid) : null;

        }

    }

    guardar() {
        let arrayopciones = [];
        let hoy = new Date();
        this.submitted = true;
        let talleres = this.FormGuardar.get("opciontaller").value;

        if (this.FormGuardar.invalid) {
            return false;
        }


        for (let i = 0; i < this.FormGuardar.get("opciontaller").value.length; i++) {
            for (let j = 0; j < this.FormGuardar.get("opciontaller").value[i].opciones.length; j++) {
                arrayopciones.push(this.FormGuardar.get("opciontaller").value[i].opciones[j]);
            }
        }
        this._httpService.postElemento('Controlescolar/preregistrocurricular', arrayopciones, null, true).subscribe(
            result => {
                if (result.status == 200) {
                    this.editable = true;
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );

    }


}
