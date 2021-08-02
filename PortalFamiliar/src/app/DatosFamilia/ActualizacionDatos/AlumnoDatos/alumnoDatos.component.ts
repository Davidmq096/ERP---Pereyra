import {Component, ViewChild} from "@angular/core";
import {AppState} from "../../../app.service";

import {AlumnoModel, DinamicaFamiliar, DatoMedico, ContactoEmegrencia} from "./alumno.model";
import {PersonaAutorizadaRecogerModel} from "./padreTutorModel.model";

import {document} from "ng2-bootstrap/utils/facade/browser";
import {Router, Event as RouterEvent, NavigationEnd,ActivatedRoute} from '@angular/router';
import {Helpers} from "app/app.helpers";
import {DatosMedicosService} from "./Datos/DatosMedicos/LUX/DatosMedicos.service";
import {DinamicaFamiliarService} from "./Datos/DinamicaFamiliar/LUX/DinamicaFamiliar.service";

declare let Messenger:any;
declare let alasql: any;
import createNumberMask from 'text-mask-addons/dist/createNumberMask';
import {TelefonoService} from "../../../Servicios/Telefono.Service";

@Component(
  {
    selector: "alumnoDatos",
    templateUrl: "./alumnoDatos.template.html",
    providers: [DatosMedicosService, DinamicaFamiliarService]
  })

export class AlumnoDatos
{
  //datos
  router: Router;

  alumno:AlumnoModel = new AlumnoModel();
  datoMedico:DatoMedico = new DatoMedico();
  contactoEmergencia: ContactoEmegrencia[] = []
  contactosEliminados: any[] = []
  dinamicaFamiliar:DinamicaFamiliar = new DinamicaFamiliar();
  recoger:any = [];

  summittedGeneral:boolean;
  actualizarDatos:any = {docilio: false, padrestutor: true, recoger: false};
  cpnoconocido:boolean = false;

  sistema:number;
  sistemaNombre:string;

  //catálogos
  tutor:any[] = [];
  parentesco:any[] = [];
  vivecon:any[] = [];

  nacionalidad:any[] = [];
  pais:any[] = [];
  estadoNacimiento:any[] = [];
  ciudadNacimiento:any[] = [];

  estado:any[] = [];
  ciudad:any[] = [];
  colonia:any[] = [];

  generacion:any[] = [];
  situacionConyugal:any[] = [];
  escolaridad:any[] = [];

  tipoSanguineo:any[] = [];
  alergia:any[] = [];
  antecedenteMedico:any[] = [];

  respuestaSiNo:any[] = [{nombre:"Si", valor:"1"}, {nombre:"No", valor:"0"}];

  //URL
  alumnoid:number;
  clavefamiliar:string;
  actualizar:number;
  sub:any;

  //Mascara
  public lada = ['(', /[1-9]/, /\d/, /\d/, ')'];
  public telefono = [ /\d/, /\d/,/\d/, '-', /\d/,/\d/,/\d/,/\d/];
  public maskCP = [ /\d/,/\d/,/\d/,/\d/, /\d/];
  public numberMaskNoComma = createNumberMask({
        prefix: '',
        suffix: '',
        includeThousandsSeparator: true,
        thousandsSeparatorSymbol: '',
        allowDecimal: false,
        decimalSymbol: '',
        decimalLimit: 0,
        integerLimit: null,
        requireDecimal: false,
        allowNegative: false,
        allowLeadingZeroes: false
    });

  constructor(private _httpService: AppState, private route: ActivatedRoute, router: Router, private datoMedicoService:DatosMedicosService, private dinamicaFamiliarService:DinamicaFamiliarService, public telefonoService:TelefonoService, private _help: Helpers)
  {
    this.sub = this.route.params.subscribe(params =>
    {
      this.alumnoid = +params['id'];
    });

    this.sub = this.route.params.subscribe(params =>
    {
      this.clavefamiliar = params['clavefamiliar'];
    });

    this.sub = this.route.params.subscribe(params =>
    {
      this.actualizar = +params['actualizar'];
    });

    this.summittedGeneral = false;

    this.router = router;

    this.sistema = _httpService.sistema;
    this.sistemaNombre = this.sistema == 1 ? "LUX" : this.sistema == 2 ? "Ciencias" : "";

  }

  ngOnInit()
  {
    //catálogos
    this.GetCatalogosDatosAlumno();
  }


  //-------------------------------------- Datos iniciales -----------------------------------------------

