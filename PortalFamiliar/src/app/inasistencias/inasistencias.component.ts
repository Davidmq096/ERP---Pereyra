import {AfterViewInit, Component, OnInit, ViewChild} from '@angular/core';
import {AppState} from "app/app.service";
import {Router} from '@angular/router';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {Subject} from 'rxjs/Rx';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import {StorageService} from 'app/Servicios/storage.service';


declare let Messenger: any;
declare let $: any;

@Component({
    selector: 'inasistencias',
    templateUrl: './inasistencias.component.html'
})

export class InasistenciasComponent implements OnInit, AfterViewInit {


    accion: boolean;
    FormAlumno: FormGroup;
    FormBuscar: FormGroup;
    submitted: boolean;

    @ViewChild('modal') public modal: ModalDirective;

    exportar: any;
    dtOptions: any = {};
    dtTrigger = new Subject();

    arrayentidad: any[];
    padretutorid: any;

    selectActivo: any[];

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private _fb: FormBuilder, private _router: Router, private storage: StorageService) {
        this.padretutorid = this.storage.getItem('PadresOTutoresId');
    }

    //Metodo de inicio
    ngOnInit(): void {
        $.fn.dataTable.ext.errMode = 'none';
        this.dtOptions = {
            dom: 'Blfrtip',
            buttons: [{
                extend: 'excel',
                title: 'Inasistencias',
                exportOptions: {orthogonal: 'sort', columns: [0,1,2]}
            }],
            initComplete: () => {
                var botones = $('.dt-buttons').hide();
                this.exportar = function () {
                    botones.find('.buttons-excel').click();
                }
            },
            language: {url: "./assets/datatable/Spanish.json"},
            columnDefs: [{"targets": [0,1,2], "searchable": false, "orderable": false}],
            bSort: false,
            order: false
        };

        this.FormBuscar = this._fb.group({
          columna1: [],
        });

        this.FormAlumno = this._fb.group({
            alumnoid: [, <any>Validators.required]
        });

    }

    ngAfterViewInit(): void {
        this.dtTrigger.next();
        this.datosIniciales();
        //this.buscar();
    }

    selectAlumno: any[];
    arrayalumnos: any[];
    datosIniciales() {
        let alumnos = [];
        this._httpService.getElemento('portalfamiliar/hijos/' + this.padretutorid).subscribe(
            result => {
                if (result.status == 200) {
                    let alumnos = result.body;
                    for (let i = 0; i < (result.body as any[]).length; i++) {
                        alumnos[i].nombrecompleto = (result.body[i].apellidopaterno ? result.body[i].apellidopaterno : null) + ' ' +
                            (result.body[i].apellidomaterno ? result.body[i].apellidomaterno : null) + ' ' +
                            (result.body[i].apellidopaterno ? result.body[i].primernombre : null)
                    }
                    this.selectAlumno = alumnos;
                    this.arrayalumnos = alumnos.map((alu) => {
                        return alu.alumnoid;
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


    //Accion de busqueda de inicio
    buscar(id) {
        //Llamada al servicio get para obtener el array para llenar el grid
            var data = $.param({alumnoid: id, alumno: 1});
            this._httpService.getElemento('Asistencia/Cancelacion/?' + data).subscribe(
                result => {
                    if (result.status == 200) {
                        $("#tablaInasistencia").dataTable().fnDestroy();
                        this.arrayentidad = result.body
                        this.dtTrigger.next();
                    } else {
                        $("#tablaInasistencia").dataTable().fnClearTable();
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
