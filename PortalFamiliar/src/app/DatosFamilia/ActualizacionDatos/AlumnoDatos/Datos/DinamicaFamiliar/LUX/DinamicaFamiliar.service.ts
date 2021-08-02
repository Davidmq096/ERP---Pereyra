import {Injectable} from '@angular/core';

@Injectable()

export class DinamicaFamiliarService
{
  constructor()
  {
  }

  ValidarDinamicaFamiliar(dinamicaFamiliar)
  {
    if(dinamicaFamiliar.Ninguna || dinamicaFamiliar.Divorcio || dinamicaFamiliar.Separacion || dinamicaFamiliar.Custodia)
    {
      return true;
    }
    if(dinamicaFamiliar.EnfermedadGrave || dinamicaFamiliar.Muerte || dinamicaFamiliar.CambioResidencia || dinamicaFamiliar.MedioHermano)
    {
      return true;
    }
    if(dinamicaFamiliar.SegundoMatrimonio || dinamicaFamiliar.MadrePadreSoltero || dinamicaFamiliar.Otro)
    {
      return true;
    }

    return false;
  }

}
