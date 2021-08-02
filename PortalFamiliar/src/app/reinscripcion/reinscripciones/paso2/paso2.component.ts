import {ViewEncapsulation, Component, AfterViewInit, OnInit, Output, EventEmitter, Input, ViewChild, ElementRef} from '@angular/core';
import {AppState} from 'app/app.service';
import { MenuList } from "entity/menulist.ts";
import {StorageService} from 'app/Servicios/storage.service';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {TelefonoService} from 'app/Servicios/Telefono.Service'
import {Reinscripciones} from 'app/reinscripcion/reinscripciones/reinscripciones';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import {saveAs as importedSaveAs} from "file-saver";
import {Helpers} from 'app/app.helpers';
import { ThrowStmt } from '@angular/compiler/src/output/output_ast';


declare let Messenger: any;
declare let alasql: any;

@Component({
    selector: 'paso2',
    templateUrl: './paso2.component.html',
    providers: [AppState],
    encapsulation: ViewEncapsulation.None,
})
export class Paso2Component implements OnInit, AfterViewInit {
    @Input() reinscripciones: Reinscripciones;
    @Output() output = new EventEmitter();
    @Output() paso3 = new EventEmitter();
    @ViewChild('modal') public modal: ModalDirective; 

    arrayDocumentos: any[] = [];
    tramitobecaSelect: any[] = [];
    FormGuardar: FormGroup;
    mensaje: string;
    submitted: boolean;
    arrayPagocolegiaturas: any[] = [];
    arrayPagoadelantada: any[] = [];
    arrayInscripcion: any[] = [];
    arrayTipocolegiatura: any[] = [];
    arrayTipopago: any[] = [];
    mostrarpagoanticipado: boolean;
    mostrarpagocolegiatura: boolean;
    cambio: boolean = false;
    public solicitudadmisionid: string;
    public viveCon: any;
    public email: any;    
    public cel: any;
    public cel2: any;
    public celular: any;
    public municipio: string;
    public pais: string;

    public estudiadoExtr: string;
    public textEstudiadoExtr: string;

    public municipioCp: string;
    public colonia: string;
    public otraColonia: string;    
    public calle: string;
    public numex: string;
    public numint: string;
    public cp: string;

    public municipioCp2: string;
    public colonia2: string;
    public otraColonia2: string;    
    public calle2: string;
    public numex2: string;
    public numint2: string;
    public cp2: string;

    public enfermedad: string;
    public alergia1: string;
    public antecedente: string;
    public auditivo: string;
    public ortopedico: string;
    public ortopedico1: string;
    public talla: string;
    public cronica: string;
    public curacion: string;
    public unguento: string;
    public autoriza: string;
    public autorizacion: string;
    public autorizo: string;
    public vista: string;
    public lentes: string;
    public sanguineo: string;
    public peso: string;
    public medicamento: string;
    public medicamento1: string;
    public analgesicos: string;
    public antigripales: string;
    public Antiacidos: string;
    public sustancia: string;

    public remediosAlternos: string;
    public atispasmodico: string;
    public nombreCE: any;
    public ladatel: any;
    public tel: any;
    public tel2: any;
    public telCE: any;
    public formapagocontrato: any;
    public firmantenombre: any;
    public firmanteap: any;
    public firmanteam: any;
    public firmanteparentesco: any;
    public contratoid: any;
    public responsableid: any;

    public estadoTempCP: any;
    public estadoTempCP2: any;

    public nombre: any;
    public apellidoPaterno: any;
    public apellidoMaterno: any;
    public ocupacion: any;
    public edad: any;

    public nombre2: any;
    public apellidoPaterno2: any;
    public apellidoMaterno2: any;
    public ocupacion2: any;
    public edad2: any;
    public responsablefof1: any;
    public responsablefof2: any;
    public parentesco1: any;
    public parentesco2: any;
    public tutor: any;
    public pago: any;
    public Padres: any;
    public Parentesco: any;
    public padreotutorid: any;
    public mEstado: any;
    public mEstados: any;
    public mColonias: any;
    public mColonia: any;
    public mCiudades: any;
    public mCiudad: any;
    public potEstado: any;
    public potEstados: any;
    public potColonias: any;
    public potColonia: any;
    public potCiudades: any;
    public potCiudad: any;
    public preview: any;
    public status:any;
    public validaMadre: any;
    public validaPadre: any;
    public reinscripcionid: any;

    //En el contructor se declara la llamada a los servicios
    constructor(private _he:ElementRef, private _httpService: AppState, private _fb: FormBuilder, public helpers: Helpers, private storage: StorageService, public telefonoService: TelefonoService) {
        this.padreotutorid = this.storage.getItem('PadresOTutoresId');
        MenuList.visible = true;
        window.onpopstate = null;
    }

