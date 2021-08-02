import {Component, Input, Output, EventEmitter} from "@angular/core";
import {AppState} from "../../../../../../app.service";

import {DinamicaFamiliar} from "../../../alumno.model";
import {AlumnoDatos} from "../../../alumnoDatos.component";
import {DinamicaFamiliarService} from "./DinamicaFamiliar.service";

declare let Messenger:any;


@Component(
  {
    selector: "dinamcaFamiliar",
    templateUrl: "./DinamicaFamiliar.template.html"
  })

export class DinamicaFamiliarComponent
{
  @Input() dinamicaFamiliar:DinamicaFamiliar; //Objeto que contiene todos los parametros a bindear en los componenetes
  @Output() output = new EventEmitter(); //Objeto que avisa al componenete padre que se ha cerrado la modal

  //datos
  alumno:AlumnoDatos = null;
  dfs:DinamicaFamiliarService;

  constructor(private _httpService: AppState, alumno:AlumnoDatos, dfs:DinamicaFamiliarService)
  {
    this.alumno = alumno;
    this.dfs = dfs;
  }

  ngOnInit()
  {
  }

  SetDinamicaFamiliarGuardar(data)
  {
    var dinamica = new DinamicaFamiliar();

    dinamica.AlumnoDinamicaFamiliarId = data.AlumnoDinamicaFamiliarId;
    dinamica.Ninguna = this.alumno.CambiarValorBoolAInt(data.Ninguna);
    dinamica.Divorcio = this.alumno.CambiarValorBoolAInt(data.Divorcio);
    dinamica.Separacion = this.alumno.CambiarValorBoolAInt(data.Separacion);
    dinamica.Custodia = this.alumno.CambiarValorBoolAInt(data.Custodia);
    dinamica.ParentescoId = data.ParentescoId;
    dinamica.EnfermedadGrave = this.alumno.CambiarValorBoolAInt(data.EnfermedadGrave);
    dinamica.EspecificacionEnfermedadGrave = data.EspecificacionEnfermedadGrave;
    dinamica.Muerte = this.alumno.CambiarValorBoolAInt(data.Muerte);
    dinamica.EspecificacionMuertes = data.EspecificacionMuertes;
    dinamica.CambioResidencia = this.alumno.CambiarValorBoolAInt(data.CambioResidencia);
    dinamica.MedioHermano = this.alumno.CambiarValorBoolAInt(data.MedioHermano);
    dinamica.SegundoMatrimonio = this.alumno.CambiarValorBoolAInt(data.SegundoMatrimonio);
    dinamica.MadrePadreSoltero = this.alumno.CambiarValorBoolAInt(data.MadrePadreSoltero);
    dinamica.Otro = this.alumno.CambiarValorBoolAInt(data.Otro);
    dinamica.EspecificacionOtro = data.EspecificacionOtro;

    return dinamica;
  }

  CambiaValDinamicaFamiliar(val, check)
  {
    if(val && check=="Ninguna")
    {
      this.dinamicaFamiliar.Divorcio = false;
      this.dinamicaFamiliar.Separacion = false;
      this.dinamicaFamiliar.Custodia = false;
      this.dinamicaFamiliar.EnfermedadGrave = false;
      this.dinamicaFamiliar.Muerte = false;
      this.dinamicaFamiliar.CambioResidencia = false;
      this.dinamicaFamiliar.MedioHermano = false;
      this.dinamicaFamiliar.SegundoMatrimonio = false;
      this.dinamicaFamiliar.MadrePadreSoltero = false;
      this.dinamicaFamiliar.Otro = false;
    }
    else if(val && check=="Otro")
    {
      this.dinamicaFamiliar.Ninguna = false;
    }
  }

};


