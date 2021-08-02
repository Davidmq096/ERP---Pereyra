import {Component, ViewChild, Input} from "@angular/core";
import {AppState} from "../../../../../../app.service";

import {DatoMedico, ContactoEmegrencia} from "../../../alumno.model";
import {AlumnoDatos} from "../../../alumnoDatos.component";

import {DatosMedicosService} from "./DatosMedicos.service";
import {TelefonoService} from "../../../../../../Servicios/Telefono.Service";
import createNumberMask from 'text-mask-addons/dist/createNumberMask';

@Component(
  {
    selector: "datosmedicos",
    templateUrl: "./DatosMedicos.template.html",
    providers: [DatosMedicosService]
  })

export class DatosMedicosComponent
{
  @Input() datoMedico:DatoMedico;
  @Input() contactoEmergencia: ContactoEmegrencia[];
  @Input() contactosEliminados: any[];

  //datos
  alumno:AlumnoDatos = null;

  numberMask = createNumberMask({
    prefix: '',
    suffix: '',
    includeThousandsSeparator: false,
    thousandsSeparatorSymbol: ',',
    allowDecimal: true,
    decimalSymbol: '.',
    decimalLimit: 2,
    integerLimit: null,
    requireDecimal: false,
    allowNegative: false,
    allowLeadingZeroes: false
  });


  //funciones de servicios
  datosMedicosService:DatosMedicosService;

  constructor(private _httpService: AppState, alumno:AlumnoDatos,  datosMedicosService:DatosMedicosService, public telefonoService:TelefonoService)
  {
    this.alumno = alumno;
    this.datosMedicosService = datosMedicosService;
  }

  ngOnInit()
  {
  }

  //------------------------------- Datos médicos -------------------------------------
  CambiarAlergia(val, id)
  {
    if(val && id == 1)
    {
      for(var k=0; k<this.alumno.alergia.length; k++)
      {
        if(this.alumno.alergia[k].alergiaid != 1)
        {
          this.alumno.alergia[k].Seleccionado = false;
        }
      }
    }
    if(val && id != 1)
    {
      for(var k=0; k<this.alumno.alergia.length; k++)
      {
        if(this.alumno.alergia[k].alergiaid == 1)
        {
          this.alumno.alergia[k].Seleccionado = false;
          break;
        }
      }
    }
  }

  CambiarAntecedenteMedico(val, id)
  {
    if(val && id == 1)
    {
      for(var k=0; k<this.alumno.antecedenteMedico.length; k++)
      {
        if(this.alumno.antecedenteMedico[k].antecedentefamiliarimportanteid != 1)
        {
          this.alumno.antecedenteMedico[k].Seleccionado = false;
        }
      }
    }
    if(val && id != 1)
    {
      for(var k=0; k<this.alumno.antecedenteMedico.length; k++)
      {
        if(this.alumno.antecedenteMedico[k].antecedentefamiliarimportanteid == 1)
        {
          this.alumno.antecedenteMedico[k].Seleccionado = false;
          break;
        }
      }
    }
  }

    eliminarContacto(contacto: ContactoEmegrencia, index){
        this.contactosEliminados.push(contacto.ContactoEmergenciaId)
        this.contactoEmergencia.splice(index, 1)
    }

    AgregarContacto(){
        let contacto = new ContactoEmegrencia()
        contacto.AlumnoId = this.alumno.alumnoid
        this.contactoEmergencia.push(contacto)
    }
}


