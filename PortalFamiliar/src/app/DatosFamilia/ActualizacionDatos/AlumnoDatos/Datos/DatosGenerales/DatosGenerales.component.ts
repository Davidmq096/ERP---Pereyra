import {Component, Input} from "@angular/core";
import {AppState} from "../../../../../app.service";


import {AlumnoModel} from "../../alumno.model";
import {AlumnoDatos} from "../../alumnoDatos.component";
import {TelefonoService} from "../../../../../Servicios/Telefono.Service";


declare let Messenger:any;
declare let alasql: any;

@Component(
  {
    selector: "datosGenerales",
    templateUrl: "./DatosGenerales.template.html"
  })

export class DatosGeneralesComponent
{
  //datos
  @Input()alumno:AlumnoModel;

  alumnoComponent:AlumnoDatos = null;
  public telefonoService;

  constructor(private _httpService: AppState, alumnoComponent:AlumnoDatos, telefonoService: TelefonoService)
  {
    this.alumnoComponent = alumnoComponent;
    this.telefonoService = telefonoService;
  }

  ngOnInit()
  {
  }



}
