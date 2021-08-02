import {AfterViewInit, ViewEncapsulation,  Component, OnInit, ViewChild, Output, Input, EventEmitter, ViewContainerRef, ComponentFactory,ComponentFactoryResolver, ComponentRef, AfterContentInit } from '@angular/core';
import {AppState} from 'app/app.service';
import {Router} from '@angular/router';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {Subject} from 'rxjs/Rx';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import {Seguridad} from '../../entity/seguridad';
import {DocumentoModel} from '../../../../../entity/Models/DocumentosModel';
import {SolicitudBecaComponent} from 'app/Becas/componentesbecas/modalsolicitud/solicitudbeca/solicitudbeca.component';
import {DatosPadresComponent} from 'app/Becas/componentesbecas/modalsolicitud/datospadres/datospadres.component';
import {DatosDependientesComponent} from 'app/Becas/componentesbecas/modalsolicitud/dependienteseconomicos/dependienteseconomicos.component';
import {SituacionEconomicaComponent} from 'app/Becas/componentesbecas/modalsolicitud/situacioneconomica/situacioneconomica.component';
import {ReferenciasComponent} from 'app/Becas/componentesbecas/modalsolicitud/referencias/referencias.component';
import {parametrosModal} from 'app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud';

declare let Messenger: any;
declare let $: any;
declare var alasql: any;

@Component({
    selector: 'solicitud',
    templateUrl: './modalsolicitud.component.html',
    providers: [AppState],
    encapsulation: ViewEncapsulation.None,
})

export class ModalSolicitudComponent implements OnInit, AfterViewInit, AfterContentInit {
    accion: boolean;
    identificador: any;
    @Input() parametrosModal: parametrosModal;
    @Output() output = new EventEmitter();
    Componenteenturno:any;
    pestana: number; // id de la pestaña en turno
    Documentos: DocumentoModel = new DocumentoModel();
    mostrar: any;
    mostrarguardar:any;
    mostrarsalir:any;
    mostrarguardarfinalizar:any;
    sistema:number;
    avisoPrivacidad: string;

    componentRef: ComponentRef<any>;

    @ViewChild('modal') public modal: ModalDirective;