  //----------------- catálogos --------
  GetCatalogosDatosAlumno()
  {
    this._httpService.getElemento('portalfamiliar/' + this.sistemaNombre + '/CatalogosDatosAlumno/' + this.alumnoid).subscribe(
      result =>
      {
        if (result.status == 200)
        {
            this.parentesco = result.body.parentesco;

            this.vivecon = result.body.vivecon;

            this.pais = result.body.pais;

            this.estado = result.body.estado;

            this.tutor = result.body.tutor;
            this.generacion = result.body.generacion;
            this.situacionConyugal = result.body.situacionConyugal;
            this.escolaridad = result.body.escolaridad;
            this.nacionalidad = alasql( "SELECT nacionalidadid, nombre, activo FROM ?" ,[result.body.nacionalidad]);


            this.alumno = new AlumnoModel();
            this.datoMedico = new DatoMedico();

            

            this.SetDatosAlumnos(result.body.alumnodatos[0]);
            this.SetAlumnoNivel(result.body.alumno[0])


            this.CambiarCP(this.alumno.CodigoPostal, false);

            if(result.body.contactoemergencia){
                result.body.contactoemergencia.map(contacto => {
                    let c = new ContactoEmegrencia()
                    c.AlumnoId = contacto.alumnoid.alumnoid
                    c.ContactoEmergenciaNombre = contacto.nombre
                    c.ContactoEmergenciaEmail = contacto.email
                    c.ContactoEmergenciaParentesco = (contacto.parentescoid) ? contacto.parentescoid.parentescoid : null
                    c.ContactoEmergenciaTelefono = this._help.ParseTelefono(contacto.telefono)[1]
                    c.ContactoEmergenciaLada = this._help.ParseTelefono(contacto.telefono)[0]
                    c.ContactoEmergenciaId = contacto.contactoemergenciaid
                    this.contactoEmergencia.push(c)
                })
            }

            if(this.sistema == 1)
            {
              this.tipoSanguineo = result.body.tipoSanguineo;
              this.alergia = result.body.alergia;
              this.antecedenteMedico = result.body.antecedenteMedico;

              this.dinamicaFamiliar = new DinamicaFamiliar();

              if(result.body.dinamicaFamiliar.length > 0)
              {
                this.dinamicaFamiliar = this.SetDinamicaFamiliar(result.body.dinamicaFamiliar[0]);
              }

              if(result.body.datoMedico)
              {
                this.datoMedico = this.SetDatoMedico(result.body.datoMedico[0]);
              }

              if(result.body.alergiaDatoMedico)
              {
                this.SetAlergiaVal(result.body.alergiaDatoMedico);
              }
              else
              {
                this.SetAlergiaVal([]);
              }

              if(result.body.antecedenteDatoMedico)
              {
                this.SetAntecedenteFamiliarVal(result.body.antecedenteDatoMedico);
              }
              else
              {
                this.SetAntecedenteFamiliarVal([]);
              }
            }
            else if (this.sistema == 2)
            {
              if(result.body.datoMedico.length>0)
              {
                this.datoMedico = this.SetDatoMedicoCiencias(result.body.datoMedico[0]);
              }
            }

        }
        else
        {
          //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
          Messenger().post({
                    message: 'No se pudieron cargar los datos. Intente más tarde.',
                    type: 'error',
                    showCloseButton: true
                });
        }
      },
      error =>
      {
        //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
        Messenger().post({
                    message: 'No se pudieron cargar los datos. Intente más tarde.',
                    type: 'error',
                    showCloseButton: true
                });

      }
    );
  }

  //SetDatos

  SetDatosAlumnos(data)
  {
    this.alumno = new AlumnoModel();
    this.alumno.AlumnoId = parseInt(data.AlumnoId);
    this.alumno.PrimerNombre = data.PrimerNombre;
    this.alumno.SegundoNombre = data.SegundoNombre;
    this.alumno.ApellidoPaterno = data.ApellidoPaterno;
    this.alumno.ApellidoMaterno = data.ApellidoMaterno;
    this.alumno.Correo = data.Correo;
    this.alumno.Calle = data.Calle;
    this.alumno.NumeroExterior = data.NumeroExterior;
    this.alumno.NumeroInterior = data.NumeroInterior;
    this.alumno.Colonia = data.Colonia;
    this.alumno.CiudadId = parseInt(data.CiudadId);
    this.alumno.EstadoId = parseInt(data.EstadoId);
    this.alumno.CodigoPostal = data.CodigoPostal;
    this.alumno.ViveConId = parseInt(data.ViveConId);

    this.alumno.Lada = this._help.ParseTelefono(data.Telefono)[0];
    this.alumno.Tel = this._help.ParseTelefono(data.Telefono)[1];

    this.alumno.Matricula = data.Matricula;


    if(data.PaisNacimiento)
    {
      this.CambiarPaisNacimiento(parseInt(data.PaisNacimiento));
    }

    if(data.EstadoNacimiento)
    {
      this.CambiarEstadoNacimiento(parseInt(data.EstadoNacimiento));
    }
    this.alumno.PaisNacimiento = data.PaisNacimiento;
    this.alumno.EstadoNacimiento = parseInt(data.EstadoNacimiento);
    this.alumno.CiudadNacimiento = parseInt(data.MunicipioNacimiento);
  }

  SetAlumnoNivel(data) {
    this.alumno.Nivel = data.nivel;
    this.alumno.NivelId = data.nivelid;
    this.alumno.Grado = data.grado;
  }


