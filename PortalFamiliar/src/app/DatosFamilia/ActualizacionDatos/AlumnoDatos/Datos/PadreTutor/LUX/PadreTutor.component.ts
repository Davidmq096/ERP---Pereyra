import {Component, ViewChild} from "@angular/core";
import {AppState} from "../../../../../../app.service";
import {Subject} from 'rxjs/Rx';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {IMyDateModel, IMyDpOptions} from 'mydatepicker';
import {Helpers} from "app/app.helpers";
import {PadreTutorModel} from "../../../padreTutorModel.model";
import {AlumnoDatos} from "../../../alumnoDatos.component";
import {TelefonoService} from "../../../../../../Servicios/Telefono.Service";


declare let Messenger:any;

@Component(
  {
    selector: "padretutor",
    templateUrl: "./PadreTutor.template.html"
  })

export class PadreTutorComponent
{
  //datos
  operacion: string;
  nuevoTutor: PadreTutorModel = new PadreTutorModel();
  padretutor: any;
  alumno: AlumnoDatos = null;

  summittedTutor: boolean;
  opcionaesFehaNacimiento: IMyDpOptions;

  //tablas
  dtOptionsTutor: any;
  dtTriggerTutor = new Subject();


  //modales
  @ViewChild('modalTutor') modalTutor: ModalDirective;

  constructor(private _httpService: AppState, alumno: AlumnoDatos, public telefonoService: TelefonoService, private _help: Helpers)
  {
    this.alumno = alumno;

    let hoy = new Date();

    this.opcionaesFehaNacimiento =
    {
      dateFormat: 'dd/mm/yyyy',
      disableSince: {year: hoy.getFullYear(), month: hoy.getMonth(), day: hoy.getDate()},
      showTodayBtn: false
    };
  }

  ngOnInit() {
    this.dtOptionsTutor =
      {
        dom: '',
        language: {url: "./assets/datatable/Spanish.json"},
        columnDefs:
          [
            {"targets": [3], "searchable": false, "orderable": false},
            {"targets": [4], "searchable": false, "orderable": false},
            {"targets": [5], "searchable": false, "orderable": false},
            {"targets": [6], "searchable": false, "orderable": false}
          ]
      };

    //datos
    this.GetPadresTutores();
  }


  //-------------------------------------- Padres y/ tutor -----------------------------------------------

  //-- Obtener los datos del padre y/o tutor del alumno
  GetPadresTutores() {
    this._httpService.getElemento('Controlescolar/Alumno/Familia/?alumnoid=' + this.alumno.alumnoid).subscribe(
      result => {
        if (result.status == 200) {
          this.padretutor = result.body.padresotutores;
        }
        else {
          this.padretutor = [];
          //this._httpService.mensajeDanger('No se encontraron los padres o tutotes.');
          Messenger().post({
            message: 'No se encontraron los padres o tutotes.',
            type: 'error',
            showCloseButton: true
          });
        }

        this.dtTriggerTutor.next();
      },
      error => {
        //this._httpService.mensajeDanger('No se encontraron los padres o tutotes.');
        Messenger().post({
          message: 'No se encontraron los padres o tutotes.',
          type: 'error',
          showCloseButton: true
        })
        this.padretutor = [];

        this.dtTriggerTutor.next();
      }
    );
  }


  //--Abir
  AbrirPadreTutor(operacion, data) {
    this.operacion = operacion;
    this.summittedTutor = false;

    if (operacion == "Agregar") {
      this.nuevoTutor = new PadreTutorModel();
    }
    else if (operacion == "Editar") {
      this.nuevoTutor = this.SetPadreTutor(data);

      if (data.FechaNacimiento)
      {
        this.nuevoTutor.FechaNacimiento = this.SetDateCalendar(data.FechaNacimiento);
      }
    }

    this.modalTutor.show();
  }

