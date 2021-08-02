import {Component} from "@angular/core";
import {AppState} from "../app.service";

@Component(
  {
    selector: "avisoPrivacidad",
    templateUrl: "./AvisoPrivacidad.template.html"
  })

export class AvisoPrivacidadComponent
{
  public avisoPrivacidad:string;

  constructor(private app:AppState)
  {
      this.avisoPrivacidad = app.avisoPrivacidad;
  }

  ngOnInit()
  {
  }

}


