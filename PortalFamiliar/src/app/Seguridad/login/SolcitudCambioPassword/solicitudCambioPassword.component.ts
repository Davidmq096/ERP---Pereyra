import {Component, Input, ViewChild} from '@angular/core';

import {ModalDirective} from 'ng2-bootstrap/modal';
import {AppState} from "../../../app.service";

declare let Messenger:any;

@Component({
    selector: 'solicitudCambioPassword',
    templateUrl: './solicitudCambioPassword.template.html',
})
export class SolicitudCambioPasswordComponent
{
  @Input() logo:string;

  submmitted:boolean = false;
  correo:string = "";

  //modal
  @ViewChild('modalSolicitudPassword') modalSolicitudPassword: ModalDirective;

  constructor(private _httpService: AppState)
  {

  }

  ngOnInit(): void
  {

  }

  //Recuperar password
  EnviarSolicitud(correovalido)
  {
    this.submmitted = true;
    if(!this.ValidarCorreo(correovalido))
    {
      Messenger().post(
      {
        message: 'Completa correctamente todos los datos.',
        type: 'error',
        showCloseButton: true
      });
      return;
    }
    else
    {
      this.RecuperarPassoword();
    }
  }

  RecuperarPassoword()
  {
    let datos = {correo: this.correo, ip: this._httpService.sistema};
    this._httpService.postElemento('recuperarcontrasena', datos, true).subscribe(
      result =>
      {
        if (result.status == 200)
        {
          Messenger().post({
            message: result.body,
            type: 'success',
            showCloseButton: true
          });

          this.CerrarModal();
        }
        else
        {
          Messenger().post({
            message: result.body,
            type: 'error',
            showCloseButton: true
          });
        }
      },
      error =>
      {
        Messenger().post({
          message: 'No se pudo comunicar con el servidor',
          type: 'error',
          showCloseButton: true
        });
      }
    );
  }

  ValidarCorreo(correovalido)
  {
    if(!correovalido)
    {
      return false;
    }

    return true;
  }

  //---- Cerrar el modal
  CerrarModal()
  {
    this.modalSolicitudPassword.hide();

    this.submmitted = false;
    (<any>document.getElementById('fSolicitudPassword')).reset();
    this.correo = "";
  }
}
