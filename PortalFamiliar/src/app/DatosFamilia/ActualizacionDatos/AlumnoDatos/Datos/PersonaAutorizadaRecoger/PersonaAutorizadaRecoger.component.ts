import {Component, ViewChild, Input, Output, EventEmitter} from "@angular/core";
import {AppState} from "../../../../../app.service";
import {Subject} from 'rxjs/Rx';
import {ModalDirective} from 'ng2-bootstrap/modal';

import {PersonaAutorizadaRecogerModel} from "../../padreTutorModel.model";
import {AlumnoDatos} from "../../alumnoDatos.component";

declare let Messenger:any;

@Component(
  {
    selector: "personasRecoger",
    templateUrl: "./PersonaAutorizadaRecoger.template.html"
  })

export class PersonasAutorizadasRecogerComponent
{
  //datos
  @Input() recoger:any;
  operacion:string;

  alumno:AlumnoDatos = null;
  nuevoRecoger:PersonaAutorizadaRecogerModel = new PersonaAutorizadaRecogerModel();

  summitted:boolean;

  //Output
  @Output() EnviarRecoger = new EventEmitter();


  //tablas
  dtOptionsPersonaAutorizada:any;
  dtTriggerPersonaAutorizada = new Subject();


  //modales
  @ViewChild('modalRecoge') modalRecoge: ModalDirective;

  constructor(private _httpService: AppState, alumno:AlumnoDatos)
  {
    this.alumno = alumno;
  }

  ngOnInit()
  {
    this.dtOptionsPersonaAutorizada =
      {
        dom: '',
        language: {url: "./assets/datatable/Spanish.json"},
        columnDefs:
          [
            {"targets": [0], "searchable": false, "orderable": true},
            {"targets": [1], "searchable": false, "orderable": false},
            {"targets": [2], "searchable": false, "orderable": false}
          ]
      };

    //datos
    this.GetPersonaAutorizadasRecoger();

  }


  //--------------------------------------- Personas autorizada para recoger ----------------------
  GetPersonaAutorizadasRecoger()
  {
    this._httpService.getElemento('portalfamiliar/PersonasAutorizadasRecogerAlumno/' + this.alumno.alumnoid).subscribe(
      result =>
      {
        if (result.status == 200)
        {
          this.recoger = result.body;
        }
        else
        {
          this.recoger = [];
          //this._httpService.mensajeDanger('No se encontraron las personas autorizada para recoger al alumno.');
          Messenger().post({
            message: 'No se encontraron las personas autorizada para recoger al alumno.',
            type: 'error',
            showCloseButton: true
          });
        }

        this.dtTriggerPersonaAutorizada.next();

        this.Enviar();
      },
      error =>
      {
        //this._httpService.mensajeDanger('No se encontraron las personas autorizada para recoger al alumno.');
        Messenger().post({
          message: 'No se encontraron las personas autorizada para recoger al alumno.',
          type: 'error',
          showCloseButton: true
        });
        this.recoger = [];

        this.dtTriggerPersonaAutorizada.next();
      }
    );
  }

  AbrirAutorizadoRecoger(operacion, recoger)
  {
    this.operacion = operacion;

    if(this.operacion == "Agregar")
    {
      this.nuevoRecoger = new PersonaAutorizadaRecogerModel();
      this.nuevoRecoger.AlumnoId = this.alumno.alumnoid;
    }
    else
    {
      this.nuevoRecoger = new PersonaAutorizadaRecogerModel();
      this.nuevoRecoger = this.SetPersonaAutorizadaRecoger(recoger);
    }

    this.modalRecoge.show();
  }

  CerrarPersonaRecoge(nombre, parentesco)
  {
    nombre.reset();
    parentesco.reset();

    this.summitted = false;
    this.modalRecoge.hide();
  }

  SetPersonaAutorizadaRecoger(data)
  {
    let recoger = new PersonaAutorizadaRecogerModel();

    recoger.PersonaAutorizadaRecogerPorAlumnoId = data.PersonaAutorizadaRecogerPorAlumnoId;
    recoger.Nombre = data.Nombre;
    recoger.Descripcion = data.Descripcion;
    recoger.ParentescoId = parseInt(data.ParentescoId);
    recoger.PersonaAutorizadaRecogerId = parseInt(data.PersonaAutorizadaRecogerId);

    return recoger;
  }

