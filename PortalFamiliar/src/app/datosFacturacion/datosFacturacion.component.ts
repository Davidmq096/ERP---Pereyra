import {AfterViewInit, ViewEncapsulation, Component, OnInit, ViewChild} from '@angular/core';
import {AppState} from "app/app.service";
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {StorageService} from 'app/Servicios/storage.service';

declare let Messenger: any;
declare var $: any;
declare var $window: any;
declare var Pace: any;
declare var alasql: any;
import {FacturaModel} from './facturaModel';

import {Subject} from 'rxjs/Rx';

@Component(
{
    selector: 'datosFacturacion',
    templateUrl: './datosFacturacion.component.html'
})

export class DatosFacturacion implements OnInit {
        tipospersonas = [
        {tipopersonaid : 0, persona:"FÍSICA"},
        {tipopersonaid : 1, persona:"MORAL"}];
    PadresOTutoresId: number = +this.storage.getItem("PadresOTutoresId");
    status: boolean = false;
    accion:boolean = false;
    _otracol : boolean = false;
    rfctemp:any='';
    coloniaDefault:any='';

    //GridGeneral
    arraydatosfacturacion: any[];
    dtOptions1: any = {};
    dtTrigger1 = new Subject;
    FormGuardar: FormGroup;
    ColoniasFull = []; 
    MunicipioFull = []; 
    EstadoFull = [];
    existscp =false;
    myrfc = {id:0,esautomaticacolegiatura : "NO",esautomaticaotros : 0};
    submitted: boolean;
    chkchange: boolean;
    summittedMyRFC:boolean = false;
    estado = [];
    estadosel:any;
    ciudadsel:any;
    coloniasel:any;


    avisoPrivacidad:string;
    sistema:string;

    //Mascaras
    public maskCP = [ /\d/,/\d/,/\d/,/\d/, /\d/];

    //Modal
    @ViewChild('modalPadre') modalPadre: ModalDirective;

    constructor(private _httpService: AppState, private _fb: FormBuilder, private storage: StorageService)
    {
        this.avisoPrivacidad = _httpService.avisoPrivacidad
        //this.sistema = _httpService.sistema == 1 ? 'lux' : _httpService.sistema == 2 ? 'ciencias' : '';
        this.sistema = 'ciencias';
    }
    //Metodo de inicio
    ngOnInit(): void
    {
        //Grid general
        this.chkchange = false;
        this.dtOptions1 =
        {
            dom: '',
            language: {url: "./assets/datatable/Spanish.json"},
            pageLength: 100,
            columnDefs:
                [
                 {"targets": [0], "searchable": false, "orderable": true},
                 {"targets": [1], "searchable": false, "orderable": true},
                 {"targets": [2], "searchable": false, "orderable": true},
                 {"targets": [3], "searchable": false, "orderable": false},
                 {"targets": [4], "searchable": false, "orderable": false}
                ]
        };

        this.FormGuardar = this._fb.group(
        {
            padresotutoresfacturacionid: null,
            padresotutoresid: this.PadresOTutoresId,
            rfc: [, [<any> Validators.required, <any> Validators.maxLength(13),Validators.pattern(/^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/)]],
            tipopersonaid: [, [<any> Validators.required, <any> Validators.maxLength(1)]],
            razonsocial : [, [<any> Validators.required, <any> Validators.maxLength(200)]],
            correo : [, [<any> Validators.required, <any> Validators.maxLength(300),Validators.pattern(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)]],
            codigopostal:[null, [<any> Validators.required, <any> Validators.maxLength(5), Validators.pattern(/^[0-9]{5}$/)]],
            colonia:null,
            otracolonia:null,
            ciudad:null,
            estado:null,
            calle:null,
            numeroexterior:null,
            numerointerior:null,
            esautomaticacolegiatura : 0,
            esautomaticaotros : 0,
            padresotutoresdomicilioid:null,
            sistema: this._httpService.sistema
        });

        this.LoadEstados();
        this.getAll();

    }
    //Metodo inicial

    SaveButtonStyle(){
        if(this.chkchange)
            return 'btn-primary';
        else
            return 'btn-default';
    }
    SaveButtonDisabled(){
        if(this.chkchange)
            return 'btn-primary';
        else
            return 'btn-default';
    }

