import { AfterViewInit, AfterContentInit, ViewEncapsulation, Component, OnInit, ViewChild, ElementRef } from '@angular/core';
import { AppState } from 'app/app.service';
import { Router, Event as RouterEvent, NavigationEnd } from '@angular/router';
import { FormGroup, FormBuilder, Validators, FormArray } from '@angular/forms';
import { ModalDirective } from 'ng2-bootstrap/modal';
import { Subject } from 'rxjs/Rx';
import createNumberMask from "text-mask-addons/dist/createNumberMask";
import { saveAs as importedSaveAs } from "file-saver";
import { Config } from 'app/config';
import { DomSanitizer } from '@angular/platform-browser';
import {StorageService} from 'app/Servicios/storage.service';


declare let Messenger: any;
declare let alasql: any;
declare var $: any;

@Component({
    selector: 'inscripciontalleres',
    templateUrl: './inscripciontalleres.component.html',
    encapsulation: ViewEncapsulation.None,
})
export class InscripcionTallerComponent implements OnInit, AfterViewInit {
    configuraciontaller: any;
    opcionregistro: any;
    accion: boolean;
    submitted: boolean;
    submittedreglamento: boolean;
    dtOptions: any = {};
    dtTrigger = new Subject();
    exportar: any;
    temp: any;
    formato: boolean = false;
    arraytaller: any[] = [];
    arrayalumnos: any[] = [];
    arraydocumentos: any[] = [];
    arraysec: any[] = [];
    datostabla: any[] = [];
    padreotutorid: any;
    objetoalumno: any;
    tallerespagador: boolean = false;
    arrayseleccionado: any[] = [];
    selectAlumno: any[] = [];
    alumnoid: any;
    usuarioid: any;
    cadena: string;
    documentosporpagar: any;
    importe: any;
    permiteinscripcion: boolean = true;
    save: boolean = false;
    sistema: any;
    router: Router;
    rutareglamento: any;
    datosBanco: any;
    disponible: boolean = false;
    FormGuardar: FormGroup;
    FormReglamento: FormGroup;
    FormAlumno: FormGroup;
    FormPersona: FormGroup;
    leyenda: any;
    ordenmodal: any;

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

    @ViewChild('modalinscripcion') public modalinscripcion: ModalDirective;
    @ViewChild('modalReglamento') public modalReglamento: ModalDirective;

    @ViewChild('solicitudCobro') public solicitudCobro;

    @ViewChild('modalPago') public modalPago: ModalDirective;

    constructor(private URLBase: AppState, private HostElement: ElementRef, 
        private _httpService: AppState, 
        private _fb: FormBuilder, 
        private _router: Router,
        private storage: StorageService) {
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
            columnDefs: [{ "targets": [0, 12], "searchable": false, "orderable": false }]
        };

        this.FormGuardar = this._fb.group({
            horas: [, <any>Validators.required],
            pago: [, <any>Validators.required],
        });

        this.FormAlumno = this._fb.group({
            alumnoid: [, <any>Validators.required]
        });

        this.FormPersona = this._fb.group({
            nombrepersona: [, <any>Validators.required]
        });

