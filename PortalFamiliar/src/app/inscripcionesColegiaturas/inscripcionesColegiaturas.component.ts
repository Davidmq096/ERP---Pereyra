import {AfterViewInit, ViewEncapsulation, Component, OnInit, ViewChild} from '@angular/core';
import {AppState} from "app/app.service";
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {Router, Event as RouterEvent, NavigationEnd} from '@angular/router';
import {StorageService} from 'app/Servicios/storage.service';

declare let Messenger: any;
declare var $: any;
declare var $window: any;
declare var Pace: any;
declare var alasql: any;
import {DocumentoPorPagar, Multipagos, PagoLinea} from "../Modelos/PagoLinea.model";

import {Subject} from 'rxjs/Rx';
import {forEach} from "@angular/router/src/utils/collection";
import {Config} from 'app/config';

@Component({
    selector: 'InscripcionesColegiaturas',
    templateUrl: './inscripcionesColegiaturas.component.html',
    styleUrls: ['./inscripcionesColegiaturas.css'],
    encapsulation: ViewEncapsulation.None,
})
export class InscripcionesColegiaturas implements OnInit {
    @ViewChild('solicitudCobro') solicitudCobro;
    @ViewChild('mensajePago') mensajePago;

    //Gridas de catalogo Familiar
    PadresOTutoresId: number = +this.storage.getItem("PadresOTutoresId");
    status: boolean = false;
    ExistsVencidos: boolean = false;
    router: Router;
    config: Config = new Config()
    //GridGeneral
    arrayalumnos: any[];
    arraydocumentos: any[];
    arraymaestro: any[];
    arrayconvenios: any[];
    sumseleccionados: number = 0;
    arrayseleccion: any;
    arrayFactura: any;
    myalumnoid: number;
    ObjetoCobroLinea: PagoLinea;
    cantidad: number;
    datosimpresion: any = {};
    hoy: string = "";
    mostrarVencido: boolean = false;
    DatosBanco: Multipagos;


    bloqueoimpresion: any;
    observacionesimpresion: any;
    bloqueopagos: any[] = [];
    observacionespagos: any;

    //tablas
    dtOptionsDoc: any;
    dtTriggerDoc = new Subject();

    dtOptions1: any;
    dtTrigger1 = new Subject();

    tablaRegistros: number = 10;
    sistema: string;
    sistemaid: any;


    //Modal
    @ViewChild('modalPago') modalPago: ModalDirective;

    clave: string = this.storage.getItem("clave");
    grado: string = this.storage.getItem("grado");
    privacidad: string = this.storage.getItem("urlPrivacidad");
    valPadres: string = this.storage.getItem("valPadres");


    //domicilioModel: DomicilioModel = new DomicilioModel();
    constructor(private _httpService: AppState, private _fb: FormBuilder, router: Router, private storage: StorageService) {
        this.router = router;
        this.sistemaid = _httpService.sistema;
        this.sistema = _httpService.sistema == 1 ? 'lux' : _httpService.sistema == 2 ? 'ciencias' : '';
    }
    //Metodo de inicio
    ngOnInit(): void {
        this.sumseleccionados = 0;
        this.arraydocumentos = [];
        this.arraymaestro = [];
        this.arrayconvenios = [];
        this.arrayseleccion = [];
        this.myalumnoid = -1;
        this.cantidad = 0;
        this.datosimpresion = {};

        this.hoy = this.GetHoy();

        //inicializar tabla
        this.dtOptionsDoc =
            {
                dom: '',
                language: {url: "./assets/datatable/Spanish.json"},
                ordering: false,
                pageLength: this.tablaRegistros
            };

        this.dtOptions1 =
            {
                dom: '',
                language: {url: "./assets/datatable/Spanish.json"},
                ordering: false,
                pageLength: this.tablaRegistros
            };


        this.dtTriggerDoc.next();
        this.dtTrigger1.next();
    }

