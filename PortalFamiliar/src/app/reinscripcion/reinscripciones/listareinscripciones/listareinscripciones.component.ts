import {ViewEncapsulation, Component, OnInit, Output, EventEmitter, Input} from '@angular/core';
import {AppState} from 'app/app.service';
import { MenuList } from "entity/menulist.ts";
import {StorageService} from 'app/Servicios/storage.service';
import {Reinscripciones} from 'app/reinscripcion/reinscripciones/reinscripciones';

declare let Messenger: any;

@Component({
    selector: 'listareinscripciones',
    templateUrl: './listareinscripciones.component.html',
    providers: [AppState],
    encapsulation: ViewEncapsulation.None,
})
export class ListareinscripcionesComponent implements OnInit {
    @Input() reinscripciones: Reinscripciones;
    @Output() output = new EventEmitter();

    alumnoid: any;
    padreotutorid: any;
    alumno: any;
    arrayentidadFull: any[];
    arrayentidad: any[];
    arraypendientes: any[];
    arraycompletados: any[];
    mostrarmensaje: boolean;
    pendientes: boolean;
    completos: boolean;
    mensajestatus: any;
    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private storage: StorageService) {
        this.padreotutorid = this.storage.getItem('PadresOTutoresId');
        MenuList.visible = true;
        window.onpopstate = null;
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.datosAlumnos();
        //this.buscar();
    }

    datosAlumnos() {
        this._httpService.getElemento('Controlescolar/Reinscripcion/Alumnosbypadretutor/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    let res = result.body;
                    this.completos  = false;
                    this.pendientes = false;

                    this.arraypendientes = res.alumnos.filter(x=> x.reinscripcionestatusid == 1 || x.reinscripcionestatusid == 3);
                    this.arraycompletados = res.alumnos.filter(x=> x.reinscripcionestatusid == 2 || x.reinscripcionestatusid == 4);

                    if (this.arraypendientes.length !== 0)                    
                       this.pendientes = true

                    if (this.arraycompletados.length !== 0)
                       this.completos = true;                        

                    if (this.arraypendientes.length == 0 && this.arraycompletados.length == 0) {
                        this.mostrarmensaje = true;
                    }else{
                        this.mostrarmensaje == false;
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
        //Llamada al servicio get para obtener el array para llenar el grid
        this._httpService.getElemento('Alumno/Examenes/' + this.alumnoid).subscribe(
            result => {
                if (result.status == 200) {

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

    Proceso(alumno) {
        this.reinscripciones.padretutorid = this.padreotutorid;
        this.reinscripciones.alumno = alumno;
        this.output.next();
    }

}
