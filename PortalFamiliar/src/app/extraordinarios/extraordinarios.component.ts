import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { AppState } from "app/app.service";
import { Router } from '@angular/router';
import { ModalDirective } from 'ng2-bootstrap/modal';
import { Subject } from 'rxjs/Rx';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { StorageService } from 'app/Servicios/storage.service';


declare let Messenger: any;
declare let $: any;

@Component({
    selector: 'extraordinarios',
    templateUrl: './extraordinarios.component.html'
})

export class ExtraordinariosComponent implements OnInit, AfterViewInit {


    accion: boolean;
    FormGuardar: FormGroup;
    FormAlumno: FormGroup;
    submitted: boolean;
    padreotutorid: any;
    submittedBuscar: boolean;

    @ViewChild('modal') public modal: ModalDirective;

    exportar: any;
    dtOptions: any = {};
    dtTrigger = new Subject();
    fechaperiodo: any;
    selectPeriodo: any[];
    arrayentidad: any[];
    hoy: any;
    selectActivo: any[];
    selectAlumno: any[];

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private _fb: FormBuilder, private _router: Router, private storage: StorageService) {
        this.padreotutorid = this.storage.getItem('PadresOTutoresId');
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.dtOptions = {
            dom: 'Blfrtip',
            buttons: [{
                extend: 'excel',
                title: 'Extraordinarios',
            }],
            initComplete: () => {
                var botones = $('.dt-buttons').hide();
                this.exportar = function () {
                    botones.find('.buttons-excel').click();
                }
            },
            language: { url: "./assets/datatable/Spanish.json" },
        };

        this.FormAlumno = this._fb.group({
            alumnoid: [, <any>Validators.required],
            periodoregularizacionid: []
        });

    }

    ngAfterViewInit(): void {
        this.dtTrigger.next();
        this.datosIniciales();
        this.getPeriodos();
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

    getPeriodos() {
        this._httpService.getElemento('Controlescolar/Extraordinario/Periodos').subscribe(
            result => {
                if (result.status == 200) {
                    this.selectPeriodo = result.body.periodos;
                    this.hoy = result.body.hoy;
                    let today = new Date(this.hoy);
                    for (let p of this.selectPeriodo) {
                        if (new Date(this.hoy) >= new Date(p.fechainicio) && new Date(p.fechafin) > new Date(this.hoy)) {
                            this.FormAlumno.get("periodoregularizacionid").setValue(p.periodoregularizacionid);
                        }
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

    //Accion de busqueda de inicio
    buscar() {
        this.submittedBuscar = true;
        if(this.FormAlumno.invalid) {
            return false;
        }
        let datos = this.FormAlumno.value;
        let data = $.param(datos);
        //Llamada al servicio get para obtener el array para llenar el grid
        this._httpService.getElemento('Controlescolar/Extraordinario/Alumno/' + datos.alumnoid + '?' + data).subscribe(
            result => {
                if (result.status == 200) {
                    let hoy = result.body.hoy;
                    let alumno = this.selectAlumno.find(x => x.alumnoid == datos.alumnoid);
                    ($("#tablaExtraordinario") as any).dataTable().fnDestroy();
                    this.fechaperiodo = result.body.periodos.filter(x => x.cicloid.cicloid == alumno.cicloid && new Date(x.fechalimiteasignacion) >= new Date(hoy))[0];
                    this.arrayentidad = result.body.extraordinarios;
                    this.dtTrigger.next();
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

    limpiar() {
        this.submittedBuscar = false;
        this.FormAlumno.reset();
        ($("#tablaExtraordinario") as any).dataTable().fnClearTable();
    }

}
