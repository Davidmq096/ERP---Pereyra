import { ViewEncapsulation, Component, OnInit, Output, EventEmitter, Input } from '@angular/core';
import { AppState } from 'app/app.service';
import { MenuList } from "entity/menulist.ts";
import { StorageService } from 'app/Servicios/storage.service';
import { Reinscripciones } from 'app/reinscripcion/reinscripciones/reinscripciones';
import { saveAs as importedSaveAs } from "file-saver";
import * as AWS from 'aws-sdk';
import * as S3 from 'aws-sdk/clients/s3';
import { Config } from 'app/config';

declare let Messenger: any;

@Component({
    selector: 'paso4',
    templateUrl: './paso4.component.html',
    providers: [AppState],
    encapsulation: ViewEncapsulation.None,
})
export class Paso4Component implements OnInit {
    @Input() reinscripciones: Reinscripciones;
    @Output() output = new EventEmitter();
    @Output() lista = new EventEmitter();
    arrayDocumentos: any[] = [];
    mensaje: string;
    fileconfigFull: any;
    arrayArchivos: any[] = [];
    arrayDocumentossubidos: any[] = [];
    cambio: boolean;
    config: Config = new Config()
    tamanoMaximo: any;



    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private storage: StorageService) {
        MenuList.visible = true;
        window.onpopstate = null;
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.fileconfigFull = {
            maxFileCount: 8,
            showClose: false,
            showUpload: false,
            showRemove: false,
            browseLabel: "Seleccionar",
            layoutTemplates: { footer: '<div class="file-thumbnail-footer" style ="height:0px"> </div>' }
        };
        let docs = this.reinscripciones.catalogos.arrayDocumentos;
        this.arrayDocumentos = docs.filter(x => x.grados.includes(parseInt(this.reinscripciones.alumno.gradoid)));
        this.tamanoMaximo = this.reinscripciones.tamanoMaximo;
        this.recargarDocumentos();
        //this.buscar();
        console.log(this.reinscripciones);

        this.configAWS();
    }



    descargar(objeto) {

        const s3 = new AWS.S3()

        const signedUrlExpireSeconds = 2

        const url = s3.getSignedUrl('getObject', {
            Bucket: this.reinscripciones.catalogos.s3.bucket,
            Key: objeto.urldocumento,
            Expires: signedUrlExpireSeconds
        });
        window.open(url);
    }

    onFileChange(archivo, tipo) {
        var files = {};
        let docs = this.arrayArchivos.filter(x => x.documentoid != tipo);
        for (let a of archivo) {
            console.log("normal", a);
            let reader = new FileReader();
            reader.readAsDataURL(a);
            reader.onload = () => {
                files = {
                    filename: a.name,
                    filetype: a.type,
                    size: a.size,
                    documentoid: tipo,
                    file: a,
                    ciclo: this.reinscripciones.alumno.ciclo
                }
                docs.push(files);
                console.log(files);
            };
        }
        this.arrayArchivos = docs;
        this.cambio = true;
    }

    async cancelar() {
        if (!this.cambio) {
            this.output.next();
            return false;
        }

        for (let d of this.arrayDocumentos) {
            let archivos = this.arrayArchivos.filter(x => x.documentoid == d.documentoid);
            let subidos = this.arrayDocumentossubidos.filter(x => x.documentoid == d.documentoid);
            if (archivos.length == 0 && subidos.length == 0) {
                Messenger().post({
                    message: "Debe agregar un archivo al tipo de documento " + d.nombre,
                    type: "success",
                    showCloseButton: true
                });
                return false;
            }
        }

        for (let a of this.arrayArchivos) {
            let file = Object.assign({}, a);
            file.reinscripcionid = this.reinscripciones.alumno.reinscripcionid;
            //verificamos si existe el archivo
            let existe = await this.obtenerArchivo(a.filename);
            if (!(existe as any)) {
                let resp = await this.guardarDocumento(file);
                if (!resp.success) {
                    Messenger().post({
                        message: resp.msj,
                        type: 'success',
                        showCloseButton: true
                    });
                    return false;
                }
            } else {
                Messenger().post({
                    message: "Ya existe un archivo con el mismo nombre",
                    type: 'success',
                    showCloseButton: true
                });
                return false;
            }
        }

        let objeto = {
            archivos: this.arrayArchivos,
            reinscripcionid: this.reinscripciones.alumno.reinscripcionid,
            finalizado: "false"
        }
        this._httpService.postElemento('Controlescolar/Reinscripcion/GuardarDocumentos/', objeto, null, true).subscribe(
            res => {
                if (res.status == 200) {
                    this.output.next();
                    this.reinscripciones.alumno.documentossubidos = res.body.documentos;
                    Messenger().post({
                        message: res.body.mensaje,
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

    async finalizar() {
        if (this.arrayDocumentos.length == 0) {
            Messenger().post({
                message: "No se han configurado los documentos para el grado a inscribir del alumno",
                type: "success",
                showCloseButton: true
            });
            return false;
        }

        for (let d of this.arrayDocumentos) {
            let archivos = this.arrayArchivos.filter(x => x.documentoid == d.documentoid);
            let subidos = this.arrayDocumentossubidos.filter(x => x.documentoid == d.documentoid);
            if (archivos.length == 0 && subidos.length == 0) {
                Messenger().post({
                    message: "Debe agregar un archivo al tipo de documento " + d.nombre,
                    type: "success",
                    showCloseButton: true
                });
                return false;
            }
        }

        Messenger().post({
            message: "Se cargarán los archivos al sistema, lo que puede tardar un poco, por favor espere que termine este proceso. Por favor no cierre esta ventana o presione el botón 'atrás' del navegador.",
            type: "success",
            showCloseButton: true
        });

        for (let a of this.arrayArchivos) {
            let file = Object.assign({}, a);
            file.reinscripcionid = this.reinscripciones.alumno.reinscripcionid;
            //verificamos si existe el archivo
            let existe = await this.obtenerArchivo(a.filename);
            if (!(existe as any)) {
                let resp = await this.guardarDocumento(file);
                if (!resp.success) {
                    Messenger().post({
                        message: resp.msj,
                        type: 'success',
                        showCloseButton: true
                    });
                    return false;
                }
            } else {
                Messenger().post({
                    message: "Ya existe un archivo con el mismo nombre",
                    type: 'success',
                    showCloseButton: true
                });
                return false;
            }
        }


        let objeto = {
            archivos: this.arrayArchivos,
            reinscripcionid: this.reinscripciones.alumno.reinscripcionid,
            finalizado: "true"
        }
        this._httpService.postElemento('Controlescolar/Reinscripcion/GuardarDocumentos/', objeto, null, true).subscribe(
            res => {
                if (res.status == 200) {
                    this.lista.next();
                    Messenger().post({
                        message: res.body.mensaje,
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

    eliminar(objeto) {
        var s3 = new AWS.S3();

        var params = {
            Bucket: this.reinscripciones.catalogos.s3.bucket,
            Key: objeto.urldocumento,
        };

        s3.deleteObject(params, (err, data) => {
            if (err) {
                console.log(err)
            } else {
                this._httpService.deleteElemento('Controlescolar/Reinscripcion/Documentossubidos/eliminar', objeto.reinscripciondocumentoid).subscribe(
                    res => {
                        if (res.status == 200) {
                            this.reinscripciones.alumno.documentossubidos = res.body.documentos;
                            this.arrayDocumentossubidos = this.reinscripciones.alumno.documentossubidos ? this.reinscripciones.alumno.documentossubidos : [];
                            for (let i = 0; i < this.arrayDocumentos.length; i++) {
                                let files = this.arrayDocumentossubidos.filter(x => x.documentoid == this.arrayDocumentos[i].documentoid);
                                this.arrayDocumentos[i].documentossubidos = files;
                            }
                            Messenger().post({
                                message: res.body.mensaje,
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
        });
    }

    recargarDocumentos() {
        let tipo = 'image';
        this.arrayDocumentossubidos = this.reinscripciones.alumno.documentossubidos ? this.reinscripciones.alumno.documentossubidos : [];
        for (let i = 0; i < this.arrayDocumentos.length; i++) {
            let files = this.arrayDocumentossubidos.filter(x => x.documentoid == this.arrayDocumentos[i].documentoid);
            this.arrayDocumentos[i].documentossubidos = files;
            $.when($("#multimedia" + i)).then(() => {
                (<any>$("#multimedia" + i)).fileinput("destroy");
                $("#multimedia" + i).attr("accept", "*");
                (<any>$("#multimedia" + i)).fileinput(this.fileconfigFull);
            });
        }
    }

    configAWS() {
        AWS.config.update({
            secretAccessKey: this.reinscripciones.catalogos.s3.sacceskey,
            accessKeyId: this.reinscripciones.catalogos.s3.accessid,
            region: this.reinscripciones.catalogos.s3.region,
            signatureVersion: 'v4',
        });
    }


    guardarDocumento(file): Promise<any> {
        file.nombrearchivo = file.filename;
        
        var promise = new Promise((result, reject) => {
            var upload = new AWS.S3.ManagedUpload({
                params: {
                    Bucket: this.reinscripciones.catalogos.s3.bucket,
                    Key: this.reinscripciones.catalogos.s3.ruta + this.reinscripciones.alumno.ciclo + '/' + this.reinscripciones.alumno.ciclo +
                        '_' + this.reinscripciones.alumno.matricula + '_' + file.nombrearchivo,
                    Body: file.file
                }
            });

            var promise = upload.promise();

            promise.then(
                (data) => {
                    this._httpService.postElemento("Controlescolar/Reinscripcion/GuardarDocumentoReinscripcion/", file, false, true).subscribe(
                        res => {
                            var results;
                            if (res.status == 200) {
                                results = { success: true }
                                result(results);

                            } else {
                                Messenger().post({
                                    message: res.body,
                                    type: "success",
                                    showCloseButton: true
                                });
                                results = { success: false, msj: res.body }
                                result(results);
                            }
                        },
                        err => {
                            //handle your error here.
                            var results = { success: false, msj: err }
                            result(results);
                        }
                    );
                },
                (err) => {
                    var results = { success: false, msj: 'Ocurrió un error al subir el archivo, pruebe intentando de nuevo.' }
                    result(results);
                }
            );
        });

        return promise;
    }

    async obtenerArchivo(nombre) {

        const s3 = new AWS.S3();
        const exists = await s3
        .headObject({
            Bucket: this.reinscripciones.catalogos.s3.bucket, // your bucket name,
            Key: this.reinscripciones.catalogos.s3.ruta + this.reinscripciones.alumno.ciclo + '/' + this.reinscripciones.alumno.ciclo +
                '_' + this.reinscripciones.alumno.matricula + '_' + nombre
        })
        .promise()
        .then(
          () => true,
          err => {
            if (err.code === 'NotFound') {
              return false;
            }
            throw err;
          }
        );
        return exists;

    }

}
