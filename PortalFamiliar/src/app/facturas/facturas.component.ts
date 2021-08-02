import {AfterViewInit, ViewEncapsulation, Component, OnInit, ViewChild} from '@angular/core';
import {AppState} from "app/app.service";
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {Subject} from 'rxjs/Rx';
import {IMyDrpOptions} from 'mydaterangepicker';
import {ElementRef} from "@angular/core";
import {forEach} from "@angular/router/src/utils/collection";
import {StorageService} from 'app/Servicios/storage.service';


declare let Messenger: any;
declare var alasql: any;


@Component({
    selector: 'Facturas',
    templateUrl: './facturas.component.html'
})
export class Facturas implements OnInit
{
    tipospersonas =
    [
        {tipopersonaid : 0, persona:"FÍSICA"},
        {tipopersonaid : 1, persona:"MORAL"}
    ];

    doctoafacturar:number=0;
    PadresOTutoresId: number = +this.storage.getItem("PadresOTutoresId");
    pago: Array<any> = [];
    arraydatosfacturacion: any [];
    arraymaster: any [];
    dtOptions1: any;
    accion:boolean = false;
    rfctemp:any=null;
    conceptosafacturar:any = {};
    myrfcid:any = null;
    dtTrigger1 = new Subject();
    seleccion:number;
    FormGuardar: FormGroup;
    existsrfc: boolean = false;
    ColoniasFull = []; 
    MunicipioFull = []; 
    EstadoFull = [];
    estado = [];
    _otracol : boolean = false;
    existscp =false;
    showconcept =false;
    submitted: boolean;
    avisoPrivacidad:string;
    sistema:string;
    facturado:boolean;
    usuarioId = this.storage.getItem('UsuarioId');
    pagofacturar: any = {};
    correoTouched:boolean = false;
    correoModificado:boolean = true;
    estadosel:any;
    ciudadsel:any;
    coloniasel:any;
    reenviar:boolean = false;
    usocfdi:Array<any> = [];
    usocfdifactura:Array<any> = [];
    usocfdisel = null;
    alumnospeg:Array<any> = [];
    diasfacturar:string;
    nuevoRFC:boolean= false;

    filtroFactura:string = "-1";
    filtroFecha:any;

    myDateRangePickerOptions: IMyDrpOptions;
    meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre","Octubre", "Noviembre", "Diciembre"];

    correoenvio:Array<string> = ['gabriel@gmail.com', 'diana@gmail.com', 'ricardomredrano@gmail.com', 'ricardomedranoherrejondneilricardomedranoherrejondneil@gmail.com'];
    correoaux:string = "";

    estilo =
        {
            nuevaEntrada: {}
        };

    @ViewChild('amRegla') amRegla: ElementRef;
    @ViewChild('correoInput') amNuevaEntrada: ElementRef;

    //Mascaras
    public maskCP = [ /\d/,/\d/,/\d/,/\d/, /\d/];

