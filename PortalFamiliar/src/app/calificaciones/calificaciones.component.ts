import { AfterViewInit, AfterContentInit, ViewEncapsulation, Component, OnInit, ViewChild } from '@angular/core';
import { AppState } from 'app/app.service';
import { Router } from '@angular/router';
import { FormGroup, FormBuilder, Validators, FormArray } from '@angular/forms';
import { ModalDirective } from 'ng2-bootstrap/modal';
import { Subject } from 'rxjs/Rx';
import { saveAs as importedSaveAs } from "file-saver";
import { StorageService } from 'app/Servicios/storage.service';


declare let Messenger: any;
declare let alasql: any;
declare var $: any;

@Component({
    selector: 'calificaciones',
    templateUrl: './calificaciones.component.html',
    encapsulation: ViewEncapsulation.None,
})
export class CalificacionesComponent implements OnInit, AfterViewInit {

    accion: boolean;
    submitted: boolean;
    submittedconsulta: boolean;
    id: number = 1;
    mostrar: boolean = false;
    mostrarCalificaciones: boolean = false;
    mostrararea: boolean;
    dtOptions: any = {};
    dtTrigger = new Subject();
    dtOptions2: any = {};
    dtTrigger2 = new Subject();
    exportar: any;
    alumno: any;
    alumnoid: any;
    arrayalumno: any[] = [];
    arraycalificaciones: any[] = [];
    arrayperiodos: any[] = [];
    arraymaterias: any[] = [];
    arraymateriasr: any[] = [];
    arraycolumnas: any[] = [];
    arraytabla: any[] = [];
    selectAlumno: any[] = [];
    padreotutorid: any;
    FormAlumno: FormGroup;
    bloqueoalumno: any;
    bloqueoadeudo: boolean;
    bloqueojunta: boolean;
    observacionesjunta: any;
    observacionesbloqueo: any;
    observacionesadeudo: any;
    datosalumno: any;
    sistema: any;
    detallecalificacion: any;

    portalcalificacion: boolean = true;
    boletacalificacion: boolean = true;

    @ViewChild('modal') public modal: ModalDirective;
    @ViewChild('modaldetallecal') public modaldetallecal: ModalDirective;
    @ViewChild('modalCalificacion') public modalCalificacion: ModalDirective;

