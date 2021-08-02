import {AfterViewInit, ViewEncapsulation, Component, OnInit, ViewChild, Input, Output, EventEmitter} from '@angular/core';
import {AppState} from '../../app.service';
import {FormGroup, FormBuilder} from '@angular/forms';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {Subject} from 'rxjs/Rx';
import {forEach} from "@angular/router/src/utils/collection";
import {Defer} from "../../inscripcionesColegiaturas/MensajePago/mensajePago.model";
import {StorageService} from 'app/Servicios/storage.service';


declare let Messenger: any;
declare let $: any;
declare var alasql: any;

@Component({
    selector: 'modalfamilia',
    templateUrl: './Familias.template.html',
    providers: [AppState],
    encapsulation: ViewEncapsulation.None,
})

export class FamiliasComponent
{
    @Output() familiaSeleccionada = new EventEmitter();

    //Variables
    padreotutorid:any;
    msnPago:string = "";
    msnSolicitudFamilia:string = "";
    matricularSeleccinada:number = 0;

    //Modal
    @ViewChild('modalFamilia') public modalFamilia: ModalDirective;

    //Tabla
    familias: any[] = [];
    sistema:number = 0;

    constructor(private _httpService: AppState, private _fb: FormBuilder, private storage: StorageService)
    {
        this.padreotutorid = this.storage.getItem("PadresOTutoresId");
        this.sistema = this._httpService.sistema;
        this.familias = [];
    }

    //Metodo de inicio
    ngOnInit(): void
    {

        this.GetMensajesSeccionBecas();
    }

    ngAfterViewInit(): void
    {
        this.modalFamilia.onHidden.subscribe(() =>
        {
            if(this.matricularSeleccinada)
            {
                this.familiaSeleccionada.emit(this.matricularSeleccinada);
                this.matricularSeleccinada = null;
            }
        });
    }

    //------ funcionalidad ---------

    AbrirModal()
    {
        this.GetFamilias();
    }

    CerrarModal()
    {
        this.modalFamilia.hide();
    }

    GetFamilias()
    {

        this.familias = [];

        this._httpService.getElemento('portalfamiliar/becas/SolicitudBeca/Familia/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200)
                {
                    this.familias = result.body;

                    for( let fam of  this.familias)
                    {
                        fam.veralumnos = false;
                    }

                    if(this.familias.length > 1)
                    {
                        this.modalFamilia.show();
                    }
                    else  if(this.familias.length == 1)
                    {
                        if(this.familias[0].solicitado == "0") //Crear nueva
                        {
                            this.FamiliaSeleccionada(this.familias[0]);
                        }
                        else //Ya solicitado
                        {
                            this.EnviarAviso("Usted ya realizó la solicitud de beca para este ciclo escolar.");
                        }
                    }
                    else
                    {
                        this.CerrarModal();
                    }
                }
                else
                {
                    this.familias = [];
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });

                }
            },
            error => {
                this.familias = [];

                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });

            }
        );
    }

    FamiliaSeleccionada(familia)
    {
        if(familia.alumno.length > 0)
        {
            if (this.sistema == 1) //LUX
            {
                this._httpService.getElemento('portalfamiliar/becas/SolicitudBeca/Pagado/' + familia.clavefamiliarid).subscribe(
                    result => {
                        if (result.status == 200) {
                            if (result.body.Pago.Pagado == "1")
                            {
                                this.CrearSolicitud(familia.alumno[0].matricula);
                            }
                            else {
                                this.EnviarAviso(this.msnPago);
                            }
                        }
                        else {
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
            else //IDEC
            {
                this.CrearSolicitud(familia.alumno[0].matricula);
            }
        }
        else
        {
            this.CerrarModal();
        }
    }

    CrearSolicitud(matricula)
    {
        if(this.familias.length > 1)
        {
            this.matricularSeleccinada = matricula;
            this.CerrarModal();
        }
        else if(this.familias.length == 1)
        {
            this.matricularSeleccinada = matricula;
            this.familiaSeleccionada.emit(this.matricularSeleccinada);
            this.matricularSeleccinada = null;
        }
    }

    EnviarAviso(msn)
    {
        let msg = Messenger({extraClasses: 'messenger-fixed messenger-on-top'}).post({
            message: msn,
            hideAfter: false,
            actions:
                {
                    confirm:
                    {
                        label: "Aceptar",
                        action: () => {
                            msg.hide();
                        }
                    },
                }
        })
    }


    GetMensajesSeccionBecas()
    {
        this._httpService.getElemento('portalfamiliar/becas/SolicitudBeca/Mensajes' ).subscribe(
            result =>
            {
                if (result.status == 200)
                {
                    this.msnPago = result.body.pagobeca;
                    this.msnSolicitudFamilia = result.body.solicitudfamilia;
                }
                else
                {
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