    //Modal
    @ViewChild('modalFactura') modalFactura: ModalDirective;
    constructor(private _httpService: AppState, private _fb: FormBuilder, private storage: StorageService)
    {
        this.avisoPrivacidad = _httpService.avisoPrivacidad;
        //this.sistema = _httpService.sistema == 1 ?  'lux' : _httpService.sistema == 2 ? 'ciencias' : '';
        this.sistema = 'ciencias';
    }
    //Metodo de inicio
    ngOnInit(): void
    {
        this.arraydatosfacturacion=[];
        this.arraymaster=[];
        this.seleccion=1;
        this.FormGuardar = this._fb.group(
        {
                padresotutoresfacturacionid: null,
                padresotutoresdomicilioid: null,
                padresotutoresid: this.PadresOTutoresId,
                rfc: [, [<any> Validators.required, <any> Validators.maxLength(13),Validators.pattern(/^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/)]],
                tipopersonaid: [, [<any> Validators.required, <any> Validators.maxLength(1)]],
                razonsocial : [{value:null, disabled:true}, [<any> Validators.required, <any> Validators.maxLength(200)]],
                correo : [{value:null, disabled:true}, [<any> Validators.required, <any> Validators.maxLength(300),Validators.pattern(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)]],
                codigopostal:[{value:null, disabled:true}, [<any> Validators.required, <any> Validators.maxLength(5), Validators.pattern(/^[0-9]{5}$/)]],
                colonia:null,
                otracolonia:null,
                ciudad:null,
                estado:null,
                calle:[{value:null, disabled:true}],
                numeroexterior:[{value:null, disabled:true}],
                numerointerior:[{value:null, disabled:true}],
                esautomaticacolegiatura : 0,
                esautomaticaotros : 0,
                usocfdiid:[null, [<any> Validators.required]],
                sistema: this._httpService.sistema
        });

        this.dtOptions1 =
        {
            dom: '',
            language: {url: "./assets/datatable/Spanish.json"},
            columnDefs:
            [
                {"targets": [0], "searchable": true, "orderable": true},
                {"targets": [1], "searchable": true, "orderable": true},
                {"targets": [2], "searchable": true, "orderable": true},
                {"targets": [3], "searchable": true, "orderable": true},
                {"targets": [4], "searchable": true, "orderable": true},
                {"targets": [5], "searchable": true, "orderable": true},
                {"targets": [6], "searchable": false, "orderable": false},

            ]
        };


        var hoy = new Date();

        this.filtroFecha =
        {
            beginDate: {year: hoy.getFullYear(), month: (hoy.getMonth() + 1), day: 1},
            endDate:{year: hoy.getFullYear(), month: (hoy.getMonth() + 1), day: hoy.getDate()}
        };


        hoy.setDate(hoy.getDate() + 1);
        this.myDateRangePickerOptions =
        {
            dateFormat: 'dd-mmm-yyyy',
            disableSince: {year: hoy.getFullYear(), month: (hoy.getMonth() + 1), day: hoy.getDate()},
            openSelectorOnInputClick: true,
        };

        this.LoadEstados();
    }
    //Metodo inicial
    ngAfterViewInit(): void
    {
        this.getPagados(this.PadresOTutoresId);
        this.GetDatosIniciales(this.PadresOTutoresId);
    }

