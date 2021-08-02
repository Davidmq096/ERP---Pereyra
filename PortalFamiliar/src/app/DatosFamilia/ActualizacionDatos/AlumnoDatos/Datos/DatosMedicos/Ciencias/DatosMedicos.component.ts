import {Component, ViewChild, Input} from "@angular/core";
import {AppState} from "../../../../../../app.service";
import {Helpers} from "app/app.helpers";
import {DatoMedico, ContactoEmegrencia} from "../../../alumno.model";
import {AlumnoDatos} from "../../../alumnoDatos.component";
import {TelefonoService} from "../../../../../../Servicios/Telefono.Service";
import createNumberMask from 'text-mask-addons/dist/createNumberMask';



@Component(
  {
    selector: "datosmedicosCiencias",
    templateUrl: "./DatosMedicos.template.html"
  })

export class DatosMedicosCienciasComponent
{
  @Input() datoMedico:DatoMedico;
  @Input() contactoEmergencia: ContactoEmegrencia[]
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

  constructor(private _httpService: AppState, alumno:AlumnoDatos, public telefonoService: TelefonoService, private _help: Helpers)
  {
    this.alumno = alumno;
  }

  ngOnInit()
  {
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


