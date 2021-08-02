import {ViewEncapsulation, HostListener, Component, OnInit, ViewChild, ElementRef, AfterViewInit} from '@angular/core';
import {LoginModel} from "./loginModel";
import {AppState} from "../../app.service";
import {ModalDirective} from 'ng2-bootstrap/modal';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import {RecaptchaComponent} from 'ng-recaptcha';
import {StorageService} from 'app/Servicios/storage.service';
declare let Messenger: any;
declare let moment: any;
declare let CryptoJS: any;

@Component({
    selector: 'login',
    styleUrls: ['./login.style.scss', './landing.style.scss'],
    templateUrl: './login.template.html',
    encapsulation: ViewEncapsulation.None,
    host: {
        class: 'app'
    }
})
export class Login implements OnInit, AfterViewInit{
    @ViewChild('reCaptcha') reCaptcha;
    Formregistro: FormGroup;
    correo: string;
    loginModel: LoginModel = new LoginModel();
    sumitted: boolean = false;
    qa: any;
    logo: string;
    intentos: number = 0;
    minutos: number = 0;         //minutos que se bloquerá el login después de errar 3 veces
    bloqueo: boolean = false;
    tiempoBloqueo: Date;
    sistema: any;
    errorCaptcha: string = "";
    matriculas: any[];
    mostrarmensaje: boolean;
    counter: number = 0;
    mostrarversion: boolean;
    @ViewChild('modalbeca') public modal: ModalDirective;
    @ViewChild('modal2') public modal2: ModalDirective;

    handleVersion() {
        this.counter++;
        if(this.qa && this.counter >= 5) {
            this.mostrarversion = true;
        }
    }

    constructor(private _httpService: AppState, private _fb: FormBuilder, private storage: StorageService, private _he:ElementRef) {
        this.logo = _httpService.logo;
        this.sistema = this._httpService.sistema;
        this.qa = this._httpService.qa;
    }

    //Metodo de inicio
    ngOnInit(): void {

        RecaptchaComponent.prototype.ngOnDestroy = function () {
            if (this.subscription) {
                this.subscription.unsubscribe();
            }
        }

        this.Formregistro = this._fb.group({
            soymama: [, <any>Validators.required],
            soypapa: [, <any>Validators.required],
            soytutor: [, <any>Validators.required],
            correo: [, <any>Validators.required],
            nombres: [, <any>Validators.required],
            apellidopaterno: [, <any>Validators.required],
            apellidomaterno: [, <any>Validators.required],
            matricula: []
        });


    }

    ngAfterViewInit() {
        if (this.storage.getItem("Sesion") == "true") {
            if (this.storage.getItem("ReiniciarPassword") == "true") {
                window.location.href = '#/Seguridad/CambiarPassword';
            }
            else {
                window.location.href = '#/Menu/Inicio';
            }
        }
        else {
            if (this.storage.getItem("TiempoBloqueo")) {
                let fecha = new Date(this.storage.getItem("TiempoBloqueo"));

                tiempoBloqueo = moment().add({ s: fecha.getSeconds(), m: fecha.getMinutes() }).format('YYYY/MM/DD HH:mm:ss');
            }
            else {
                var tiempoBloqueo = moment();
            }

            this.intentos = this.storage.getItem("IntentoLogin") ? parseInt(this.storage.getItem("IntentoLogin")) : 0;
            this.GetParametro();
            this.BloquearLogin(tiempoBloqueo);
        }

        this.sumitted = false;
    }

    url: string;

    GetParametro() {
        this._httpService.getElemento('Parametros').subscribe
            (
            result => {
                if (result.status == 200) {
                    for (let k = 0; k < result.body.length; k++) {
                        if (result.body[k].nombre == "BloqueoLogin") {
                            this.minutos = parseInt(result.body[k].valor);
                        }
                        if (result.body[k].nombre == "ValidaSesion") {
                            this.storage.setItem("ValidarSesion", result.body[k].valor);
                        }
                        if (result.body[k].nombre == "VideoInicioPortalFamiliar") {
                            if(result.body[k].valor) {
                                if(localStorage.getItem("videoinicio") == "0") {
                                    this.modal2.show();
                                    localStorage.setItem("videoinicio", "1");
                                }
                                let iframe=document.getElementById('iframe');
                                (iframe as any).src=result.body[k].valor;
                            }
                        }
                    }
                }
                else {
                    //this._httpService.mensajeDanger('Error no se pudo comunicar con el servidor');
                    Messenger().post(
                        {
                            message: 'Ocurrió un error. Intente más tarde.',
                            type: 'error',
                            showCloseButton: true
                        });
                }
            },
            error => {
                Messenger().post(
                    {
                        message: 'No se pudo conectar con el servidor.',
                        type: 'error',
                        showCloseButton: true
                    });
            }
            );
    }