  SetAlergiaVal(alergia)
  {
      for(var k=0; k<this.alergia.length; k++)
      {
          this.alergia[k].Seleccionado = false;

          for(var i=0; i<alergia.length; i++)
          {
              if(alergia[i].alergiaid.alergiaid == this.alergia[k].alergiaid)
              {
                  this.alergia[k].Seleccionado = true;
                  break;
              }
          }
      }
  }

  SetAntecedenteFamiliarVal(antecedente)
  {
      for(var k=0; k<this.antecedenteMedico.length; k++)
      {
          this.antecedenteMedico[k].Seleccionado = false;
          for(var i=0; i<antecedente.length; i++)
          {
              if(antecedente[i].antecedentefamiliarimportanteid.antecedentefamiliarimportanteid == this.antecedenteMedico[k].antecedentefamiliarimportanteid)
              {
                  this.antecedenteMedico[k].Seleccionado = true;
                  break;
              }
          }
      }
  }

  SetDinamicaFamiliar(data)
  {
      var dinamica = new DinamicaFamiliar();

      dinamica.AlumnoDinamicaFamiliarId = data.alumnodinamicafamiliarid;
      dinamica.Ninguna = data.ninguna;
      dinamica.Divorcio = data.divorcio;
      dinamica.Separacion = data.separacion;
      dinamica.Custodia = data.custodia;

      if(data.parentescoid)
      {
        dinamica.ParentescoId = data.parentescoid.parentescoid;
      }

      dinamica.EnfermedadGrave = data.enfermedadgrave;
      dinamica.EspecificacionEnfermedadGrave = data.miembroenfermedadgrave;
      dinamica.Muerte = data.muerteperdida;
      dinamica.EspecificacionMuertes = data.miembromuerteperdida;
      dinamica.CambioResidencia = data.cambioresidencia;
      dinamica.MedioHermano = data.medioshermanos;
      dinamica.SegundoMatrimonio = data.segundosmatrimonios;
      dinamica.MadrePadreSoltero = data.madrepadresoltero;
      dinamica.Otro = data.otros;
      dinamica.EspecificacionOtro = data.descripcionotros;

      return dinamica;
  }

  SetDatoMedico(data)
  {
      var dato = new DatoMedico();
      if (data) {
        dato.AlumnoDatoMedicoId = data.alumnodatomedicoid ? data.alumnodatomedicoid: null;
        dato.ContactoEmergenciaNombre = data.contactoemergencianombre;
  
        if(data.contactoemergenciaparentesco)
        {
            dato.ContactoEmergenciaParentesco = data.contactoemergenciaparentesco.parentescoid;
        }
  
        dato.EnfermedadCronica = data.enfermedadcronica;
        dato.PadeceEnfermedadCuidaNombre = data.padeceenfermedadcuidanombre;
  
        dato.PadeceEnfermedadDescripcion = data.padeceenfermedadcuidadescripcion;
  
        dato.Alergico = data.alergico;
        dato.AlergicoDescripcion = data.otraalergia;
  
        dato.AntecedenteFamiliar = data.antecedentefamiliar;
        dato.AntecedenteFamiliarDescripcion = data.descripcionantecedenteimportante;
        dato.ExamenVista = data.examenvista;
        dato.ExamenAuditivo = data.examenauditivo;
        dato.ExamenOrtopedico = data.examenortopedicos;
        dato.AparatoAuditivo = data.aparatoauditivo;
        dato.AditamentoOrtopedico = data.aditamentoortopedico;
        dato.Talla = data.talla;
        dato.Peso = data.peso;
        dato.Lentes = data.lentes;
        dato.AutorizoAntihistaminico = data.autorizoantihistaminico;
  
        dato.NombreAutoriza = data.nombreautoriza;
  
        if(data.tiposangineo)
        {
            dato.TipoSangineo = data.tiposangineo.tiposanguineoid;
        }
  
        if(this.actualizar == 1)
        {
          dato.ContactoEmergenciaLada = "";
          dato.ContactoEmergenciaTelefono = "";
        }
        else
        {
          dato.ContactoEmergenciaLada = this._help.ParseTelefono(data.contactoemergenciatelefono)[0];
          dato.ContactoEmergenciaTelefono = this._help.ParseTelefono(data.contactoemergenciatelefono)[1];
        }
  
        dato.PadeceEnfermedadLada = this._help.ParseTelefono(data.padeceenfermedadcuidatelefono)[0];
        dato.PadeceEnfermedadTelefono = this._help.ParseTelefono(data.padeceenfermedadcuidatelefono)[1];
      }


      return dato;
  }

