import {AfterViewInit, Component, OnInit, ViewChild} from '@angular/core';
import {AppState} from "app/app.service";
import {Router} from '@angular/router';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {Subject} from 'rxjs/Rx';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';


declare let Messenger: any;
declare let $: any;

@Component({
    selector: 'directorioescolar',
    templateUrl: './directorioescolar.component.html'
})

export class DirectorioescolarComponent implements OnInit, AfterViewInit {


    accion: boolean;
    FormGuardar: FormGroup;
    FormBuscar: FormGroup;
    submitted: boolean;

    @ViewChild('modal') public modal: ModalDirective;

    exportar: any;
    dtOptions: any = {};
    dtTrigger = new Subject();

    arrayentidad: any[];

    selectActivo: any[];

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private _fb: FormBuilder, private _router: Router) {
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
            columnDefs: [{"targets": [0,1,2,3], "searchable": false, "orderable": false}],
            bSort: false,
            order: false
        };

        this.FormBuscar = this._fb.group({
          departamento: [],
          activo: 1
        });

    }

    ngAfterViewInit(): void {
        this.dtTrigger.next();
        this.buscar();
    }

    //Accion de busqueda de inicio
    buscar() {
        //Llamada al servicio get para obtener el array para llenar el grid
            var data = $.param(this.FormBuscar.value);
            this._httpService.getElemento('Directorioescolar?' + data).subscribe(
                result => {
                    if (result.status == 200) {
                        $("#tablaDepartamento").dataTable().fnDestroy();
                        this.arrayentidad = result.body;
                        this.dtTrigger.next();
                    } else {
                        $("tablaDepartamento").dataTable().fnClearTable();
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