  //-- Guardar --
  GuardarPersonaAutorizadaRecoger()
  {
    this.summitted = true;

    if(!this.ValidarDatosPersonaAutorizadaRecoger())
    {
      //this._httpService.mensajeNotice('Completa correctamente todos los datos');
      Messenger().post({
        message: 'Completa correctamente todos los datos.',
        type: 'error',
        showCloseButton: true
      });
      return;
    }
    else
    {
      if(this.operacion == "Agregar")
      {
        this.AgregarPersonaAutorizadaRecoger();
      }
      else if(this.operacion == "Editar")
      {
        this.EditarPersonaAutorizadaRecoger();
      }
    }
  }

  AgregarPersonaAutorizadaRecoger()
  {
    this._httpService.postElemento('portalfamiliar/PersonaAutorizadaRecoger', this.nuevoRecoger).subscribe(
      result =>
      {
        if (result.status == 200)
        {
          (<any>$("#personaAutorizada")).dataTable().fnDestroy();

          this.GetPersonaAutorizadasRecoger();
          document.getElementById('btnCerrarPAR').click();
        }
        else
        {
          //this._httpService.mensajeDanger('No se puedo realizar la operación.');
          Messenger().post({
            message: 'No se puedo realizar la operación.',
            type: 'error',
            showCloseButton: true
          });
        }
      },
      error =>
      {
        //this._httpService.mensajeDanger('No se puedo realizar la operación.');
        Messenger().post({
          message: 'No se puedo realizar la operación.',
          type: 'error',
          showCloseButton: true
        });
      }
    );
  }

  EditarPersonaAutorizadaRecoger()
  {
    this._httpService.putElemento('portalfamiliar/PersonaAutorizadaRecoger', this.nuevoRecoger).subscribe(
      result =>
      {
        if (result.status == 200)
        {
          (<any>$("#personaAutorizada")).dataTable().fnDestroy();

          this.GetPersonaAutorizadasRecoger();

          document.getElementById('btnCerrarPAR').click();
        }
        else
        {
          //this._httpService.mensajeDanger('No se puedo realizar la operación.');
          Messenger().post({
            message: 'No se puedo realizar la operación.',
            type: 'error',
            showCloseButton: true
          });
        }


      },
      error =>
      {
        //this._httpService.mensajeDanger('No se puedo realizar la operación.');
        Messenger().post({
          message: 'No se puedo realizar la operación.',
          type: 'error',
          showCloseButton: true
        });
      }
    );
  }

  ValidarDatosPersonaAutorizadaRecoger()
  {
    if(!this.nuevoRecoger.Nombre)
    {
      return false;
    }

    if(!this.nuevoRecoger.ParentescoId)
    {
      return false;
    }

    return true;
  }

  //-- Borrar --
  BorrarAutorizadoRecoger(autorizado)
  {
    let msg = Messenger({extraClasses: 'messenger-fixed messenger-on-top'}).post(
    {
      message: "Confirme que desea eliminar a " + autorizado.Nombre + " como persona autorizada para recoger al alumno.",
      hideAfter: false,
      actions:
      {
        cancel:
        {
          label: "Cancelar",
          action: () =>
          {
            msg.hide();
          }
        },
        confirm:
        {
          label: "Eliminar",
          extraClasses: "btnMessage",
          action: () =>
          {
            msg.hide();
            this._httpService.deleteElemento('portalfamiliar/PersonaAutorizadaRecoger', autorizado.PersonaAutorizadaRecogerPorAlumnoId).subscribe(
              result =>
              {
                if (result.status == 200)
                {
                  (<any>$("#personaAutorizada")).dataTable().fnDestroy();

                  for(var k=0; k<this.recoger.length; k++)
                  {
                    if(this.recoger[k].PersonaAutorizadaRecogerPorAlumnoId == autorizado.PersonaAutorizadaRecogerPorAlumnoId)
                    {
                      this.recoger.splice(k,1);
                      break;
                    }
                  }

                  this.Enviar();
                  this.dtTriggerPersonaAutorizada.next();
                }
                else
                {
                  Messenger().post({
                    message: result.body,
                    type: 'success',
                    showCloseButton: true
                  });
                }
              },
              error =>
              {
                var errorMessage = <any> error;
                Messenger().post(
                  {
                    message: 'No se pudo realizar la operación',
                    type: 'error',
                    showCloseButton: true
                  });
              }
            );
          }
        }
      }
    })
  }

  Enviar()
  {
    this.EnviarRecoger.emit(this.recoger);
  }
}