  SetDatoMedicoCiencias(data)
  {
    var dato = new DatoMedico();

    if(data) {
      dato.AlumnoDatoMedicoId = data.alumnodatomedicoid;
      dato.ContactoEmergenciaNombre = data.contactoemergencianombre;
      dato.EnfermedadCronica = data.enfermedadcronica;
      dato.Padece = data.padece ? "SI" : "NO";
      dato.PadeceEnfermedadDescripcion = data.padece;
  
      dato.Alergico = data.alergico ? "SI" : "NO";
      dato.AlergicoDescripcion = data.alergico;
  
      dato.TomaMedicamento = data.antecedentefamiliar ? "SI" : "NO";
      dato.TomaMedicamentoDescripcion = data.antecedentefamiliar;
  
      dato.Talla = data.talla;
      dato.Peso = data.peso;
  
      if(this.actualizar == 1)
      {
        dato.ContactoEmergenciaLada = "";
        dato.ContactoEmergenciaTelefono = "";
      }
      else
      {
        dato.ContactoEmergenciaLada = this._help.ParseTelefono(data.contactoemergenciatelefono)[0];
        dato.ContactoEmergenciaTelefono = this._help.ParseTelefono(data.contactoemergenciatelefono)[1];
      }
    }

    return dato;
  }

  //-- Set datos guardar
  SetDatosAlumnoGuardar(data)
  {
    let alumno = new AlumnoModel();

    alumno.AlumnoId = parseInt(data.AlumnoId);

    alumno.Correo = data.Correo;
    alumno.Calle = data.Calle;
    alumno.NumeroExterior = data.NumeroExterior;
    alumno.NumeroInterior = data.NumeroInterior;
    alumno.Colonia = data.Colonia == "Otra" ? data.OtraColonia : data.Colonia;
    alumno.CiudadId = data.CiudadId;
    alumno.EstadoId = data.EstadoId;
    alumno.CodigoPostal = data.CodigoPostal.toString();
    alumno.ViveConId = data.ViveConId;

    if(data.Lada && data.Tel)
    {
      alumno.Telefono = this._help.UnitTelefono(data.Lada, data.Tel);
    }

    alumno.PaisNacimiento = parseInt(data.PaisNacimiento);
    alumno.EstadoNacimiento = data.EstadoNacimiento;
    alumno.CiudadNacimiento = data.CiudadNacimiento;

    return alumno;
  }

  SetDinamicaFamiliarGuardar(data)
  {
      var dinamica = new DinamicaFamiliar();

      dinamica.AlumnoDinamicaFamiliarId = data.AlumnoDinamicaFamiliarId;
      dinamica.Ninguna = this.CambiarValorBoolAInt(data.Ninguna);
      dinamica.Divorcio = this.CambiarValorBoolAInt(data.Divorcio);
      dinamica.Separacion = this.CambiarValorBoolAInt(data.Separacion);
      dinamica.Custodia = this.CambiarValorBoolAInt(data.Custodia);
      dinamica.ParentescoId = data.ParentescoId;
      dinamica.EnfermedadGrave = this.CambiarValorBoolAInt(data.EnfermedadGrave);
      dinamica.EspecificacionEnfermedadGrave = data.EspecificacionEnfermedadGrave;
      dinamica.Muerte = this.CambiarValorBoolAInt(data.Muerte);
      dinamica.EspecificacionMuertes = data.EspecificacionMuertes;
      dinamica.CambioResidencia = this.CambiarValorBoolAInt(data.CambioResidencia);
      dinamica.MedioHermano = this.CambiarValorBoolAInt(data.MedioHermano);
      dinamica.SegundoMatrimonio = this.CambiarValorBoolAInt(data.SegundoMatrimonio);
      dinamica.MadrePadreSoltero = this.CambiarValorBoolAInt(data.MadrePadreSoltero);
      dinamica.Otro = this.CambiarValorBoolAInt(data.Otro);
      dinamica.EspecificacionOtro = data.EspecificacionOtro;

      return dinamica;
  }

  SetDatoMedicoGuardar(data)
  {
      var dato = new DatoMedico();

      dato.AlumnoDatoMedicoId = data.AlumnoDatoMedicoId;
      dato.ContactoEmergenciaNombre = data.ContactoEmergenciaNombre;
      dato.ContactoEmergenciaParentesco = data.ContactoEmergenciaParentesco;

      dato.EnfermedadCronica = data.EnfermedadCronica;
      dato.PadeceEnfermedadCuidaNombre = data.PadeceEnfermedadCuidaNombre;

      dato.PadeceEnfermedadDescripcion = data.PadeceEnfermedadDescripcion;

      dato.AlergicoDescripcion = data.AlergicoDescripcion;

      dato.AntecedenteFamiliar = data.AntecedenteFamiliar;

      dato.ExamenVista = data.ExamenVista;
      dato.ExamenAuditivo = data.ExamenAuditivo;
      dato.ExamenOrtopedico = data.ExamenOrtopedico;
      dato.AparatoAuditivo = data.AparatoAuditivo;
      dato.AditamentoOrtopedico = data.AditamentoOrtopedico;
      dato.Talla = data.Talla;
      dato.Peso = data.Peso;
      dato.Lentes = data.Lentes;
      dato.AutorizoAntihistaminico = data.AutorizoAntihistaminico;
      dato.TipoSangineo = data.TipoSangineo;
      dato.NombreAutoriza = data.NombreAutoriza;

      dato.ContactoEmergenciaTelefono = this._help.UnitTelefono(data.ContactoEmergenciaLada, data.ContactoEmergenciaTelefono);

      if(data.PadeceEnfermedadLada && data.PadeceEnfermedadTelefono)
      {
        dato.PadeceEnfermedadTelefono = this._help.UnitTelefono(data.PadeceEnfermedadLada, data.PadeceEnfermedadTelefono);
      }

      if(this.datoMedicoService.ValidarAntecedenteMedicoDescripcion(this.antecedenteMedico))
      {
          dato.AntecedenteFamiliarDescripcion = data.AntecedenteFamiliarDescripcion;
      }

      return dato;
  }

