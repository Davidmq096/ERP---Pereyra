import {AfterViewInit, ViewEncapsulation, Component, OnInit, ViewChild} from '@angular/core';
import {AppState} from "app/app.service";
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {PagoLineaModel} from './PagoLineaModel';
import {Subject} from 'rxjs/Rx';
import {StorageService} from 'app/Servicios/storage.service';


declare let Messenger: any;
declare var $: any;
declare var $window: any;
declare var Pace: any;
declare var alasql: any;
@Component({
    selector: 'DoctosPagados',
    templateUrl: './documentospagados.component.html'
})
export class DoctosPagados implements OnInit {
    ExistsVencidos: boolean = false;
    PadresOTutoresId: number = +this.storage.getItem("PadresOTutoresId");
    arrayalumnos: any[];
    arraydocumentos: any[];
    arraymaestro: any[];
    sumseleccionados : number;
    myalumnoid : number;
    cantidad : number;
    alumnosel;

    // Tablas
    dtOptionsPagado: any = {};
    dtTriggerPagado = new Subject;
    tablaRegistros:number = 10;


    //Modal
    @ViewChild('modalPago') modalPago: ModalDirective;
    constructor(private _httpService: AppState, private _fb: FormBuilder, private storage: StorageService)
    {
        this.dtOptionsPagado =
        {
            dom: '',
            language: {url: "./assets/datatable/Spanish.json"},
            ordering: false,
            pageLength: this.tablaRegistros
        };
    }

    //Metodo de inicio
    ngOnInit(): void
    {
        this.sumseleccionados = 0;
        this.arraydocumentos=[];
        this.arraymaestro=[];
        this.myalumnoid =-1;
        this.cantidad =0;

        this.dtTriggerPagado.next();
    }
    //Metodo inicial
    ngAfterViewInit(): void
    {

        this.getAlumnos(this.PadresOTutoresId);
        this.getDocumentos();
    }

    getAlumnos(id:number){
        this._httpService.getElemento('portalfamiliar/infoalumno/' + id + '?consultainactivos=true').subscribe(
            result => {
                if (result.status == 200) {
                    this.arrayalumnos = result.body;
                    this.arrayalumnos.forEach(alumno => {
                        alumno.nombrecompleto ='';
                    if('primernombre' in alumno)
                      alumno.nombrecompleto +=  alumno.primernombre +' ';
                    if('segundonombre' in alumno)
                      alumno.nombrecompleto +=  alumno.segundonombre +' ';
                    if('apellidopaterno' in alumno)
                      alumno.nombrecompleto +=  alumno.apellidopaterno +' ';
                    if('apellidomaterno' in alumno)
                      alumno.nombrecompleto +=  alumno.apellidomaterno +' ';
                      alumno.nombrecompleto = alumno.nombrecompleto.toUpperCase();                                                                               
                    });
                    this.arrayalumnos.unshift({"nombrecompleto":"VER TODOS","alumnoid":-1});

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

    getDocumentos()
    {
        this._httpService.getElemento('portalfamiliar/pagoenlinea/pagados/bypadreotutor/1/' + this.PadresOTutoresId).subscribe(
        result =>
        {
            (<any>$("#tablaPagados")).dataTable().fnDestroy();

            this.arraydocumentos=[];
            this.arraymaestro=[];

            if (result.status == 200)
            {
                if(result.body.length>0)
                {
                    result.body.forEach(obj =>
                    {
                        obj.ImporteTotal = parseFloat(obj.Importe);


                        obj.Interes = obj.Interes ? parseFloat(obj.Interes) : 0;

                        if(obj.Inscripcion)
                        {
                            obj.ImporteTotal += parseFloat(obj.Inscripcion);
                        }

                        this.arraydocumentos.push(obj);
                        this.arraymaestro.push(obj);
                    });
                 }

                if(this.myalumnoid > 0)
                {
                    this.arraydocumentos = this.arraydocumentos.filter(alumno => alumno.AlumnoId == this.myalumnoid);
                }

                this.SetTablaDocumentosPagados();
            }
            else
            {
                (<any>$("#tablaPagados")).dataTable().fnDestroy();

                this.arraydocumentos=[];
                this.arraymaestro=[];

                Messenger().post({
                    message: result.body,
                    type: 'success',
                    showCloseButton: true

                });

                this.SetTablaDocumentosPagados();
            }
        },
        error =>
        {
            (<any>$("#tablaPagados")).dataTable().fnDestroy();

            this.arraydocumentos=[];
            this.arraymaestro=[];

            var errorMessage = <any> error;
            Messenger().post({
                message: 'No se pudo comunicar con el servidor',
                type: 'error',
                showCloseButton: true
            });
            this.SetTablaDocumentosPagados();
        });


    }

    FiltrarDocumento(alumnoid)
    {
        if(!alumnoid)
        {
            this.myalumnoid = -1;
        }

        (<any>$("#tablaPagados")).dataTable().fnDestroy();
        this.alumnosel = alumnoid;
        this.arraydocumentos = this.arraymaestro;

        if(alumnoid > 0)
        {
            this.arraydocumentos = this.arraydocumentos.filter(alumno => alumno.AlumnoId == alumnoid);
        }

        this.SetTablaDocumentosPagados();
    }

    SetTablaDocumentosPagados()
    {
        if(this.arraydocumentos.length > this.tablaRegistros)
        {
            this.dtOptionsPagado.dom  = "rtp";
            this.dtOptionsPagado.sDom  = "rtp";
        }
        else
        {
            this.dtOptionsPagado.dom = "";
            this.dtOptionsPagado.sDom = "";
        }

        this.dtTriggerPagado.next();
    }
}