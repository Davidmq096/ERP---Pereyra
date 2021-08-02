import {Component, ViewChild} from "@angular/core";
import {Subject} from 'rxjs/Rx'; //trigger datatable

import {ModalDirective} from 'ng2-bootstrap/modal'; // Modal
import { Hermano } from "../../alumno.model";
import {AppState} from "../../../../../app.service";
import {Router, Event as RouterEvent, NavigationEnd,ActivatedRoute} from '@angular/router';
import createNumberMask from 'text-mask-addons/dist/createNumberMask';

declare let Messenger:any;

@Component(
  {
    selector: "hermano",
    templateUrl: "./hermano.template.html"
  })

export class HermanoComponent
{
  //dato
  router: Router;
  operacion:string;
  nuevoHermano:Hermano = new Hermano();
  hermano:any[] = [];
  sub:any;
  alumnoid:number;

  summittedHermano:boolean = false;

  //tablas
  dtOptionsHermano:any;
  dtTriggerHermano = new Subject();

  //variable para identificar en que sistema se esta trabajando
  sistema:number;  // 1 = lux, 2 = ciencias

  //Mascara para numero entero
  numberMaskNoComma = createNumberMask({
    prefix: '',
    suffix: '',
    includeThousandsSeparator: true,
    thousandsSeparatorSymbol: '',
    allowDecimal: false,
    decimalSymbol: '',
    decimalLimit: 0,
    integerLimit: 3,
    requireDecimal: false,
    allowNegative: false,
    allowLeadingZeroes: false
  });

  //modales
  @ViewChild('modalHermano') modalHermano: ModalDirective;

  constructor(private _httpService: AppState, private route: ActivatedRoute, router: Router)
  {
    this.sub = this.route.params.subscribe(params =>
    {
      this.alumnoid = +params['id'];
      this.sistema = this._httpService.sistema;
    });

    this.router = router;

  }

  ngOnInit()
  {
    this.dtOptionsHermano =
    {
      dom: '',
      language: {url: "./assets/datatable/Spanish.json"},
      columnDefs:
        [
          {"targets": [3], "searchable": false, "orderable": false},
          {"targets": [4], "searchable": false, "orderable": false},
          {"targets": [5], "searchable": false, "orderable": false}
        ]
    };

    this.GetHermano();

  }

  //---------------------------------- hermano ------------------
  GetHermano()
  {
    this._httpService.getElemento('portalfamiliar/Hermano/' + this.alumnoid).subscribe(
      result =>
      {
        if (result.status == 200)
        {
            this.hermano = result.body;
        }
        else
        {
          this.hermano = [];
          //this._httpService.mensajeDanger('No se encontraron los padres o tutotes.');
          Messenger().post({
                    message: 'No se encontraron los padres o tutotes.',
                    type: 'error',
                    showCloseButton: true
                });
        }

        this.dtTriggerHermano.next();
      },
      error =>
      {
        //this._httpService.mensajeDanger('No se encontraron los padres o tutotes.');
        Messenger().post({
                    message: 'No se encontraron los padres o tutotes.',
                    type: 'error',
                    showCloseButton: true
                });
        this.hermano = [];

        this.dtTriggerHermano.next();
      }
    );
  }

  AbrirHermano(operacion, hermano)
  {
    this.operacion = operacion;

    if(this.operacion == "Agregar")
    {
      this.nuevoHermano = new Hermano();
      this.nuevoHermano.AlumnoId = this.alumnoid;
    }
    else if(operacion == "Editar")
    {
      this.nuevoHermano = new Hermano();
      this.nuevoHermano = this.SetHermano(hermano);
    }

    this.modalHermano.show();
  }

  CerrarHermano()
  {
    (<any>document.getElementById('hermanoForm')).reset();

    this.summittedHermano = false;
    this.modalHermano.hide();
  }

  GuardarHermano(curp, edad)
  {
      this.summittedHermano = true;

      if(!this.ValidarHermano(curp, edad))
      {
         //this._httpService.mensajeNotice('Completa correctamente todos los datos');
         Messenger().post({
                    message: 'Completa correctamente todos los datos',
                    type: 'error',
                    showCloseButton: true
                });
          return;
      }
      else
      {
          this.nuevoHermano.Edad = parseInt( this.nuevoHermano.Edad );

          if(this.operacion == "Agregar")
          {
              this.AgregarHermano();
          }
          else if(this.operacion == "Editar")
          {
               this.EditarHermano();
          }
      }
  }

  AgregarHermano()
  {
    this._httpService.postElemento('portalfamiliar/Hermano', this.nuevoHermano).subscribe(
      result =>
      {
        if (result.status == 200)
        {
          (<any>$("#hermanotabla")).dataTable().fnDestroy();

          this.GetHermano();
          this.CerrarHermano();
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

  EditarHermano()
  {
    this._httpService.putElemento('portalfamiliar/Hermano', this.nuevoHermano).subscribe(
      result =>
      {
        if (result.status == 200)
        {
          (<any>$("#hermanotabla")).dataTable().fnDestroy();

          this.GetHermano();
          this.CerrarHermano();
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

  ValidarHermano(curp, edad)
  {
      if(!this.nuevoHermano.Nombre)
      {
          return false;
      }

      if(!this.nuevoHermano.ApellidoPaterno && !this.nuevoHermano.ApellidoMaterno )
      {
          return false;
      }

      if(this.nuevoHermano.CURP && !curp && this.sistema == 1)
      {
          return false;
      }

      if(!edad)
      {
          return false;
      }

      return true;
  }

  SetHermano(data)
  {
      var hermano = new Hermano;

      hermano.HermanoId = data.HermanoId;
      hermano.AlumnoId = data.AlumnoId;
      hermano.Nombre = data.Nombre;
      hermano.ApellidoPaterno = data.ApellidoPaterno;
      hermano.ApellidoMaterno = data.ApellidoMaterno;
      hermano.Edad = data.Edad;

      if(this.sistema == 1)
      {
          hermano.CURP = data.CURP;
      }
      else
      {
          hermano.CURP = null;
      }

      return hermano;
  }

  CambiarCURPMayuscula(curp)
  {
      if(curp)
      {
          this.nuevoHermano.CURP = curp.toUpperCase()
      }
  }

 //-- Borrar --
  BorrarHermano(hermano)
  {
    let msg = Messenger({extraClasses: 'messenger-fixed messenger-on-top'}).post(
    {
      message: "Confirme que desea eliminar a " + hermano.Nombre + " " + hermano.ApellidoPaterno + " " + hermano.ApellidoMaterno + " como hermano del alumno.",
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
          action: () =>
          {
            msg.hide();
            this._httpService.deleteElemento('portalfamiliar/Hermano', hermano.HermanoId).subscribe(
              result =>
              {
                if (result.status == 200)
                {
                  (<any>$("#hermanotabla")).dataTable().fnDestroy();

                  this.GetHermano();
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

}


