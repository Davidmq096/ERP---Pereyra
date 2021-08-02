import {Injectable} from '@angular/core';
import {Http, Response, Headers, ResponseContentType} from '@angular/http';
import 'rxjs/add/operator/map';
import {StorageService} from 'app/Servicios/storage.service';
import {Config, ConfigModel} from "./config";

declare let CryptoJS: any;
declare var $: any;
declare let Messenger: any;

export type InteralStateType = {
    [key: string]: any
};

@Injectable()
export class AppState {
    public static SISTEMAID = 4;
    _state: InteralStateType = {};

    public url: string;
    public urlSeguridad: string;
    public qa: any;
    public logo: string;
    public favicon: string;
    public logobar: string;
    public sistema: number;
    public avisoPrivacidad: string;

    //Constructor.- Anexamos el par�metro de tipo Http para que inicialice los permisos de llamadas a Urls.
    constructor(private _http: Http, private storage: StorageService) {
        let _config: Config = new Config();
        let config: ConfigModel = _config.getConfig();
        switch (process.env.NODE_ENV) {
            case 'prod':
            case 'production':
                this.url = config.url.produccion.servicios;
                this.urlSeguridad = config.url.produccion.seguridad;
                this.qa = 0;
                break;
            case 'dev':
            case 'development':
            default:
                this.url = config.url.qa.servicios;
                this.urlSeguridad = config.url.qa.seguridad;
                this.qa = 1;
        }
        $('#title-header').html(config.titulo)
        $('#relicon').attr('href', config.favicon)
        $('#dsc').attr('content', config.titulo)
        this.logo = config.logo;
        this.favicon = config.favicon;
        this.logobar = config.logobar;
        this.sistema = config.version;
        this.avisoPrivacidad = config.avisoPrivacidad;

        this.url = "http://localhost:8080/Code/Jesuitas_webServices/web/api/";
        //this.url = "http://134.209.1.0/inceptioQA/Jesuitas_webServices/web/api/";
        //this.url = "http://rest.lugiadark1.com/web/api/";
        this.urlSeguridad = "http://18.222.34.197:8017/api/";
    }


    ///Llamadas a servicios http-----------------------------------------------------------------------------

    //Ejemplo de una petición  GET
    getElemento(metodo) {
        var token = this.storage.getItem("Token");
        let headers = new Headers();
        //headers.append('Content-Type', 'application/json');
        if (token) {
            headers.append('X-AUTH-TOKEN', token);
        }
        let options = {headers: headers};
        //metodo: Identifica el nombre del método a llamar.
        return this._http.get(this.url + metodo, options).map((response: Response) => {
            return {status: response.status, body: response.json()};
        });
    }

    //Ejemplo de una petici�n  POST
    postElemento(metodo, body, seguridad?, version?) {
        var url = seguridad ? this.urlSeguridad : this.url;
        if (version) {
            if (typeof body.datos === 'string') {
                body = seguridad ? body : JSON.parse(body.datos);
            }
            var token = this.storage.getItem("Token");
            let headers = new Headers();
            //headers.append('Content-Type', 'application/json');

            if (token && !seguridad) {
                headers.append('X-AUTH-TOKEN', token);
            }
            let options = {headers: headers};
            return this._http.post(url + metodo, JSON.stringify(body), options).map((response: Response) => {
                let data = response.json()
                if (response.headers.get('X-AUTH-VERSION')) {
                    if (data.status == 'success') {
                        if (data.data) {
                            return {status: response.status, body: data.data};
                        } else {
                            return {status: response.status, body: data.message};
                        }
                    } else {
                        return {status: data.error.code, body: data.error.message}
                    }
                } else {
                    return {status: response.status, body: response.json()};
                }
            });
        } else {
            body = seguridad ? JSON.stringify(body) : $.param(body);
            var token = this.storage.getItem("Token");
            let headers = new Headers();
            headers.append('Content-Type', 'application/x-www-form-urlencoded');

            if (token) {
                headers.append('X-AUTH-TOKEN', token);
            }
            let options = {headers: headers};
            return this._http.post(url + metodo, body, options).map((response: Response) => {
                return {status: response.status, body: response.json()};
            });
        }
    }

    //Ejemplo de una petici�n PUT
    putElemento(metodo, body, seguridad?, version?) {
        if (version) {
            if (typeof body.datos === 'string') {
                body = seguridad ? JSON.stringify(body) : JSON.parse(body.datos);
            } else {
                body = seguridad ? JSON.stringify(body) : body;
            }
            var token = this.storage.getItem("Token");
            let headers = new Headers({
                'Content-Type': 'application/json; charset=utf-8',
                'X-AUTH-TOKEN': token
            });
            let options = {headers: headers};
            return this._http.put(this.url + metodo, body, options).map((response: Response) => {
                let data = response.json()
                if (response.headers.get('X-AUTH-VERSION')) {
                    if (data.status == 'success') {
                        if (data.data) {
                            return {status: response.status, body: data.data};
                        } else {
                            return {status: response.status, body: data.message};
                        }
                    } else {
                        return {status: data.error.code, body: data.error.message}
                    }
                } else {
                    return {status: response.status, body: response.json()};
                }
            });
        } else {
            body = seguridad ? JSON.stringify(body) : $.param(body);
            var token = this.storage.getItem("Token");
            let headers = new Headers({
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-AUTH-TOKEN': token
            });
            let options = {headers: headers};
            return this._http.put(this.url + metodo, body, options).map((response: Response) => {
                return {status: response.status, body: response.json()};
            });
        }
    }

