import {Component, Input} from "@angular/core";
import {AppState} from "../../../../../app.service";

import {AlumnoModel} from "../../alumno.model";
import {AlumnoDatos} from "../../alumnoDatos.component";

declare let alasql: any;
declare let Messenger:any;

@Component(
  {
    selector: "domicilioAlumno",
    templateUrl: "./DomicilioAlumno.template.html"
  })

export class DomicilioAlumnoComponent
{
  //datos
  @Input() alumno: AlumnoModel;
  @Input() cpnoconocido: boolean;
  alumnoComponent: AlumnoDatos = null;


  constructor(private _httpService: AppState, alumnoComponent: AlumnoDatos) {
    this.alumnoComponent = alumnoComponent;
  }

  ngOnInit() {
  }

}
