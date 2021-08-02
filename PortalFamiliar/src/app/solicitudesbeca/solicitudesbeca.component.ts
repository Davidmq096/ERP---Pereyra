import {AfterViewInit, Component, OnInit, ViewChild, ViewContainerRef, ComponentFactory, ComponentRef, ComponentFactoryResolver} from '@angular/core';
import {AppState} from '../app.service';
import {Router} from '@angular/router';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {Subject} from 'rxjs/Rx';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import {Seguridad} from '../../entity/seguridad';
import {ModalSolicitudComponent} from 'app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud.component';
import {parametrosModal} from 'app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud';
import {MensajeComponent} from 'app/Becas/componentesbecas/mensaje/mensaje.component';
import {StorageService} from 'app/Servicios/storage.service';

declare let Messenger: any;
declare let $: any;
declare var alasql: any;

@Component({
    selector: 'solicitudesbeca',
    templateUrl: 'solicitudesbeca.component.html',
    providers: [AppState]
})

export class SolicitudesBecaComponent implements OnInit, AfterViewInit {
    seguridad: Seguridad = new Seguridad();
    parametros: parametrosModal;
    componentRef: ComponentRef<any>;
    accion: boolean;
    FormGuardar: FormGroup;
    FormBuscar: FormGroup;
    FormSolicitud: FormGroup;
    submitted: boolean;
    periodobeca: number = 0;

    @ViewChild("containerSolicitud", {read: ViewContainerRef}) containerSolicitud;
    @ViewChild("containermensaje", {read: ViewContainerRef}) containermensaje;

    @ViewChild('modal') public modal: ModalDirective;
    @ViewChild('desplegarmenu') public modal2: ModalDirective;
    @ViewChild("modalfamilia") modalFamilia;

    @ViewChild("containerDatosPadres", {read: ViewContainerRef}) containerDatosPadres;
    @ViewChild("containerDepenedientes", {read: ViewContainerRef}) containerDependientes;
    @ViewChild("containerSituacionEconomica", {read: ViewContainerRef}) containerSituacionEconomica;
    @ViewChild("containerReferencia", {read: ViewContainerRef}) containerReferencia;
    @ViewChild("containerDocumento", {read: ViewContainerRef}) containerDocumento;
    @ViewChild("containerSocioeconomico", {read: ViewContainerRef}) containerSocioeconomico;
    @ViewChild("containerDictamen", {read: ViewContainerRef}) containerDictamen;


    dtOptions: any = {};
    dtTrigger = new Subject();
    exportar: any;
    datostabla: any[];
    familiaalumnos: any;
    clavef: any = {};