    IniciarSesion() {
        this.sumitted = true;

        if (!this.ValidarDatosLogin()) {
            return;
        }
        else {
            //            let datos = new LoginModel();
            let datos = {
                cuenta: this.loginModel.cuenta,
                clave: this._httpService.encodePassword({
                    cadena: this.loginModel.clave
                }),
                id: null,
                ip: null
            }
            //let cadena = this._httpService.EncriptarDatos({cadena: this.loginModel.password});

            //Llamada al servicio post para insertar un nuevo elemento
            this._httpService.postElemento('login/padres', datos, true).subscribe
                (
                result => {
                    if (result.status == 200) {
                        this._httpService.SetDatosUsuario(result);
                        if(!result.body.padreotutorid || result.body.padreotutorid <= 0) {
                            Messenger().post({
                                message: "El usuario ingresado debe ser un padre o tutor.",
                                type: 'success',
                                showCloseButton: true,
                            });
                            return false;
                        }
                        window.location.href = "#/Menu/Inicio";
                    }
                    else {
                        if (result.body.reiniciarcontrasena == 1) {
                            this._httpService.SetDatosUsuario(result);
                            window.location.href = "#/Seguridad/CambiarPassword";
                        }
                        else {
                            //this._httpService.mensajeDanger(result.body);
                            Messenger().post({
                                message: result.body,
                                type: 'error',
                                showCloseButton: true,
                            });
                            this.intentos++;
                            if (this.intentos > 2) {
                                var tiempobloqueo = moment().add(this.minutos, 'm').format('YYYY/MM/DD HH:mm:ss');
                                this.BloquearLogin(tiempobloqueo);
                                this.storage.setItem('TiempoBloqueo', tiempobloqueo);

                            }
                            this.reCaptcha.reset();
                            this.loginModel.captcha = false;
                        }
                    }
                },
                error => {
                    this.reCaptcha.reset();
                    Messenger().post(
                        {
                            message: 'No se pudo conectar con el servidor.',
                            type: 'error',
                            showCloseButton: true
                        });
                }
                );
        }
    }


    ValidarDatosLogin() {
        if (!this.loginModel.cuenta || !this.loginModel.clave) {
            return false;
        }

        if (!this.loginModel.captcha) {
            this.errorCaptcha = "Verique que no es un robot";
            return false;
        }
        else {
            this.errorCaptcha = "";
        }

        return true;

    }


    //bloquear login
    BloquearLogin(t) {
        if (t) {
            var inicio = Date.now();
            var fin = new Date(t);
            if (inicio.valueOf() < fin.valueOf()) {
                this.bloqueo = true;
                var tiempo = moment.duration(fin.valueOf() - inicio.valueOf());
                var m = tiempo.minutes();
                var s = tiempo.seconds();
                this.tiempoBloqueo = new Date(1970, 0, 1, 0, m, s);
                this.storage.setItem("TiempoBloqueo", this.tiempoBloqueo.toString());
                setTimeout(() => { this.BloquearLogin(t); }, 500);
            }
            else {
                this.bloqueo = false;
            }
        }
    }

    CaptchaResolve(evento) {
        this.loginModel.captcha = evento;
    }


    agregardatosbecas() {
        window.location.href = '#/Seguridad/registrousuario';
    }

    switchVersion(id) {
        localStorage.setItem("sistema",id);
        this._httpService.putElemento('VersionSistema/' + id,'').subscribe(
            result => {
                if (result.status == 200) {
                    window.location.reload();

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

    remove(){
        let iframe=document.getElementById('iframe');
        iframe.parentNode.removeChild(iframe);
        this.modal2.hide();
    }
}