  SetPadreTutor(data)
  {
    var tutor = new PadreTutorModel();
    let fechanacimiento = data.fechanacimiento? data.fechanacimiento.split("T"): null;
    tutor.PadresOTutoresId = data.padresotutoresid;
    tutor.Nombre = data.nombre;
    tutor.ApellidoPaterno = data.apellidopaterno;
    tutor.ApellidoMaterno = data.apellidomaterno;
    tutor.Correo = data.correo;
    tutor.TutorId = data.tutorid;
    tutor.AlumnoInstituto = data.alumnoinstituto? "1" : "0";
    tutor.EspecificarAlumno = data.especificaralumno;
    tutor.Antiguedad = data.antiguedad;

    tutor.Lada = this._help.ParseTelefono(data.telefono)[0];
    tutor.Telefono = this._help.ParseTelefono(data.telefono)[1];

    tutor.FechaNacimiento = fechanacimiento ? {date: this._help.FechaToStringObjeto(fechanacimiento[0])} : null;
    tutor.Tutor = data.tutor == "1" ? true : false;
    tutor.Vive = data.vive == "1" ? true : false;

    tutor.Nacionalidad = data.nacionalidad? data.nacionalidad.map((x)=>{
      return x.nacionalidadid;
    }) : null;
    tutor.SituacionConyugalId = data.situacionconyugalid;
    tutor.NivelEstudioId = data.nivelestudioid;

    tutor.EspecificacionOcupacion = data.especificacionocupacion;
    tutor.Ramo = data.ramo;
    tutor.Empresa = data.empresa;
    tutor.ExtensionEmpresa = data.extensionempresa;
    tutor.HorarioTrabajo = data.horariotrabajo;
    tutor.LadaEmpresa = this._help.ParseTelefono(data.telempresa)[0];
    tutor.TelefonoEmpresa = this._help.ParseTelefono(data.telempresa)[1];
    tutor.Ocupacion = data.ocupacion;

    tutor.ExLux = data.exlux? "1" : "0";
    tutor.GeneracionId = data.generacionid? data.generacionid+"" : null;

    return tutor;
  }


  SetDateCalendar(date)
  {
    var year = parseInt(date.slice(6));
    var mes = parseInt(date.slice(3, 5)) - 1;
    var dia = parseInt(date.slice(0, 2));

    return {date: {year: year, month: mes + 1, day: dia}, jsdate: new Date(year, mes, dia)};
  }

  CambiarFecha(val) {
    if (val) {
      var mes = val.date.month;
      var dia = val.date.day;

      if (mes < 10) {
        mes = "0" + mes;
      }

      if (dia < 10) {
        dia = "0" + dia;
      }

      return dia + "-" + mes + "-" + val.date.year;
    }
    return "";
  }


  //--Guardar
  GuardarPadreTutor(correoTutor, telefonoTutor, ladaTutor, fechaNacimiento, ladaEmpresa, telefonoEmpresa) {
    this.summittedTutor = true;

    if (!this.ValidarDatosPadreOTutor(correoTutor, telefonoTutor, ladaTutor, fechaNacimiento, ladaEmpresa, telefonoEmpresa))
    {
      //this._httpService.mensajeNotice('Completa correctamente todos los datos');
      Messenger().post({
        message: 'Completa correctamente todos los datos.',
        type: 'error',
        showCloseButton: true
      });
      return;
    }
    else      //Guardar datos del padre o tutor
    {
      if (this.operacion == "Editar") {
        this.EditarPadreoTutor();
      }
    }
  }

  EditarPadreoTutor()
  {
    this._httpService.putElemento("portalfamiliar/LUX/PadresOTutoresAlumno", this.SetPadreTutorGuardar(this.nuevoTutor)).subscribe(
      result => {
        if (result.status == 200) {
          (<any>$("#padreTutor")).dataTable().fnDestroy();
          this.GetPadresTutores();
          this.CerrarPadreTutor();
        }
        else {
          //this._httpService.mensajeDanger('No se puedo realizar la operación.');
          Messenger().post({
            message: 'No se puedo realizar la operación.',
            type: 'error',
            showCloseButton: true
          });

        }


      },
      error => {
        //this._httpService.mensajeDanger('No se puedo realizar la operación.');
        Messenger().post({
          message: 'No se puedo realizar la operación.',
          type: 'error',
          showCloseButton: true
        });

      }
    );
  }