    constructor(private URLBase: AppState, private _httpService: AppState, private _fb: FormBuilder, private _router: Router, private storage: StorageService) {
        this.padreotutorid = this.storage.getItem('PadresOTutoresId');
        this.alumnoid = this.storage.getItem('AlumnoId');
        this.sistema = _httpService.sistema;
    }
    //Metodo de inicio
    ngOnInit(): void {
        $.fn.dataTable.ext.errMode = 'none';
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
                title: 'calificaciones',
                exportOptions: { orthogonal: 'sort', columns: [1] }
            }],
            initComplete: () => {
                var botones = $('.dt-buttons').hide();
                this.exportar = function () {
                    botones.find('.buttons-excel').click();
                }
            },
            language: { url: "./assets/datatable/Spanish.json" },
            columnDefs: [{ "targets": [4], "searchable": false, "orderable": false }],
            order: [0]
        };

        this.dtOptions2 = {
            dom: 'Blfrtip',
            initComplete: () => {
                var botones2 = $('.dt-buttons').hide();
            },

            language: { url: "./assets/datatable/Spanish.json" }
        };

        this.FormAlumno = this._fb.group({
            alumnoid: [, <any>Validators.required]
        });

    }

    ngAfterViewInit() {
        this.dtTrigger.next();
        this.dtTrigger2.next();
        this.datosHijos();
        this.modaldetallecal.onHidden.subscribe(() => {
            $('body').addClass('modal-open');
        });
    }

    datosHijos() {
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


    cagarInfo(idalumno) {
        if (idalumno) {
            this.datosAlumnos(idalumno);
            this.consultar(idalumno);
        } else {
            this.limpiarDatos();
        }
    }

    datosAlumnos(id) {
        this._httpService.getElemento('Alumno/?alumnoid=' + id).subscribe(
            result => {
                if (result.status == 200) {
                    this.alumno = result.body[0];
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

    consultar(idalumno) {
        this._httpService.getElemento('Controlescolar/Alumno/Subgrupos/Datoalumno?alumnoid=' + idalumno).subscribe(
            res => {
                if (res.status == 200) {
                    this.arraytabla = res.body;
                    this.mostrar = true;
                } else {
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            err => {
                //handle your error here.
                console.log(err);
            }
        );
    }

    openCalificaciones(obj) {
        let hoy = new Date();
        this.bloqueoalumno = false;
        this.observacionesbloqueo = false;
        this.bloqueoadeudo = false;
        this.datosalumno = obj;
        let objeto = {
            alumnoporcicloid: obj.alumnoporcicloid,
            cicloid: obj.cicloid? obj.cicloid: null,
            gradoid: obj.gradoid? obj.gradoid : null
        }
        let data = $.param(objeto);
        this._httpService.getElemento('Controlescolar/CapturaCalificacion/alumno?alumnoid[]=' + this.FormAlumno.get("alumnoid").value + '&' + data).subscribe(
            result => {
                if (result.status == 200) {
                    let data = result.body.data[0];
                    if (data) {
                        if(data.permisos) {
                            this.portalcalificacion = data.permisos.consultaportalpadres;
                            this.boletacalificacion = data.permisos.boletaportalpadres;
                        }   

                        if (data.bloqueo || (data.bloqueoadeudo) || data.bloqueojunta) {
                            this.bloqueoalumno = true;
                            this.observacionesbloqueo = data.observacionesbloqueo;
                            this.mostrarCalificaciones = false;
                            this.bloqueoadeudo = data.bloqueoadeudo;
                            this.observacionesadeudo = data.observacionesadeudo;
                            this.bloqueojunta = data.bloqueojunta;
                            this.observacionesjunta = data.observacionesjunta;
                            this.modalCalificacion.show();
                                            
                        } else {
                            try {
                                //this.arraycolumnas = data.col.filter(x=> x.visible ? x.visible[2] == true : false);
                                data.col.forEach(x=>{
                                    let status=x.visible[2],
                                        dateCheck=x.fechadefinitiva;
                                    x.visible=status;
                                    if(!status){
                                        let fechita=new Date(dateCheck);
                                        x.publicacion=fechita.getDate()+"/"+(fechita.getMonth() + 1)+"/"+fechita.getFullYear();
                                    }
                                });
                                this.arraycolumnas = data.col;
                                this.arraymateriasr = data.row;
                                this.arraycalificaciones = data.inte;
                                this.modalCalificacion.show();
                                this.mostrarCalificaciones = true;

                            } catch (error) {
                                console.log(error);
                                Messenger().post({
                                    message: "Ocurrio un error al obtener las calificaciones del alumno.",
                                    type: 'success',
                                    showCloseButton: true
                                });
                            }
                        }
                    } else {
                        Messenger().post({
                            message: "No se encontraron calificaciones relacionadas con el alumno.",
                            type: 'success',
                            showCloseButton: true
                        });
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
    getDataXY(materia,periodo){
        let data=this.arraycalificaciones.find(x=>x.row==materia.id && x.col==periodo.id);
        if(data){
            if(!data._cali){
                let calificacion;
                if(data.extra){
                    calificacion=data.extra+" (E)";
                }else if(data.rec){
                    calificacion=data.rec+" (Rc)";
                }else if(data.data4){
                    calificacion=data.data4;
                }else{
                    let calRaw=[];
                    if(data.data){ calRaw.push(data.data); }
                    if(data.data2){ calRaw.push(data.data2); }
                    calificacion=calRaw.join("/");
                }
                data._cali=calificacion;
            }
            return data._cali;
        }
        return "-";
    }
    imprimirboleta() {
        let objeto = {
            publicacion: true,
            cicloid: this.datosalumno.cicloid,
            nivelid: this.datosalumno.nivelid,
            gradoid: this.datosalumno.gradoid,
            matricula: this.alumno.matricula
        }
        let data = $.param(objeto);
        this._httpService.getArchivo('Controlescolar', 'Boletaimpresion/?' + data).subscribe(
            result => {
                if (result.status == 200) {
                    importedSaveAs(result.body, "boleta");
                } else {
                    Messenger().post({
                        message: 'No es posible generar la boleta ya que no se ha configurado. Comuníquese al área de Sistemas del Instituto.',
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
    limpiarDatos() {
        this.mostrar = false;
        this.arraymateriasr = [];
        this.arraycolumnas = [];
    }

    detallecal(materia, periodo){
        let criterios=[],
            data=this.arraycalificaciones.find(x=>x.row==materia.id && x.col==periodo.id),
            cfinal={_total:true, aspecto:"Total", calificacion:"-"};
        if(data){
            cfinal.calificacion=data._cali;
            if(data.det){
                criterios=data.det.map(x=>{
                    x.aspecto=x.nombre+" ("+x.porcentaje+"%)";
                    return x;
                });
            }
        }
        criterios.push(cfinal);
        this.detallecalificacion={
            materia: materia.nombre,
            periodo: periodo.nombre,
            detalle: criterios
        }
        this.modaldetallecal.show();
    }

}
