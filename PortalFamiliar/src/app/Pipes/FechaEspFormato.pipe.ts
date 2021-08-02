import {Pipe, PipeTransform} from '@angular/core';

@Pipe(
{
    name: 'fechaEspFormato'
})

export class FechaEspFormatoPipe
{
    transform(date)
    {
        if(date)
        {
            var year = date.slice(6);
            var mes = date.slice(3,5);
            var dia = date.slice(0,2);

            return dia + "/" + mesesS[parseInt(mes)-1] + "/" + year;
        }
        else
        {
            return "";
        }

    }

}

var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre","Octubre", "Noviembre", "Diciembre"];
var mesesS = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep","Oct", "Nov", "Dic"];
