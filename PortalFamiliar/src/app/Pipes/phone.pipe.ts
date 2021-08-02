import {Pipe, PipeTransform} from '@angular/core';
import {TelefonoService} from "../Servicios/Telefono.Service";

@Pipe(
  {
    name: 'phone'
  })

export class PhonePipe
{
  constructor(public telefonoService: TelefonoService)
  {

  }

  transform(val, args)
  {
    var lada = this.telefonoService.GetLadaTelefono(val);
    var telefono = this.telefonoService.GetTelefonoTelefono(val);

    return lada + " " + telefono;
  }

}
