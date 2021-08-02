import { AfterViewInit, Component,Input, Output, OnInit, ViewChild,EventEmitter } from '@angular/core';
import { AppState } from "app/app.service";
import { Router } from '@angular/router';
import { ModalDirective } from 'ng2-bootstrap/modal';
import { Subject } from 'rxjs/Rx';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import {StorageService} from 'app/Servicios/storage.service';


declare let Messenger: any;
declare let $: any;

@Component({
    selector: 'horarioalumno',
    templateUrl: './horarioalumno.component.html'
})

export class HorariosAlumnoComponent implements OnInit, AfterViewInit {

    @Output() output = new EventEmitter();
    accion: boolean;
    FormGuardar: FormGroup;
    FormAlumno: FormGroup;
    submitted: boolean;
    padreotutorid: any;

    @ViewChild('modal') public modal: ModalDirective;

    exportar: any;
    alumno: any;
    dtOptions: any = {};
    dtTrigger = new Subject();
    fechaperiodo: any;

    arrayentidad: any[];

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
                title: 'Horarios',
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
            alumnoid: [, <any>Validators.required]
        });

    }

    ngAfterViewInit(): void {
        this.dtTrigger.next();
        this.datosIniciales();
    }

    datosIniciales() {
        let data = {
            alumnoid: this.alumno.alumnoid
        }
        this._httpService.postElemento('Controlescolar/ImportarHorarios/TablaHorarioAlumno', data, null, true).subscribe(
            result => {
                if (result.status == 200) {
                    ($("#tablaHorariosDetalle") as any).dataTable().fnDestroy();
                    this.arrayentidad = result.body;
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

    terminar() {
        this.output.next();
    }

}
