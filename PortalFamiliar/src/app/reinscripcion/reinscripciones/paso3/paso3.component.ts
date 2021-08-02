import { ViewEncapsulation, Component, OnInit, Output, EventEmitter, Input } from '@angular/core';
import { AppState } from 'app/app.service';
import { MenuList } from "entity/menulist.ts";
import { StorageService } from 'app/Servicios/storage.service';
import { Reinscripciones } from 'app/reinscripcion/reinscripciones/reinscripciones';
import { saveAs as importedSaveAs } from "file-saver";
import * as Types from 'app/types.json';
import { TypeScriptEmitter } from '@angular/compiler';

declare let Messenger: any;

@Component({
    selector: 'paso3',
    templateUrl: './paso3.component.html',
    providers: [AppState],
    encapsulation: ViewEncapsulation.None,
})
export class Paso3Component implements OnInit {
    @Input() reinscripciones: Reinscripciones;
    @Output() output = new EventEmitter();
    @Output() paso4 = new EventEmitter();
    arrayDocumentos: any[] = [];
    mensaje: string;
    extensiones: any;
    public reinscripcionid: any;
    public padreotutorid: any;
    arrayImpresos: any[] = [];

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private storage: StorageService) {
        this.padreotutorid = this.storage.getItem('PadresOTutoresId');
        MenuList.visible = true;
        window.onpopstate = null;
        this.extensiones = Types;
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.datosAlumnos();
        let docs = this.reinscripciones.catalogos.arrayDocumentos;
        this.arrayDocumentos = docs.filter(x => x.grados.includes(parseInt(this.reinscripciones.alumno.gradoid)));
    }


    datosAlumnos(){
    this._httpService.getElemento('Controlescolar/Reinscripcion/Alumnosbypadretutor/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    let res = result.body;
                    this.reinscripcionid = this.reinscripciones.alumno.reinscripcionid;     
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


    descargar(id) {     
        if (this.arrayImpresos.indexOf(id) < 0){
            this.arrayImpresos.push(id);
        }

        this._httpService.getArchivo("Controlescolar/Reinscripcion/Documentoalumno/descargar", id + "?reinscripcionid=" + this.reinscripcionid ).subscribe(
            result => {
                if (result.status == 200) {
                    let docs = this.arrayDocumentos.find(x => x.documentoid == id);
                    let extension = "" // Extensión a buscar
                    Object.keys(this.extensiones).map(m => { // Mapeamos las llaves del json
                        if (result.body.type == this.extensiones[m]) { 
                            extension = m;
                        }
                    })
                    importedSaveAs(result.body, (docs.nombre + " - " + this.reinscripciones.alumno.matricula + extension));
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

    masInformacion(t: any){
        if (t){
            window.open('https://www.idec.edu.mx/web7/servicios-en-linea/padres-de-familia/domiciliacion-a-tarjeta-de-debito-o-cuenta-bancaria/', '_blank');            
        }else{
            window.open('https://www.idec.edu.mx/web7/servicios-en-linea/padres-de-familia/cargo-automatico-a-tarjeta-de-credito/', '_blank');
        }
    }

    cancelar() {
        this.output.next();
    }

    siguiente() {
        console.log(this.arrayDocumentos.length);
        console.log(this.arrayImpresos.length);
        if (this.arrayDocumentos.length !== this.arrayImpresos.length){
            this._httpService.mensajeWarning("Por favor imprima los documentos para firmarlos.");
            return false;
        }

        let data = {reinscripcionid: this.reinscripcionid, status: 2};
        this._httpService.putElemento('Controlescolar/Reinscripcion/Estatus/', data, null, true).subscribe(
            res => {
                if (res.status == 200) {
                    this._httpService.mensajeSuccess("Recuerda llevar los documentos firmados a recepción del instituto o a la caja instalada en caseta.");
                    this.paso4.next();
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                } else {
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            err => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'success',
                    showCloseButton: true
                });
                console.log('error');
            }
        );
    }
}
