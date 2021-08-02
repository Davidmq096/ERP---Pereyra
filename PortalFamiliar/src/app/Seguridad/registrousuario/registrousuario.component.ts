import {Component, OnInit} from '@angular/core';
import {AppState} from "../../app.service";
import {Helpers} from "app/app.helpers";
import {FormGroup, FormBuilder, Validators, FormControl} from '@angular/forms';
import {Router} from "@angular/router";
declare let Messenger: any;

@Component({
    selector: 'registrousuario',
    styleUrls: ['./login.style.scss', './landing.style.scss'],
    templateUrl: './registrousuario.template.html'
})
export class registrousuario implements OnInit {
    Formregistro: FormGroup;
    sistema: any;
    matriculas: any[];
    submitted: boolean = false;
    router: Router;
    logo: string;
    location: Location;

    constructor(private _httpService: AppState, private _fb: FormBuilder, private _help: Helpers) {
        this.logo = _httpService.logo;
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.Formregistro = this._fb.group({
            padremadreotutor: [, <any> Validators.required],
            correo: [, Validators.pattern(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)],
            nombre: [, <any> Validators.required],
            apellidopaterno: [, <any> Validators.required],
            apellidomaterno: [, <any> Validators.required],
            matricula: [],
            buscarmatricula: []
        });
        this.matriculas = [];
    }

    transformartexto(forname: FormControl) {
        let texto: string = forname.value;
        if (texto) {
            forname.setValue(this.sistema == 1 ? texto.toUpperCase() : this._help.capitalize(texto));
        }
    }

    agregarmatricula(matricula: any) {
        this.matriculas.push(matricula.value);
        this.Formregistro.get('buscarmatricula').reset();
    }

    eliminarmatricula(matricula: any) {
        this.matriculas.splice(matricula, 1);

    }

    guardar() {
        this.Formregistro.get('buscarmatricula').setValidators(null);
        this.Formregistro.get('buscarmatricula').updateValueAndValidity();
        this.Formregistro.get('matricula').setValue(this.matriculas);
        if (this.Formregistro.get('padremadreotutor').value == null || this.Formregistro.get('padremadreotutor').value == undefined || this.Formregistro.get('padremadreotutor').value == "") {
            Messenger().post({
                message: "Seleccione si es padre, madre o tutor",
                type: 'success',
                showCloseButton: true
            });
        }

        if (this.Formregistro.get('matricula').value.length == 0) {
            Messenger().post({
                message: "Ingrese al menos una matricula",
                type: 'success',
                showCloseButton: true
            });
        }

        this.submitted = true;
        if (this.Formregistro.invalid) {
            return false;
        }


        this.submitted = false;
        this._httpService.postElemento("portalfamiliar/registro", this.Formregistro.value,null,true).subscribe(res => {
            if (res.status == 200) {
                if (res.body.mensaje) {
                    try {
                        let mensaje = res.body.mensaje.split('"')
                        let msj = mensaje[1].split('"')
                        Messenger().post({
                            message: msj[0],
                            type: 'success',
                            showCloseButton: true
                        });
                    } catch (e) {
                        Messenger().post({
                            message: res.body.mensaje,
                            type: 'success',
                            showCloseButton: true
                        });
                        window.location.href = '#/Seguridad/Login';
                    }

                } else {
                    try {
                        let mensaje = res.body.split('"')//res.text.split('"')
                        let msj = mensaje[1].split('"')
                        Messenger().post({
                            message: msj[0],
                            type: 'success',
                            showCloseButton: true
                        });
                    } catch (e) {
                        Messenger().post({
                            message: res.body,
                            type: 'success',
                            showCloseButton: true
                        });
                        window.location.href = '#/Seguridad/Login';
                    }
                }

            } else if (res.status == 206) {
                if (res.body.mensaje) {
                    try {
                        let mensaje = res.body.mensaje.split('"')
                        let msj = mensaje[1].split('"')
                        Messenger().post({
                            message: msj[0],
                            type: 'success',
                            showCloseButton: true
                        });
                    } catch (e) {
                        Messenger().post({
                            message: res.body.mensaje,
                            type: 'success',
                            showCloseButton: true
                        });
                    }
                } else {
                    try {
                        let mensaje = res.body.split('"')
                        let msj = mensaje[1].split('"')
                        Messenger().post({
                            message: msj[0],
                            type: 'success',
                            showCloseButton: true
                        });
                    } catch (e) {
                        Messenger().post({
                            message: res.body,
                            type: 'success',
                            showCloseButton: true
                        });
                    }
                }
            }
        },
            error => {
                Messenger().post(
                    {
                        message: 'No se puedo comunicar con el servidor.',
                        type: 'success',
                        showCloseButton: true
                    });
            });



    }


    mensaje() {

    }
    cancelar() {
        window.location.href = '#/Seguridad/Login';
    }
}
