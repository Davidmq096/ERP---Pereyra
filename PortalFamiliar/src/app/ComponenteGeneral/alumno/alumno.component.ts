import {AfterViewInit, ViewEncapsulation, Component, OnInit, ViewChild, Input, Output, EventEmitter} from '@angular/core';
import {AppState} from '../../app.service';
import {FormGroup, FormBuilder} from '@angular/forms';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {Subject} from 'rxjs/Rx';

import {Seguridad} from '../../../entity/seguridad';
import {Alumno} from './alumno';

declare let Messenger: any;
declare let $: any;
declare var alasql: any;

@Component({
    selector: 'alumno',
    templateUrl: './alumno.component.html',
    providers: [AppState],
    encapsulation: ViewEncapsulation.None,
})
export class AlumnoComponent implements OnInit, AfterViewInit {
    @Input() seguridad: Seguridad;
    @Output() output = new EventEmitter();

    alumno: Alumno = new Alumno();

    FormBuscarAlumno: FormGroup;
    submittedAlumno: boolean;

    NivelSelect: any[];
    GradoSelectFull: any[]
    GradoSelect: any[];

    @ViewChild('modal') public modal: ModalDirective;

    dtOptionsalumno: any = {};
    dtTriggeralumno = new Subject();
    arrayentidadalumno: any[];

    constructor(private _httpService: AppState, private _fb: FormBuilder) {}

    //Metodo de inicio
    ngOnInit(): void {
        this.dtOptionsalumno = {
            dom: 'frtip',
            language: {url: "./assets/datatable/Spanish.json"},
            columnDefs: [{"targets": [7], "searchable": false, "orderable": false}]
        };
        this.FormBuscarAlumno = this._fb.group({
            matricula: [],
            nombre: [],
            apellidopaterno: [],
            apellidomaterno: [],
            nivelid: [],
            gradoid: []
        });
    }

    ngAfterViewInit(): void {
        this.datosIniciales();
        this.dtTriggeralumno.next();
        this.modal.show()
    }

    datosIniciales() {
        this._httpService.getElemento('Alumno').subscribe(
            result => {
                if (result.status == 200) {
                    this.NivelSelect = alasql('SELECT * FROM ? where nivelid IN (' + this.seguridad.nivel + ')', [result.body.nivel]);
                    this.GradoSelectFull = alasql('SELECT * FROM ? where gradoid IN (' + this.seguridad.grado + ')', [result.body.grado]);
                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                var errorMessage = <any> error;
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    load(id: any) {
        this.FormBuscarAlumno.get('gradoid').setValue(null);
        this.GradoSelect = this.GradoSelectFull.filter(x => x.nivelid.nivelid == id);
    }

    buscarAlumno() {
        this.submittedAlumno = true;
        if (!this.FormBuscarAlumno.get('matricula').value && !this.FormBuscarAlumno.get('apellidopaterno').value && !this.FormBuscarAlumno.get('apellidomaterno').value
            && !this.FormBuscarAlumno.get('nombre').value && !this.FormBuscarAlumno.get('nivelid').value && !this.FormBuscarAlumno.get('gradoid').value) {
            return false;
        }
        this.submittedAlumno = false;

        let data = this.FormBuscarAlumno.value;
        if (!this.FormBuscarAlumno.get('nivelid').value) {
            data.nivelid = this.NivelSelect.map(function (a) {return a.nivelid});
        } else {
            if (!this.FormBuscarAlumno.get('gradoid').value) {
                data.gradoid = this.GradoSelect.map(function (a) {return a.gradoid});
            }
        }

        data = $.param(data);
        //Llamada al servicio get para obtener el array para llenar el grid
        this._httpService.getElemento('Alumno/?' + data).subscribe(
            result => {
                if (result.status == 200) {
                    $("#tablaConsultaAlumno").dataTable().fnDestroy();
                    this.arrayentidadalumno = result.body;
                    this.dtTriggeralumno.next();
                } else {
                    $("#tablaConsultaAlumno").dataTable().fnClearTable();
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                var errorMessage = <any> error;
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    cerrar(a: any) {
        if (a)
            this.alumno = {
                alumnoid: a.alumnoid,
                matricula: a.matricula,
                nombre: a.primernombre,
                apellidopaterno: a.apellidopaterno,
                apellidomaterno: a.apellidomaterno,
                nivelid: a.nivelid,
                nivel: a.nivel,
                gradoid: a.gradoid,
                grado: a.grado,
                grupo: a.grupo,
                estatusid: a.alumnoestatusid,
                estatus: a.estatus,
                adeudo: a.adeudo,
                tipobaja: a.tipobaja,
                motivobaja: a.motivobaja
            }
        this.output.next({modal: this.modal, alumno: a ? this.alumno : null});
        this.modal.hide();
    }

}
