import { AfterViewInit, ViewEncapsulation, Component, OnInit, ViewChild } from '@angular/core';
import { AppState } from "app/app.service";
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { ModalDirective } from 'ng2-bootstrap/modal';
import { Subject } from 'rxjs/Rx';
import { Router, Event as RouterEvent, NavigationEnd } from '@angular/router';
import { DocumentoPorPagar, Multipagos, PagoLinea } from "../Modelos/PagoLinea.model";
import { Config } from 'app/config';
import { StorageService } from 'app/Servicios/storage.service';


declare let Messenger: any;
declare var $: any;
declare var $window: any;
declare var Pace: any;
declare var alasql: any;


@Component(
    {
        selector: 'OtrosConceptos',
        templateUrl: './otrosPagos.component.html'
    })

export class OtrosConceptos implements OnInit {
    @ViewChild('solicitudCobro') solicitudCobro;

    ExistsVencidos: boolean = false;
    PadresOTutoresId: number = +this.storage.getItem("PadresOTutoresId");
    arrayalumnos: any[];
    arraydocumentos: any[];
    arraymaestro: any[];
    sumseleccionados: number;
    router: Router;
    myalumnoid: number;
    ObjetoCobroLinea: PagoLinea;
    DatosBanco: Multipagos;
    cantidad: number;
    datosimpresion: any = {};
    hoy: string;
    mostrarVencido: boolean = false;
    sistema: string;
    sistemaid: any;
    config: Config = new Config()

    //tabla
    dtOptionsPagos: any = {};
    dtTriggerPagos = new Subject();
    tablaRegistros: number = 10;

    bloqueoimpresion: any;
    observacionesimpresion: any;
    leyendabloqueoimpresion: any;

    bloqueopago: any;
    observacionespago: any;
    observacionesbloqueo: any;

    bloqueoadeudo: boolean;


