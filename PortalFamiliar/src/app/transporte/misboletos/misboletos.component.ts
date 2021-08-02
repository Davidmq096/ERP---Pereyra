import {AfterViewInit, Component, OnInit, ViewChild} from '@angular/core';
import {AppState} from "app/app.service";
import {Subject} from 'rxjs/Rx';
import {saveAs as importedSaveAs} from "file-saver";
import {StorageService} from 'app/Servicios/storage.service';
import {ModalDirective} from 'ng2-bootstrap/modal';

import {Helpers} from '../../app.helpers';
declare let Messenger: any;
declare let $: any;

@Component({
    selector: 'misboletos',
    templateUrl: './misboletos.component.html'
})

export class MisBoletosComponent implements OnInit, AfterViewInit {
    dtOptions: any = {};
    dtTrigger = new Subject();
    dtOptions2: any = {};
    dtTrigger2 = new Subject();
    dtOptionsContrato: any = {};
    dtTriggerContrato = new Subject();

    arrayentidad: any[];
    arrayrutas: any[];
    arraycontratos: any[] = [];
    padreotutorid: number = +this.storage.getItem("PadresOTutoresId");
    mostrarcontrato: boolean = false;
    nombreruta: any;
    arrayrutadetalle: any;
    @ViewChild('modal') public modal: ModalDirective;
    @ViewChild('modaldetalle') public modaldetalle: ModalDirective;

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, public _helpers: Helpers, private storage: StorageService) {
    }

    //Metodo de inicio
    ngOnInit(): void {
        $.fn.dataTable.ext.errMode = 'none';
        this.dtOptions = {
            dom: 'Blfrtip',
            initComplete: () => {
                var botones = $('.dt-buttons').hide();
            },
            language: {url: "./assets/datatable/Spanish.json"},
            bSort: false,
            order: false
        };
        this.dtOptions2 = {
            dom: 'Blfrtip',
            initComplete: () => {
                var botones = $('.dt-buttons').hide();
            },
            language: {url: "./assets/datatable/Spanish.json"},
            columnDefs: [{"targets": [3], "searchable": false, "orderable": false}],
        };
    }

    ngAfterViewInit(): void {
        this.dtTrigger.next();
        this.dtTrigger2.next();
        this.buscarContratos();
        setTimeout(() => {
            this.buscar();
    
            }, 100);
        this.modaldetalle.onHidden.subscribe(() => {
            $('body').addClass('modal-open')
        })
    }

    buscarContratos() {
        this._httpService.getElemento('Transporte/Contrato/?padresotutoresid=' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    this.arraycontratos = result.body;
                    this.mostrarcontrato = true;
                } else {
                    this.arraycontratos = [];
                    this.mostrarcontrato = false;
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
        this._httpService.getElemento('Transporte/Misboletos?padreotutorid=' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    $("#tablaBoletos").dataTable().fnDestroy();
                    this.arrayentidad = result.body;
                    this.dtTrigger.next();
                } else {
                    $("#tablaBoletos").dataTable().fnClearTable();
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

    selectall(e: any) {
        var check = $(e.srcElement).is(':checked');
        var rows = $("#tablaBoletos").dataTable().api().rows({
            page: 'all',
            search: 'applied'
        }).nodes();
        $('input[class="all labelCheckBox"]', rows).prop('checked', check);
    }

    selectallContrato(e: any) {
        var check = $(e.srcElement).is(':checked');
        var rows = $('input.contratoCheckGG').rows;
        $('input.contratoCheckGG', rows).prop('checked', check);
    }

    imprimir() {
        var seleccionado = $($("#tablaBoletos").dataTable().api().column(0).nodes()).find("input[class='all labelCheckBox']:checked:enabled");
        if (seleccionado.length == 0) {
            Messenger().post({
                message: 'Debes seleccionar mínimo un boleto',
                type: 'success',
                showCloseButton: true
            });
            return false;
        }
        let boletos = [];
        for (let s of seleccionado) {
            boletos.push(s.value);
        }
        let data = $.param({boletos: boletos});
        this._httpService.getArchivo('Transporte/Boleto/pdf', '?' + data).subscribe(
            result => {
                if (result.status == 200) {
                    this._helpers.printPDF(result.body);
                    //importedSaveAs(result.body, "Boletos");
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

    crendenciales() {
        var seleccionado: any[] = $("#tablaAlumno .contratoCheckGG:checked");
        if (seleccionado.length < 1) {
            Messenger().post({
                message: 'Debes seleccionar minimo un elemento para esta opción',
                type: 'success',
                showCloseButton: true
            });
            return false;
        }
        let contratos: any[] = [];
        for (let s of seleccionado) {
            let alumno = this.arraycontratos.find(x => x.alumnoporcontratoid == s.value);
            contratos.push({contratoid: alumno.contratoid, alumnoid: alumno.alumnoid});
        }
        this.cargarContenedorCredencial(contratos);
    }

    cargarContenedorCredencial(contratos: {contratoid: number, alumnoid: number}[]) {

        this._httpService.postDownloadArchivo('Transporte/Contrato/Credencial', contratos).subscribe(
            result => {
                if (result.status == 200) {
                    //importedSaveAs(result.body, "Credencial");
                    this._helpers.printPDF(result.body);
                } else {
                    Messenger().post({
                        message: "No se han creado los usuarios a los hijos de la familia",
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

    cancelarBoletos() {
        var seleccionado: any[] = $($("#tablaBoletos").dataTable().api().column(0).nodes()).find("input[class='all labelCheckBox']:checked:enabled");
        if (seleccionado.length < 1) {
            Messenger().post({
                message: 'Debes seleccionar minimo un elemento para esta opción',
                type: 'success',
                showCloseButton: true
            });
            return false;
        }
        let boletos: any[] = [];
        for (let s of seleccionado) {
            let boletoids = s.value.split(",");
            for (let ids of boletoids) {
                boletos.push(parseInt(ids));
            }
        }
        let obj = {
            ids: boletos,
            portal: 3,
            usuarioid: this.storage.getItem("UsuarioId")
        }
        let msg = Messenger({extraClasses: 'messenger-fixed messenger-on-top'}).post({
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
                        this._httpService.postElemento('Transporte/Boleto/Familiar/Cancelar', obj, null, true).subscribe(
                            result => {
                                if (result.status == 200) {
                                    Messenger().post({
                                        message: result.body.msj,
                                        type: 'success',
                                        showCloseButton: true
                                    });
                                    this.buscar();
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
                }
            }
        });
    }

    buscarRuta() {
        this._httpService.getElemento('Transporte/Ruta/').subscribe(
            result => {
                if (result.status == 200) {
                    $("#tablaRutas").dataTable().fnDestroy();
                    this.arrayrutas = result.body.ruta;
                    this.dtTrigger2.next();
                    this.modal.show();
                } else {
                    $("#tablaRutas").dataTable().fnClearTable();
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

    detalleRuta(objeto, id) {
        this._httpService.getElemento('Transporte/Ruta/detalle/' + id).subscribe(
            result => {
                if (result.status == 200) {
                    this.nombreruta = objeto.nombre;
                    this.arrayrutadetalle = result.body.rutaprecioparada;
                    console.log(objeto);
                    console.log(this.arrayrutadetalle);
                    this.modaldetalle.show();
                } else {
                    $("#tablaRuta").dataTable().fnClearTable();
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
}