    //Metodo de inicio
    ngOnInit(): void {
        
        window.scrollTo(0,0);

        this.solicitudadmisionid = null;
        this.formapagocontrato = null;

        this.tutor = null;
        this.mEstados = [];
        this.mEstado = null;
        this.mColonias = [];
        this.mColonia = null;
        this.mCiudades = [];
        this.mCiudad = null;
        this.potEstados = [];
        this.potEstado = null;
        this.potColonias = [];
        this.potColonia = null;
        this.potCiudades = [];
        this.potCiudad = null;        

        this.FormGuardar = this._fb.group({
            reinscripcionid: [],
            cpAlumno: [],
            estadoAlumno: [],
            ciudadAlumno: [],
            coloniaAlumno: [],
            calleAlumno: [],
            numexAlumno: [],
            numintAlumno: [],
            mnombre: [],
            mapaterno: [],
            mamaterno: [],
            mcp: [],
            mtel: [],
            mcelc: [],
            mocupacion: [],
            medad: [],
            mestado: [],
            mnumex: [],
            mcalle: [],
            mnumint: [],
            mcolonia: [],
            motracolonia: [],
            mciudad: [],
            mresponsableid: [],
            potnombre: [],
            potapaterno: [],
            potamaterno: [],
            potcp: [],
            pottel: [],
            potcelc: [],
            potocupacion: [],
            potedad: [],
            potestado: [],
            potnumex: [],
            potcalle: [],
            potnumint: [],
            potcolonia: [],
            pototracolonia: [],
            potciudad: [],
            potparentesco: [],
            potresponsableid: []
        });
        this.datosAlumnos();
        if(this.reinscripciones.catalogos) {
            let docs = this.reinscripciones.catalogos.arrayDocumentos;
            this.arrayPagocolegiaturas = this.reinscripciones.catalogos.arrayPagocolegiaturas;
            this.arrayPagoadelantada = this.reinscripciones.catalogos.arrayPagoadelantada;
            this.arrayInscripcion = this.reinscripciones.catalogos.arrayInscripcion;
            this.arrayDocumentos = docs.filter(x=> x.grados.includes(this.reinscripciones.alumno.gradoid));
            this.arrayTipopago = this.reinscripciones.catalogos.arrayTipopago;
        }
        if(this.reinscripciones.formPaso2) {         
            if(this.reinscripciones.formPaso2.mcp){
              this.FormGuardar.get("reinscripcionid").setValue(this.reinscripciones.formPaso2.reinscripcionid);  
              this.FormGuardar.get("mnombre").setValue(this.reinscripciones.formPaso2.mnombre);
              this.FormGuardar.get("mapaterno").setValue(this.reinscripciones.formPaso2.mapaterno);
              this.FormGuardar.get("mamaterno").setValue(this.reinscripciones.formPaso2.mamaterno);
              this.FormGuardar.get("mtel").setValue(this.reinscripciones.formPaso2.mtel);
              this.FormGuardar.get("mcelc").setValue(this.reinscripciones.formPaso2.mcelc);
              this.FormGuardar.get("mcp").setValue(this.reinscripciones.formPaso2.mcp);
              this.FormGuardar.get("medad").setValue(this.reinscripciones.formPaso2.medad);
              this.FormGuardar.get("mocupacion").setValue(this.reinscripciones.formPaso2.mocupacion);
              this.FormGuardar.get("mcalle").setValue(this.reinscripciones.formPaso2.mcalle);       
              this.FormGuardar.get('mcolonia').setValue('Otra Colonia');
              this.FormGuardar.get("motracolonia").setValue(this.reinscripciones.formPaso2.mcolonia !== 'Otra Colonia' ? this.reinscripciones.formPaso2.mcolonia : this.reinscripciones.formPaso2.motracolonia);
              this.FormGuardar.get("mnumex").setValue(this.reinscripciones.formPaso2.mnumex);            
              this.FormGuardar.get("mnumint").setValue(this.reinscripciones.formPaso2.mnumint);
              this.FormGuardar.get("mresponsableid").setValue(this.reinscripciones.formPaso2.mresponsableid);  
              $("#mdivColonia").css('display', 'block');
              this.buscarCP(this.reinscripciones.formPaso2.mcp, 0, 1);
            }
            if(this.reinscripciones.formPaso2.potcp){                                     
              this.FormGuardar.get("potnombre").setValue(this.reinscripciones.formPaso2.potnombre);
              this.FormGuardar.get("potapaterno").setValue(this.reinscripciones.formPaso2.potapaterno);
              this.FormGuardar.get("potamaterno").setValue(this.reinscripciones.formPaso2.potamaterno);
              this.FormGuardar.get("pottel").setValue(this.reinscripciones.formPaso2.pottel);
              this.FormGuardar.get("potcelc").setValue(this.reinscripciones.formPaso2.potcelc);
              this.FormGuardar.get("potcp").setValue(this.reinscripciones.formPaso2.potcp);
              this.FormGuardar.get("potedad").setValue(this.reinscripciones.formPaso2.potedad);
              this.FormGuardar.get("potocupacion").setValue(this.reinscripciones.formPaso2.potocupacion);
              this.FormGuardar.get("potcalle").setValue(this.reinscripciones.formPaso2.potcalle);                                 
              this.FormGuardar.get('potcolonia').setValue('Otra Colonia');
              this.FormGuardar.get("pototracolonia").setValue(this.reinscripciones.formPaso2.potcolonia !== 'Otra Colonia' ? this.reinscripciones.formPaso2.potcolonia : this.reinscripciones.formPaso2.pototracolonia);
              this.FormGuardar.get("potnumex").setValue(this.reinscripciones.formPaso2.potnumex);            
              this.FormGuardar.get("potnumint").setValue(this.reinscripciones.formPaso2.potnumint);
              this.FormGuardar.get("potparentesco").setValue(this.reinscripciones.formPaso2.potparentesco);
              this.FormGuardar.get("potresponsableid").setValue(this.reinscripciones.formPaso2.potresponsableid);
              $("#potdivColonia").css('display', 'block');
              this.buscarCP(this.reinscripciones.formPaso2.potcp, 1, 1);
            }
        } else {
           this.FormGuardar.get("reinscripcionid").setValue(this.reinscripciones.alumno.reinscripcionid);    
           let fondo = this.reinscripciones.alumno.documentoresponsable.filter(x => x.documentoid.documentoid == 2);
           let madre = fondo.filter(x => x.tutorid.tutorid == 2);
           if (madre.length > 0){
            this.FormGuardar.get("mnombre").setValue(madre[0].nombre);
            this.FormGuardar.get("mapaterno").setValue(madre[0].apellidopaterno);
            this.FormGuardar.get("mamaterno").setValue(madre[0].apellidomaterno);
            this.FormGuardar.get("mtel").setValue(madre[0].telefono);
            this.FormGuardar.get("mcelc").setValue(madre[0].celular);
            this.FormGuardar.get("mcp").setValue(madre[0].cp);
            this.FormGuardar.get("medad").setValue(madre[0].edad);
            this.FormGuardar.get("mocupacion").setValue(madre[0].ocupacion);
            this.FormGuardar.get("mcalle").setValue(madre[0].calle);
            this.FormGuardar.get("motracolonia").setValue(madre[0].colonia);
            this.FormGuardar.get("mnumex").setValue(madre[0].numeroext);            
            this.FormGuardar.get("mnumint").setValue(madre[0].numeroint);
            this.FormGuardar.get("mresponsableid").setValue(madre[0].responsablecontratoid);
            this.buscarCP(madre[0].cp, 0, 1);
            this.FormGuardar.get("mcolonia").setValue('Otra Colonia');
            $("#mdivColonia").css('display', 'block');
           }
           let pot = fondo.filter(x => x.tutorid.tutorid !== 2);
           if (pot.length > 0){          
             console.log(pot);
            this.FormGuardar.get("potnombre").setValue(pot[0].nombre);
            this.FormGuardar.get("potapaterno").setValue(pot[0].apellidopaterno);
            this.FormGuardar.get("potamaterno").setValue(pot[0].apellidomaterno);
            this.FormGuardar.get("pottel").setValue(pot[0].telefono);
            this.FormGuardar.get("potcelc").setValue(pot[0].celular);
            this.FormGuardar.get("potcp").setValue(pot[0].cp);
            this.FormGuardar.get("potedad").setValue(pot[0].edad);
            this.FormGuardar.get("potocupacion").setValue(pot[0].ocupacion);
            this.FormGuardar.get("potcalle").setValue(pot[0].calle);            
            this.FormGuardar.get("pototracolonia").setValue(pot[0].colonia);
            this.FormGuardar.get("potnumex").setValue(pot[0].numeroext);            
            this.FormGuardar.get("potnumint").setValue(pot[0].numeroint);
            this.FormGuardar.get("potresponsableid").setValue(pot[0].responsablecontratoid);
            this.buscarCP(pot[0].cp, 1, 1);
            this.FormGuardar.get("potcolonia").setValue('Otra Colonia');
            this.FormGuardar.get("potparentesco").setValue(pot[0].tutorid.tutorid);
            $("#potdivColonia").css('display', 'block');
           }
        }
    }