  SetPadreTutorGuardar(data) {
    var tutor = new PadreTutorModel();

    tutor.PadresOTutoresId = data.PadresOTutoresId;
    tutor.Nombre = data.Nombre;
    tutor.ApellidoPaterno = data.ApellidoPaterno;
    tutor.ApellidoMaterno = data.ApellidoMaterno;
    tutor.Correo = data.Correo;
    tutor.TutorId = data.TutorId;
    tutor.AlumnoInstituto = parseInt(data.AlumnoInstituto);
    tutor.EspecificarAlumno = data.EspecificarAlumno;
    tutor.Antiguedad = data.Antiguedad;

    tutor.Nacionalidad = data.Nacionalidad;
    tutor.SituacionConyugalId = data.SituacionConyugalId;
    tutor.NivelEstudioId = data.NivelEstudioId;

    tutor.Ocupacion = data.Ocupacion;
    tutor.EspecificacionOcupacion = data.EspecificacionOcupacion;
    tutor.Ramo = data.Ramo;
    tutor.Empresa = data.Empresa;
    tutor.ExtensionEmpresa = data.ExtensionEmpresa;
    tutor.HorarioTrabajo = data.HorarioTrabajo;

    tutor.ExLux = parseInt(data.ExLux);

    tutor.Vive = this.alumno.CambiarValorBoolAInt(data.Vive);
    tutor.GeneracionId = parseInt(data.GeneracionId);
    tutor.FechaNacimiento = this.CambiarFecha(data.FechaNacimiento);

    if (data.Lada && data.Telefono)
    {
      tutor.Telefono = this.telefonoService.SetTelefonoFromLadaTelefono(data.Lada, data.Telefono);

      if (tutor.Ocupacion == "Económicamente activo")
      {
        if(data.LadaEmpresa && data.TelefonoEmpresa)
        {
          tutor.TelefonoEmpresa = this.telefonoService.SetTelefonoFromLadaTelefono(data.LadaEmpresa, data.TelefonoEmpresa);
        }
      }
    }

    return tutor;
  };

  ValidarDatosPadreOTutor(correoTutor, telefonoTutor, ladaTutor, fechaNacimiento, ladaEmpresa, telefonoEmpresa) {
    if (!this.nuevoTutor.Nombre)
    {
      return false;
    }

    if (!this.nuevoTutor.ApellidoPaterno && !this.nuevoTutor.ApellidoMaterno)
    {
      return false;
    }


    if (!this.nuevoTutor.TutorId) {
      return false;
    }

    if (!this.nuevoTutor.AlumnoInstituto) {
      return false;
    }

    if (this.nuevoTutor.AlumnoInstituto == "1" && !this.nuevoTutor.EspecificarAlumno) {
      return false;
    }

    if (!fechaNacimiento) {
      return false;
    }

    if (this.nuevoTutor.Nacionalidad.length == 0)
    {
      return false;
    }

    if (!this.nuevoTutor.SituacionConyugalId && this.nuevoTutor.Vive)
    {
      return false;
    }

    if (!this.nuevoTutor.NivelEstudioId && this.nuevoTutor.Vive)
    {
      return false;
    }

    if (!this.nuevoTutor.Ocupacion && this.nuevoTutor.Vive) {
      return false;
    }

    if (this.nuevoTutor.Ocupacion == "Económicamente activo" && this.nuevoTutor.Vive)
    {
      if (!this.nuevoTutor.EspecificacionOcupacion) {
        return false;
      }

      if (!this.nuevoTutor.Ramo) {
        return false;
      }

      if (!this.nuevoTutor.Empresa) {
        return false;
      }

      if (!this.nuevoTutor.HorarioTrabajo)
      {
        return false;
      }

      if (!this.nuevoTutor.Antiguedad)
      {
          return false;
      }

      if (!ladaEmpresa || !telefonoEmpresa)
      {
          return false;
      }

      if(!ladaTutor  || !telefonoTutor)
      {
          return false;
      }

      if (!correoTutor)
      {
          return false;
      }
    }
    else
    {
        if (this.nuevoTutor.Ocupacion == "Económicamente activo" && (this.nuevoTutor.LadaEmpresa || this.nuevoTutor.TelefonoEmpresa || this.nuevoTutor.ExtensionEmpresa) && (!ladaEmpresa || !telefonoEmpresa))
        {
            return false;
        }

        if ((this.nuevoTutor.Telefono || this.nuevoTutor.Lada) &&   (!ladaTutor || !telefonoTutor))
        {
            return false;
        }

        if(!correoTutor && this.nuevoTutor.Correo)
        {
            return false;
        }
    }

    if (!this.nuevoTutor.ExLux) {
      return false;
    }

    if (this.nuevoTutor.ExLux == "1" && !this.nuevoTutor.GeneracionId) {
      return false;
    }


    return true;
  }


  //--Cerrar
  CerrarPadreTutor() {
    (<any>document.getElementById('formaPT')).reset();

    this.nuevoTutor = new PadreTutorModel();

    this.summittedTutor = false;
    this.modalTutor.hide();
  }

};