    //Modal
    @ViewChild('modalPago') modalPago: ModalDirective;
    constructor(private _httpService: AppState, private _fb: FormBuilder, router: Router, private storage: StorageService) {
        this.router = router;
        this.sistema = _httpService.sistema == 1 ? 'lux' : _httpService.sistema == 2 ? 'ciencias' : '';
        this.sistemaid = _httpService.sistema;
    }
    //Metodo de inicio
    ngOnInit(): void {
        this.sumseleccionados = 0;
        this.arraydocumentos = [];
        this.myalumnoid = -1;
        this.cantidad = 0;
        this.ObjetoCobroLinea = new PagoLinea();
        this.datosimpresion = {};

        this.hoy = this.GetHoy();

        //tablas
        this.dtOptionsPagos =
        {
            autoWidth: false,
            language: { url: "./assets/datatable/Spanish.json" },
            ordering: false,
            pageLength: this.tablaRegistros
        };

        this.dtTriggerPagos.next();

    }
    //Metodo inicial
    ngAfterViewInit(): void {
        this.getAlumnos(this.PadresOTutoresId);
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
                    this.arrayalumnos.unshift({ "nombrecompleto": "VER TODOS", "alumnoid": -1 });

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
                var errorMessage = <any>error;
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    getDocumentos() {
        this.arraymaestro = [];

        this._httpService.getElemento('portalfamiliar/pagoenlinea/bypadreotutor/0/' + this.PadresOTutoresId + '?instituto=' + this.config.config.version).subscribe(result => {
            if (result.status == 200) {
                if (result.body.length > 0) {
                    result.body.forEach(obj => {
                        obj.AlumnoId = parseFloat(obj.AlumnoId);

                        obj.Saldo = parseFloat(obj.Saldo);
                        obj.Importe = parseFloat(obj.Importe);
                        obj.Interes = parseFloat(obj.Interes);

                        obj.IsPagar = false;
                        obj.IsVencido = obj.FechaLimite < this.hoy;

                        this.arraymaestro.push(obj);
                    });

                    this.ExistsVencidos = this.ChecarVencidos();

                    this.FiltrarDocumento(this.mostrarVencido, this.myalumnoid);
                    this.bloqueoadeudo = this.arraymaestro.find(x=> x.bloqueoadeudo != null) ? true : false;
                } else {
                    let filteredalumnos = [];
                    filteredalumnos.unshift({ "nombrecompleto": "VER TODOS", "alumnoid": -1 });
    
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

                this.SetTablaPagos();
            }
        },
            error => {
                var errorMessage = <any>error;
                Messenger().post(
                    {
                        message: 'No se pudo comunicar con el servidor',
                        type: 'error',
                        showCloseButton: true
                    });

                this.SetTablaPagos();
            });


    }

    FiltrarDocumento(vencido, alumnoid) {
        let alumnoids = [];
        (<any>$("#tablaOtrosPagos")).dataTable().fnDestroy();

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
        
        alumnoids = this.arraymaestro.map(item => item.AlumnoId)
            .filter((value, index, self) => self.indexOf(value) === index);

        let filteredalumnos = this.arrayalumnos.filter(function (item) {
            return alumnoids.indexOf(item.alumnoid) !== -1;
        });

        filteredalumnos.unshift({ "nombrecompleto": "VER TODOS", "alumnoid": -1 });

        this.arrayalumnos = filteredalumnos;


        this.calcularpago();
        this.SetTablaPagos();
        console.log(this.arraymaestro);
    }

    SetTablaPagos() {
        if (this.arraydocumentos.length > this.tablaRegistros) {
            this.dtOptionsPagos.dom = "rtp";
            this.dtOptionsPagos.sDom = "rtp";
        }
        else {
            this.dtOptionsPagos.dom = "";
            this.dtOptionsPagos.sDom = "";
        }

        this.dtTriggerPagos.next();
    }


    ImprimirRecibo(e: any) {
        this._httpService.putElemento('pagolinea/ImprimirRecibo', { TipoPago: '3', DocumentoPorPagarId: e.DocumentoPorPagarId, Documento: e.Documento, AlumnoId: e.AlumnoId, CicloId: e.CicloId, Importe: (e.Interes + e.Saldo).toFixed(2) }).subscribe(
            result => {
                if (result.status == 200) {
                    e.Referencia = result.body.Referencia;
                    this.Imprimir(e);
                }
            },
            error => {
                var errorMessage = <any>error;
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    Imprimir(e) {
        this.datosimpresion = {};

        this.datosimpresion.matricula = e.Matricula;
        this.datosimpresion.nombre = e.Alumno.toUpperCase();

        this.datosimpresion.concepto = e.Concepto;
        this.datosimpresion.documento = e.Documento;
        this.datosimpresion.fechavencimiento = e.FechaLimite;
        this.datosimpresion.importe = e.Interes + e.Saldo;
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

    ChecarVencidos(): boolean {
        return alasql("SELECT * FROM ? where Saldo > 0 and FechaLimite < '" + this.hoy + "'", [this.arraymaestro]).length > 0;
    }

    calcularpago() {
        let pago = 0;

        for (var k = 0; k < this.arraydocumentos.length; k++) {
            if (this.arraydocumentos[k].IsPagar == true) {
                pago += (this.arraydocumentos[k].Saldo + (this.arraydocumentos[k].Interes ? this.arraydocumentos[k].Interes : 0));
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
            this.arraydocumentos = alasql("SELECT * FROM ? where saldo > 0 and date(fechalimitepago) < date(now())", [this.arraymaestro]);
        } else
            this.arraydocumentos = this.arraymaestro;
    }

    NoSeleccionMasAntiguo(): boolean {
        let alumnoId;
        let resultado = false;

        for (var k = 0; k < this.arraydocumentos.length; k++) {
            if (this.arraydocumentos[k].IsPagar == true) {
                alumnoId = this.arraydocumentos[k].AlumnoId;
                break;
            }
        }

        let aux = this.arraydocumentos.filter(documento => documento.AlumnoId == alumnoId);

        for (var i = 0; i < aux.length; i++) {
            if (aux[i].IsPagar) {
                for (var j = 0; j < aux.length; j++) {
                    if (i != j && !aux[j].IsPagar && aux[j].FechaLimite < aux[i].FechaLimite) {
                        resultado = true;
                    }
                }
            }
        }

        return resultado;
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

    PagarSeleccionados() {
        let bloqueo = this.arraydocumentos.filter(x => x.bloqueopago == true && x.IsPagar);
        if (bloqueo.length > 0) {
            this.bloqueopago = true;
            this.observacionespago = "No se pueden realizar los pagos seleccionados porque existe un bloqueo relacionado al alumno " + bloqueo[0].Matricula + " - " + bloqueo[0].Alumno;
            this.observacionesbloqueo = bloqueo[0].observacionespago;
            return false;
        } else {
            this.bloqueopago = null;
            this.observacionespago = null;
        }
        if (this.NoSeleccionMasAntiguo()) {
            Messenger().post({
                message: "Recuerde que debe realizar los pagos correspondientes a los adeudos más antiguos.",
                type: 'success',
                showCloseButton: true
            });
            return;
        }
        else if (!this.SeleccionadosMismoAlumno()) {
            Messenger().post({
                message: "Recuerde que debe realizar pagos que correspondan al mismo alumno.",
                type: 'success',
                showCloseButton: true
            });
            return;
        }


        //lux
        if (this._httpService.sistema == 1) {
            let pago = this.arraydocumentos.filter(p => p.IsPagar);

            if (pago.length <= 0) {
                Messenger().post({
                    message: 'Debe seleccionar al menos un pago a realizar',
                    type: 'success',
                    showCloseButton: true
                });
                return;
            }
            else {
                this.ObjetoCobroLinea = new PagoLinea();

                let monto = 0;
                pago.forEach(p => {
                    monto += (p.Saldo + p.Interes);

                    let doc = new DocumentoPorPagar();
                    doc.Documento = p.Documento;
                    doc.AlumnoId = p.AlumnoId;
                    doc.CicloId = p.CicloId;
                    doc.DocumentoPorPagarId = p.DocumentoPorPagarId;

                    this.ObjetoCobroLinea.Documento.push(doc);
                });

                this.ObjetoCobroLinea.UsuarioId = this.storage.getItem('UsuarioId');
                this.ObjetoCobroLinea.cl_concepto = "3";
                this.ObjetoCobroLinea.dl_monto = monto.toFixed(2);
                this.ObjetoCobroLinea.TipoPago = "3";

                this.sendData();
            }

        }
        else if (this._httpService.sistema == 2) //Prosa
        {
            this.PagoBancoCiencias(3);
        }
    }

    PagoBancoCiencias(tipoPago) {
        let datos: any;

        if (tipoPago == 3)  //Pago de documentos (otros conceptos)
        {
            let pago = this.arraydocumentos.filter(documento => documento.IsPagar == true)
            datos = this.SetDatosPago(pago);
        }

        this._httpService.postElemento('portalfamiliar/Pago/SolicitudCobro', datos).subscribe(
            result => {
                if (result.status == 200) {
                    this.solicitudCobro.AbrirSolicitudPago(result.body.url);
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
                var errorMessage = <any>error;
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    SetDatosPago(data) {
        //--- documento ---
        let documento = "";            //el documento de mayor antigüedad
        let documentoPorPagarId = "";        //una cadena que concatena todos los documentoporpagarid de los pagos seleccionado

        let aux = alasql("SELECT * FROM ? ORDER BY FechaLimite", [data]);

        documento = aux[0].Documento;

        for (var k = 0; k < data.length; k++) {
            documentoPorPagarId += data[k].DocumentoPorPagarId + "/";
        }

        documentoPorPagarId = documentoPorPagarId.substring(0, documentoPorPagarId.length - 1);

        if (documentoPorPagarId.length > 50) {
            Messenger().post(
                {
                    message: 'Ha seleccionado muchos pagos. Deselecciona algunos.',
                    type: 'error',
                    showCloseButton: true
                });
            return;
        }

        let datos =
        {
            concepto: ("Pago de otros conceptos (" + data.length + ")").toUpperCase(),
            alumno: data[0].Alumno.toUpperCase(),
            documento: documento,
            documentoPorPagarId: documentoPorPagarId,
            importe: this.sumseleccionados,
            padreotutorid: this.PadresOTutoresId,
            tipopago: "3",
            empresaid: 1
        };

        return datos;
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

                    let pago = this.arraydocumentos.filter(p => p.IsPagar);
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
                var errorMessage = <any>error;
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

    //--- control de check box de pagar --
    DeshabilitarPagarPagoCheckBox(documento) {
        let alumnoId = -1;
        for (var k = 0; k < this.arraydocumentos.length; k++) {
            if (this.arraydocumentos[k].IsPagar == true) {
                alumnoId = this.arraydocumentos[k].AlumnoId;
                break;
            }
        }

        if (alumnoId == -1) {
            return false;
        }

        if (documento.AlumnoId == alumnoId) {
            return false;
        }
        else {
            return true;
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