    ngAfterViewInit() {
        /* */
    }


    descargar(id) {
        this._httpService.getArchivo("Controlescolar/Reinscripcion/Documentoalumno/descargar", id + "?reinscripcionid=" + this.reinscripcionid).subscribe(
            result => {
                if (result.status == 200) {
                    let docs = this.arrayDocumentos.find(x=> x.documentoid == id);
                    importedSaveAs(result.body, docs.nombre);
                    this.cancelar();
                } else {
                    Messenger().post({
                        message: result.body,
                        type: "success",
                        showCloseButton: true
                    });
                }
            },
            error => {
                var errorMessage = <any> error;
                Messenger().post({
                    message: "No se pudo comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
        );
    }

    CambiarEstado(id, type)
    {
      this._httpService.getElemento('Ciudad/'+id).subscribe
      (
        result =>
        {
          if (result.status == 200)
          {
            if (type){
              this.potCiudades = alasql("SELECT nombre, municipioid, activo FROM ? ", [result.body]);
            }else{
              this.mCiudades = alasql("SELECT nombre, municipioid, activo FROM ? ", [result.body]);
            }
          }
          else
          {
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

          //this._httpService.mensajeDanger('No se pudieron cargar los datos. Intente más tarde. ');
          Messenger().post({
            message: 'No se pudieron cargar los datos. Intente más tarde.',
            type: 'error',
            showCloseButton: true
          });
        }
      );
    } 

  //----- Domicilio
  cambioColonia(e, type){
    let divOtraColonia;

    if (type){
      divOtraColonia = "potdivColonia";
    }else{
      divOtraColonia = "mdivColonia";
    }
    if(e !== 'Otra Colonia'){
      $("#"+divOtraColonia).css('display', 'none');
    }else{
      $("#"+divOtraColonia).css('display', 'block');
    }
  }
  buscarCP(cp, type, withOutTarget = null)
  {
    if (withOutTarget == null)
      cp = cp.target.value;
    
    var aux = cp;
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
              if (type){
                this.potCiudades = alasql("SELECT nombre, municipioid FROM ? ", [[result.body[0].municipioid]]);
                this.potColonias = alasql("SELECT coloniaid, nombre, cp FROM ? ", [result.body]);
                this.potColonias.push({coloniaid: 0, nombre: 'Otra Colonia'});
                this.FormGuardar.get('potestado').setValue(result.body[0].municipioid.estadoid.estadoid);
                this.FormGuardar.get('potciudad').setValue(result.body[0].municipioid.municipioid);                
                this.potEstado = result.body[0].municipioid.estadoid.estadoid;
                this.potCiudad = result.body[0].municipioid.municipioid;
                this._httpService.inputValidateSuccess('potcolonia');
                this._httpService.inputValidateSuccess('potestado');
                this._httpService.inputValidateSuccess('potciudad');
              }else{
                this.mCiudades = alasql("SELECT nombre, municipioid FROM ? ", [[result.body[0].municipioid]]);
                this.mColonias = alasql("SELECT coloniaid, nombre, cp FROM ? ", [result.body]);
                this.mColonias.push({coloniaid: 0, nombre: 'Otra Colonia'});
                this.mEstado = result.body[0].municipioid.estadoid.estadoid;
                this.mCiudad = result.body[0].municipioid.municipioid;
                this.FormGuardar.get('mestado').setValue(result.body[0].municipioid.estadoid.estadoid);
                this.FormGuardar.get('mciudad').setValue(result.body[0].municipioid.municipioid);
                this._httpService.inputValidateSuccess('mcolonia');
                this._httpService.inputValidateSuccess('mestado');
                this._httpService.inputValidateSuccess('mciudad');
              }
            }
            else if (result.status == 206)
            {
              /*this.cpnoconocido = true;
              this.ciudad = [];
              if(this.alumno.EstadoId)
              {
                this.CambiarEstado(this.alumno.EstadoId, false);
              }*/
            }
            else
            {
              //this.ciudad = [];
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
            //this.ciudad = [];
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

    /* Elegir un padreotutor */
    seleccionPadre(e: any, type: any){
        let ev_padre = this.Padres.filter(x=> x.padresotutoresid == e);
        let tel = ev_padre[0].celular.replace(' ', '');
        tel = tel.replace('-', '');
        if (type){
            this.FormGuardar.get('potamaterno').setValue(ev_padre[0].apellidomaterno);
            this.FormGuardar.get('potapaterno').setValue(ev_padre[0].apellidopaterno);
            this.FormGuardar.get('potnombre').setValue(ev_padre[0].nombre);
            this.FormGuardar.get('potcelc').setValue(tel);
            this.FormGuardar.get('pottel').setValue(tel);
            this.FormGuardar.get('potocupacion').setValue(ev_padre[0].ocupacion);
            this._httpService.inputValidateSuccess('potnombre');
            this._httpService.inputValidateSuccess('potapaterno');
            this._httpService.inputValidateSuccess('potamaterno');
            this._httpService.inputValidateSuccess('pottel');
            this._httpService.inputValidateSuccess('potcelc');
            this._httpService.inputValidateSuccess('potocupacion');
        }else{
            this.FormGuardar.get('mamaterno').setValue(ev_padre[0].apellidomaterno);
            this.FormGuardar.get('mapaterno').setValue(ev_padre[0].apellidopaterno);
            this.FormGuardar.get('mnombre').setValue(ev_padre[0].nombre);
            this.FormGuardar.get('mcelc').setValue(tel);
            this.FormGuardar.get('mtel').setValue(tel);
            this.FormGuardar.get('mocupacion').setValue(ev_padre[0].ocupacion);
            this._httpService.inputValidateSuccess('mnombre');
            this._httpService.inputValidateSuccess('mapaterno');
            this._httpService.inputValidateSuccess('mamaterno');
            this._httpService.inputValidateSuccess('mtel');
            this._httpService.inputValidateSuccess('mcelc');
            this._httpService.inputValidateSuccess('mocupacion');
        }
    }

    /* Buscar información */
    datosAlumnos() {        

        this._httpService.inputValidateSuccess('mnombre');
        this._httpService.inputValidateSuccess('mapaterno');
        this._httpService.inputValidateSuccess('mamaterno');
        this._httpService.inputValidateSuccess('mcelc');
        this._httpService.inputValidateSuccess('mtel');
        this._httpService.inputValidateSuccess('mocupacion');
        this._httpService.inputValidateSuccess('medad');
        this._httpService.inputValidateSuccess('mcp');
        this._httpService.inputValidateSuccess('mcalle');
        this._httpService.inputValidateSuccess('mcolonia');
        this._httpService.inputValidateSuccess('mnumex');
        this._httpService.inputValidateSuccess('mnumint');
        this._httpService.inputValidateSuccess('mestado');
        this._httpService.inputValidateSuccess('mciudad');

        this._httpService.inputValidateSuccess('potnombre');
        this._httpService.inputValidateSuccess('potapaterno');
        this._httpService.inputValidateSuccess('potamaterno');
        this._httpService.inputValidateSuccess('potcelc');
        this._httpService.inputValidateSuccess('pottel');
        this._httpService.inputValidateSuccess('potocupacion');
        this._httpService.inputValidateSuccess('potedad');
        this._httpService.inputValidateSuccess('potcp');
        this._httpService.inputValidateSuccess('potcalle');
        this._httpService.inputValidateSuccess('potcolonia');
        this._httpService.inputValidateSuccess('potnumex');
        this._httpService.inputValidateSuccess('potnumint');
        this._httpService.inputValidateSuccess('potestado');
        this._httpService.inputValidateSuccess('potciudad');        
        this._httpService.inputValidateSuccess('potparentesco'); 

        this._httpService.getElemento('Controlescolar/Reinscripcion/Alumnosbypadretutor/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    this.reinscripcionid = this.reinscripciones.alumno.reinscripcionid;
                    let res = result.body;
                    this.Padres = [];
                    res.padresotutores.forEach(element => {
                        element.padresotutoresid.nombrecompleto = element.padresotutoresid.nombre + ' ' + element.padresotutoresid.apellidopaterno + ' ' +  element.padresotutoresid.apellidomaterno;
                        element.padresotutoresid.parentescoid = element.tutorid.tutorid;
                        this.Padres.push(element.padresotutoresid);
                    });     
                    let tutores = res.tutores.filter(x=> x.descripcion !== 'Aspirante' && x.descripcion !== 'Madre' && x.descripcion !== 'Tutora' );
                    this.Parentesco =  tutores;
                    this.mEstados = res.estados;
                    this.potEstados = res.estados;
                    let domAlumno = res.alumnos[0].domicilio;
                    this.FormGuardar.get('cpAlumno').setValue(domAlumno.codigopostal);
                    this.FormGuardar.get('calleAlumno').setValue(domAlumno.calle);
                    this.FormGuardar.get('numexAlumno').setValue(domAlumno.numeroexterior);
                    this.FormGuardar.get('numintAlumno').setValue(domAlumno.numerointerior);
                    if (this.reinscripciones.formPaso2){       
                       this.reinscripcionid = this.reinscripciones.formPaso2.reinscripcionid;                
                       let responsables = res.alumnos.filter(x=> x.reinscripcionid == this.reinscripciones.formPaso2.reinscripcionid);
                       let fondo = responsables[0].documentoresponsable.filter(x => x.documentoid.documentoid == 2);
                       let madre = fondo.filter(x => x.tutorid.tutorid == 2);
                       if (madre.length > 0)
                        this.FormGuardar.get('mresponsableid').setValue(madre[0].responsablecontratoid);
                       let padre = fondo.filter(x => x.tutorid.tutorid !== 2);
                       if (padre.length > 0)
                        this.FormGuardar.get('potresponsableid').setValue(padre[0].responsablecontratoid);
                    }else{
                        this.reinscripcionid = this.reinscripciones.alumno.reinscripcionid;
                    }                       

                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    cancelar() {
      this.status = true
      this.validaMadre = false;
      this.validaPadre = false; 

      if (  this.FormGuardar.get('mnombre').value !== undefined && this.FormGuardar.get('mnombre').value !== null
        || this.FormGuardar.get('mapaterno').value !== undefined && this.FormGuardar.get('mapaterno').value !== null
        || this.FormGuardar.get('mamaterno').value !== undefined && this.FormGuardar.get('mamaterno').value !== null
        || this.FormGuardar.get('medad').value !== undefined && this.FormGuardar.get('medad').value !== null
        || this.FormGuardar.get('mcp').value !== undefined && this.FormGuardar.get('mcp').value !== null
        || this.FormGuardar.get('mtel').value !== undefined && this.FormGuardar.get('mtel').value !== null
        || this.FormGuardar.get('mcelc').value !== undefined && this.FormGuardar.get('mcelc').value !== null
        || this.FormGuardar.get('mocupacion').value !== undefined && this.FormGuardar.get('mocupacion').value !== null
        || this.FormGuardar.get('mestado').value !== undefined && this.FormGuardar.get('mestado').value !== null
        || this.FormGuardar.get('mciudad').value !== undefined && this.FormGuardar.get('mciudad').value !== null
        || this.FormGuardar.get('mcolonia').value !== undefined && this.FormGuardar.get('mcolonia').value !== null
        || this.FormGuardar.get('mnumex').value !== undefined && this.FormGuardar.get('mnumex').value !== null         
        || this.FormGuardar.get('mcalle').value !== undefined && this.FormGuardar.get('mcalle').value !== null
        ){
            this.validaMadre = true;
      }

      if (this.FormGuardar.get('potnombre').value !== undefined && this.FormGuardar.get('potnombre').value !== null
      || this.FormGuardar.get('potapaterno').value !== undefined && this.FormGuardar.get('potapaterno').value !== null
      || this.FormGuardar.get('potamaterno').value !== undefined && this.FormGuardar.get('potamaterno').value !== null
      || this.FormGuardar.get('potedad').value !== undefined && this.FormGuardar.get('potedad').value !== null
      || this.FormGuardar.get('potcp').value !== undefined && this.FormGuardar.get('potcp').value !== null
      || this.FormGuardar.get('pottel').value !== undefined && this.FormGuardar.get('pottel').value !== null
      || this.FormGuardar.get('potcelc').value !== undefined && this.FormGuardar.get('potcelc').value !== null
      || this.FormGuardar.get('potocupacion').value !== undefined && this.FormGuardar.get('potocupacion').value !== null
      || this.FormGuardar.get('potestado').value !== undefined && this.FormGuardar.get('potestado').value !== null
      || this.FormGuardar.get('potciudad').value !== undefined && this.FormGuardar.get('potciudad').value !== null
      || this.FormGuardar.get('potcolonia').value !== undefined && this.FormGuardar.get('potcolonia').value !== null
      || this.FormGuardar.get('potnumex').value !== undefined && this.FormGuardar.get('potnumex').value !== null
      || this.FormGuardar.get('potcalle').value !== undefined && this.FormGuardar.get('potcalle').value !== null
      || this.FormGuardar.get('potparentesco').value !== undefined && this.FormGuardar.get('potparentesco').value !== null 
      ){
          this.validaPadre = true;
      }

      if (!this.validaMadre && !this.validaPadre)
        this.validaMadre = true;

      /* validaciones madre */
      if (this.validaMadre){
        if (this.FormGuardar.get('mnombre').value == '' || this.FormGuardar.get('mnombre').value == null){         
          this._httpService.inputValidateDanger('mnombre','Ingrese el nombre');
          this.status = false;
        }
        if (this.FormGuardar.get('mapaterno').value == '' || this.FormGuardar.get('mapaterno').value == null){
          this._httpService.inputValidateDanger('mapaterno','Ingrese el apellido paterno');
          this.status = false;
        }
        if (this.FormGuardar.get('mamaterno').value == '' || this.FormGuardar.get('mamaterno').value == null){
          this._httpService.inputValidateDanger('mamaterno','Ingrese el apellido materno');
          this.status = false;
        }
        if (this.FormGuardar.get('medad').value == '' || this.FormGuardar.get('medad').value == null){
          $('#medad').focus();
          this._httpService.inputValidateDanger('medad','Ingrese la edad');
          this.status = false;
        }
        if (this.FormGuardar.get('mcp').value == '' || this.FormGuardar.get('mcp').value == null){
          this._httpService.inputValidateDanger('mcp','Ingrese el codigo postal');
          this.status = false;
        }
        if (this.FormGuardar.get('mtel').value == '' || this.FormGuardar.get('mtel').value == null){
          $('#mtel').focus();
          this._httpService.inputValidateDanger('mtel','Ingrese el teléfono');
          this.status = false;
        }
        if (this.FormGuardar.get('mcelc').value == '' || this.FormGuardar.get('mcelc').value == null){
          $('#mcelc').focus();
          this._httpService.inputValidateDanger('mcelc','Ingrese el celular');
          this.status = false;
        }
        if (this.FormGuardar.get('mocupacion').value == '' || this.FormGuardar.get('mocupacion').value == null){
          this._httpService.inputValidateDanger('mocupacion','Ingrese la ocupación');
          this.status = false;
        }
        if (this.FormGuardar.get('mestado').value == '' || this.FormGuardar.get('mestado').value == null){
          this._httpService.inputValidateDanger('mestado','Ingrese el estado');
          this.status = false;
        }
        if (this.FormGuardar.get('mciudad').value == '' || this.FormGuardar.get('mciudad').value == null){
          this._httpService.inputValidateDanger('mciudad','Ingrese el municipio');
          this.status = false;
        }
        if (this.FormGuardar.get('mcolonia').value == '' || this.FormGuardar.get('mcolonia').value == null){
          this._httpService.inputValidateDanger('mcolonia','Ingrese la colonia');
          this.status = false;
        }
        if (this.FormGuardar.get('mnumex').value == '' || this.FormGuardar.get('mnumex').value == null){
          this._httpService.inputValidateDanger('mnumex','Ingrese el numero de vivienda');
          this.status = false;
        }
        if (this.FormGuardar.get('mcalle').value == '' || this.FormGuardar.get('mcalle').value == null){
          this._httpService.inputValidateDanger('mcalle','Ingrese la calle');
          this.status = false;
        }
        
        if ( this.FormGuardar.get('mcolonia').value == 'Otra Colonia'){
          if (this.FormGuardar.get('motracolonia').value == '' || this.FormGuardar.get('motracolonia').value == null){
            this._httpService.inputValidateDanger('motracolonia','Ingrese la colonia');
            this.status = false;
          }
        }
      }

      /* validaciones madre */
      if (this.validaPadre){
        if (this.FormGuardar.get('potnombre').value == '' || this.FormGuardar.get('potnombre').value == null){
          this._httpService.inputValidateDanger('potnombre','Ingrese el nombre');
          this.status = false;
        }
        if (this.FormGuardar.get('potapaterno').value == '' || this.FormGuardar.get('potapaterno').value == null){
          this._httpService.inputValidateDanger('potapaterno','Ingrese el apellido paterno');
          this.status = false;
        }
        if (this.FormGuardar.get('potamaterno').value == '' || this.FormGuardar.get('potamaterno').value == null){
          this._httpService.inputValidateDanger('potamaterno','Ingrese el apellido materno');
          this.status = false;
        }
        if (this.FormGuardar.get('potcp').value == '' || this.FormGuardar.get('potcp').value == null){
          this._httpService.inputValidateDanger('potcp','Ingrese el codigo postal');
          this.status = false;
        }
        if (this.FormGuardar.get('potedad').value == '' || this.FormGuardar.get('potedad').value == null){
          $('#potedad').focus();
          this._httpService.inputValidateDanger('potedad','Ingrese la edad');
          this.status = false;
        }
        if (this.FormGuardar.get('pottel').value == '' || this.FormGuardar.get('pottel').value == null){
          $('#pottel').focus();
          this._httpService.inputValidateDanger('pottel','Ingrese el teléfono');
          this.status = false;
        }
        if (this.FormGuardar.get('potcelc').value == '' || this.FormGuardar.get('potcelc').value == null){
          $('#potcelc').focus();
          this._httpService.inputValidateDanger('potcelc','Ingrese el celular');
          this.status = false;
        }
        if (this.FormGuardar.get('potocupacion').value == '' || this.FormGuardar.get('potocupacion').value == null){
          this._httpService.inputValidateDanger('potocupacion','Ingrese la ocupación');
          this.status = false;
        }
        if (this.FormGuardar.get('potestado').value == '' || this.FormGuardar.get('potestado').value == null){
          this._httpService.inputValidateDanger('potestado','Ingrese el estado');
          this.status = false;
        }
        if (this.FormGuardar.get('potciudad').value == '' || this.FormGuardar.get('potciudad').value == null){
          this._httpService.inputValidateDanger('potciudad','Ingrese el municipio');
          this.status = false;
        }
        if (this.FormGuardar.get('potcolonia').value == '' || this.FormGuardar.get('potcolonia').value == null){
          this._httpService.inputValidateDanger('potcolonia','Ingrese la colonia');
          this.status = false;
        }
        if (this.FormGuardar.get('potnumex').value == '' || this.FormGuardar.get('potnumex').value == null){
          this._httpService.inputValidateDanger('potnumex','Ingrese el numero de vivienda');
          this.status = false;
        }
        if (this.FormGuardar.get('potcalle').value == '' || this.FormGuardar.get('potcalle').value == null){
          this._httpService.inputValidateDanger('potcalle','Ingrese la calle');
          this.status = false;
        }        
        if (this.FormGuardar.get('potparentesco').value == '' || this.FormGuardar.get('potparentesco').value == null){
          this._httpService.inputValidateDanger('potparentesco','Ingrese el parentesco');
          this.status = false;
        }
        if ( this.FormGuardar.get('potcolonia').value == 'Otra Colonia'){
          if (this.FormGuardar.get('pototracolonia').value == '' || this.FormGuardar.get('pototracolonia').value == null){
            this._httpService.inputValidateDanger('pototracolonia','Ingrese la colonia');
            this.status = false;
          }
        }
      }    

      if (!this.status){
        return false;
      }
      
      this.submitted = true;
      if(this.FormGuardar.invalid) {          
          return false;
      }
 
      /* 
         15/04/2021
            No hace falta ya que no hay necesidad probablmente de editar de nuevo
      if(!this.cambio) {
          this.paso3.next();
          return false;
      } */

      this.reinscripciones.formPaso2 = this.FormGuardar.value;
      let data = this.FormGuardar.value;
      data.telefono = data.tel;
      data.soloResponsables = 1;   
      data.info = [];
      let detalle = {};

      if (this.validaMadre){
        detalle = {nombre: this.FormGuardar.get('mnombre').value,
        ap: this.FormGuardar.get('mapaterno').value,
        am: this.FormGuardar.get('mamaterno').value,
        responsableid: this.FormGuardar.get('mresponsableid').value,
        parentesco: 2,
        cp: this.FormGuardar.get('mcp').value,
        telefono: this.FormGuardar.get('mtel').value,
        celular: this.FormGuardar.get('mcelc').value,
        ocupacion: this.FormGuardar.get('mocupacion').value,
        edad: this.FormGuardar.get('medad').value,
        estadoid: this.FormGuardar.get('mestado').value,
        municipioid: this.FormGuardar.get('mciudad').value,     
        colonia: this.FormGuardar.get('mcolonia').value !== 'Otra Colonia' ? this.FormGuardar.get('mcolonia').value : this.FormGuardar.get('motracolonia').value,
        numex: this.FormGuardar.get('mnumex').value,
        calle: this.FormGuardar.get('mcalle').value,
        numint: this.FormGuardar.get('mnumint').value,
        documentoid: 2};
        data.info.push(detalle);
      }      
      if (this.validaPadre){
        detalle = {nombre: this.FormGuardar.get('potnombre').value,
        ap: this.FormGuardar.get('potapaterno').value,
        am: this.FormGuardar.get('potamaterno').value,
        responsableid: this.FormGuardar.get('potresponsableid').value,
        parentesco: this.FormGuardar.get('potparentesco').value,
        cp: this.FormGuardar.get('potcp').value,
        telefono: this.FormGuardar.get('pottel').value,
        celular: this.FormGuardar.get('potcelc').value,
        ocupacion: this.FormGuardar.get('potocupacion').value,
        edad: this.FormGuardar.get('potedad').value,
        estadoid: this.FormGuardar.get('potestado').value,
        municipioid: this.FormGuardar.get('potciudad').value,     
        colonia: this.FormGuardar.get('potcolonia').value !== 'Otra Colonia' ? this.FormGuardar.get('potcolonia').value : this.FormGuardar.get('pototracolonia').value,
        numex: this.FormGuardar.get('potnumex').value,
        calle: this.FormGuardar.get('potcalle').value,
        numint: this.FormGuardar.get('potnumint').value,
        documentoid: 2};
        data.info.push(detalle);
      }    
      this._httpService.postElemento('Controlescolar/Reinscripcion/AlumnoPago/', this.FormGuardar.value, null, true).subscribe(
          res => {
              if (res.status == 200) {
                  this.output.next();
                  Messenger().post({
                      message: res.body,
                      type: 'success',
                      showCloseButton: true
                  });
              } else {
                  Messenger().post({
                      message: res.body,
                      type: 'success',
                      showCloseButton: true
                  });
              }
          },
          err => {
              Messenger().post({
                  message: 'No se pudo comunicar con el servidor',
                  type: 'success',
                  showCloseButton: true
              });
              console.log('error');
          }
      );
    }

    siguiente() {

        this.status = true
        this.validaMadre = false;
        this.validaPadre = false; 

        if (  this.FormGuardar.get('mnombre').value !== undefined && this.FormGuardar.get('mnombre').value !== null
          || this.FormGuardar.get('mapaterno').value !== undefined && this.FormGuardar.get('mapaterno').value !== null
          || this.FormGuardar.get('mamaterno').value !== undefined && this.FormGuardar.get('mamaterno').value !== null
          || this.FormGuardar.get('medad').value !== undefined && this.FormGuardar.get('medad').value !== null
          || this.FormGuardar.get('mcp').value !== undefined && this.FormGuardar.get('mcp').value !== null
          || this.FormGuardar.get('mtel').value !== undefined && this.FormGuardar.get('mtel').value !== null
          || this.FormGuardar.get('mcelc').value !== undefined && this.FormGuardar.get('mcelc').value !== null
          || this.FormGuardar.get('mocupacion').value !== undefined && this.FormGuardar.get('mocupacion').value !== null
          || this.FormGuardar.get('mestado').value !== undefined && this.FormGuardar.get('mestado').value !== null
          || this.FormGuardar.get('mciudad').value !== undefined && this.FormGuardar.get('mciudad').value !== null
          || this.FormGuardar.get('mcolonia').value !== undefined && this.FormGuardar.get('mcolonia').value !== null
          || this.FormGuardar.get('mnumex').value !== undefined && this.FormGuardar.get('mnumex').value !== null         
          || this.FormGuardar.get('mcalle').value !== undefined && this.FormGuardar.get('mcalle').value !== null
          ){
              this.validaMadre = true;
        }

        if (this.FormGuardar.get('potnombre').value !== undefined && this.FormGuardar.get('potnombre').value !== null
        || this.FormGuardar.get('potapaterno').value !== undefined && this.FormGuardar.get('potapaterno').value !== null
        || this.FormGuardar.get('potamaterno').value !== undefined && this.FormGuardar.get('potamaterno').value !== null
        || this.FormGuardar.get('potedad').value !== undefined && this.FormGuardar.get('potedad').value !== null
        || this.FormGuardar.get('potcp').value !== undefined && this.FormGuardar.get('potcp').value !== null
        || this.FormGuardar.get('pottel').value !== undefined && this.FormGuardar.get('pottel').value !== null
        || this.FormGuardar.get('potcelc').value !== undefined && this.FormGuardar.get('potcelc').value !== null
        || this.FormGuardar.get('potocupacion').value !== undefined && this.FormGuardar.get('potocupacion').value !== null
        || this.FormGuardar.get('potestado').value !== undefined && this.FormGuardar.get('potestado').value !== null
        || this.FormGuardar.get('potciudad').value !== undefined && this.FormGuardar.get('potciudad').value !== null
        || this.FormGuardar.get('potcolonia').value !== undefined && this.FormGuardar.get('potcolonia').value !== null
        || this.FormGuardar.get('potnumex').value !== undefined && this.FormGuardar.get('potnumex').value !== null
        || this.FormGuardar.get('potcalle').value !== undefined && this.FormGuardar.get('potcalle').value !== null
        || this.FormGuardar.get('potparentesco').value !== undefined && this.FormGuardar.get('potparentesco').value !== null 
        ){
            this.validaPadre = true;
        }

        if (!this.validaMadre && !this.validaPadre)
          this.validaMadre = true;

        /* validaciones madre */
        if (this.validaMadre){
          if (this.FormGuardar.get('mnombre').value == '' || this.FormGuardar.get('mnombre').value == null){         
            this._httpService.inputValidateDanger('mnombre','Ingrese el nombre');
            this.status = false;
          }
          if (this.FormGuardar.get('mapaterno').value == '' || this.FormGuardar.get('mapaterno').value == null){
            this._httpService.inputValidateDanger('mapaterno','Ingrese el apellido paterno');
            this.status = false;
          }
          if (this.FormGuardar.get('mamaterno').value == '' || this.FormGuardar.get('mamaterno').value == null){
            this._httpService.inputValidateDanger('mamaterno','Ingrese el apellido materno');
            this.status = false;
          }
          if (this.FormGuardar.get('medad').value == '' || this.FormGuardar.get('medad').value == null){
            $('#medad').focus();
            this._httpService.inputValidateDanger('medad','Ingrese la edad');
            this.status = false;
          }
          if (this.FormGuardar.get('mcp').value == '' || this.FormGuardar.get('mcp').value == null){
            this._httpService.inputValidateDanger('mcp','Ingrese el codigo postal');
            this.status = false;
          }
          if (this.FormGuardar.get('mtel').value == '' || this.FormGuardar.get('mtel').value == null){
            $('#mtel').focus();
            this._httpService.inputValidateDanger('mtel','Ingrese el teléfono');
            this.status = false;
          }
          if (this.FormGuardar.get('mcelc').value == '' || this.FormGuardar.get('mcelc').value == null){
            $('#mcelc').focus();
            this._httpService.inputValidateDanger('mcelc','Ingrese el celular');
            this.status = false;
          }
          if (this.FormGuardar.get('mocupacion').value == '' || this.FormGuardar.get('mocupacion').value == null){
            this._httpService.inputValidateDanger('mocupacion','Ingrese la ocupación');
            this.status = false;
          }
          if (this.FormGuardar.get('mestado').value == '' || this.FormGuardar.get('mestado').value == null){
            this._httpService.inputValidateDanger('mestado','Ingrese el estado');
            this.status = false;
          }
          if (this.FormGuardar.get('mciudad').value == '' || this.FormGuardar.get('mciudad').value == null){
            this._httpService.inputValidateDanger('mciudad','Ingrese el municipio');
            this.status = false;
          }
          if (this.FormGuardar.get('mcolonia').value == '' || this.FormGuardar.get('mcolonia').value == null){
            this._httpService.inputValidateDanger('mcolonia','Ingrese la colonia');
            this.status = false;
          }
          if (this.FormGuardar.get('mnumex').value == '' || this.FormGuardar.get('mnumex').value == null){
            this._httpService.inputValidateDanger('mnumex','Ingrese el numero de vivienda');
            this.status = false;
          }
          if (this.FormGuardar.get('mcalle').value == '' || this.FormGuardar.get('mcalle').value == null){
            this._httpService.inputValidateDanger('mcalle','Ingrese la calle');
            this.status = false;
          }
          
          if ( this.FormGuardar.get('mcolonia').value == 'Otra Colonia'){
            if (this.FormGuardar.get('motracolonia').value == '' || this.FormGuardar.get('motracolonia').value == null){
              this._httpService.inputValidateDanger('motracolonia','Ingrese la colonia');
              this.status = false;
            }
          }
        }

        /* validaciones madre */
        if (this.validaPadre){
          if (this.FormGuardar.get('potnombre').value == '' || this.FormGuardar.get('potnombre').value == null){
            this._httpService.inputValidateDanger('potnombre','Ingrese el nombre');
            this.status = false;
          }
          if (this.FormGuardar.get('potapaterno').value == '' || this.FormGuardar.get('potapaterno').value == null){
            this._httpService.inputValidateDanger('potapaterno','Ingrese el apellido paterno');
            this.status = false;
          }
          if (this.FormGuardar.get('potamaterno').value == '' || this.FormGuardar.get('potamaterno').value == null){
            this._httpService.inputValidateDanger('potamaterno','Ingrese el apellido materno');
            this.status = false;
          }
          if (this.FormGuardar.get('potcp').value == '' || this.FormGuardar.get('potcp').value == null){
            this._httpService.inputValidateDanger('potcp','Ingrese el codigo postal');
            this.status = false;
          }
          if (this.FormGuardar.get('potedad').value == '' || this.FormGuardar.get('potedad').value == null){
            $('#potedad').focus();
            this._httpService.inputValidateDanger('potedad','Ingrese la edad');
            this.status = false;
          }
          if (this.FormGuardar.get('pottel').value == '' || this.FormGuardar.get('pottel').value == null){
            $('#pottel').focus();
            this._httpService.inputValidateDanger('pottel','Ingrese el teléfono');
            this.status = false;
          }
          if (this.FormGuardar.get('potcelc').value == '' || this.FormGuardar.get('potcelc').value == null){
            $('#potcelc').focus();
            this._httpService.inputValidateDanger('potcelc','Ingrese el celular');
            this.status = false;
          }
          if (this.FormGuardar.get('potocupacion').value == '' || this.FormGuardar.get('potocupacion').value == null){
            this._httpService.inputValidateDanger('potocupacion','Ingrese la ocupación');
            this.status = false;
          }
          if (this.FormGuardar.get('potestado').value == '' || this.FormGuardar.get('potestado').value == null){
            this._httpService.inputValidateDanger('potestado','Ingrese el estado');
            this.status = false;
          }
          if (this.FormGuardar.get('potciudad').value == '' || this.FormGuardar.get('potciudad').value == null){
            this._httpService.inputValidateDanger('potciudad','Ingrese el municipio');
            this.status = false;
          }
          if (this.FormGuardar.get('potcolonia').value == '' || this.FormGuardar.get('potcolonia').value == null){
            this._httpService.inputValidateDanger('potcolonia','Ingrese la colonia');
            this.status = false;
          }
          if (this.FormGuardar.get('potnumex').value == '' || this.FormGuardar.get('potnumex').value == null){
            this._httpService.inputValidateDanger('potnumex','Ingrese el numero de vivienda');
            this.status = false;
          }
          if (this.FormGuardar.get('potcalle').value == '' || this.FormGuardar.get('potcalle').value == null){
            this._httpService.inputValidateDanger('potcalle','Ingrese la calle');
            this.status = false;
          }        
          if (this.FormGuardar.get('potparentesco').value == '' || this.FormGuardar.get('potparentesco').value == null){
            this._httpService.inputValidateDanger('potparentesco','Ingrese el parentesco');
            this.status = false;
          }
          if ( this.FormGuardar.get('potcolonia').value == 'Otra Colonia'){
            if (this.FormGuardar.get('pototracolonia').value == '' || this.FormGuardar.get('pototracolonia').value == null){
              this._httpService.inputValidateDanger('pototracolonia','Ingrese la colonia');
              this.status = false;
            }
          }
        }    

        if (!this.status){
          return false;
        }

        this.submitted = true;
        if(this.FormGuardar.invalid) {
            return false;
        }
        /* 
           15/04/2021
              No hace falta ya que no hay necesidad probablmente de editar de nuevo
        if(!this.cambio) {
            this.paso3.next();
            return false;
        } */

        this.reinscripciones.formPaso2 = this.FormGuardar.value;
        let data = this.FormGuardar.value;
        data.telefono = data.tel;
        data.soloResponsables = 1;   
        data.info = [];
        let detalle = {};

        if (this.validaMadre){
          detalle = {nombre: this.FormGuardar.get('mnombre').value,
          ap: this.FormGuardar.get('mapaterno').value,
          am: this.FormGuardar.get('mamaterno').value,
          responsableid: this.FormGuardar.get('mresponsableid').value,
          parentesco: 2,
          cp: this.FormGuardar.get('mcp').value,
          telefono: this.FormGuardar.get('mtel').value,
          celular: this.FormGuardar.get('mcelc').value,
          ocupacion: this.FormGuardar.get('mocupacion').value,
          edad: this.FormGuardar.get('medad').value,
          estadoid: this.FormGuardar.get('mestado').value,
          municipioid: this.FormGuardar.get('mciudad').value,     
          colonia: this.FormGuardar.get('mcolonia').value !== 'Otra Colonia' ? this.FormGuardar.get('mcolonia').value : this.FormGuardar.get('motracolonia').value,
          numex: this.FormGuardar.get('mnumex').value,
          calle: this.FormGuardar.get('mcalle').value,
          numint: this.FormGuardar.get('mnumint').value,
          documentoid: 2};
          data.info.push(detalle);
        }      
        if (this.validaPadre){
          detalle = {nombre: this.FormGuardar.get('potnombre').value,
          ap: this.FormGuardar.get('potapaterno').value,
          am: this.FormGuardar.get('potamaterno').value,
          responsableid: this.FormGuardar.get('potresponsableid').value,
          parentesco: this.FormGuardar.get('potparentesco').value,
          cp: this.FormGuardar.get('potcp').value,
          telefono: this.FormGuardar.get('pottel').value,
          celular: this.FormGuardar.get('potcelc').value,
          ocupacion: this.FormGuardar.get('potocupacion').value,
          edad: this.FormGuardar.get('potedad').value,
          estadoid: this.FormGuardar.get('potestado').value,
          municipioid: this.FormGuardar.get('potciudad').value,     
          colonia: this.FormGuardar.get('potcolonia').value !== 'Otra Colonia' ? this.FormGuardar.get('potcolonia').value : this.FormGuardar.get('pototracolonia').value,
          numex: this.FormGuardar.get('potnumex').value,
          calle: this.FormGuardar.get('potcalle').value,
          numint: this.FormGuardar.get('potnumint').value,
          documentoid: 2};
          data.info.push(detalle);
        }    
        this._httpService.postElemento('Controlescolar/Reinscripcion/AlumnoPago/', this.FormGuardar.value, null, true).subscribe(
            res => {
                if (res.status == 200) {
                    this.paso3.next();
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                } else {
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            err => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'success',
                    showCloseButton: true
                });
                console.log('error');
            }
        );
    }
    // Copiar domicilio
    copiarDomicilio(){       
       this.potCiudades = this.mCiudades;
       this.potColonias = this.mColonias;
       if(this.FormGuardar.get('mcolonia').value !== 'Otra Colonia'){
          $("#potdivColonia").css('display', 'none');
       }else{
          $("#potdivColonia").css('display', 'block');
       }
       this.FormGuardar.get('potestado').setValue(this.FormGuardar.get('mestado').value);
       this.FormGuardar.get('potciudad').setValue(this.FormGuardar.get('mciudad').value);
       this.FormGuardar.get('potcolonia').setValue(this.FormGuardar.get('mcolonia').value);
       this.FormGuardar.get('potcp').setValue(this.FormGuardar.get('mcp').value);
       this.FormGuardar.get('potcalle').setValue(this.FormGuardar.get('mcalle').value);
       this.FormGuardar.get('potnumex').setValue(this.FormGuardar.get('mnumex').value);
       this.FormGuardar.get('potnumint').setValue(this.FormGuardar.get('mnumint').value);
       this.FormGuardar.get('pototracolonia').setValue(this.FormGuardar.get('motracolonia').value);
       this._httpService.inputValidateSuccess('potcp');
       this._httpService.inputValidateSuccess('potestado');
       this._httpService.inputValidateSuccess('potciudad');
       this._httpService.inputValidateSuccess('potcalle');
       this._httpService.inputValidateSuccess('potnumex');
       this._httpService.inputValidateSuccess('potcolonia');
       this._httpService.inputValidateSuccess('potnumint');
       this._httpService.inputValidateSuccess('pototracolonia');
       

    }
    //Utilizar el domiciio del aluno
    domicilioAlumno(){       
       this.buscarCP(this.FormGuardar.get('cpAlumno').value, 0, 1);
       this.FormGuardar.get('mcp').setValue(this.FormGuardar.get('cpAlumno').value);
       this.FormGuardar.get('mcalle').setValue(this.FormGuardar.get('calleAlumno').value);
       this.FormGuardar.get('mnumex').setValue(this.FormGuardar.get('numexAlumno').value);
       this.FormGuardar.get('mnumint').setValue(this.FormGuardar.get('numintAlumno').value);
       this._httpService.inputValidateSuccess('mcp');
       this._httpService.inputValidateSuccess('mestado');
       this._httpService.inputValidateSuccess('mciudad');
       this._httpService.inputValidateSuccess('mcalle');
       this._httpService.inputValidateSuccess('mnumex');
       this._httpService.inputValidateSuccess('motracolonia');
    }
    //vista de contratos
    openContrato(id){
          this.modal.show();
          this.preview=true;
      this._httpService.getArchivo("Controlescolar/Reinscripcion/Documentoalumno/descargar", id + "?reinscripcionid=" + this.reinscripcionid).subscribe(
        result=>{
          if(result.status == 200){
            let iframe=this._he.nativeElement.querySelector('iframe');
                      iframe.src=window.URL.createObjectURL(result.body) + '#toolbar=0&zoom=100&navpanes=0';
          }else{ this._httpService.mensajeDanger('No se encontro ningún documento: ' + id); }
        },
        error=>{ this._httpService.mensajeDanger('No se encontro ningún documento: ' + id);;}
      );
    }
  
    closeContrato(){
        this.modal.hide();
    }
}
