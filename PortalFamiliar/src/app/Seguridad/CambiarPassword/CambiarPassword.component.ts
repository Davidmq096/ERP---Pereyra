import {Component} from "@angular/core";
import {ActivatedRoute, Router} from "@angular/router";
import {AppState} from "../../app.service";
import {Location} from "@angular/common";
import {Md5} from 'ts-md5/dist/md5';
import {StorageService} from 'app/Servicios/storage.service';

import {CambiarPasswordModel} from "./CambiarPassword.model";
import { Session } from "entity/session";

declare let Messenger:any;

@Component(
{
  selector: "cambiarPassword",
  templateUrl: "./CambiarPassword.template.html",
})


export class   CambiarPasswordComponent{
  public nuevoPassword:CambiarPasswordModel = new CambiarPasswordModel();
  public submitted:boolean = false;
  public leyenda:string;
  public patternPassword:string;
  public reiniciar:boolean;          //indica si se tiene que reiniciar la contraseña

  logo:string;

  constructor(private _httpService: AppState, private route: ActivatedRoute, private router:Router, private location: Location, private storage: StorageService){
    Session.instance={storage: this.storage, appstate:_httpService, router:router, idle:null};
    let session=Session.instance;
    if(session && session.isLoggedCheck(true)){
      this.logo=_httpService.logo;
      this.nuevoPassword.UsuarioId = parseInt(this.storage.getItem('UsuarioId'));
      this.GetParametrosUsuario();
    }
  }

  ngOnInit(){
    this.reiniciar = this.storage.getItem('ReiniciarPassword') == "1" ? true : false;
  }

  //Obtener los parametros del usuario
  GetParametrosUsuario()
  {
    this._httpService.getElemento('Parametros/' + this.nuevoPassword.UsuarioId).subscribe(
      result =>
      {
        if (result.status == 200)
        {
          this.leyenda = result.body.leyenda;
          this.patternPassword = result.body.regexr;
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


  //----- Cambiar Contraseña
  CambiarPassword(correoValido, nuevoPasswordValido, confirmarPasswordValido)
  {
    this.submitted = true;

    if(!this.ValidarNuevoPassword(correoValido, nuevoPasswordValido, confirmarPasswordValido))
    {
      Messenger().post({
        message: 'Completa correctamente todos los datos.',
        type: 'error',
        showCloseButton: true
      });
      return;
    }
    else
    {
      this.ActualizarPassword();
    }
  }

  ActualizarPassword()
  {
    this._httpService.putElemento('portalfamiliar/CambiarPassword', this.SetCambiarPassword(this.nuevoPassword)).subscribe(
      result =>
      {
        if (result.status == 200)
        {
          Messenger().post(
          {
            message: 'Tu contraseña se cambio correctamente.',
            type: 'Aviso',
            showCloseButton: true
          });

          if(this.reiniciar)
          {
            this.storage.setItem("ReiniciarPassword", "0");
            this.IniciarSesion({cuenta:this.nuevoPassword.Correo, clave: this.nuevoPassword.NuevoPassword});
          }
          else
          {
            this.router.navigate(["/Menu/Inicio"]);
          }
        }
        else
        {
          Messenger().post(
          {
            message: 'Verifica que tu correo y contraseña sean correctos.',
            type: 'error',
            showCloseButton: true
          });

        }
      },
      error =>
      {
        Messenger().post(
        {
          message: 'No se puedo realizar la operación.',
          type: 'error',
          showCloseButton: true
        });
      }
    );
  }

  SetCambiarPassword(data)
  {
    var password = new CambiarPasswordModel();

    password.Correo = data.Correo;
    password.Password = Md5.hashStr(data.Password);
    password.NuevoPassword = Md5.hashStr(data.NuevoPassword);
    password.ConfirmarPassword = Md5.hashStr(data.ConfirmarPassword);
    password.UsuarioId = data.UsuarioId;

    return password;
  }

  ValidarNuevoPassword(correoValido, nuevoPasswordValido, confirmarPasswordValido)
  {
    if(!correoValido)
    {
      return false;
    }

    if(!this.nuevoPassword.Password)
    {
      return false;
    }

    if(!nuevoPasswordValido)
    {
      return false;
    }

    if(!confirmarPasswordValido)
    {
      return false;
    }


    return true;
  }

  //----- Cancelar cambiar contraseña
  CancelarCambiarPassword(){
    if(this.storage.getItem('UsuarioId')){
      if(!this.reiniciar){
        this.router.navigate(["/Menu/Inicio"]);
      }else{
        Session.instance.logout();
      }
    }else{
      this.router.navigate(['/Seguridad/Login']);
    }
  }

  IniciarSesion(loginModel)
  {
      let datos =
      {
          cuenta: loginModel.cuenta,
          clave: this._httpService.encodePassword({
              cadena: loginModel.clave
          }),
          id: null,
          ip: null
      }

        //Llamada al servicio post para insertar un nuevo elemento
        this._httpService.postElemento('login/padres', datos, true).subscribe
            (
            result => {
                if (result.status == 200)
                {
                    this._httpService.SetDatosUsuario(result);
                    window.location.href = "#/Menu/Inicio";
                }
            },
            error =>
            {
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