    padreotutorid: any;
    sistema: number;
    parambecas: any;
    numtablaregistros: number = 3;

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, 
        private URLBase: AppState, 
        private _fb: FormBuilder, 
        private _router: Router, 
        public _cfr: ComponentFactoryResolver,
        private storage: StorageService
        ) {
        this.parambecas = _httpService.sistema;
        this.datostabla = [];
    }

    //Accion al cerrar el modal
    cancelar() {
        //Esconde el modal
        this.modal.hide();
        //Limpia el formulario de guardad y le coloca un valor por defaul al campo activo. (Al realizar un nuevo registro el campo activo siempre debe inica true)
        this.FormGuardar.reset({activog: true});
        //Ocultamos los mensajes en el formulario de guardar
        this.submitted = false;
    }


    //Metodo de inicio
    ngOnInit(): void {
        $.fn.widgster.Constructor.DEFAULTS.bodySelector = '.widget-body form';
        $('.widget').widgster();

        this.dtOptions =
            {
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'Fondoorfandad',
                    exportOptions: {orthogonal: 'sort', columns: [1, 2, 3]}
                }],
                initComplete: () => {
                    var botones = $('.dt-buttons').hide();
                    this.exportar = function () {
                        botones.find('.buttons-excel').click();
                    }
                },
                language: {url: "./assets/datatable/Spanish.json"},
                columnDefs: [{"targets": [7], "searchable": false, "orderable": false},
                {
                    targets: [3], "orderDataType": "dom-text", type: 'string',
                    render: function (data, type, row, meta) {
                        if (type === 'sort') {
                            var $input = $(data);
                            data = ($input.hasClass("fa-check-square-o")) ? "SI" : "NO";
                        }
                        return data;
                    }
                }
                ]
            };

        this.FormGuardar = this._fb.group({
            Matricula: []
        });
        this.FormSolicitud = this._fb.group({
            clavefamiliarid: []
        });

        this.padreotutorid = this.storage.getItem("PadresOTutoresId");
        this.GetPeriodoBeca();
    }


    GetPeriodoBeca() {
        this._httpService.getElemento('Becas/SolicitudBeca/PeriodoCaptura').subscribe(
            res => {
                if (res.status == 200) {
                    this.periodobeca = res.body ? 1 : -1;
                }
                else {
                    this.periodobeca = -1;
                }
            },
            err => {
                this.periodobeca = -1;
            }
        );
    }

    guardar(matricula) {
        this.URLBase.postElemento( 'SolicitudBeca/GuardarSb',{Matricula: matricula}, null, true).subscribe(
            res => {
                if (res.status == 200) {
                    var respuesta: any = res;
                    this.getRegistros(parseInt(respuesta._body));
                    this.cancelar();
                    Messenger().post({
                        message: "Se ha guardado con éxito una nueva solicitud de beca",
                        type: 'success',
                        showCloseButton: true
                    });
                } else{
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            err => {
                //handle your error here.

            }
        );
    }

    public newestatus = "En captura";
    getRegistros(id) {
        //Llamada al servicio get para obtener el array para llenar la tabla
        this._httpService.getElemento('Becas/SolicitudBeca/padresotutores/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    this.parambecas = parseInt(result.body.parambecas);
                    console.log(this.parambecas);
                    console.log('a:');
                    if (this.parambecas == 1 && result.body.solicitudes.length == 0) {
                        console.log('3:');
                        const factory: ComponentFactory<any> = this._cfr.resolveComponentFactory(MensajeComponent);
                        var ref: ComponentRef<any> = this.containermensaje.createComponent(factory);
                        ref.instance.output.subscribe((componentemensaje: any) => {
                        });
                        this.datostabla = [];
                    } else if (result.body.solicitudes.length > 0 && result.body.solicitudes[0].alumno.length == 0) {
                        console.log('i:');
                        const factory: ComponentFactory<any> = this._cfr.resolveComponentFactory(MensajeComponent);
                        var ref: ComponentRef<any> = this.containermensaje.createComponent(factory);
                        ref.instance.output.subscribe((componentemensaje: any) => {
                        });
                        this.datostabla = [];
                    } else if (this.parambecas == 1 && result.body.solicitudes.length > 0) {
                        console.log('o:');
                        this.datostabla = result.body.solicitudes;
                    }

                    if (this.parambecas == 2) {
                        console.log('u:');
                        this.datostabla = result.body.solicitudes;

                    }

                    if (id) {
                        console.log('k:');
                        for (let solicitud of this.datostabla) {
                            if (solicitud.solicitudid == id) {
                                this.openmodalSolicitud(solicitud);
                                break;
                            }
                        }
                    }

                } else {
                    console.log('er:');
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

    ngAfterViewInit(): void {
        this.dtTrigger.next();
        this.getRegistros(null);
    }

    objeto: any[] = [];
    openmodalSolicitud(c) {

        this.containerSolicitud.clear();
        this.parametros = new parametrosModal();
        this.parametros.solicitudid = parseInt(c.solicitudid);
        this.parametros.clavefamiliarid = parseInt(c.clavefamiliarid);
        this.parametros.pestana = 1;
        this.parametros.estatusid = c.estatusid;
        if (this.parambecas == 1) {
            this.parametros.editable = c.estatusid == 2 || c.estatusid==3 ? true : false;
            this.parametros.configpestana = {
                datospadres: {visible: true, editable: c.estatusid == 2 || c.estatusid==3 ? true : false},
                dependienteseconomicos: {visible: true, editable: c.estatusid == 2 || c.estatusid==3? true : false},
                dictaminacion: {visible: true, editable: c.estatusid == 2 || c.estatusid==3? true : false},
                documentos: {visible: true, editable: c.estatusid == 2 || c.estatusid==3? true : false},
                estudiosocioeconomico: {visible: true, editable: c.estatusid == 2 || c.estatusid==3? true : false},
                referencias: {visible: true, editable: c.estatusid == 2 || c.estatusid==3? true : false},
                situacioneconomica: {visible: true, editable: c.estatusid == 2 || c.estatusid==3? true : false},
                solicitudbeca: {visible: true, editable: c.estatusid == 2 || c.estatusid==3? true : false},
            }
        } else {
            this.parametros.editable = c.alumno[0].estatusalumno ? (c.alumno[0].estatusalumno == 'En captura' || c.alumno[0].estatusalumno == 'Capturada') : (c.estatusid == 2 || c.estatusid == 3);
            this.parametros.configpestana = {
                datospadres: {visible: true, editable: c.alumno[0].estatusalumno ? (c.alumno[0].estatusalumno == 'En captura' || c.alumno[0].estatusalumno == 'Capturada') : (c.estatusid == 2 || c.estatusid == 3)},
                dependienteseconomicos: {visible: true, editable: c.alumno[0].estatusalumno ? (c.alumno[0].estatusalumno == 'En captura' || c.alumno[0].estatusalumno == 'Capturada') : (c.estatusid == 2 || c.estatusid == 3)},
                dictaminacion: {visible: true, editable: c.alumno[0].estatusalumno ? (c.alumno[0].estatusalumno == 'En captura' || c.alumno[0].estatusalumno == 'Capturada') : (c.estatusid == 2 || c.estatusid == 3)},
                documentos: {visible: true, editable: c.alumno[0].estatusalumno ? (c.alumno[0].estatusalumno == 'En captura' || c.alumno[0].estatusalumno == 'Capturada') : (c.estatusid == 2 || c.estatusid == 3)},
                estudiosocioeconomico: {visible: true, editable: c.alumno[0].estatusalumno ? (c.alumno[0].estatusalumno == 'En captura' || c.alumno[0].estatusalumno == 'Capturada') : (c.estatusid == 2 || c.estatusid == 3)},
                referencias: {visible: true, editable: c.alumno[0].estatusalumno ? (c.alumno[0].estatusalumno == 'En captura' || c.alumno[0].estatusalumno == 'Capturada') : (c.estatusid == 2 || c.estatusid == 3)},
                situacioneconomica: {visible: true, editable: c.alumno[0].estatusalumno ? (c.alumno[0].estatusalumno == 'En captura' || c.alumno[0].estatusalumno == 'Capturada') : (c.estatusid == 2 || c.estatusid == 3)},
                solicitudbeca: {visible: true, editable: c.alumno[0].estatusalumno ? (c.alumno[0].estatusalumno == 'En captura' || c.alumno[0].estatusalumno == 'Capturada') : (c.estatusid == 2 || c.estatusid == 3)},
            }
        }
        const factory: ComponentFactory<any> = this._cfr.resolveComponentFactory(ModalSolicitudComponent);
        this.componentRef = this.containerSolicitud.createComponent(factory);
        this.componentRef.instance.parametrosModal = this.parametros;
        this.componentRef.instance.output.subscribe((componentefigura: any) => {                     //Queda a espera de que el componenete regrese "this"
            this.objeto.push(componentefigura);

            this.getRegistros(null);

        });
    }

    checks: any = [];
    public todos: boolean;
    public isChecked: boolean;
    checkValue(valor) {

    }
    //seleccionar o deseleccionar todos los check
    todosloscheck(n) {

        if (this.isChecked === false) {
            this.todos = true;
            for (var i = 0; i < n.length; i++) {
                this.checks.push(n[i].becaid);
            }
        } else if (this.isChecked === true) {
            this.todos = false;
        } else {
            this.todos = true;
            for (var i = 0; i < n.length; i++) {
                this.checks.push(n[i].becaid);
            }
        }

    }

    marcados(c, event) {
        if (event.target.checked) {
            this.checks.push(c.becaid);
        } else {
            for (var i = 0; i < this.datostabla.length; i++) {
                if (this.checks[i] == c.becaid) {
                    this.checks.splice(i, 1);
                }
            }
        }
    }

    //Modal Familia
    AgregarSolicitudBeca() {
        this.modalFamilia.AbrirModal();
    }

}