    //Ejemplo de una petici�n DELETE
    deleteElemento(metodo, id) {
        //id: Identificador del elemento a Eliminar.
        //metodo: Identifica el nombre del m�todo a llamar.
        var token = this.storage.getItem("Token");
        let headers = new Headers({
            'X-AUTH-TOKEN': token
        });
        let options = {headers: headers};
        return this._http.delete(this.url + metodo + "/" + id, options).map((response: Response) => {
            return {status: response.status, body: response.json()};
        });
    }

    //Ejemplo de una petici�n GET que devuelve un archivo
    getArchivo(metodo, id) {
        //id(opcional): Identificador del elemento a Descargar.
        //metodo: Identifica el nombre del m�todo a llamar.
        var token = this.storage.getItem("Token");
        let headers = new Headers({
            'X-AUTH-TOKEN': token
        });
        let options = {headers: headers, responseType: ResponseContentType.Blob};
        return this._http.get(this.url + metodo + "/" + id, options).map((response: Response) => {
            let body: Blob = new Blob([response.blob()], {type: response.headers.get("content-type")});
            return {status: response.status, body: body};
        });
    }

    //Ejemplo de una petici�n POST que sube un archivo al servidor
    postArchivo(metodo, body) {
        var token = this.storage.getItem("Token");;
        let headers = new Headers({
            "Accept": 'application/json',
            'X-AUTH-TOKEN': token
        });
        let options = {headers: headers};
        return this._http.post(this.url + metodo, body, options).map((response: Response) => {
            return {status: response.status, body: response.json()};
        });
    }

    //Ejemplo de una petici�n POST que devuelve un archivo
    postDownloadArchivo(metodo, body) {
        //id(opcional): Identificador del elemento a Descargar.
        //metodo: Identifica el nombre del m�todo a llamar.
        var token = this.storage.getItem("Token");;
        let headers = new Headers({
            "Accept": 'application/json',
            'X-AUTH-TOKEN': token
        });
        let options = {headers: headers, responseType: ResponseContentType.Blob};
        return this._http.post(this.url + metodo, body, options).map((response: Response) => {
            let body = new Blob([response.blob()], {type: response.headers.get("content-type")});
            return {status: response.status, body: body};
        });
    }


    /* Funcion para validar campos */
    inputValidateDanger(id: any, text: any) {
        $("#" + id).addClass("inputValidate");
        $("#" + id + "massageError").text(text);
        $("#" + id + "massageError").show();
    };

    /* Funcion para validar campos */
    inputValidateSuccess(id: any) {
        $("#" + id).removeClass("inputValidate");
        $("#" + id + "massageError").hide();
    };


    /* funcion para visualizar los mensajes generales (Exitoso) */
    mensajeSuccess(text: any) {
        // console.debug("entra funcion");
        $("#success-alert").alert();
        $("#text-messageSucess").text(text);
        $("#success-alert").fadeIn();
        setTimeout(() => {
            $("#success-alert").fadeOut();
        }, 7500);
    };
    /* funcion para visualizar los mensajes generales (Error) */
    mensajeDanger(text: any) {
        // console.debug("entra funcion");
        $("#danger-alert").alert();
        $("#text-messageDanger").text(text);
        $("#danger-alert").fadeIn();
        setTimeout(() => {
            $("#danger-alert").fadeOut();
        }, 7500);
    };
    /* funcion para visualizar los mensajes generales (Avisos) */
    mensajeWarning(text: any) {
        // console.debug("entra funcion");
        $("#warning-alert").alert();
        $("#text-messageWarning").text(text);
        $("#warning-alert").fadeIn();
        setTimeout(() => {
            $("#warning-alert").fadeOut();
        }, 7500);
    };    
    //------ Login ------
    SetDatosUsuario(result) {
        let nombre = result.body.nombre + " " + result.body.apellidopaterno + " " + result.body.apellidomaterno;
        //                        let foto = result.body.padre.Fotografia ? result.body.padre.Fotografia : null;
        //                        if (result.body.padre.Fotografia) {
        ////                            this.storage.setItem("Foto", foto);
        //

        this.storage.setItem("Sesion", "true");
        this.storage.setItem("ReiniciarPassword", result.body.reiniciarcontrasena);
        this.storage.setItem("UsuarioId", result.body.usuarioid);
        this.storage.setItem("PadresOTutoresId", result.body.padreotutorid);
        this.storage.setItem("Nombre", nombre);
        this.storage.setItem("TiempoInactividad", result.body.tiempoinactividad);
        this.storage.setItem("Token", result.body.token);
        this.storage.setItem("IntentoLogin", "0");
        
    }

    encodePassword(pass) {
        var header = {
            "alg": "HS256",
            "typ": "JWT"
        };

        function base64url(source) {
            // Encode in classical base64
            let encodedSource = CryptoJS.enc.Base64.stringify(source);

            // Remove padding equal characters
            encodedSource = encodedSource.replace(/=+$/, '');

            // Replace characters according to base64url specifications
            encodedSource = encodedSource.replace(/\+/g, '-');
            encodedSource = encodedSource.replace(/\//g, '_');

            return encodedSource;
        }

        var stringifiedHeader = CryptoJS.enc.Utf8.parse(JSON.stringify(header));
        var encodedHeader = base64url(stringifiedHeader);

        var stringifiedData = CryptoJS.enc.Utf8.parse(JSON.stringify(pass));
        var encodedData = base64url(stringifiedData);

        var token = encodedHeader + "." + encodedData;

        var secret = "GQDstcKsx0NHjPOuXOYg5MbeJ1XT0uFiwDVvVBrk123456789";

        var signature = CryptoJS.HmacSHA256(token, secret);
        signature = base64url(signature);

        var signedToken = token + "." + signature;

        return signedToken
    }
}