  SetDatoMedicoGuardarCiencias(data)
  {
    var dato = new DatoMedico();

    dato.AlumnoDatoMedicoId = data.AlumnoDatoMedicoId;

    dato.ContactoEmergenciaNombre = data.ContactoEmergenciaNombre;

    dato.Padece = data.Padece;
    dato.PadeceEnfermedadDescripcion = data.PadeceEnfermedadDescripcion;

    dato.Alergico = data.Alergico;
    dato.AlergicoDescripcion = data.AlergicoDescripcion;

    dato.TomaMedicamento = data.TomaMedicamento;
    dato.TomaMedicamentoDescripcion = data.TomaMedicamentoDescripcion;

    dato.Talla = data.Talla;
    dato.Peso = data.Peso;

    dato.ContactoEmergenciaTelefono = this._help.UnitTelefono(data.ContactoEmergenciaLada, data.ContactoEmergenciaTelefono);

    return dato;
  }

  //--------------------------- Admin Teléfono ----------------------------
  CambiarATelefono(val, id)
  {
    if(val)
    {
        if(val.indexOf('_')<0)
        {
          document.getElementById(id).focus();
        }
    }
  }

  CambiarALada(val, id)
  {
    if(!val)
    {
      document.getElementById(id).focus();
    }
  }


  //-- Valores checkbox

  CambiarValorBoolAInt(val)
  {
    return val ? 1:0;
  }

  CambiarValorIntABool(val)
  {
    return val == 1 ? true:false;
  }

  //----------------- Datos alumno ----------------------------------
  GuardarDatosAlumno()
  {
      this.summittedGeneral = true;

      if(!this.ValidarDatosAlumnos())
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
          let datosalumno = {datos: {}, dinamicafamiliar: {}, datomedico: {}, actualizardatos: this.actualizarDatos, clavefamiliar: this.clavefamiliar.toString(), alergia: this.alergia, antecedente: this.antecedenteMedico, recoger:[], contactosemergencia: [], contactoseliminados: []};
          datosalumno.datos = this.SetDatosAlumnoGuardar(this.alumno);
          datosalumno.recoger = this.actualizarDatos.recoger ? this.recoger : [];

          datosalumno.contactosemergencia = this.contactoEmergencia
          datosalumno.contactoseliminados = this.contactosEliminados
          if(this.sistema == 1)
          {
            datosalumno.dinamicafamiliar = this.SetDinamicaFamiliarGuardar(this.dinamicaFamiliar);
            datosalumno.datomedico = this.SetDatoMedicoGuardar(this.datoMedico);
          }
          else if(this.sistema == 2)
          {
            datosalumno.datomedico = this.SetDatoMedicoGuardarCiencias(this.datoMedico);
          }

          this._httpService.putElemento('portalfamiliar/' + this.sistemaNombre + '/Alumno', datosalumno).subscribe(
          result =>
          {
            if (result.status == 200)
            {
                //this._httpService.mensajeSuccessFinal('Los datos se actualizaron.');
                Messenger().post({
                    message: 'Los datos se actualizaron.',
                    type: 'success',
                    showCloseButton: true
                });
                this.router.navigate(['/Menu/DatosFamilia/ActualizacionDatos/AlumnoDatos'] );
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
            var errorMessage = <any> error;
            console.log(errorMessage);
                Messenger().post({
                    message: 'No se puedo realizar la operación.',
                    type: 'error',
                    showCloseButton: true
                });
          });
      }
  };

  ValidarDatosAlumnos()
  {
    let erCorreo = /^[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,3})$/;
    let erLada = /^\([1-9][0-9]{1,2}\)$/;
    //let erTelefono = /^\d{3}.\d{4}$/;
    let erCP = /^[0-9]{5}$/;
    let erTalla = /^[1-9]\d{1,2}$/;
    let erPeso = /^[1-9]\d{1,2}$/;
    let correovalido = true;

