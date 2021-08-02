import {Injectable} from '@angular/core';

@Injectable()

export class DatosMedicosService
{
  constructor()
  {
  }


  ValidarAlergia(alergia)
  {
    for(var k=0; k<alergia.length; k++)
    {
      if(alergia[k].Seleccionado == true && alergia[k].alergiaid == 6)
      {
        return true;
      }
    }

    return false;
  }

  ValidarAlergiaRequired(alergia)
  {
    for(var k=0; k<alergia.length; k++)
    {
      if(alergia[k].Seleccionado == true)
      {
        return true;
      }
    }

    return false;
  }

  ValidarAlergiaDescripcion(alergia)
  {
    for(var k=0; k<alergia.length; k++)
    {
      if(alergia[k].Seleccionado == true && alergia[k].alergiaid == 6)
      {
        return true;
      }
    }

    return false;
  }

  ValidarAntecedenteMedico(antecedenteMedico)
  {
    for(var k=0; k<antecedenteMedico.length; k++)
    {
      if(antecedenteMedico[k].Seleccionado == true && antecedenteMedico[k].antecedentefamiliarimportanteid == 5)
      {
        return true;
      }
    }

    return false;
  }

  ValidarAntecedenteMedicoRequired(antecedenteMedico)
  {
    for(var k=0; k<antecedenteMedico.length; k++)
    {
      if(antecedenteMedico[k].Seleccionado == true)
      {
        return true;
      }
    }

    return false;
  }

  ValidarAntecedenteMedicoDescripcion(antecedenteMedico)
  {
    for(var k=0; k<antecedenteMedico.length; k++)
    {
      if(antecedenteMedico[k].Seleccionado == true && antecedenteMedico[k].antecedentefamiliarimportanteid == 5)
      {
        return true;
      }
    }

    return false;
  }

}
