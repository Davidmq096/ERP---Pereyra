import { AfterViewInit, Component, OnInit, ViewChild, ViewContainerRef,ComponentRef, ComponentFactory, ComponentFactoryResolver } from '@angular/core';
import { AppState } from "app/app.service";
import { Router } from '@angular/router';
import { ModalDirective } from 'ng2-bootstrap/modal';
import { Subject } from 'rxjs/Rx';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import {HorariosAlumnoComponent} from './horarioalumno/horarioalumno.component';
import {StorageService} from 'app/Servicios/storage.service';


declare let Messenger: any;
declare let $: any;

@Component({
    selector: 'horariosclase',
    templateUrl: './horariosclase.component.html'
})

export class HorariosClaseComponent implements OnInit, AfterViewInit {


    accion: boolean;
    FormGuardar: FormGroup;
    FormAlumno: FormGroup;
    submitted: boolean;
    padreotutorid: any;

    @ViewChild('modal') public modal: ModalDirective;

    exportar: any;
    dtOptions: any = {};
    dtTrigger = new Subject();
    fechaperiodo: any;

    arrayentidad: any[];

    selectActivo: any[];
    selectAlumno: any[];

    vistahorario: boolean = false;

    @ViewChild("containerHorario", {read: ViewContainerRef}) containerHorario;
    @ViewChild("container", {read: ViewContainerRef}) container;
    componentRef: ComponentRef<any>; // Contenedor

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private _fb: FormBuilder, private _router: Router, private _cfr: ComponentFactoryResolver, private storage: StorageService) {
        this.padreotutorid = this.storage.getItem('PadresOTutoresId');
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.dtOptions = {
            dom: 'Blfrtip',
            buttons: [{
                extend: 'excel',
                title: 'Horariosclase',
                exportOptions: {orthogonal: 'sort', columns: [0, 1, 2, 3, 4, 5]}
            }],
            initComplete: () => {
                var botones = $('.dt-buttons').hide();
                this.exportar = function () {
                    botones.find('.buttons-excel').click();
                }
            },
            language: { url: "./assets/datatable/Spanish.json" },
            columnDefs: [{"targets": [6], "searchable": false, "orderable": false}]
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

        let alumnos = [];
        this._httpService.getElemento('portalfamiliar/hijos/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    ($("#tablaHorarios") as any).dataTable().fnDestroy();
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

    //Accion de busqueda de inicio
    buscar(id) {
        let hoy = new Date();
        //Llamada al servicio get para obtener el array para llenar el grid
        this._httpService.getElemento('Controlescolar/Extraordinario/Alumno/' + id).subscribe(
            result => {
                if (result.status == 200) {
                    ($("#tablaExtraordinario") as any).dataTable().fnDestroy();
                    this.fechaperiodo = result.body.periodos.filter(x=> new Date(x.fechalimiteasignacion) >= hoy)[0];
                    this.arrayentidad = result.body.extraordinarios.filter(x=> !x.periodoregularizacionid
                         || (this.fechaperiodo? x.periodoregularizacionid == this.fechaperiodo.periodoregularizacionid : null) );
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

    openmodalHorario(alumno) {
        this.containerHorario.clear();
        const factory: ComponentFactory<any> = this._cfr.resolveComponentFactory(HorariosAlumnoComponent);
        this.componentRef = this.containerHorario.createComponent(factory);
        this.vistahorario = true;
        this.componentRef.instance.alumno=alumno;
        this.componentRef.instance.output.subscribe((alu) => {
            this.componentRef.destroy();
            this.vistahorario = false;
        });
    }

}