    let correoAlumno = this.alumno.Correo ? this.alumno.Correo.match(erCorreo) : false;
    let ladaAlumno = this.alumno.Lada ? this.alumno.Lada.match(erLada) : false;
    let telefonoAlumno = this.telefonoService.ValidarTelefono(this.alumno.Lada, this.alumno.Tel);
    let cp = this.alumno.CodigoPostal ? this.alumno.CodigoPostal.match(erCP) : false;
    let ladaCE = this.datoMedico.ContactoEmergenciaLada ? this.datoMedico.ContactoEmergenciaLada.match(erLada) : false;
    let telefonoCE = this.telefonoService.ValidarTelefono(this.datoMedico.ContactoEmergenciaLada, this.datoMedico.ContactoEmergenciaTelefono);
    let ladaEC = this.datoMedico.PadeceEnfermedadLada ? this.datoMedico.PadeceEnfermedadLada.match(erLada) : false;
    let telefonoEC = this.telefonoService.ValidarTelefono(this.datoMedico.PadeceEnfermedadLada, this.datoMedico.PadeceEnfermedadTelefono);
    let talla = this.datoMedico.Talla ? this.datoMedico.Talla : false;
    let peso = this.datoMedico.Peso ? this.datoMedico.Peso : false;

    if (this.contactoEmergencia&& this.contactoEmergencia.length >0) {
        for(let c of this.contactoEmergencia) {
            if(c.ContactoEmergenciaEmail && !c.ContactoEmergenciaEmail.match(erCorreo)) {
              return false;
            }
            if (!c.ContactoEmergenciaParentesco) {
              return false;
            }
            if(!c.ContactoEmergenciaNombre) {
              return false;
            }
            if (c.ContactoEmergenciaLada && c.ContactoEmergenciaTelefono) {
              var valtel = this.telefonoService.ValidarTelefono(c.ContactoEmergenciaLada, c.ContactoEmergenciaTelefono);
              var vallada = c.ContactoEmergenciaLada.match(erLada); 
            } else {
              return false;
            }

            if (!valtel && !vallada) {
              return false;
            }
        }
    }

    // datos del alumno
    if (!correoAlumno && this.alumno.Correo && !correovalido) {
      return false;
    }

    if ((this.alumno.Tel || this.alumno.Lada) && (!ladaAlumno || !telefonoAlumno)) {
      return false;
    }

    if (!this.alumno.ViveConId) {
      return false;
    }


    //lugar nacimiento
    if (!this.alumno.PaisNacimiento) {
      return false;
    }

    if (this.alumno.PaisNacimiento == "484") {
      if (!this.alumno.EstadoNacimiento || !this.alumno.CiudadNacimiento) {
        return false;
      }
    }

    //domicilio
    if (!cp) {
      return false;
    }

    if (!this.alumno.EstadoId) {
      return false;
    }

    if (!this.alumno.CiudadId) {
      return false;
    }

    if (!this.alumno.Colonia) {
      return false;
    }

    if (this.alumno.Colonia == "Otra" && !this.alumno.OtraColonia) {
      return false;
    }

    if (!this.alumno.Calle) {
      return false;
    }

    if (!this.alumno.NumeroExterior) {
      return false;
    }

    if (!this.alumno.NumeroExterior) {
      return false;
    }


    // área médica
    // if (!this.datoMedico.ContactoEmergenciaNombre)
    // {
    //   return false;
    // }

    // if (!ladaCE)
    // {
    //   return false;
    // }

    // if (!telefonoCE)
    // {
    //   return false;
    // }

    // if (!this.datoMedico.ContactoEmergenciaParentesco && this.sistema == 1)
    // {
    //   return false;
    // }

    if (!talla)
    {
      return false;
    }

    if (!peso)
    {
      return false;
    }


    if (this.sistema == 1)
    {
      if (!this.datoMedico.EnfermedadCronica)
      {
        return false;
      }

      if (this.datoMedico.EnfermedadCronica == "SI")
      {
        if (!this.datoMedico.PadeceEnfermedadCuidaNombre)
        {
          return false;
        }

        if (!ladaEC)
        {
          return false;
        }

        if (!telefonoEC)
        {
          return false;
        }

        if (!this.datoMedico.PadeceEnfermedadDescripcion)
        {
          return false;
        }
      }

      if (!this.datoMedicoService.ValidarAlergiaRequired(this.alergia))
      {
        return false;
      }

      if (this.datoMedicoService.ValidarAlergiaDescripcion(this.alergia) && !this.datoMedico.AlergicoDescripcion)
      {
        return false;
      }

      if (!this.datoMedicoService.ValidarAntecedenteMedicoRequired(this.antecedenteMedico))
      {
        return false;
      }

      if (this.datoMedicoService.ValidarAntecedenteMedicoDescripcion(this.antecedenteMedico) && !this.datoMedico.AntecedenteFamiliarDescripcion)
      {
        return false;
      }

      if (!this.datoMedico.ExamenAuditivo)
      {
        return false;
      }

      if (!this.datoMedico.AparatoAuditivo)
      {
        return false;
      }

      if (!this.datoMedico.ExamenOrtopedico)
      {
        return false;
      }

      if (!this.datoMedico.AditamentoOrtopedico)
      {
        return false;
      }

      if (!this.datoMedico.ExamenVista)
      {
        return false;
      }

      if (!this.datoMedico.Lentes)
      {
        return false;
      }

      if (!this.datoMedico.AutorizoAntihistaminico)
      {
        return false;
      }

      if (!this.datoMedico.TipoSangineo)
      {
        return false;
      }

      if (!this.datoMedico.NombreAutoriza)
      {
        return false;
      }
    }
    else if(this.sistema == 2)
    {
      if(!this.datoMedico.Padece)
      {
        return;
      }

      if(this.datoMedico.Padece == "SI")
      {
        if(!this.datoMedico.PadeceEnfermedadDescripcion)
        {
          return;
        }
      }

      if(!this.datoMedico.Alergico)
      {
        return;
      }

      if(this.datoMedico.Alergico == "SI")
      {
        if(!this.datoMedico.AlergicoDescripcion)
        {
          return;
        }
      }

      if(!this.datoMedico.TomaMedicamento)
      {
        return;
      }

      if(this.datoMedico.TomaMedicamento == "SI")
      {
        if(!this.datoMedico.TomaMedicamentoDescripcion)
        {
          return;
        }
      }
    }