    //Metodo inicial
    ngAfterViewInit(): void {
        this.getAlumnos(this.PadresOTutoresId);
        this.getConvenios();
    }


    getAlumnos(id: number) {

        this._httpService.getElemento('portalfamiliar/infoalumno/' + id + '?consultainactivos=true').subscribe(
            result => {
                if (result.status == 200) {
                    this.arrayalumnos = result.body;
                    this.arrayalumnos.forEach(alumno => {
                        alumno.nombrecompleto = '';

                        if ('primernombre' in alumno)
                            alumno.nombrecompleto += alumno.primernombre + ' ';
                        if ('segundonombre' in alumno)
                            alumno.nombrecompleto += alumno.segundonombre + ' ';
                        if ('apellidopaterno' in alumno)
                            alumno.nombrecompleto += alumno.apellidopaterno + ' ';
                        if ('apellidomaterno' in alumno)
                            alumno.nombrecompleto += alumno.apellidomaterno + ' ';
                        alumno.nombrecompleto = alumno.nombrecompleto.toUpperCase();
                    });

                    this.arrayalumnos = alasql("SELECT * FROM ? ORDER BY nombrecompleto", [this.arrayalumnos]);


                    this.arrayalumnos.unshift({"nombrecompleto": "VER TODOS", "alumnoid": -1});

                    this.getDocumentos();

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

    private getTime(date?: Date) {
        return date != null ? date.getTime() : 0;
    }

    getDocumentos() {
        this.arraymaestro = [];

        this._httpService.getElemento('portalfamiliar/pagoenlinea/bypadreotutor/1/' + this.PadresOTutoresId + '?instituto=' + this.config.config.version).subscribe(result => {
            if (result.status == 200) {
                if (result.body.length > 0) {

                    let documentos = alasql("SELECT * FROM ? order by FechaLimite", [result.body]);
                    documentos.forEach(obj => {
                        obj.AlumnoId = parseInt(obj.AlumnoId);
                        if (obj.TipoPago == 'Otros') {

                            obj.ImporteTotal = parseFloat(obj.Importe);
                            obj.SaldoTotal = parseFloat(obj.Saldo);
                        } else {

                            obj.ImporteTotal = parseFloat(obj.ImporteTotal);
                            obj.SaldoTotal = parseFloat(obj.SaldoTotal);
                        }
                        obj.InteresTotal = obj.InteresTotal ? parseFloat(obj.InteresTotal) : 0;
                        obj.SaldoInscripcion = obj.SaldoInscripcion ? parseFloat(obj.SaldoInscripcion) : 0;
                        obj.SaldoFondoOrfandad = obj.SaldoFondoOrfandad ? parseFloat(obj.SaldoFondoOrfandad) : 0;

                        obj.DescuentoProntoPago = parseFloat(obj.DescuentoProntoPago);

                        obj.IsPagar = false;
                        obj.IsVencido = obj.FechaLimite < this.hoy;

                        obj.VerSubconcepto = false;

                        this.arraymaestro.push(obj);

                    });

                    this.ExistsVencidos = this.ChecarVencidos();

                    this.FiltrarDocumento(this.mostrarVencido, this.myalumnoid);
                } else {
                    let filteredalumnos = [];
                    filteredalumnos.unshift({"nombrecompleto": "VER TODOS", "alumnoid": -1});

                    this.arrayalumnos = filteredalumnos;
                    Messenger().post(
                    {
                        message: "No hay adeudos pendientes de pago",
                        type: 'success',
                        showCloseButton: true
                    });
                }
            }
            else {
                Messenger().post(
                    {
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });


                this.SetTablaDocumentosPorPagar();
            }
        },
            error => {
                var errorMessage = <any> error;
                Messenger().post(
                    {
                        message: 'No se pudo comunicar con el servidor',
                        type: 'error',
                        showCloseButton: true
                    });

                this.SetTablaDocumentosPorPagar();
            });


    }

    FiltrarDocumento(vencido, alumnoid) {
        let alumnoids = [];
        $("#tablaColegiaturas").dataTable().fnDestroy();

        for (var k = 0; k < this.arraymaestro.length; k++) {
            if (vencido) {
                if (!this.arraymaestro[k].IsVencido) {
                    this.arraymaestro[k].IsPagar = false;
                }
            }

            if (alumnoid > 0) {
                if (this.arraymaestro[k].AlumnoId != alumnoid) {
                    this.arraymaestro[k].IsPagar = false;
                }
            }

        }

        this.arraydocumentos = [];

        if (vencido) {
            this.arraydocumentos = this.arraymaestro.filter(vencido => vencido.IsVencido == true);
        }
        else {
            this.arraydocumentos = this.arraymaestro;
        }

        if (alumnoid > 0) {
            this.arraydocumentos = this.arraydocumentos.filter(alumno => alumno.AlumnoId == alumnoid);
        }

        this.calcularpago();


        alumnoids = this.arraymaestro.map(item => item.AlumnoId)
            .filter((value, index, self) => self.indexOf(value) === index);


        let filteredalumnos = this.arrayalumnos.filter(function (item) {
            return alumnoids.indexOf(item.alumnoid) !== -1;
        });

        filteredalumnos.unshift({"nombrecompleto": "VER TODOS", "alumnoid": -1});

        this.arrayalumnos = filteredalumnos;


        this.SetTablaDocumentosPorPagar();
    }

    SetTablaDocumentosPorPagar() {
        if (this.arraydocumentos.length > this.tablaRegistros) {
            this.dtOptionsDoc.dom = "rtp";
            this.dtOptionsDoc.sDom = "rtp";
        }
        else {
            this.dtOptionsDoc.dom = "";
            this.dtOptionsDoc.sDom = "";
        }

        this.dtOptionsDoc.order = false;


        this.dtTriggerDoc.next();
    }

    ChecarVencidos(): boolean {
        return alasql("SELECT * FROM ? where SaldoTotal > 0 and FechaLimite < '" + this.hoy + "'", [this.arraymaestro]).length > 0;
    }

    getConvenios() {
        this.arrayconvenios = [];

        this._httpService.getElemento('portalfamiliar/pagoenlinea/convenio/' + this.PadresOTutoresId).subscribe(result => {
            if (result.status == 200) {
                $('#tablaConvenio').dataTable().fnDestroy();
                this.arrayconvenios = result.body;

                this.arrayconvenios.forEach(acuerdo => {
                    let saldo = parseFloat(acuerdo.saldo) + (acuerdo.interes ? parseFloat(acuerdo.interes) : 0)
                    acuerdo.pagoparcial = saldo;
                    acuerdo.saldototal = saldo;
                });

                this.dtTrigger1.next();
            }
            else {
                Messenger().post(
                    {
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
            }
        },
            error => {
                var errorMessage = <any> error;
                Messenger().post(
                    {
                        message: 'No se pudo comunicar con el servidor',
                        type: 'error',
                        showCloseButton: true
                    });
            });
    }

    SolicitarImprimirRecibo(e: any) {
        this.bloqueoimpresion = e.bloqueoimpresion ? e.bloqueoimpresion : null;
        this.observacionesimpresion = e.observacionesimpresion ? e.observacionesimpresion : null;
        if (this.bloqueoimpresion) {
            return false;
        }
        if (!this.ValidarDentroProrroga(e)) {
            return;
        }
        else {
            if (this.AplicarDescuento(e)) {
                this.mensajePago.AbrirModal([e]).then(respuesta => {
                    if (respuesta == "pagar") {
                        this.ImprimirRecibo(e);
                    }
                    else {
                        return;
                    }
                });
            }
            else {
                this.ImprimirRecibo(e);
            }
        }
    }

    ImprimirRecibo(e) {
        let descuento = this.CalcularDescuento([e]);

        this._httpService.putElemento('pagolinea/ImprimirRecibo', {TipoPago: (e.TipoDocumento == '1' || e.TipoDocumento == '2') ? '1' : '3', DocumentoPorPagarId: e.DocumentoPorPagarId, Documento: e.Documento, AlumnoId: e.AlumnoId, CicloId: e.CicloId, Importe: (e.InteresTotal + e.SaldoTotal - descuento).toFixed(2)}).subscribe(
            result => {
                if (result.status == 200) {
                    e.Referencia = result.body.Referencia;
                    this.Imprimir(e);
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

    Imprimir(e: any) {
        let descuento = this.CalcularDescuento([e]);

        this.datosimpresion = {};
        this.datosimpresion.matricula = e.Matricula;
        this.datosimpresion.nombre = e.Alumno.toUpperCase();
        this.datosimpresion.concepto = e.Concepto;
        this.datosimpresion.documento = e.Documento;
        this.datosimpresion.fechavencimiento = e.FechaLimite;
        this.datosimpresion.importe = e.InteresTotal + e.SaldoTotal - descuento;
        this.datosimpresion.referencia = e.Referencia;
        this.datosimpresion.ciclo = e.Ciclo;
        this.datosimpresion.seccion = e.Nivel;
        this.datosimpresion.grado = e.Grado;
        this.datosimpresion.grupo = e.Grupo;

        $.when($("recibopago")).then(() => {
            let printContents = document.getElementById("recibopago").innerHTML;
            var hiddenFrame = $('<iframe></iframe>').appendTo('body')[0];
            hiddenFrame.contentWindow.printAndRemove = function () {
                //let todelete=hiddenFrame.contentDocument.getElementsByClassName("deleteonload");
                //for(let i of todelete){ i.parentNode.remove(i); }
                hiddenFrame.contentWindow.print();
                setTimeout(() => {
                    $(hiddenFrame).remove();
                });
            };
            var htmlDocument = "<!doctype html>" +
                `<html>
                     ${$('head').clone().html()}
                     <body onload="printAndRemove();"><app style="display:none"></app>${printContents}</body></html>`;
            var doc = hiddenFrame.contentWindow.document.open("text/html", "replace");
            doc.write(htmlDocument);
            doc.close();
        });
    }

    ImprimirConvenio(e: any) {
        this.datosimpresion = {};
        this.datosimpresion.noconvenio = e.nconvenio;
        this.datosimpresion.fechalimitepago = e.fechalimite;
        this.datosimpresion.importe = e.pagoparcial;
        this.datosimpresion.referencia = e.referencia;
        $.when($("reciboconvenio")).then(() => {
            let printContents = document.getElementById("reciboconvenio").innerHTML;
            var hiddenFrame = $('<iframe></iframe>').appendTo('body')[0];

            hiddenFrame.contentWindow.printAndRemove = function () {
                hiddenFrame.contentWindow.print();
                $(hiddenFrame).remove();
            };

            var htmlDocument = "<!doctype html>" +
                `<html>
                ${$('head').clone().html()}
                    <app></app><body onload="printAndRemove();">${printContents}</body></html>`;
            var doc = hiddenFrame.contentWindow.document.open("text/html", "replace");
            doc.write(htmlDocument);
            doc.close();
        });
    }

    PagarConvenio(e: any) {
        if (e.pagoparcial <= 0) {
            Messenger().post({
                message: "Ingrese la cantidad a pagar.",
                type: 'error',
                showCloseButton: true
            });
            return;
        }
        if (e.pagoparcial > e.saldototal) {
            Messenger().post({
                message: "No puede realizar un pago mayor a lo acordado.",
                type: 'error',
                showCloseButton: true
            });
            return;
        }
        else if (this._httpService.sistema == 1) {
            this.ObjetoCobroLinea = new PagoLinea();

            this._httpService.getElemento('pagoenlinea/getnextfolio').subscribe(
                result => {
                    if (result.status == 200) {
                        //this.ObjetoCobroLinea.cl_folio = result.body;
                        this.ObjetoCobroLinea.dl_monto += e.pagoparcial;
                        //this.sendData(this.ObjetoCobroLinea);
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
                });
        }
        else if (this._httpService.sistema == 2) {
            this.PagoBancoCiencias(2, e);
        }
        //Aquí va el Post para realiar el pago parcial.
    }

    calcularpago() {
        let pago = 0;
        this.arrayseleccion = [];
        for (var k = 0; k < this.arraydocumentos.length; k++) {
            if (this.arraydocumentos[k].IsPagar == true) {
                this.arrayseleccion.push(this.arraydocumentos[k]);
                pago += (this.arraydocumentos[k].SaldoTotal + (this.arraydocumentos[k].InteresTotal ? this.arraydocumentos[k].InteresTotal : 0));
            }
        }

        this.sumseleccionados = pago;
    }

    IsDateExpired(e: any) {
        return new Date(e.fechalimitepago) < new Date();
    }

    ShowVencido(e: any) {
        this.arraydocumentos = [];

        if (e.target.checked) {
            this.arraydocumentos = this.arraymaestro.filter(vencido => vencido.IsVencido == true);
        }
        else {
            this.arraydocumentos = this.arraymaestro;
        }
    }

    NoSeleccionMasAntiguo() {
        if (this.config.sistema == 1) {
            let alumnoId;
            let resultado = false;
            let tipoDocumento = -1;

            for (var k = 0; k < this.arraydocumentos.length; k++) {
                if (this.arraydocumentos[k].IsPagar == true) {
                    alumnoId = this.arraydocumentos[k].AlumnoId;
                    //tipoDocumento = this.arraydocumentos[k].TipoDocumento;
                    break;
                }
            }

            let aux = this.arraydocumentos.filter(documento => documento.AlumnoId == alumnoId);//&& documento.TipoDocumento == tipoDocumento

            for (var i = 0; i < aux.length; i++) {
                if (aux[i].IsPagar) {
                    let colegiaturaspre = aux.find(x => x.FechaLimite < aux[i].FechaLimite && !x.IsPagar && x.DocumentoPorPagarId != aux[i].DocumentoPorPagarId && x.TipoDocumento == 2);
                    let documentosvencidos = aux.find(x => x.FechaLimite < aux[i].Hoy && !x.IsPagar && x.DocumentoPorPagarId != aux[i].DocumentoPorPagarId);

                    switch (aux[i].TipoDocumento) {
                        case 1:
                            resultado = documentosvencidos ? true : false;
                            break;
                        case 2:
                            resultado = colegiaturaspre ? true : false;
                            break;
                    }

                    //                    for (var j = 0; j < aux.length; j++) {
                    //                        if (i != j && !aux[j].IsPagar && aux[j].FechaLimite < aux[i].FechaLimite) {                            
                    //                            resultado = true;
                    //                            if(aux[i].TipoDocumento == 1 && aux[j].FechaLimite > aux[i].Hoy){
                    //                                resultado = false;
                    //                            }
                    //                        }
                    //
                    //                    }
                }
            }

            return resultado;
        }
        else if (this.config.sistema == 2) {
            let alumnos = [];
            let tipoDocumento = -1;

            let documentos = this.arraydocumentos.filter(p => p.IsPagar == true);
            tipoDocumento = documentos[0].TipoDocumento;

            if (tipoDocumento != 1 && tipoDocumento != 2) {
                return false;
            }

            alumnos = alasql("SELECT DISTINCT AlumnoId FROM ?", [documentos]);

            for (let k = 0; k < alumnos.length; k++) {
                let aux = this.arraydocumentos.filter(documento => documento.AlumnoId == alumnos[k].AlumnoId && (documento.TipoDocumento == 1 || documento.TipoDocumento == 2))

                for (var i = 0; i < aux.length; i++) {
                    if (aux[i].IsPagar) {
                        for (var j = 0; j < aux.length; j++) {
                            if (i != j && !aux[j].IsPagar && aux[j].FechaLimite < aux[i].FechaLimite) {
                                return true;
                            }
                        }
                    }
                }
            }

            return false;
        }

        return false;
    }

    SeleccionadosMismoAlumno(): boolean {
        let primero = true;
        let alumnoId;
        for (var k = 0; k < this.arraydocumentos.length; k++) {
            if (this.arraydocumentos[k].IsPagar == true) {
                if (primero) {
                    primero = false;
                    alumnoId = this.arraydocumentos[k].AlumnoId;
                }
                else {
                    if (alumnoId != this.arraydocumentos[k].AlumnoId) {
                        return false;
                    }
                }
            }
        }


        return true;
    }

    ValidarDentroProrroga(pago?) {
        let aux = [];

        if (pago) {
            if (pago.TipoDocumento == "1" && pago.Prorroga == "1") {
                aux.push(pago);
            }
        }
        else {
            aux = this.arraydocumentos.filter(p => p.IsPagar && p.TipoDocumento == "1" && p.Prorroga == "1");
        }

        if (aux.length > 0) {
            this.mensajePago.AbrirModalFechaProrroga(aux);

            return false;
        }

        return true;
    }

    AplicarDescuento(pago?) {
        let aux = [];
        if (pago) {
            if (pago.Descuento == "1" && pago.DescuentoProntoPago > 0) {
                aux.push(pago);
            }
        }
        else {
            aux = this.arraydocumentos.filter(p => p.IsPagar && p.Descuento == "1" && p.DescuentoProntoPago > 0);
        }

        if (aux.length > 0) {
            return true;
        }

        return false;
    }


    PagarSeleccionados() {
        if (this.NoSeleccionMasAntiguo()) {
            Messenger().post({
                message: "Recuerde que debe realizar los pagos correspondientes a los adeudos más antiguos.",
                type: 'success',
                showCloseButton: true
            });
            return;
        }
        if (this.config.sistema == 1) {
            if (!this.SeleccionadosMismoAlumno()) {
                Messenger().post({
                    message: "Recuerde que debe realizar pagos que correspondan al mismo alumno.",
                    type: 'success',
                    showCloseButton: true
                });
                return;
            }
        }
        if (!this.ValidarDentroProrroga()) {
            return;
        }
        else {
            if (this.AplicarDescuento() && this.sistemaid == 1) {
                this.mensajePago.AbrirModal(this.arraydocumentos.filter(p => p.IsPagar && p.Descuento == "1")).then(respuesta => {
                    if (respuesta == "pagar") {
                        this.RealizarPago();
                    }
                    else {
                        return;
                    }
                });
            }
            else {
                this.RealizarPago();
            }

        }
    }


    RealizarPago() {
        if (this._httpService.sistema == 1) {
            let pago = this.GetPagoSeleccionado();

            if (pago.length <= 0) {
                Messenger().post({
                    message: 'Debe seleccionar al menos un pago a realizar',
                    type: 'error',
                    showCloseButton: true
                });
                return;
            }
            else {
                let descuento: any = this.CalcularDescuento(pago);
                let monto = this.sumseleccionados - descuento;

                this.ObjetoCobroLinea = new PagoLinea();
                this.ObjetoCobroLinea.dl_monto = monto.toFixed(2);
                this.ObjetoCobroLinea.cl_concepto = pago[0].TipoDocumento;
                this.ObjetoCobroLinea.TipoPago = '1';
                this.ObjetoCobroLinea.UsuarioId = this.storage.getItem('UsuarioId');

                pago.forEach(p => {
                    let doc = new DocumentoPorPagar();
                    doc.Documento = p.Documento;
                    doc.AlumnoId = p.AlumnoId;
                    doc.CicloId = p.CicloId;
                    doc.DocumentoPorPagarId = p.DocumentoPorPagarId;

                    this.ObjetoCobroLinea.Documento.push(doc);
                });

                this.sendData();
            }
        }
        else if (this._httpService.sistema == 2) //ciencias
        {
            let pago = this.GetPagoSeleccionado();
            if (pago[0].TipoDocumento == "3") {
                this.PagoBancoCiencias(3, null);
            } else {
                this.PagoBancoCiencias(1, null);
            }
        }
    }

    sendData() {
        this._httpService.postElemento('pagolinea/hash', this.ObjetoCobroLinea).subscribe(
            result => {
                if (result.status == 200) {
                    this.DatosBanco = new Multipagos();
                    this.DatosBanco.hash = result.body.hash;
                    this.DatosBanco.cl_referencia = result.body.Referencia;
                    this.DatosBanco.servicio = result.body.Servicio;
                    this.DatosBanco.dl_monto = this.ObjetoCobroLinea.dl_monto;
                    this.DatosBanco.cl_folio = result.body.Folio;
                    this.DatosBanco.cl_concepto = this.ObjetoCobroLinea.cl_concepto;
                    this.modalPago.show();

                    let pago = this.GetPagoSeleccionado();
                    pago.forEach((documento) => {
                        documento.Referencia = result.body.Referencia;
                    });
                }
                else {
                    Messenger().post({
                        message: result.body.error,
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

    cerrarModal() {
        //Esconde el modal
        this.modalPago.hide();
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

    GoTobank() {
        this.openWindowWithPost('https://multipagos.bb.com.mx/Estandar/index2.php', this.DatosBanco);
        this.router.navigate(['/Menu/DocumentosPagados']);
    }

    PagoBancoCiencias(tipoPago, convenio) {
        let datos: any;

        if (tipoPago == 1)  //Pago de documentos
        {
            let pago = this.GetPagoSeleccionado();
            datos = this.SetDatosPago(pago);
        }
        else if (tipoPago == 2) {
            datos = this.SetDatosPagoConvenio(convenio);
        }

        if (this.config.sistema == 2) {
            if (tipoPago == 3)  //Pago de documentos (otros conceptos)
            {
                let pago = this.arraydocumentos.filter(documento => documento.IsPagar == true)
                datos = this.SetDatosPago(pago, 3);
            }
        }


        //console.log(datos);

        this._httpService.postElemento('portalfamiliar/Pago/SolicitudCobro', datos).subscribe(
            result => {
                if (result.status == 200) {
                    this.solicitudCobro.AbrirSolicitudPago(result.body.url);
                    //console.log(result.body);
                }
                else {
                    Messenger().post(
                        {
                            message: result.body.error,
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

    SetDatosPago(data, type?) {
        console.log(data);
        //--- documento ---
        let documento = "";            //el documento de mayor antigüedad
        let documentoPorPagarId = "";        //una cadena que concatena todos los documentoporpagarid de los pagos seleccionado

        let descuento = this.CalcularDescuento(data);
        let aux = alasql("SELECT * FROM ? ORDER BY FechaLimite", [data]);

        documento = aux[0].Documento;

        //---- Documento por pagar id --------
        for (var k = 0; k < data.length; k++) {
            documentoPorPagarId += data[k].DocumentoPorPagarId + "/";
        }

        documentoPorPagarId = documentoPorPagarId.substring(0, documentoPorPagarId.length - 1);

        //---- Alumno -----
        let alumnos = alasql("SELECT DISTINCT Alumno FROM ?", [data]);
        let alumno = alumnos.length == 1 ? alumnos[0].Alumno.toUpperCase() : 'ALUMNOS (' + (alumnos.length) + ")";

        //---- Concepto de pago ----
        let conceptos = alasql("SELECT DISTINCT TipoDocumento FROM ?", [data]);
        let concepto = "";

        if (conceptos[0].TipoDocumento == 1 || conceptos[0].TipoDocumento == 2) {
            if (conceptos.length > 1) {
                concepto = ("Pago de inscripciones y colegiaturas (" + data.length + ")").toUpperCase();
            }
            else {
                if (conceptos[0].TipoDocumento == 1) {
                    concepto = ("Pago de inscripciones (" + data.length + ")").toUpperCase();
                }
                else if (conceptos[0].TipoDocumento == 2) {
                    concepto = ("Pago de colegiaturas (" + data.length + ")").toUpperCase();
                }
            }
        }


        let datos: any =
            {
                concepto: concepto,
                alumno: alumno,
                documento: documento,
                documentoPorPagarId: documentoPorPagarId,
                importe: this.sumseleccionados - descuento,
                descuento: descuento,
                padreotutorid: this.PadresOTutoresId,
                tipopago: "1",
                empresaid: 1
            };

        if (type == 3) {
            datos =
                {
                    concepto: ("Pago de otros conceptos (" + data.length + ")").toUpperCase(),
                    alumno: alumno,
                    documento: documento,
                    documentoPorPagarId: documentoPorPagarId,
                    importe: this.sumseleccionados,
                    padreotutorid: this.PadresOTutoresId,
                    tipopago: "3",
                    empresaid: 1
                };
        }

        return datos;
    }

    SetDatosPagoConvenio(data) {
        let datos =
            {
                concepto: "PAGO DE CONVENIO",
                nconvenio: data.nconvenio,
                referencia: data.nconvenio,
                importe: data.pagoparcial,
                padreotutorid: this.PadresOTutoresId,
                tipopago: "2"
            };

        return datos;
    }

    CalcularDescuento(pago) {
        let descuento = 0;
        let aux = pago.filter(p => p.DescuentoProntoPago > 0 && p.Descuento == "1");

        for (let d of aux) {
            descuento += parseFloat((<any>(d.SaldoTotal) * d.DescuentoProntoPago / 100.0).toFixed(2));
        }

        return descuento;
    }

    GetPagoSeleccionado() {
        let pago = [];

        for (var k = 0; k < this.arraydocumentos.length; k++) {
            if (this.arraydocumentos[k].IsPagar == true) {
                pago.push(this.arraydocumentos[k]);
            }
        }

        return pago;
    }


    //--- control de check box de pagar --
    DeshabilitarPagarPagoCheckBox(documento) {
        let alumnoId = -1;
        let tipodocumento = -1;
        for (var k = 0; k < this.arraydocumentos.length; k++) {
            if (this.arraydocumentos[k].IsPagar == true) {
                alumnoId = this.arraydocumentos[k].AlumnoId;
                tipodocumento = this.arraydocumentos[k].TipoDocumento;
                break;
            }
        }

        if (alumnoId == -1 && tipodocumento == -1) {
            return false;
        }

        if (this.config.sistema == 1) {
            if (documento.AlumnoId == alumnoId && documento.TipoDocumento == tipodocumento) {
                return false;
            }
            else {
                return true;
            }
        } else {
            if (tipodocumento == 3) {
                if (documento.TipoDocumento == 3) {
                    return false;
                } else {
                    return true;
                }
            } else {
                if (documento.TipoDocumento == 3) {
                    return true;
                }
            }
            return false;
        }
    }

    GetHoy() {
        let fecha = new Date();

        let day = fecha.getDate();
        let month = fecha.getMonth() + 1;
        let year = fecha.getFullYear();

        let dayS = "";
        let monthS = "";

        dayS = day < 10 ? "0" + day.toString() : day.toString();
        monthS = month < 10 ? "0" + month.toString() : month.toString();

        return year + "-" + monthS + "-" + dayS;
    }
}
