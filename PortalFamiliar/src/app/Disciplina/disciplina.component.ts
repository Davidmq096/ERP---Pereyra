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
    selector: 'disciplina',
    templateUrl: './disciplina.component.html'
})

export class DisciplinaComponent implements OnInit, AfterViewInit {


    accion: boolean;
    FormGuardar: FormGroup;
    FormBuscar: FormGroup;
    submitted: boolean;
    padreotutorid: any;

    @ViewChild('modal') public modal: ModalDirective;

    exportar: any;
    dtOptions: any = {};
    dtTrigger = new Subject();

    arrayentidad: any[];

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
                title: 'Directorioescolar',
                exportOptions: {orthogonal: 'sort', columns: [0,1,2,3]}
            }],
            initComplete: () => {
                var botones = $('.dt-buttons').hide();
                this.exportar = function () {
                    botones.find('.buttons-excel').click();
                }
            },
            language: {url: "./assets/datatable/Spanish.json"},
            bSort: false
        };

        this.FormBuscar = this._fb.group({
          alumnoid: [,<any>Validators.required],
          activo: 1
        });

    }

    ngAfterViewInit(): void {
        this.dtTrigger.next();
        this.datosIniciales();
    }

    

    datosIniciales () {
        let alumnos = [];
        this._httpService.getElemento('portalfamiliar/infoalumno/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    let alumnos = result.body;
                    for (let i = 0; i < (result.body as any[]).length; i++) {
                        alumnos[i].nombrecompleto = (result.body[i].apellidopaterno? result.body[i].apellidopaterno : null) + ' ' +
                        (result.body[i].apellidomaterno? result.body[i].apellidomaterno : null) + ' ' +
                        (result.body[i].apellidopaterno? result.body[i].primernombre : null)
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

    limpiar () {
        this.FormBuscar.reset();
        this.submitted = false;
        this.arrayentidad = [];
        $("tablaFormato").dataTable().fnClearTable();
    }

    //Accion de busqueda de inicio
    buscar() {
        this.submitted = true;
        if (this.FormBuscar.invalid) {
            return false;
        }
        //Llamada al servicio get para obtener el array para llenar el grid
            var data = this.FormBuscar.get('alumnoid').value;
            this._httpService.getElemento('portalfamiliar/Reportedisciplina/' + data).subscribe(
                result => {
                    if (result.status == 200) {
                        $("#tablaFormato").dataTable().fnDestroy();
                        for (let i = 0; i < (result.body as any[]).length; i++) {
                            let fechat = result.body[i].fecha.split("T");
                            result.body[i].fecha = fechat[0];
                            result.body[i].fechaformat = this.convertDate(fechat[0]);
                        }
                        if(result.body){
                            this.arrayentidad = result.body.filter(x=> x.tiporeporteid.tiporeporteid == 2);
                        }
                        this.dtTrigger.next();
                    } else {
                        $("tablaFormato").dataTable().fnClearTable();
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

    expandir(tabla: any, descripcion: string) {
        var tr = $(tabla.srcElement).closest('tr');
        var row = $("#tablaFormato").dataTable().api().row(tr);
        if (row.child.isShown()) {
            $(tabla.srcElement).removeClass("fa-minus");
            $(tabla.srcElement).addClass("fa-plus");
            row.child.hide();
        }
        else {
            $(tabla.srcElement).removeClass("fa-plus");
            $(tabla.srcElement).addClass("fa-minus");
            let html = this.formulaTotext(descripcion);
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            let text = tmp.textContent || tmp.innerText || "";
            row.child(text).show();
        }
    }

    formulaTotext(text) {
        return text = text ? String(text).replace(/<math.*?math>/g, '[Formula]') : '';
    }

    convertDate(input) {
        if(input) {
            var str = input.split('-');
            return str[2] + '/' + str[1] + '/' + str[0];
        } else {
            return '';
        }
      }
      


}