        this.arraytaller = [
            { id: 0, ciclo: "2018 - 2019", taller: "Música", profesor: "Huerta Godínez Abraham", costo: 250, l: "12:00 - 13:00", m: "15:00 - 16:00", mi: "10:00 - 11:00", descripcion: "Curso músical para todas las edades, incialización musical, coro, lírica", fechavencimiento: "22/06/2019 - 17:20" },
            { id: 1, ciclo: "2018 - 2019", taller: "Dibujo", profesor: "Pérez Mora Andrea", costo: 200, j: "12:00 - 13:00", v: "15:00 - 16:00", l: "14:00 - 15:00", descripcion: "Taller de dibujo básico", fechavencimiento: "24/06/2019 - 12:00" },
            { id: 2, ciclo: "2018 - 2019", taller: "Pintura", profesor: "Godínez Lucatero Javier", costo: 100, l: "15:00 - 16:00", descripcion: "Pintura aguada, acrílica, al óleo, lápices de colores, carboncillo", fechavencimiento: "25/06/2019 - 23:59" },
            { id: 3, ciclo: "2018 - 2019", taller: "Teatro", profesor: "Gúzman Alvés Katia", costo: 350, l: "17:00 - 18:00", m: "13:00 - 14:00", mi: "12:00 - 13:00", j: "17:00 - 19:00", descripcion: "Pintura aguada, acrílica, al óleo, lápices de colores, carboncillo", fechavencimiento: "27/06/2019 - 15:00" },
            { id: 4, ciclo: "2018 - 2019", taller: "Karate", profesor: "Sanchez Escobar Alejandra", costo: 100, m: "17:00 - 18:00", descripcion: "Iniciación al karate" },

        ]


    }


    ngAfterViewInit() {
        this.dtTrigger.next();
        $(function () {
            $("table tr").click(function () {
                $("table tr").removeClass('selectedRow');
                $(this).addClass('selectedRow');
            });
        });
        this.modalReglamento.onHidden.subscribe(() => {
            if (this.ordenmodal == 1) {
                $('body').addClass('modal-open');
            } else {
                $('body').removeClass('modal-open');
            }
            const iframe = this.HostElement.nativeElement.querySelector('iframe');
            iframe.src = null;
            this.formato = false;
        })
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

    buscarTalleres(id) {
        let alumno = this.selectAlumno.find(x => x.alumnoid == id);
        this.alumnoid = id;
        let objeto = {
            alumnoid: alumno.alumnoid,
            gradoid: alumno.gradoid,
            cicloid: alumno.cicloid
        }

        this._httpService.postElemento('Controlescolar/conftallerextracurricular/alumno/', [alumno.alumnoid], null, true).subscribe(
            result => {
                if (result.status == 200) {
                    let peinscripcion=result.body[0].periodoinscripcion,
                        alumno=result.body[0].alumno;
                    this.objetoalumno=alumno;
                    this.tallerespagador = false;
                    this.mostrar = true;
                    this.documentosporpagar = result.body[0].documentosporpagar;
                    this.importe = result.body[0].importe;
                    this.arraytaller = result.body[0].talleresextracurriculares;
                    this.opcionregistro = result.body[0].opcionregistro;
                    this.configuraciontaller = result.body[0].configuracion;
                    this.disponible=false;
                    if(peinscripcion){
                        let reingreso=alumno.estatusalumnoporcicloid,
                            semestreid=alumno.semestreid,
                            nivelid=alumno.nivelid;
                        this.disponible=this.checkValidDates(peinscripcion,nivelid,semestreid,reingreso,result.body[0].fechaactual);
                    }

                    if (this.opcionregistro && this.opcionregistro.tipopago == 1) {
                        this.leyenda = result.body[0].leyendacaja ? result.body[0].leyendacaja.valor : "";
                    } else {
                        this.leyenda = result.body[0].leyendapreregistro ? result.body[0].leyendapreregistro.valor : "";
                    }

                    //if (this.opcionregistro.tipopago == 1) {
                    //    let talleresdisponibles = this.opcionregistro.notalleres * this.objetoalumno.totalpagos;
                    //    this.tallerespagador = this.arraytaller.length > 0 ?
                    //    this.arraytaller.filter(x => x.alumnoportaller && x.pagado).length == talleresdisponibles : false;                        
                    //}

                    if (this.arraytaller.filter(x => x.alumnoportaller).length == 0) {
                        this.tallerespagador = false;
                    }

                    this.datostabla = result.body[0].talleresextracurriculares.filter(item => item.alumnoportaller);

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

    /**método que contiene la petición para descargar archivos */
    descargar(id) {
        this.save = true;
        this.URLBase.getArchivo("Controlescolar/conftallerextracurricular", id + '?portal=2').subscribe(
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
                var errorMessage = <any>error;
                Messenger().post({
                    message: "No se pudo comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
        );
    }

    detalle(r) {
        let objeto = this.arraytaller.find(x => x.tallerextracurricularid == r);
        this.temp = objeto;
    }

    detalles(c, id, pagado) {
        if (c.target.checked && !pagado) {
            let objeto = this.arraytaller.find(x => x.tallerextracurricularid == id);
            this.arraysec.push(objeto);
        } else {
            for (let i = 0; i < this.arraysec.length; i++) {
                if (this.arraysec[i].tallerextracurricularid == id) {
                    let ids = this.arraysec.findIndex(x => x.tallerextracurricularid == id);
                    this.arraysec.splice(ids, 1);
                }

            }
        }

    }

    cancelardetalle() {
        this.FormPersona.reset();
        this.seleccionado = false;
        this.temp = null;
        this.arraysec = [];
        this.arrayseleccionado = [];
        this.permiteinscripcion = true;
        $("table tr").removeClass('selectedRow');
        $('tbody tr td input[type="checkbox"]').each(function () {
            $(this).prop('checked', false);
        });
        $('#aviso').prop('checked', false);
        this.modalinscripcion.hide();
    }


    guardar() {
        let datos;
        if (this.arraysec.length == 0) {
            Messenger().post({
                message: 'Debe seleccionar al menos un taller',
                type: 'success',
                showCloseButton: true
            });
            return false;
        }

        let check = $('#aviso').is(":checked");
        var fecha = new Date();
        let horas = this.configuraciontaller ? this.configuraciontaller.horasreservacion : null;

        this.arrayseleccionado = [];

        if (!check) {
            Messenger().post({
                message: 'Debe aceptar que ha leido el/los reglamento(s)',
                type: 'success',
                showCloseButton: true
            });
            return false;
        }

        //
        for (let j = 0; j < this.arraysec.length; j++) {
            let objeto = {
                tallerextracurricularid: this.arraysec[j].tallerextracurricularid,
                horario: this.arraysec[j].horario,
                estatusincripcionid: this.opcionregistro ? this.opcionregistro.tipopago == 2 ? 2 : 3 : null,
                subconceptoid: this.arraysec[j].subconceptoid,
                costo: this.objetoalumno.importe ? this.objetoalumno.importe : null,
                gradoid: this.objetoalumno ? this.objetoalumno.gradoid : null,
                cicloid: this.objetoalumno ? this.objetoalumno.cicloid : null,
                horasreservacion: this.configuraciontaller ? this.configuraciontaller.horasreservacion : null,
                nivelid: this.objetoalumno ? this.objetoalumno.nivelid : null,
                portal: 1,
                usuarioid: this.usuarioid
            }
            this.arrayseleccionado.push(objeto);
        }

        datos = {
            alumnoporcicloid: this.objetoalumno.alumnoporcicloid ? this.objetoalumno.alumnoporcicloid : null,
            usuarioid: this.usuarioid,
            personaautorizo: this.FormPersona.get("nombrepersona").value,
            talleres: this.arrayseleccionado
        }

        this._httpService.postElemento('Controlescolar/conftallerextracurricular/GuardarTallerAlumno', datos, null, true).subscribe(
            result => {
                if (result.status == 200) {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                    this.cancelardetalle();
                    this.modalReglamento.hide();
                    this.modalinscripcion.hide();
                    this.buscarTalleres(this.alumnoid);
                    this.ordenmodal = 2;
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

    eliminar(id: number) {
        let msg = Messenger({ extraClasses: 'messenger-fixed messenger-on-top' }).post({
            message: "Confirme que desea eliminar el registro",
            hideAfter: false,
            actions: {
                cancel: {
                    label: "Cancelar",
                    action: () => {
                        msg.hide();
                    }
                },
                delete: {
                    label: "Eliminar",
                    action: () => {
                        msg.hide();
                        //Llamada al servicio delete para eliminar un elemento
                        this._httpService.deleteElemento('Controlescolar/conftallerextracurricular/eliminarinscripcion', id).subscribe(
                            result => {
                                if (result.status == 200) {
                                    //this.cancelar();
                                    Messenger().post({
                                        message: result.body,
                                        type: 'success',
                                        showCloseButton: true
                                    });
                                    this.buscarTalleres(this.alumnoid);
                                } else if (result.status == 206) {
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
            }
        })
    }

    selectall(e: HTMLInputElement) {
        var check = e.checked;
        var rows = document.getElementById("data").getElementsByTagName('tbody');
        $('input[class="all labelCheckBox"]', rows).prop('checked', check);
    }

    seleccionTaller() {
        this.modalinscripcion.show();
        if (this.datostabla.length > 0) {
            for (let i = 0; i < this.datostabla.length; i++) {
                $('#select' + this.datostabla[i].tallerextracurricularid).prop('checked', true);
                let objeto = this.arraytaller.find(x => x.tallerextracurricularid == this.datostabla[i].tallerextracurricularid);
                this.temp = objeto;
                if (objeto && !objeto.pagado || this.opcionregistro.tipopago == 1) {
                    this.arraysec.push(objeto);
                }
            }
        }
    }
    pagoenlinea() {
        this.arraydocumentos = [];
        let arraypago = this.arraytaller.filter(x => x.alumnoportaller && !x.pagado);
        let documentosporpagar = this.documentosporpagar.split("/");
        this.arraydocumentos.push(documentosporpagar);

        if (this.sistema == 2) {
            let objeto = {
                concepto: arraypago.length < 2 ? arraypago[0].taller : "Pago de talleres extracurriculares (" + arraypago.length + ")",
                alumno: this.objetoalumno.primernombre + ' ' + (this.objetoalumno.apellidopaterno ? this.objetoalumno.apellidopaterno : '')
                    + ' ' + (this.objetoalumno.apellidomaterno ? this.objetoalumno.apellidomaterno : ''),
                documento: this.objetoalumno.documento,
                documentoPorPagarId: this.documentosporpagar,
                importe: this.importe,
                descuento: 0,
                padreotutorid: this.padreotutorid,
                tipopago: 3,
                empresaid: 2,

            }
            this._httpService.postElemento('portalfamiliar/Pago/SolicitudCobro', objeto).subscribe(
                result => {
                    if (result.status == 200) {
                        this.solicitudCobro.AbrirSolicitudPago(result.body.url);
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

        } else {
            let documentos = [];
            this.arraydocumentos.forEach((d, i) => {
                documentos.push({
                    Documento: this.objetoalumno.documento,
                    AlumnoId: this.objetoalumno.alumnoid,
                    CicloId: this.objetoalumno.cicloid,
                    DocumentoPorPagarId: d[i]
                });
            })


            let objeto = {
                //cl_folio: this.usuarioid + '-' + this.objetoalumno.matricula,
                dl_monto: this.objetoalumno.saldo,
                UsuarioId: this.usuarioid,
                TipoPago: "3",
                cl_concepto: this.objetoalumno.tipodocumento.tipodocumentoid,
                Documento: documentos
            }

            this._httpService.postElemento('pagolinea/hash', objeto).subscribe(
                result => {
                    if (result.status == 200) {
                        this.modalPago.show();
                        this.datosBanco = {
                            hash: result.body.hash,
                            cl_referencia: result.body.Referencia,
                            servicio: result.body.Servicio,
                            dl_monto: this.objetoalumno.saldo,
                            cl_folio: result.body.Folio,
                            cl_concepto: this.objetoalumno.tipodocumento.tipodocumentoid 
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
    }

    GoTobank() {
        this.openWindowWithPost('https://multipagos.bb.com.mx/Estandar/index2.php', this.datosBanco);
        this._router.navigate(['/Menu/DocumentosPagados']);
    }

    openWindowWithPost(url, data): void {
        var form = document.createElement("form");
        form.method = "POST";
        form.target = "_blank";
        form.action = url;
        form.style.display = "none";

        for (var key in data) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = data[key];
            form.appendChild(input);
        }
        document.body.appendChild(form);
        //window.open('', 'formresult', 'scrollbars=yes,menubar=no,height=600,width=870,resizable=no,toolbar=no,status=no,directories=no');
        form.submit();
        document.body.removeChild(form);
    }

    cerrarModal() {
        //Esconde el modal
        this.modalPago.hide();
    }

    private checkValidDates(praw, nivelid, semestreid, estatusinscripcion, date):boolean{
        if(estatusinscripcion!=1 && estatusinscripcion!=2){ return false; }
        if(praw){
            let per=praw.filter(x=>{ return x.nivelid.nivelid==nivelid
                && (!semestreid || (x.semestreid && x.semestreid.semestreid==semestreid)); });
            let pera=per.find(x=>{ return x.tallerextraperiodoinscripciontipoid.tallerextraperiodoinscripciontipoid==1; });
            if(!pera){//Si no es anual, buscar correspondiente a ingreso/reingreso
                let pers=(estatusinscripcion==2 ? 3 : 2);
                pera=per.find(x=>{ return x.tallerextraperiodoinscripciontipoid.tallerextraperiodoinscripciontipoid==pers; });
            }
            if(pera){
                let now=new Date(date);
                return (new Date(pera.fechainicio)<=now && now<=new Date(pera.fechafin));
            }
        }
        return false;
    }

    parseFecha(fecha: string) {
        let array = fecha.split('T');
        return array[0];
    }

    DisPreinscribirse() {
        this.permiteinscripcion = $('#aviso').is(":checked");
    }

    VerificarGuardado(id: number) {
        if (this.arraysec.length == 0) {
            Messenger().post({
                message: 'Debe seleccionar al menos un taller',
                type: 'success',
                showCloseButton: true
            });
            return false;
        }
        this.submitted = true;
        if (this.FormPersona.invalid) {
            return false;
        }
        if (this.save) {
            this.guardar();
        } else {
            this.modalReglamento.show();
            this.ordenmodal = 1;
            this.URLBase.getArchivo("Controlescolar/conftallerextracurricular", id + '?portal=2').subscribe(
                result => {
                    if (result.status == 200) {
                        let scadena = window.URL.createObjectURL(result.body);
                        const iframe = this.HostElement.nativeElement.querySelector('iframe');
                        iframe.src = scadena;
                        this.formato = true;
                    } else {
                        Messenger().post({
                            message: result.body,
                            type: "success",
                            showCloseButton: true
                        });
                    }
                },
                error => {
                    var errorMessage = <any>error;
                    Messenger().post({
                        message: "No se pudo comunicar con el servidor",
                        type: "error",
                        showCloseButton: true
                    });
                }
            );
        }
    }



}