    //dinamica familiar
    if(this.sistema == 1)
    {
      if (!this.dinamicaFamiliarService.ValidarDinamicaFamiliar(this.dinamicaFamiliar)) {
        return false;
      }

      if (this.dinamicaFamiliar.Custodia && !this.dinamicaFamiliar.ParentescoId) {
        return false;
      }

      if (this.dinamicaFamiliar.EnfermedadGrave && !this.dinamicaFamiliar.EspecificacionEnfermedadGrave) {
        return false;
      }

      if (this.dinamicaFamiliar.Muerte && !this.dinamicaFamiliar.EspecificacionMuertes) {
        return false;
      }

      if (this.dinamicaFamiliar.Otro && !this.dinamicaFamiliar.EspecificacionOtro) {
        return false;
      }
    }


    return true;
  }





  CancelarCambiosAlumnos()
  {
    let msg = Messenger({extraClasses: 'messenger-fixed messenger-on-top'}).post(
    {
      message: "¿Está seguro de que quiere salir? Los cambios realizados no se guardarán.",
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
          label: "Salir",
          action: () => {
            this.router.navigate(['/Menu/DatosFamilia/ActualizacionDatos/AlumnoDatos']);
            msg.hide();
          }
        }
      }
    });
  }

  GetEstatusBarra()
  {
    if( !jQuery('layout').is('.nav-collapsed') )
    {
        return true;
    }
    else
    {
        return false;
    }
  }

  //------------------------------------------------- Funciones adicionales -------------
  //----- Domicilio
  CambiarCP(cp, manual)
  {

    this.ciudad = [];
    this.colonia = [];


    this.cpnoconocido = false;

    if(manual)
    {
      this.alumno.EstadoId = null;
      this.alumno.Colonia = null;
      this.alumno.OtraColonia = null;
      this.alumno.CiudadId = null;
    }


    var aux = cp ? cp.replace(/\_/g, "") : "";

    if(parseInt(aux))
    {
      if(aux.length == 5)
      {
        this._httpService.getElemento('Colonia/GetByCP/'+cp).subscribe
        (
          result =>
          {
            if (result.status == 200)
            {
              this.ciudad = alasql("SELECT nombre, municipioid FROM ? ", [[result.body[0].municipioid]]);
              this.colonia = alasql("SELECT coloniaid, nombre, cp FROM ? ", [result.body]);

              this.alumno.EstadoId = result.body[0].municipioid.estadoid.estadoid;
              this.alumno.CiudadId = result.body[0].municipioid.municipioid;


              this.SetOtraColonia();

              if(!manual)
              {
                this.CambiarColonia(this.alumno.Colonia);
              }
            }
            else if (result.status == 206)
            {
              this.cpnoconocido = true;
              this.ciudad = [];
              if(this.alumno.EstadoId)
              {
                this.CambiarEstado(this.alumno.EstadoId, false);
              }
            }
            else
            {
              this.ciudad = [];
              //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
              Messenger().post({
                message: 'No se pudieron cargar los datos. Intente más tarde.',
                type: 'error',
                showCloseButton: true
              });

            }
          },
          error =>
          {
            this.ciudad = [];
            //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
            Messenger().post({
              message: 'No se pudieron cargar los datos. Intente más tarde.',
              type: 'error',
              showCloseButton: true
            });
          }
        );
      }
    }
  }

  CambiarEstado(id, reiniciarAlumno)
  {
    this._httpService.getElemento('Ciudad/'+id).subscribe
    (
      result =>
      {
        if (result.status == 200)
        {
          this.ciudad = alasql("SELECT nombre, municipioid, activo FROM ? ", [result.body]);

          if(reiniciarAlumno != false)
          {
            this.alumno.CiudadId = null;
            this.alumno.Colonia = null;
            this.alumno.OtraColonia = null;
          }
          else
          {
            if(this.alumno.CiudadId)
            {
              this.CambiarCiudad(this.alumno.CiudadId, false);
            }

          }


          if(!this.ValidarCodigoPostal())
          {
            this.alumno.CodigoPostal = "";
          }
        }
        else
        {
          this.ciudad = [];
          //this.alumno.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
          Messenger().post({
            message: 'No se pudieron cargar los datos. Intente más tarde.',
            type: 'error',
            showCloseButton: true
          });
        }
      },
      error =>
      {
        this.ciudad = [];
        //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
        Messenger().post({
          message: 'No se pudieron cargar los datos. Intente más tarde.',
          type: 'error',
          showCloseButton: true
        });
      }
    );
  }

  CambiarCiudad(id, reiniciarAlumno)
  {

    if(!this.cpnoconocido)
    {
      this._httpService.getElemento('Colonia/'+id).subscribe
      (
        result =>
        {
          if (result.status == 200)
          {
            this.colonia = alasql("SELECT nombre, coloniaid, cp FROM ? ", [result.body]);
            this.SetOtraColonia();

            this.alumno.Colonia = null;
            this.alumno.OtraColonia = null;

          }
          else
          {
            this.colonia = [];
            //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
            Messenger().post({
              message: 'No se pudieron cargar los datos. Intente más tarde.',
              type: 'error',
              showCloseButton: true
            });
          }
        },
        error =>
        {
          this.colonia = [];
          //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
          Messenger().post({
            message: 'No se pudieron cargar los datos. Intente más tarde.',
            type: 'error',
            showCloseButton: true
          });
        }
      );
    }
    else
    {
      this.colonia = [];
      this.SetOtraColonia();

      if(reiniciarAlumno != false)
      {
        this.alumno.Colonia = null;
        this.alumno.OtraColonia = null;
      }
      else
      {
        this.CambiarColonia(this.alumno.Colonia);
      }
    }
  }

  ValidarCodigoPostal()
  {
    if(this.alumno.CodigoPostal)
    {
      this.alumno.CodigoPostal = this.alumno.CodigoPostal.toString();
      var aux = this.alumno.CodigoPostal.replace(/\_/, "");
      if(aux.length == 5)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

  CambiarColonia(colonia)
  {
    if(colonia)
    {
      let col = alasql("SELECT * FROM ? WHERE LOWER(nombre) = '" + colonia.toLowerCase() + "'", [this.colonia]);

      if(col.length > 0)
      {
        if(col[0].nombre != "Otra")
        {
          this.alumno.Colonia = col[0].nombre;
          this.alumno.CodigoPostal = col[0].cp;
          this.alumno.OtraColonia = "";
        }
      }
      else
      {
        if(this.alumno.Colonia != "Otra")
        {
          this.alumno.OtraColonia = this.alumno.Colonia;
        }

        this.alumno.Colonia = "Otra";
      }
    }
  }

  SetOtraColonia()
  {
    if(this.alumno.CodigoPostal)
    {
      if(this.alumno.CodigoPostal.toString().length == 5)
      {
        let otracol = {nombre:"Otra", coloniaid: 0};

        this.colonia.push(otracol);
      }
    }
  }

  //--------------------------------------   Lugar de nacimiento -------------------------
  CambiarPaisNacimiento(id)
  {

    this.alumno.EstadoNacimiento = null;
    this.alumno.CiudadNacimiento = null;

    this.estadoNacimiento = [];
    this.ciudadNacimiento = [];


    this._httpService.getElemento('Estado/'+id).subscribe
    (
      result =>
      {
        if (result.status == 200)
        {
          this.estadoNacimiento = alasql("SELECT nombre, estadoid, activo FROM ?", [result.body]);
        }
        else
        {
          this.estadoNacimiento = [];
        }
      },
      error =>
      {
        this.estadoNacimiento = [];
        //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
        Messenger().post({
          message: 'No se pudieron cargar los datos. Intente más tarde.',
          type: 'error',
          showCloseButton: true
        });
      }
    );
  }

  CambiarEstadoNacimiento(id)
  {
    this.alumno.CiudadNacimiento = null;

    this.ciudadNacimiento = [];

    this._httpService.getElemento('Ciudad/'+id).subscribe
    (
      result =>
      {
        if (result.status == 200)
        {
          this.ciudadNacimiento = alasql("SELECT nombre, municipioid, activo FROM ?", [result.body]);
        }
        else
        {
          this.ciudadNacimiento = [];
        }
      },
      error =>
      {
        this.ciudadNacimiento = [];
        //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
        Messenger().post({
          message: 'No se pudieron cargar los datos. Intente más tarde.',
          type: 'error',
          showCloseButton: true
        });
      }
    );
  }

  //--personas autorizadas recoger
  SetRecoger(recoger)
  {
    this.recoger = recoger;
  }
}