    /* 8 componentes*/
    @ViewChild("container", {read: ViewContainerRef}) container;

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private _fb: FormBuilder, private _router: Router, public _cfr: ComponentFactoryResolver)
    {
        this.sistema = _httpService.sistema;
        this.avisoPrivacidad = _httpService.avisoPrivacidad;

    }

    //Metodo de inicio
    ngOnInit(): void {
        $.fn.widgster.Constructor.DEFAULTS.bodySelector = '.widget-body form';
        $('.widget').widgster();         
    }
    ngAfterViewInit(): void {
        this.modal.show();
    }

    ngAfterContentInit() {
        this.contentView(this.parametrosModal.pestana);
    }

   //nuevo menu
    contentView(e: number)
    {
        this.parametrosModal.pestana = e;
        if (e == 1)
        {
        this.mostrar=false;
        this.mostrarsalir=false;
        this.mostrarguardar=false;
        this.mostrarguardarfinalizar=true;
        this.parametrosModal.configpestana.solicitudbeca.visible ? this.cargarVista(SolicitudBecaComponent) : this.contentView(e + 1);
        }if(e==2){
            this.mostrar=true;
            this.mostrarsalir=false;
            this.mostrarguardar=false;
            this.mostrarguardarfinalizar=true;
            this.parametrosModal.configpestana.datospadres.visible ?
                this.cargarVista(DatosPadresComponent) : this.contentView(e + 1);
        }
        if(e==3){
            this.mostrar=true;
            this.mostrarsalir=false;
            this.mostrarguardar=false;
            this.mostrarguardarfinalizar=true;
            this.parametrosModal.configpestana.dependienteseconomicos.visible ?
                this.cargarVista(DatosDependientesComponent) : this.contentView(e + 1);

        }if(e==4){
            this.mostrar=true;
            this.mostrarsalir=false;
            this.mostrarguardar=false;
            this.mostrarguardarfinalizar=true;
            this.parametrosModal.configpestana.situacioneconomica.visible ?
                this.cargarVista(SituacionEconomicaComponent) : this.contentView(e + 1);

            if(this.sistema == 1)
            {
                this.mostrarguardar = true;
                this.mostrarguardarfinalizar = false;
            }

        }if(e==5){
            this.mostrar=true;
            this.mostrarsalir=false;

            if(this.sistema == 2)
            {
                this.mostrarguardar = true;
                this.mostrarguardarfinalizar = false;
            }

            this.parametrosModal.configpestana.referencias.visible ?
//                this.cargarVista(ReferenciasComponent) : this.contentView(e + 1);
                this.cargarVista(ReferenciasComponent) : this.destroyComponenete();
                
        }
    }

    //Funcion que carga el componenete en el contenedor
    cargarVista(componente: any) {
        this.container.clear();
        const factory: ComponentFactory<any> = this._cfr.resolveComponentFactory(componente);
        this.componentRef = this.container.createComponent(factory);
        this.componentRef.instance.parametrosModal = this.parametrosModal;                      //Le envia "parametrosModalReactivos"
        this.componentRef.instance.output.subscribe((componentesolicitud: any) => {                     //Queda a espera de que el componenete regrese "this"
            this.Componenteenturno = componentesolicitud;

        });
        this.componentRef.instance.accionGuardar.subscribe((exito: boolean) => {                //Queda a espera de que la accion de guardar se realice en el componente en turno
            this.cambiarpestana(exito);                                                         //Cambia de pestaña
        });
    }

    //Funcion para llamar a la funcion de guardado del componente en turno
    guardar(pestana?: number)
    {
        if (pestana != this.parametrosModal.pestana) {  //Valida si se esta cambiando de pestaña para realizar o no el guadado
            this.pestana = pestana;                         //Asiga del valor de la pestaña a la que se va a cambiar
            this.Componenteenturno.guardar();                     //Llama la funcion guardar del compoennete en turno
        }
    }

    //Funcion para cambiar de pestaña
    cambiarpestana(exito: boolean) {                                                         //Quita el style de la pestaña actual
        if (exito) {                                                                     //Si la funcion de guardado fue exitosa
            if (this.pestana) {                                                                         //Si le dio click a una pestaña
                this.contentView(this.pestana);                                                             //Se cambia a la pestaña seleccionada

            } else {                                                                                    //Le dio click al boton de guardar
                var index = this.parametrosModal.pestana + 1;                                               //Se cambia a la siguiente pestaña en el orden
                if (index > (this.sistema == 1 ? 4 : 5) )
                {                                                                                //Si el id de la pestaña s mayor a 5
                    this.destroyComponenete();                                                                              //Ya no hay pestañas, terminamos el proceso y cerramos la modal
                } else {                                                                                        //El id de la pestaña es monor a 5
                    this.contentView(index);                                                                        //Se cambia a la siguiente pestaña
                }
            }
        }
    }

    destroyComponenete() {
      //  try{
            this.output.next(this.modal);      //Avisa al componente padre que se cerrara la modal
            this.modal.hide();
       // }
      //  catch (e){
           // this.salir();
      //  }
                                             //Cierra la modal
    }


/*
guardarGeneral(){

    this.Componenteenturno.guardar();
    }*/


    valoresiniciales(){
    this.Componenteenturno.getdomicilio();
    }


    salir() {
        this.output.next({modal: this.modal});
        this.modal.hide();
    }

  GetCurrentTab()
  {
    switch (this.parametrosModal.pestana)
    {
      case 1:
        return "Solicitud";

      case 2:
        return "Datos de los padres";

      case 3:
        return "Dependientes económicos";

      case 4:
        return "Situación económica";

      case 5:
        return "Referencias";


      default:
        return "";
    }
  }

}
