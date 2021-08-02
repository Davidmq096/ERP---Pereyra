import {Pipe, PipeTransform} from '@angular/core';

@Pipe(
  {
    name: 'fechaEsp'
  })

export class FechaEspPipe
{
  transform(date)
  {
    if(date && date != '0000-00-00')
    {
        var year = date.slice(0, 4);
        var mes = date.slice(5, 7);
        var dia = date.slice(8);

        return dia + "/" + mesesS[parseInt(mes) - 1] + "/" + year;
    }
    else
    {
      return "-";
    }
  }

}

var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre","Octubre", "Noviembre", "Diciembre"];
var mesesS = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep","Oct", "Nov", "Dic"];