    //Accion de busqueda de registros
    getAll()
    {
        this._httpService.getElemento('portalfamiliar/datosfacturacion/' + this.PadresOTutoresId).subscribe(
      result =>
            {
                if (result.status == 200)
                {
                    $("#tablaPadres").dataTable().fnDestroy();
                    this.arraydatosfacturacion = result.body;
                    this.getRFCAutomatic();
                    this.dtTrigger1.next();
                }
                else
                {
                    $("#tablaPadres").dataTable().fnClearTable();
                    Messenger().post(
                    {
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
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    getRFCAutomatic()
    {
        this.arraydatosfacturacion.forEach(dato =>
        {
            if(dato.esautomaticacolegiatura == 1 || dato.esautomaticaotros == 1)
            {
                this.SelectRFC(dato.padresotutoresfacturacionid);
                return;
            }
        });
    }

    CancelarCambiosFaturaAutomatica()
    {
        this.myrfc = {id:0,esautomaticacolegiatura : "NO",esautomaticaotros : 0};
        this.getRFCAutomatic();
        this.chkchange = false;
        this.summittedMyRFC = false;
    }

    cancelar()
    {
        //Esconde el modal
        this.modalPadre.hide();
        //Limpia el formulario de guardad y le coloca un valor por defaul al campo activo. (Al realizar un nuevo registro el campo activo siempre debe inica true)
        this.FormGuardar.reset({activo: true,padresotutoresid:this.PadresOTutoresId});
        //Ocultamos los mensajes en el formulario de guardar
        this.submitted = false;
    }

    //Accion para eliminar una entidad
    eliminar(id: number)
    {
        //Llamada al servicio delete para eliminar un elemento
        let msg = Messenger({extraClasses: 'messenger-fixed messenger-on-top'}).post({
            message: "Confirme que desea eliminar un registro",
            hideAfter: false,
            actions:
            {

                cancel:
                {
                    label: "Cancelar",
                    action: () => {
                        msg.hide();
                    }
                },
                confirm:
                    {
                        label: "Eliminar",
                        action: () => {
                            msg.hide();
                            this._httpService.deleteElemento('portalfamiliar/datosfacturacion', id).subscribe(
                                result => {
                                    if (result.status == 200) {
                                        Messenger().post({
                                            message: result.body,
                                            type: 'success',
                                            showCloseButton: true
                                        });
                                        this.getAll();
                                    } else {
                                        Messenger().post({
                                            message: result.body,
                                            type: 'success',
                                            showCloseButton: true
                                        });
                                    }
                                },
                                error => {
                                    var errorMessage = <any> error;
                                    Messenger().post({
                                        message: 'No se pudo comunicar con el servidor',
                                        type: 'error',
                                        showCloseButton: true
                                    });
                                }
                            );
                        }
                    },
            }
        })
    }

    Agregar()
    {
       this.estado = this.EstadoFull.slice(0);
       this.existscp = false;
       this._otracol = false;

       this.FormGuardar.get('sistema').setValue(this._httpService.sistema);
    }

    //Acion para obtener los datos a editar y colocarlos en el modal
    editar(r: any)
    {
        //Mostarremos en el modal "Editar registro"
        //console.log(r);
        //Colocamos los valores del registro en el formulario para mostarra al abrir la modal
        this.rfctemp =r.rfc;
        this._otracol = false;

        this.FormGuardar.setValue(
 {
            padresotutoresfacturacionid: r.padresotutoresfacturacionid,
            padresotutoresid: r.padresotutoresid,
            rfc: r.rfc,
            tipopersonaid:r.tipopersonaid,
            razonsocial :r.razonsocial,
            correo :r.correo,
            esautomaticacolegiatura : r.esautomaticacolegiatura,
            esautomaticaotros : r.esautomaticaotros,
            codigopostal:r.codigopostal,
            colonia:null,
            otracolonia:null,
            ciudad:r.ciudad,
            estado:r.estado ? r.estado : "",
            calle:r.calle,
            numeroexterior:r.numeroexterior,
            numerointerior:r.numerointerior  ,
            padresotutoresdomicilioid: r.padresotutoresdomicilioid,
            sistema: this._httpService.sistema
        });

        //this.FormGuardar.get('rfc').disable();

        if(this.sistema != 'ciencias')
        {
            this.busquedaPorCp2(r.codigopostal, r.colonia, r);
        }

        //Abrimos la modal
        this.modalPadre.show();
    }

    LimpiarFormulario()
    {
        //Quitar valores no obligatorios

        //número interior
        this.FormGuardar.get('numerointerior').setValidators(null);
        this.FormGuardar.get('numerointerior').updateValueAndValidity();

        //otra colonia
        if(!this._otracol)
        {
            this.FormGuardar.get('otracolonia').setValidators(null);
            this.FormGuardar.get('otracolonia').updateValueAndValidity();
        }
        else
        {
            this.FormGuardar.get('otracolonia').setValidators(Validators.required);
            this.FormGuardar.get('otracolonia').updateValueAndValidity();
        }

        if(this.sistema == 'ciencias')
        {
            //Persona jurídica
            this.FormGuardar.get('tipopersonaid').setValidators(null);
            this.FormGuardar.get('tipopersonaid').updateValueAndValidity();

            //Estado
            this.FormGuardar.get('estado').setValidators(null);
            this.FormGuardar.get('estado').updateValueAndValidity();

            //Persona jurídica
            this.FormGuardar.get('ciudad').setValidators(null);
            this.FormGuardar.get('ciudad').updateValueAndValidity();

            //Colonia
            this.FormGuardar.get('colonia').setValidators(null);
            this.FormGuardar.get('colonia').updateValueAndValidity();

            //Otra Colonia
            this.FormGuardar.get('colonia').setValidators(null);
            this.FormGuardar.get('colonia').updateValueAndValidity();

            //calle
            this.FormGuardar.get('calle').setValidators(null);
            this.FormGuardar.get('calle').updateValueAndValidity();

            //número exterior
            this.FormGuardar.get('numeroexterior').setValidators(null);
            this.FormGuardar.get('numeroexterior').updateValueAndValidity();

            //otracolonia
            this.FormGuardar.get('otracolonia').setValidators(null);
            this.FormGuardar.get('otracolonia').updateValueAndValidity();
        }
    }

    guardar()
    {
        //Mostramos los mensajes en los campos que faltan por llenar
        this.submitted = true;

        this.LimpiarFormulario();


        //Validamos si los campos obligatorios han sido llenados
        if (!this.FormGuardar.valid)
        {
            //Faltan campos, cancelamos
            Messenger().post(
            {
                message: 'Completa correctamente todos los datos.',
                type: 'error',
                showCloseButton: true
            });
            return false;
        }


        let validate = false;
        this.arraydatosfacturacion.forEach(dato =>
        {
            if(dato.rfc.toUpperCase() == this.FormGuardar.get('rfc').value.toUpperCase() && this.FormGuardar.get('padresotutoresfacturacionid').value != dato.padresotutoresfacturacionid)
            {
                Messenger().post({
                    message: 'El RFC capturado ya existe en sus datos de facturación.',
                    type: 'error',
                    showCloseButton: true
                });
                validate=true;
                return;
            }
        });

        if(validate)
            return false;

        //Verificamos si el formulario trae un id.
        if (!this.FormGuardar.get('padresotutoresfacturacionid').value)
        {
            let tipoPersona = this.FormGuardar.get('rfc').value.length == 13 ? 0 : this.FormGuardar.get('rfc').value.length == 12 ? 1: null;
            this.FormGuardar.get('tipopersonaid').setValue(tipoPersona);

            //No tiene Id: Es un nuevo registro--- POST
            //Llamada al servicio post para insertar un nuevo elemento
            this._httpService.postElemento('portalfamiliar/datosfacturacion', this.FormGuardar.value).subscribe(
                result => {
                    if (result.status == 200) {
                        this.cancelar();
                        Messenger().post({
                            message: "Se ha guardado el nuevo dato de facturación",
                            type: 'success',
                            showCloseButton: true
                        });
                    this.getAll();
                    }
                },
                error => {
                    var errorMessage = <any> error;
                    Messenger().post({
                        message: 'No se pudo comunicar con el servidor',
                        type: 'error',
                        showCloseButton: true
                    });
                }
            );
        }
        else
        {
            this.FormGuardar.get('rfc').enable();
            //Si tiene Id: Es un registro existente y se va a editar: PUT
            //Llamada al servicio put para actualizar un elemento
            let tipoPersona = this.FormGuardar.get('rfc').value.length == 13 ? 0 : this.FormGuardar.get('rfc').value.length == 12 ? 1: null;
            this.FormGuardar.get('tipopersonaid').setValue(tipoPersona);

            this._httpService.putElemento('portalfamiliar/datosfacturacion', this.FormGuardar.value).subscribe(
                result =>
                {
                    if (result.status == 200)
                    {
                        this.cancelar();
                        Messenger().post({
                            message: result.body,
                            type: 'success',
                            showCloseButton: true
                        });
                        this.getAll();
                    }
                },
                error => {
                    var errorMessage = <any> error;
                    Messenger().post({
                        message: errorMessage,
                        type: 'error',
                        showCloseButton: true
                    });
                }
            );
        }
    }

    SelectRFC(e: any)
    {
        if(e)
        {
            let oka = alasql("SELECT * FROM ? where padresotutoresfacturacionid =" + e, [this.arraydatosfacturacion]);
            
            this.myrfc.id = oka[0].padresotutoresfacturacionid;
            this.myrfc.esautomaticacolegiatura = "SI";
            this.myrfc.esautomaticaotros = oka[0].esautomaticaotros;
        }
        else
        {
            this.myrfc = {id:0,esautomaticacolegiatura : "SI",esautomaticaotros : 0};
        }
    }

    SaveMyRFC()
    {
        this.summittedMyRFC = true;

        if(this.myrfc.esautomaticacolegiatura == "SI" && this.myrfc.id == 0)
        {
            Messenger().post({
                message: 'Completa correctamente todos los datos.',
                type: 'error',
                showCloseButton: true
            });
            return;
        }

        let automatico = this.myrfc.esautomaticacolegiatura == "SI" ? 1 : 0;
        let datos = {id: this.myrfc.id, esautomaticacolegiatura : automatico, esautomaticaotros : 0, padreotutorid: this.PadresOTutoresId};

        //console.log(this.myrfc);
        //return;
        this._httpService.putElemento('portalfamiliar/datosfacturacion/RFC/Automatico', datos).subscribe(
            result =>
            {
                if (result.status == 200)
                {
                    this.arraydatosfacturacion.forEach(dato =>
                    {
                        if(dato.padresotutoresfacturacionid == this.myrfc.id)
                        {
                            dato.esautomaticacolegiatura = this.myrfc.esautomaticacolegiatura == "SI" ? 1 : 0;
                            dato.esautomaticaotros = this.myrfc.esautomaticaotros;
                        }else{
                            dato.esautomaticacolegiatura = 0;
                            dato.esautomaticaotros = 0;
                        }
                    });
                    this.chkchange = false;
                    this.summittedMyRFC = false;
                    Messenger().post(
                    {
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
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
            error => {
                var errorMessage = <any> error;
                Messenger().post({
                    message: errorMessage,
                    type: 'error',
                    showCloseButton: true
                });
            }
        );

    }

    busquedaPorCp2(e: any, f:any, r)
    {
        if (e)
        {
            this._httpService.getElemento('Colonia/GetByCP/' + this.FormGuardar.get('codigopostal').value).subscribe(
            result =>
            {
                if (result.status == 200)
                {
                    this.ColoniasFull = result.body;

                    if(this.ValidarCodigoPostal(this.FormGuardar.get('codigopostal').value))
                    {
                        this.ColoniasFull.push({"nombre": "OTRA", "cp": 0, "coloniaid": -1});
                    }

                    for(let colonia of this.ColoniasFull)
                    {
                        colonia.nombre = colonia.nombre.toUpperCase();
                    }

                    let oka = alasql("SELECT * FROM ? where nombre = TRIM('" + f + "')", [this.ColoniasFull]);

                    if(oka.length <=0)
                    {
                        this.FormGuardar.patchValue(
                 {
                            colonia:"OTRA",
                            otracolonia:f
                        });

                        $('#divColonia').show();
                        this._otracol=true;
                    }
                    else
                    {
                        this.FormGuardar.patchValue(
                {
                            colonia:f,
                        });
                        this._otracol=false;
                    }

                    let listaciudades = [];
                    let listaestados = [];

                    listaciudades.push(result.body[0].municipioid);
                    listaestados.push(result.body[0].municipioid.estadoid);

                     this.MunicipioFull = listaciudades;
                     this.estado = listaestados;

                     this.existscp = true;
                }
                else
                {
                    this.existscp = false;
                    this.MunicipioFull = [];
                    this.ColoniasFull = [];
                    this.estado = this.EstadoFull.slice(0);

                    let ciudad = this.FormGuardar.get('ciudad').value;

                    this.loadMunicipios2(r.estado);
                    this.loadColonias2(r.colonia, r.codigopostal);

                    this._otracol = true;
                    $('#divColonia').show();

                    //this._httpService.mensajeDanger('No se encontro ninguna colonia con el codigo postal ' + this.FormGuardar.get('codigopostal').value);
                }

                this.estadosel = r.estado;
                this.ciudadsel = r.ciudad;
                this.coloniasel = this.FormGuardar.get('colonia').value;
            },
            error =>
            {
                this._httpService.mensajeDanger('No se encontro ninguna colonia con el codigo postal ' + this.FormGuardar.get('codigopostal').value);
            });
        }
        else
        {
            this._httpService.mensajeDanger('Es necesario ingresar el código postal');
        }
    }

    loadMunicipios2(e: any)
    {
        if (e && this.existscp == false)
        {
            this._httpService.getElemento('Ciudad/'+ e).subscribe(
                result =>
                {
                    if (result.status == 200) {
                        this.MunicipioFull = result.body;
                    }
                },
                error =>
                {
                    this.MunicipioFull = [];
                    this.ColoniasFull = [];
                    Messenger().post({
                        message: 'No se pudo comunicar con el servidor de las ciudades',
                        type: 'error',
                        showCloseButton: true
                    });
                });
        }
    }

    loadColonias2(colonia, cp)
    {
        this.ColoniasFull = [];
        this.ColoniasFull.push({"nombre":"OTRA","cp":0,"coloniaid":-1});

        this.FormGuardar.patchValue(
 {
            colonia: 'OTRA',
            otracolonia: colonia
        });
        return;

    }

    busquedaPorCp(e: any)
    {
        if(this.sistema == 'ciencias')
        {
            return;
        }

        //limpiar los otros controles
        this.FormGuardar.patchValue(
  {
            ciudad:null,
            estado:null,
            colonia:null,
        });
        this.estadosel = null;
        this.ciudadsel = null;
        this.coloniasel = null;

        this._otracol = false;
        this.existscp = false;

        this.estado = this.EstadoFull.slice(0);

        if(!this.FormGuardar.get('codigopostal').value)
        {
            return;
        }

        var aux = e.replace(/\_/, "");

        if (aux.length == 5)
        {
            //Llamada al servicio datos iniciales        
            this._httpService.getElemento('Colonia/GetByCP/' + e).subscribe(
                result =>
                {
                    if (result.status == 200)
                    {
                         this.ColoniasFull = result.body;

                        if(this.ValidarCodigoPostal(this.FormGuardar.get('codigopostal').value))
                        {
                            this.ColoniasFull.push({"nombre":"OTRA","cp":0,"coloniaid":-1});
                        }

                         for(let colonia of this.ColoniasFull)
                         {
                             colonia.nombre = colonia.nombre.toUpperCase();
                         }

                         let listaciudades = [];
                         let listaestados = [];

                         listaciudades.push(result.body[0].municipioid);
                         listaestados.push(result.body[0].municipioid.estadoid);

                         this.MunicipioFull = listaciudades;
                         this.estado = listaestados;

                         this.FormGuardar.patchValue(
                         {
                            ciudad:result.body[0].municipioid.municipioid,
                            estado:result.body[0].municipioid.estadoid.estadoid
                         });

                         this.existscp = true;

                         this.estadosel = result.body[0].municipioid.estadoid.estadoid;
                         this.coloniasel = result.body[0].municipioid.municipioid;
                    }
                    else
                    {
                        this.existscp = false;
                        this.MunicipioFull = [];
                        this.ColoniasFull = [];
                    }
                },
                error =>
                {
                    this.existscp = false;
                    this.estado = [];
                    this.MunicipioFull = [];
                    this.ColoniasFull = [];
                    this._httpService.mensajeDanger('No se encontro ninguna colonia con el codigo postal ' + this.FormGuardar.get('codigopostal').value);
                }
            );
        }
        else
        {
            this._httpService.mensajeDanger('Es necesario ingresar el código postal');
        }
    }

    LoadEstados()
    {
        if(this.EstadoFull.length == 0)
        {
            this._httpService.getElemento('Estado/484').subscribe(
                result =>
                {
                    if (result.status == 200)
                    {
                        this.EstadoFull = result.body;
                    }
                },
                error =>
                {
                    this.EstadoFull = [];
                    Messenger().post({
                        message: 'No se pudo comunicar con el servidor para cargar los estados',
                        type: 'error',
                        showCloseButton: true
                    });
                }
            );
        }
    }

    loadMunicipios(e: any)
    {
        if(e == this.estadosel)
        {
            return;
        }
        this.estadosel = e;

        //limpiar otros valores dependientes de estado
        this.FormGuardar.patchValue(
 {
            ciudad:null,
            colonia:null,
            otracolonia:null,
        });
        this.ciudadsel = null;
        this.coloniasel = null;

        this._otracol = false;


        if (e && this.existscp == false)
        {
            this._httpService.getElemento('Ciudad/'+ e).subscribe(
            result =>
            {
                if (result.status == 200) {
                    this.MunicipioFull = result.body;
                }
            },
            error =>
            {
                this.MunicipioFull = [];
                this.ColoniasFull = [];
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor de las ciudades',
                    type: 'error',
                    showCloseButton: true
                });
            });
        }
    }

    loadColonias(e: any)
    {
        if(e == this.ciudadsel)
        {
            return;
        }
        this.ciudadsel = e;

        //limpiar otros valores dependientes de ciudad
        this.FormGuardar.patchValue(

 {
            colonia:null,
            otracolonia:null,
        });
        this.coloniasel = null;

        this._otracol = false;


        if(!this.existscp && this.ValidarCodigoPostal(this.FormGuardar.get('codigopostal').value))
        {
            this.ColoniasFull = [];
            this.ColoniasFull.push({"nombre":"OTRA","cp":0,"coloniaid":-1});
            return;
        }

        if (e && !this.existscp )
        {
            this._httpService.getElemento('Colonia/'+ e).subscribe(
            result =>
            {
                if (result.status == 200)
                {
                    this.ColoniasFull = result.body;

                    if(this.ValidarCodigoPostal(this.FormGuardar.get('codigopostal').value))
                    {
                        this.ColoniasFull.push({"nombre": "OTRA", "cp": 0, "coloniaid": -1});
                    }

                    for(let colonia of this.ColoniasFull)
                    {
                        colonia.nombre = colonia.nombre.toUpperCase();
                    }
                }
            },
            error =>
            {
                this.ColoniasFull = [];
                Messenger().post(
                {
                    message: 'No se pudo comunicar con el servidor de las colonias',
                    type: 'error',
                    showCloseButton: true
                });
            });
        }
    }

    otraColonia(e: any)
    {
        if(e == this.coloniasel)
        {
            return;
        }

        this.coloniasel = e;

        if (e == 'OTRA')
        {
            $('#divColonia').show();
            $('#otraColonia').val('');
            this._otracol = true;
        }
        else
        {
            $('#divColonia').hide();
            $('#otraColonia').val('');

            if(e && !this.existscp)
            {
                let oka = alasql("SELECT * FROM ? where UPPER(TRIM(nombre)) = UPPER(TRIM('" + e + "'))", [this.ColoniasFull]);
                this.FormGuardar.patchValue(
                    {
                        codigopostal: oka[0].cp.toString()
                    });
            }

            this._otracol=false;            
        }
    }

    ValidarCodigoPostal(cp)
    {
        if(!cp)
        {
            return false;
        }

        var aux = cp.replace(/\_/, "");

        if(aux.length == 5)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    CambiarFacturaAutomatica(event)
    {
        this.chkchange = true;

        if(event == "NO")
        {
            this.myrfc = {id:0,esautomaticacolegiatura : "NO",esautomaticaotros : 0};
        }
    }

}
