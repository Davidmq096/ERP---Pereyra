import { Injectable } from '@angular/core';
import {AppState} from "../app.service";



@Injectable()
export class TelefonoService
{
    sistema:number;

    constructor(appService: AppState)
    {
        this.sistema = appService.sistema;
    }

    GetLadaTelefono(tel)
    {
        if(!tel)
        {
            return "";
        }
        else
        {
            return "(" + tel.split("-")[0] + ")";
        }
    }

    GetTelefonoTelefono(tel)
    {
        if(!tel)
        {
            return "";
        }
        else
        {
            var telefono =  tel.split("-")[1];

            if(!telefono)
            {
                return "";
            }

            var sl = telefono.length > 7 ? 4 : 3;
            return telefono.slice(0, sl) + "-" + telefono.slice(sl);
        }
    }

    SetTelefonoFromLadaTelefono(lada, telefono)
    {
        var ladaaux = lada ? lada.replace(/[^0-9]/g, '') : "";
        var telefonoaux = telefono ? telefono.replace(/[^0-9]/g, '') : "";

        return ladaaux + "-" + telefonoaux;
    }
    GetExpresionRegularTelefonoSinLada(){
        return '\\d{10}';
    }
    GetExpresionRegularTelefono(Lada)
    {
        if(Lada)
        {
            if(Lada.length == 5)
            {
                return '\\d{3}.\\d{4}';
            }
            else if(Lada.length == 4)
            {
                return '\\d{4}.\\d{4}';
            }
            else
            {
                if(this.sistema == 1)
                    return  this.sistema == 1 ? '\\d{3}.\\d{4}' : '\\d{4}.\\d{4}';
            }
        }
        else
        {
            return this.sistema == 1 ? '\\d{3}.\\d{4}' : '\\d{4}.\\d{4}';
        }
    }

    ValidarTelefono(lada, telefono)
    {
        var erTelefono = this.GetExpresionRegularTelefono(lada);

        return telefono ? telefono.match(erTelefono) : false;
    }
}
