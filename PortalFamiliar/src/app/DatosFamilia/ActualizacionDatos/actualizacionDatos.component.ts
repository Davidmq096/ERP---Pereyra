import {Component} from "@angular/core";

import {AppState} from "../../app.service";
import {Subject} from 'rxjs/Rx';
import {Router, Event as RouterEvent, NavigationEnd} from '@angular/router';
import {StorageService} from 'app/Servicios/storage.service';


declare let Messenger:any;

@Component({
  selector: 'actualizacionDatos',
  templateUrl: './actualizacionDatos.template.html'
})

export class ActualizacionDatos
{
  router: Router;
  titulo:string;

  padreotutorid:string;
  alumno:any;
  periodoactualizacion:boolean = false;

  //tablas
  dtOptionsAlumno:any;
  dtTriggerAlumno = new Subject();

  constructor(private _httpService: AppState, router: Router, private storage: StorageService)
  {
    this.titulo= "Actualización de Datos";

    this.padreotutorid = this.storage.getItem('PadresOTutoresId');


    //-------- tablas ---------
    this.dtOptionsAlumno =
    {
      dom: '',
      language: {url: "./assets/datatable/Spanish.json"},
      order: [[ 0, 'asc' ], [ 3, 'asc' ]],
      columnDefs:
        [
          {"targets": [6], "searchable": false, "orderable": false}
        ]
    };

    this.router = router;

  }

  ngOnInit()
  {
    this.GetPeriodoActualizacion();
    this.GetAlumonoPorPadreTutor();
  }

  //----------- Iniciar -------------------
  GetAlumonoPorPadreTutor()
  {
    this._httpService.getElemento('portalfamiliar/AlumnoPorPadreTutor/' + this.padreotutorid).subscribe(
      result =>
      {
        if (result.status == 200)
        {
          this.alumno = result.body;
        }
        else
        {
          this.alumno = [];
          //this._httpService.mensajeDanger('No se pudieron descargar los datos. Intente de nuevo más tarde.');
                Messenger().post({
                    message: 'No se pudieron descargar los datos. Intente de nuevo más tarde.',
                    type: 'error',
                    showCloseButton: true
                });
        }

        this.dtTriggerAlumno.next();
      },
      error =>
      {
        this.alumno = [];
        //this._httpService.mensajeDanger('No se pudieron descargar los datos. Intente de nuevo más tarde.');
                Messenger().post({
                    message: 'No se pudieron descargar los datos. Intente de nuevo más tarde.',
                    type: 'error',
                    showCloseButton: true
                });

        this.dtTriggerAlumno.next();
      }
    );
  }

  GetPeriodoActualizacion()
  {
      this._httpService.getElemento('portalfamiliar/PeriodoActualizacion').subscribe(
          result =>
          {
              if (result.status == 200)
              {
                  this.periodoactualizacion = result.body.periodoactualizacion;
              }
          },
          error =>
          {
              this.periodoactualizacion = false;

              Messenger().post({
                  message: 'No se pudo conectar con el servidor.  Intente más tarde',
                  type: 'error',
                  showCloseButton: true
              });
          }
      );
  }

  //_-------- Actualizar datos -------
  ActualizarDatosAlumnos(alumno)
  {
    this.router.navigate(['/Menu/DatosFamilia/ActualizacionDatos/AlumnoDatos/' + alumno.Actualizar + "/" + alumno.AlumnoId + '/' + alumno.Clave]);
  }

}
