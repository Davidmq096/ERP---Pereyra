import { Component, OnInit, ViewChild, ComponentFactoryResolver, ViewContainerRef, ComponentFactory, ComponentRef } from '@angular/core';
import { AppState } from 'app/app.service';
import { StorageService } from 'app/Servicios/storage.service';
import { ListareinscripcionesComponent } from './listareinscripciones/listareinscripciones.component';
import { Paso1Component } from './paso1/paso1.component';
import { Paso2Component } from './paso2/paso2.component';
import { Paso3Component } from './paso3/paso3.component';
import * as AWS from 'aws-sdk';

import { Reinscripciones } from 'app/reinscripcion/reinscripciones/reinscripciones';

declare let Messenger: any;

@Component({
    selector: 'reinscripciones',
    template: `<div #containerReinscripciones></div>`,
    providers: [AppState]
})

export class ReinscripcionesComponent implements OnInit {
    reinscripciones: Reinscripciones;
    @ViewChild("containerReinscripciones", { read: ViewContainerRef }) containerReinscripciones;

    //En el contructor se declara la llamada a los servicios
    constructor(public _cfr: ComponentFactoryResolver, private storage: StorageService, private _httpService: AppState,) {
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.loadInfo();
    }

    cargarContenedorListaReinscripciones() {
        this.containerReinscripciones.clear();
        const factory: ComponentFactory<any> = this._cfr.resolveComponentFactory(ListareinscripcionesComponent);
        var ref: ComponentRef<any> = this.containerReinscripciones.createComponent(factory);
        ref.instance.reinscripciones = this.reinscripciones;
        ref.instance.output.subscribe(() => {

            this.cargarContenedorPaso1();
        });
    }



    cargarContenedorPaso1() {
        this.containerReinscripciones.clear();
        const factory: ComponentFactory<any> = this._cfr.resolveComponentFactory(Paso1Component);
        var ref: ComponentRef<any> = this.containerReinscripciones.createComponent(factory);
        ref.instance.reinscripciones = this.reinscripciones;
        ref.instance.output.subscribe(() => {
            this.loadInfo();
            this.cargarContenedorListaReinscripciones();
        });
        ref.instance.paso2.subscribe(() => {
            this.cargarContenedorPaso2();
        });
    }

    cargarContenedorPaso2() {
        this.containerReinscripciones.clear();
        const factory: ComponentFactory<any> = this._cfr.resolveComponentFactory(Paso2Component);
        var ref: ComponentRef<any> = this.containerReinscripciones.createComponent(factory);
        ref.instance.reinscripciones = this.reinscripciones;
        ref.instance.output.subscribe(() => {
            this.cargarContenedorPaso1();
        });
        /* Se omite el paso 3 */
        /*ref.instance.paso3.subscribe(() => {
            this.cargarContenedorPaso3();
        });*/
        ref.instance.paso3.subscribe(() => {
            this.cargarContenedorPaso3();
        });
    }

    cargarContenedorPaso3() {
        this.containerReinscripciones.clear();
        const factory: ComponentFactory<any> = this._cfr.resolveComponentFactory(Paso3Component);
        var ref: ComponentRef<any> = this.containerReinscripciones.createComponent(factory);
        ref.instance.reinscripciones = this.reinscripciones;
        ref.instance.output.subscribe(() => {
            this.cargarContenedorPaso2();
        });
        ref.instance.paso4.subscribe(() => {
            this.loadInfo();
            this.cargarContenedorListaReinscripciones();
        });
    }


    loadInfo() {
        this.reinscripciones = new Reinscripciones();
        this._httpService.getElemento('Controlescolar/Reinscripcion/Opciones').subscribe(
            result => {
                if (result.status == 200) {
                    if (result.body.data) {
                        this.reinscripciones.catalogos.arrayPagocolegiaturas = result.body.data.colegiatura;
                        this.reinscripciones.catalogos.arrayPagoadelantada = result.body.data.anticipada;
                        this.reinscripciones.catalogos.arrayInscripcion = result.body.data.inscripcion;
                        this.reinscripciones.catalogos.arrayDocumentos = result.body.data.documento;
                        this.reinscripciones.catalogos.arrayTipopago = result.body.data.tipopagocolegiatura;
                        this.reinscripciones.tamanoMaximo = result.body.data.maxsize;
                        this.reinscripciones.catalogos.s3 = result.body.data.s3;
                        this.cargarContenedorListaReinscripciones();
                    } else {
                        Messenger().post({
                            message: "No se ha encontrado la información necesaria para realizar el proceso",
                            type: 'success',
                            showCloseButton: true
                        });
                        this.cargarContenedorListaReinscripciones();
                    }
                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                    this.cargarContenedorListaReinscripciones();
                }
            },
            error => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
                this.cargarContenedorListaReinscripciones();
            }
        );
    }

}