    getPagados(id:number)
    {
        this._httpService.getElemento('portalfamiliar/facturacion/' + id + '/1').subscribe
        (
            result =>
            {
                if (result.status == 200)
                {
                    this.arraymaster =result.body;

                    for(var pago of this.arraymaster )
                    {
                        pago.subtotal = parseFloat(pago.subtotal );
                        pago.intereses = parseFloat(pago.intereses );
                        pago.importe = parseFloat(pago.importe );
                        pago.descuento = parseFloat(pago.descuento );
                    }

                    this.FiltrarFactura();
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
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );        
    }

    //Accion de busqueda de registros
    getDatosFacturacion(id:number)
    {
        this._httpService.getElemento('portalfamiliar/datosfacturacion/' + id).subscribe
        (
            result =>
            {
                if (result.status == 200)
                {
                    this.arraydatosfacturacion = result.body;
                    //this.arraydatosfacturacion.push({"rfc":"OTRO","cp":0,"padresotutoresfacturacionid":-1});
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
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    //Obtiene los datos iniciales para la facturación (alumnos con peg, dáas para facturar, datos de facturación y uso cfdi )
    GetDatosIniciales(id:number)
    {
        this._httpService.getElemento('portalfamiliar/facturacion/datos?padresotutoresid=' + id).subscribe
        (
            result =>
            {
                if (result.status == 200)
                {
                    //uso CFDI
                    this.usocfdi = result.body.UsoCfdi;

                    //Dato de facturación
                    this.arraydatosfacturacion = result.body.DatosFacturacion;
                    //this.arraydatosfacturacion.push({"rfc":"OTRO","cp":0,"padresotutoresfacturacionid":-1});

                    //alumnos PEG
                    this.alumnospeg = result.body.PEG;

                    //días para facturar
                    this.diasfacturar = result.body.DiasFacturar;
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
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    getDatosFacturacion2(id:number, factura)
    {
        this._httpService.getElemento('portalfamiliar/datosfacturacion/' + id).subscribe
        (
            result =>
            {
                if (result.status == 200)
                {
                    this.arraydatosfacturacion = result.body;
                    //this.arraydatosfacturacion.push({"rfc":"OTRO","cp":0,"padresotutoresfacturacionid":-1});

                    let domicilio = this.arraydatosfacturacion.filter(x => x.padresotutoresfacturacionid == factura);

                    if(domicilio)
                    {
                        this.FormGuardar.patchValue(
                        {
                            padresotutoresdomicilioid: domicilio[0].padresotutoresdomicilioid
                        });
                    }
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
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    SelectRFC(e:any)
    {
        this.submitted = false;

        if(e == -1)
        {
            this.myrfcid = -1;
        }

        if(e)
        {
            let oka  = alasql("SELECT * FROM ? where padresotutoresfacturacionid =" + e, [this.arraydatosfacturacion]);

            let usocfdi = this.FormGuardar.get('usocfdiid').value;

            //Colocamos los valores del registro en el formulario para mostarra al abrir la modal
            if (oka.length > 0)
            {
                this.existsrfc = true;
                this.existscp = false;
                this._otracol = false;
                this.rfctemp = oka[0].rfc;


                this.FormGuardar.setValue(
                {
                    padresotutoresfacturacionid: oka[0].padresotutoresfacturacionid,
                    padresotutoresdomicilioid: oka[0].padresotutoresdomicilioid,
                    padresotutoresid: oka[0].padresotutoresid,
                    rfc: oka[0].rfc,
                    tipopersonaid: oka[0].tipopersonaid,
                    razonsocial: oka[0].razonsocial,
                    correo: oka[0].correo,
                    esautomaticacolegiatura: oka[0].esautomaticacolegiatura,
                    esautomaticaotros: oka[0].esautomaticaotros,
                    codigopostal: oka[0].codigopostal,
                    colonia: null,
                    otracolonia: null,
                    ciudad: oka[0].ciudad ? oka[0].ciudad  : '',
                    estado: oka[0].estado ? oka[0].estado : '',
                    calle: oka[0].calle ? oka[0].calle : '',
                    numeroexterior: oka[0].numeroexterior,
                    numerointerior: oka[0].numerointerior,
                    usocfdiid: usocfdi,
                    sistema: this._httpService.sistema
                 });

                this.accion = true;

                if (this.sistema != 'ciencias')
                {
                    this.busquedaPorCp2(oka[0].codigopostal, oka[0].colonia, oka[0]);

                    this.estadosel = oka[0].estado;
                    this.ciudadsel = oka[0].ciudad;
                    this.coloniasel = oka[0].colonia;
                }

                if(this.sistema == 'lux')
                {
                    this.SetTipoPersonaRFC(oka[0].rfc);
                }
                else if(this.sistema == 'ciencias')
                {
                    this.SetTipoPersonaRFC(oka[0].rfc);
                }
            }
            else //No existe
            {
                this.existsrfc = false;
                this.existscp = false;
                this._otracol = false;
                this.rfctemp = null;
                this.FormGuardar.reset();
                this.FormGuardar.get('codigopostal').setValue('');

                this.FormGuardar.patchValue(
         {
                    padresotutoresid: this.PadresOTutoresId,
                    sistema: this._httpService.sistema,
                });

                if (this.sistema != 'ciencias')
                {
                    this.estadosel = null;
                    this.ciudadsel = null;
                    this.coloniasel = null;

                    this.estado = this.EstadoFull.slice(0);
                    this.MunicipioFull = [];
                    this.ColoniasFull = [];
                }

                this.CambiarTipoPersona(null);
            }

            this.FormGuardar.get('rfc').enable();
            this.FormGuardar.get('razonsocial').enable();
            this.FormGuardar.get('correo').enable();
            this.FormGuardar.get('codigopostal').enable();
            this.FormGuardar.get('calle').enable();
            this.FormGuardar.get('numeroexterior').enable();
            this.FormGuardar.get('numerointerior').enable();
        }
        else //Limpiar select
        {
            this.FormGuardar.get('razonsocial').disable();
            this.FormGuardar.get('correo').disable();
            this.FormGuardar.get('codigopostal').disable();
            this.FormGuardar.get('calle').disable();
            this.FormGuardar.get('numeroexterior').disable();
            this.FormGuardar.get('numerointerior').disable();

            this.FormGuardar.get('codigopostal').setValue('');

            this.existsrfc = true;
            this._otracol = false;
            this.rfctemp = null;
            this.FormGuardar.reset();

            this.estadosel = null;
            this.ciudadsel = null;
            this.coloniasel = null;
            this.CambiarTipoPersona(null);
        }
    }

    generarFactura(pago)
    {
        if(pago.facturahabilitada == "0")
        {
            this.FacturacionInvalida();
            return;
        }

        this.nuevoRFC = false;
        this.facturado = false;
        this.accion=false;
        this.existsrfc = true;
        this.pagofacturar = pago;
        this.correoenvio = [];
        this.correoModificado = false;
        this.modalFactura.show();
    }

    FacturacionInvalida()
    {
        Messenger().post({
            message: "Los pagos realizados con cheque tienen un periodo de espera de 72 horas para poder ser facturados.",
            type: 'success',
            showCloseButton: true
        });
    }

    cerrar()
    {
        this.existsrfc = false;
        this.showconcept=false;
        this.accion=false;
        this.myrfcid = null;
        this.submitted = false;
        this.reenviar = false;
        this.usocfdisel = null;

        this.FormGuardar.reset();
        this.modalFactura.hide();

        this.FormGuardar.get('razonsocial').disable();
        this.FormGuardar.get('correo').disable();
        this.FormGuardar.get('codigopostal').disable();
        this.FormGuardar.get('calle').disable();
        this.FormGuardar.get('numeroexterior').disable();
        this.FormGuardar.get('numerointerior').disable();

        this.FormGuardar.get('codigopostal').setValue('');
    }

    facturar()
    {
        if(!this.showconcept)
        {
            this.submitted = true;

            this.ajusarDimensionesNuevaEntrada();
            this.LimpiarFormulario();

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

            this.pagofacturar.rfc = this.FormGuardar.get('rfc').value;
            this.pagofacturar.nombre = this.FormGuardar.get('razonsocial').value;


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
                {
                    return false;
                }

            //Verificamos si el formulario trae un id.
            if (!this.FormGuardar.get('padresotutoresfacturacionid').value) //agregar
            {
                //No tiene Id: Es un nuevo registro--- POST
                //Llamada al servicio post para insertar un nuevo elemento
                this._httpService.postElemento('portalfamiliar/datosfacturacion', this.FormGuardar.value).subscribe(
                    result =>
                    {
                        if (result.status == 200)
                        {
                            this.showconcept = true;
                            this.existsrfc = true;
                            this.getDatosFacturacion2(this.PadresOTutoresId, result.body);
                            this.myrfcid = result.body;
                            this.conceptosafacturar.rfc = this.FormGuardar.get('rfc').value.toUpperCase();
                            this.conceptosafacturar.nombre = this.FormGuardar.get('razonsocial').value.toUpperCase();

                            if(!this.correoModificado)
                            {
                                this.correoenvio = [];
                                this.correoenvio.push(this.FormGuardar.get('correo').value);
                            }

                            this.FormGuardar.patchValue(
                            {
                                padresotutoresfacturacionid: result.body
                            });
                        }
                    },
                    error =>
                    {
                        var errorMessage = <any> error;
                        Messenger().post({
                            message: 'No se pudo comunicar con el servidor',
                            type: 'error',
                            showCloseButton: true
                        });
                    }
                );
            }
            else //editar
            {
                this.FormGuardar.get('rfc').enable();
                //Si tiene Id: Es un registro existente y se va a editar: PUT
                //Llamada al servicio put para actualizar un elemento
                this._httpService.putElemento('portalfamiliar/datosfacturacion' , this.FormGuardar.value).subscribe(
                    result => {
                        if (result.status == 200)
                        {
                            this.showconcept=true;
                            this.conceptosafacturar.rfc = this.FormGuardar.get('rfc').value.toUpperCase();
                            this.conceptosafacturar.nombre = this.FormGuardar.get('razonsocial').value.toUpperCase();

                            this.getDatosFacturacion(this.PadresOTutoresId);

                            if(!this.correoModificado)
                            {
                                this.correoenvio = [];
                                this.correoenvio.push(this.FormGuardar.get('correo').value);
                            }
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
        else //guardar los datos para que se pueda generar la factura
        {
            if (this.correoenvio.length < 1)
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

            let datos = this.SetDatosFacturas(this.FormGuardar.value, this.correoenvio, this.pagofacturar);

            this._httpService.postElemento('portalfamiliar/facturacion', datos).subscribe(
                result =>
                {
                    if (result.status == 200)
                    {
                        this.getPagados(this.PadresOTutoresId);
                        this.getDatosFacturacion(this.PadresOTutoresId);

                        this.facturado = true;
                    }
                },
                error =>
                {
                    var errorMessage = <any> error;

                    Messenger().post({
                        message: 'No se pudo comunicar con el servidor',
                        type: 'error',
                        showCloseButton: true
                    });
                }
            );

        }
    }
    
    SetDatosFacturas(datos, correo, pago)
    {
        let dato:any = {};

        dato.correoenvio = correo;

        dato.usuarioid = this.storage.getItem("UsuarioId");
        dato.padresotutoresid = this.PadresOTutoresId;

        dato.pagoid = pago.pagoid;
        dato.importe = pago.importe;

        dato.rfc = datos.rfc;
        dato.razonsocial = datos.razonsocial;
        dato.correo = datos.correo;
        dato.usocfdiid = datos.usocfdiid;

        dato.codigopostal = datos.codigopostal;
        dato.calle = datos.calle;
        dato.numeroexterior = datos.numeroexterior;
        dato.numerointerior = datos.numerointerior;
        dato.estado = datos.estado;

        dato.colonia = this._otracol ? datos.otracolonia : datos.colonia;

        let ciudad = this.MunicipioFull.filter(x => x.municipioid == datos.ciudad);
        if(ciudad[0])
        {
            dato.ciudad = ciudad[0].nombre;
        }

        switch(pago.concepto)
        {
            case 'COLEGIATURA':
                dato.tipofactura = 0;
                break;

            case 'INSCRIPCIÓN':
                dato.tipofactura = 1;
                break;

            case 'PAGOS DIVERSOS':
                dato.tipofactura = 2;
                break;

            default:
                dato.tipofactura = null;
                break;
        }

        return dato;
    }


    LimpiarFormulario()
    {
        //Quitar valores no obligatorios

        //número interior
        this.FormGuardar.get('numerointerior').setValidators(null);
        this.FormGuardar.get('numerointerior').updateValueAndValidity();

        if(!this._otracol)
        {
            this.FormGuardar.get('otracolonia').setValidators(null);
            this.FormGuardar.get('otracolonia').updateValueAndValidity();
        }
        else
        {
            this.FormGuardar.get('otracolonia').setValidators(<any>Validators.required);
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

            //otra colonia
            this.FormGuardar.get('otracolonia').setValidators(null);
            this.FormGuardar.get('otracolonia').updateValueAndValidity();
        }
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


                        for(let colonia of this.ColoniasFull)
                        {
                            colonia.nombre = colonia.nombre.toUpperCase();
                        }

                        if(this.ValidarCodigoPostal(this.FormGuardar.get('codigopostal').value))
                        {
                            this.ColoniasFull.push({"nombre": "OTRA", "cp": 0, "coloniaid": -1});
                        }


                        let oka = alasql("SELECT * FROM ? where nombre = TRIM('" + f + "')", [this.ColoniasFull]);

                        if(oka.length <=0)
                        {
                            //this.ColoniasFull.push({"nombre":f,"cp":this.FormGuardar.get('codigopostal').value,"coloniaid":-2});
                            this.FormGuardar.get('colonia').setValue('OTRA');
                            this.FormGuardar.get('otracolonia').setValue(f);

                            $('#divColonia').show();
                            this._otracol=true;
                        }
                        else
                        {
                            this.FormGuardar.get('colonia').setValue(f);
                            this._otracol=false;
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

                    //console.log(this.FormGuardar.value);
                    //console.log(this.coloniasel);
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

        if (e && !this.existscp)
        {
            this._httpService.getElemento('Ciudad/'+ e).subscribe(
            result =>
            {
                if (result.status == 200)
                {
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

        if (e && !this.existscp)
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

            this.FormGuardar.get('otracolonia').setValue(null);

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


    //Filtros
    FiltrarFactura()
    {
        this.pago=[];

        switch(parseInt(this.filtroFactura))
        {
            case -1:  //movimientos pendientes de facturar

                this.pago = this.arraymaster.filter((x) =>
                {
                    if(!x.facturaid || x.facturaestatusid == 1 || x.facturaestatusid == 3 || x.facturaestatusid == 4)  //1: pendiente, 3: cancelada, 4: Cancelada por error
                    {
                        return x;
                    }
                });

                break;

            case 0:  //movimientos facturados
                this.pago = this.arraymaster.filter((x) =>
                {
                    if(x.facturaid &&  (x.facturaestatusid == 2 || x.facturaestatusid == 5))//2: enviada, 4: reenviar
                    {
                        return x;
                    }
                });

                if(this.filtroFecha)
                {
                    if (this.filtroFecha.beginDate && this.filtroFecha.endDate)
                    {
                        let inicio, fin;

                        let mesi = this.filtroFecha.beginDate.month < 10 ? "0" + this.filtroFecha.beginDate.month : this.filtroFecha.beginDate.month;
                        let diai = this.filtroFecha.beginDate.day < 10 ? "0" + this.filtroFecha.beginDate.day : this.filtroFecha.beginDate.day;

                        let mesf = this.filtroFecha.endDate.month < 10 ? "0" + this.filtroFecha.endDate.month : this.filtroFecha.endDate.month;
                        let diaf = this.filtroFecha.endDate.day < 10 ? "0" + this.filtroFecha.endDate.day : this.filtroFecha.endDate.day;

                        inicio = this.filtroFecha.beginDate.year + "-" + mesi + "-" + diai;
                        fin = this.filtroFecha.endDate.year + "-" + mesf + "-" + diaf;

                        this.pago = this.pago.filter(function (docto)
                        {
                            return (docto.fecha >= inicio && docto.fecha <= fin);
                        });
                    }
                }
                break;

            default:
                this.pago = this.arraymaster;
                break;
        }

        if(this.pago.length > 10)
        {
            this.dtOptions1.dom  = "frtp";
            this.dtOptions1.sDom  = "frtp";
        }
        else
        {
            this.dtOptions1.dom = "";
            this.dtOptions1.sDom = "";
        }

        (<any>$("#tablaFactura")).dataTable().fnDestroy();
        this.dtTrigger1.next();
    }

    //ReenviarFactura
    ReenviarFactura(pago)
    {
        let factura = {facturaid:pago.facturaid};
        this._httpService.putElemento('portalfamiliar/factura/reenviar', factura).subscribe(
        result =>
        {
            if (result.status == 200)
            {
                pago.facturaestatusid = 5;
                pago.facturaestatus = 'REENVIAR';

                this.showconcept = true;
                this.facturado = true;
                this.reenviar = true;
                this.modalFactura.show();
            }
            else
            {
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
            Messenger().post({
                message: 'No se pudo comunicar con el servidor',
                type: 'error',
                showCloseButton: true
            });
        });
    }

    //------------- Correo ---------------
    AgregarCorreo(evento)
    {
        this.correoTouched = true;

        if(this.correoaux[this.correoaux.length - 1] == "," || this.correoaux[this.correoaux.length - 1] == " ")
        {
            this.correoaux = this.correoaux.slice(0, -1);
        }

        if(evento.code == "Tab")
        {
            document.getElementById('correoInput').focus();
        }

        let erCorreo = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        let correoValid = this.correoaux ? this.correoaux.match(erCorreo) : false;

        setTimeout(() =>
        {
            this.ValidarCorreoEntrada(this.correoaux);
        }, 1);

        if (!correoValid)
        {
            return;
        }
        else
        {
            let agregado = false;
            for(let c of this.correoenvio)
            {
                if(c.toLowerCase() == this.correoaux.toLocaleLowerCase())
                {
                    agregado = true;
                }
            }
            if(!agregado)
            {
                this.correoenvio.push(this.correoaux.toLowerCase());
            }

            this.correoaux = "";
            this.ajusarDimensionesNuevaEntrada();
            this.correoTouched = false;
        }


    }

    ValidarCorreoEntrada(entrada)
    {
        if(entrada[entrada.length - 1] == "," || entrada[entrada.length - 1] == " ")
        {
            entrada = entrada.slice(0, -1);
        }

        this.correoaux = entrada;

        this.ajusarDimensionesNuevaEntrada();
    }

    ValidarCorreo()
    {
        let erCorreo = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        let correoValid = this.correoaux ? this.correoaux.match(erCorreo) : false;

        if(!correoValid && this.correoaux && this.correoTouched)
        {
            return false;
        }

        return true;
    }

    ajusarDimensionesNuevaEntrada()
    {

        this.amRegla.nativeElement.innerHTML = this.amNuevaEntrada.nativeElement.value;

        let ancho = (this.amRegla.nativeElement.offsetWidth) ? this.amRegla.nativeElement.offsetWidth + 8 : 4;

        this.estilo.nuevaEntrada = {
            'width': ancho + 'px'
        };

        this.amRegla.nativeElement.innerHTML = "";

    }

    CambiarTipoPersona(tipopersona)
    {
        this.FormGuardar.get('usocfdiid').setValue(null);

        if(!tipopersona && tipopersona != 0)
        {
            this.FormGuardar.get('usocfdiid').setValue(null);
            this.FormGuardar.get('tipopersonaid').setValue(null);
            this.usocfdifactura = [];
            return;
        }

        if (tipopersona == 0) //física
        {
            this.FormGuardar.get('usocfdiid').setValue(21); //G03 -- GASTOS EN GENERAL
            this.FormGuardar.get('tipopersonaid').setValue(tipopersona); //G03 -- GASTOS EN GENERAL
        }
        else if (tipopersona == 1) //moral
        {
            this.FormGuardar.get('usocfdiid').setValue(3); //G03 -- GASTOS EN GENERAL
            this.FormGuardar.get('tipopersonaid').setValue(tipopersona); //G03 -- GASTOS EN GENERAL
        }
    }

    SetTipoPersonaRFC(rfc)
    {
        let pattern = /^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/;

        if(pattern.test(rfc))
        {
            if(rfc.length == 12)
            {
                this.CambiarTipoPersona(1);
            }
            else if(rfc.length == 13)
            {
                this.CambiarTipoPersona(0);
            }
        }
        else
        {
            this.CambiarTipoPersona(null);
        }
    }

    ValidarTipoPerosna()
    {
        if(this.sistema == 'lux')
        {
            return this.FormGuardar.get('tipopersonaid').valid;
        }
        else if(this.sistema == 'ciencias')
        {
            let pattern = /^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/;

            return pattern.test(this.FormGuardar.get('rfc').value);
        }
    }

    GetUsuCFDISeleccionado(Id)
    {
        let uso = this.usocfdi.filter(p => p.usocfdiid == Id);

        return uso.length > 0 ? uso[0].descripcion : '';
    }

}