import {AfterViewInit, Component, OnInit, Input, Output, EventEmitter, AfterContentInit, ChangeDetectorRef} from "@angular/core";
import {AppState} from "app/app.service";
import {Subject} from "rxjs/Rx";
import {FormGroup, FormControl, FormBuilder, Validators} from "@angular/forms";
import {Seguridad} from "../../../../../entity/seguridad";
import {parametrosModal} from "app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud";
import {Helpers} from "app/app.helpers";
import createNumberMask from 'text-mask-addons/dist/createNumberMask';

declare let Messenger: any;
declare let $: any;

@Component({
    selector: "dependienteseconomicos",
    templateUrl: "dependienteseconomicos.component.html",
    providers: [AppState]
})
export class DatosDependientesComponent
    implements OnInit, AfterViewInit, AfterContentInit {
    @Input()
    parametrosModal: parametrosModal;
    @Output()
    output = new EventEmitter();
    @Output()
    accionGuardar = new EventEmitter();
    seguridad: Seguridad = new Seguridad();
    accion: boolean;
    selectTienebeca: any[];
    selecsituacionConyugal: any[];
    sistema: number;
    //formulario1
    dtOptions: any = {};
    objetoestatus: any = {};
    hijosform: FormGroup;
    submitted: boolean;
    dtTrigger = new Subject();
    exportar: any;

    newhijoform: FormGroup;
    hijosfor: FormGroup;
    newhijo: boolean = false;
    newdependiente: boolean = false;
    datosgenerales: any;
    datoshijos: any;
    datosotrosdp: any;
    mostrarcampo: boolean = false;

    multihijos: {
        nombre: string;
        nivel: string;
        escuela: string;
        grado: string;
        costoanual: any;
    }[] = [];

    //mascora
    public percentMask = [/\d/, /\d/, ".", /\d/, /\d/, "%"];

    spercentMask = createNumberMask({
        prefix: '',
        suffix: '%',
        allowDecimal: true,
        integerLimit: 3,
        
    });

    //En el contructor se declara la llamada a los servicios
    constructor(private URLBase: AppState, private _httpService: AppState, private _help: Helpers, private _fb: FormBuilder, private cdr: ChangeDetectorRef) {
        this.sistema = this._httpService.sistema;
    }

    //Metodo de inicio
    ngOnInit(): void {
        $.fn.widgster.Constructor.DEFAULTS.bodySelector = ".widget-body form";
        $(".widget").widgster();
        this.dtOptions = {
            dom: "Blfrtip",
            buttons: [
                {
                    extend: "excel",
                    title: "Consultasolicitud",
                    exportOptions: {orthogonal: "sort", columns: [1, 2, 3]}
                }
            ],
            initComplete: () => {
                var botones = $(".dt-buttons").hide();
                this.exportar = function () {
                    botones.find(".buttons-excel").click();
                };
            },
            language: {url: "./assets/datatable/Spanish.json"},
            columnDefs: [{targets: [4], searchable: false, orderable: false}]
        };

        this.hijosform = this._fb.group({
            solicitudid: [, <any> Validators.required],
            nombrecompleto: [, <any> Validators.required],
            ocupacion: [, <any> Validators.required],
            relacion: [, <any> Validators.required],
            edad: [, <any> Validators.required],
            situacionconyugalid: [, <any> Validators.required]
        });

        this.newhijoform = this._fb.group({
            solicitudid: [],
            nombrecompleto: [, <any> Validators.required],
            nombreescuela: [],
            nivel: [, <any> Validators.required],
            grado: [, <any> Validators.required],
            costoanual: [, <any> Validators.required],
            tienebeca: [, <any> Validators.required],
            porcentaje: [, <any> Validators.required],
            otorgadopor: [, <any> Validators.required]
        });
        this.selectTienebeca = [{id: 1, nombre: "SI"}, {id: 0, nombre: 'NO'}];


        if  (this.sistema == 1) {

            this.newhijoform.get('nombreescuela').setValidators(null);
            this.newhijoform.get('nombreescuela').updateValueAndValidity();
            this.newhijoform.get('grado').setValidators(null);
            this.newhijoform.get('grado').updateValueAndValidity();
            this.newhijoform.get('nivel').setValidators(null);
            this.newhijoform.get('nivel').updateValueAndValidity();
            this.newhijoform.get('costoanual').setValidators(null);
            this.newhijoform.get('costoanual').updateValueAndValidity();
          }
  
          this.newhijoform.get('tienebeca').valueChanges.subscribe((tienebeca) => {
              if (tienebeca) {
                  this.mostrarcampo = true;
              } else {
                  this.mostrarcampo = false;
                  this.newhijoform.get('porcentaje').setValue(null);
                  this.newhijoform.get('otorgadopor').setValue(null);
                  this.newhijoform.get('porcentaje').setValidators(null);
                  this.newhijoform.get('otorgadopor').setValidators(null);
                  this.newhijoform.get('porcentaje').updateValueAndValidity({onlySelf: true, emitEvent: false});
                  this.newhijoform.get('otorgadopor').updateValueAndValidity({onlySelf: true, emitEvent: false});
  
              }
          });
  
          this.newhijoform.get('nombreescuela').valueChanges.subscribe((val) => {
            if (this.sistema == 1) {
              if (val != null && val != "" ||
                  this.newhijoform.get('nivel').value != null && this.newhijoform.get('nivel').value != "" ||
                  this.newhijoform.get('grado').value != null && this.newhijoform.get('grado').value != "" ||
                  this.newhijoform.get('costoanual').value != null && this.newhijoform.get('costoanual').value != ""){
  
                    this.newhijoform.get('nombreescuela').setValidators(Validators.required);
                    this.newhijoform.get('nombreescuela').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    this.newhijoform.get('grado').setValidators(Validators.required);
                    this.newhijoform.get('grado').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    this.newhijoform.get('nivel').setValidators(Validators.required);
                    this.newhijoform.get('nivel').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    this.newhijoform.get('costoanual').setValidators(Validators.required);
                    this.newhijoform.get('costoanual').updateValueAndValidity({onlySelf: true, emitEvent: false});
  
                  } else {
  
                    this.newhijoform.get('nombreescuela').setValidators(null);
                    this.newhijoform.get('nombreescuela').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    this.newhijoform.get('grado').setValidators(null);
                    this.newhijoform.get('grado').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    this.newhijoform.get('nivel').setValidators(null);
                    this.newhijoform.get('nivel').updateValueAndValidity({onlySelf: true, emitEvent: false});
                    this.newhijoform.get('costoanual').setValidators(null);
                    this.newhijoform.get('costoanual').updateValueAndValidity({onlySelf: true, emitEvent: false});
                  }
            }
        });
  
        this.newhijoform.get('grado').valueChanges.subscribe((val) => {
          if (this.sistema == 1) {
            if (val != null && val != "" ||
                this.newhijoform.get('nivel').value != null && this.newhijoform.get('nivel').value != "" ||
                this.newhijoform.get('nombreescuela').value != null && this.newhijoform.get('nombreescuela').value != "" ||
                this.newhijoform.get('costoanual').value != null && this.newhijoform.get('costoanual').value != ""){
  
                    this.newhijoform.get('costoanual').setValidators(Validators.required);
                    this.newhijoform.get('costoanual').updateValueAndValidity({onlySelf: true, emitEvent: false});
                  this.newhijoform.get('nombreescuela').setValidators(Validators.required);
                  this.newhijoform.get('nombreescuela').updateValueAndValidity({onlySelf: true, emitEvent: false});
                  this.newhijoform.get('grado').setValidators(Validators.required);
                  this.newhijoform.get('grado').updateValueAndValidity({onlySelf: true, emitEvent: false});
                  this.newhijoform.get('nivel').setValidators(Validators.required);
                  this.newhijoform.get('nivel').updateValueAndValidity({onlySelf: true, emitEvent: false});
  
                } else {
                    this.newhijoform.get('costoanual').setValidators(null);
                    this.newhijoform.get('costoanual').updateValueAndValidity({onlySelf: true, emitEvent: false});
                  this.newhijoform.get('nombreescuela').setValidators(null);
                  this.newhijoform.get('nombreescuela').updateValueAndValidity({onlySelf: true, emitEvent: false});
                  this.newhijoform.get('grado').setValidators(null);
                  this.newhijoform.get('grado').updateValueAndValidity({onlySelf: true, emitEvent: false});
                  this.newhijoform.get('nivel').setValidators(null);
                  this.newhijoform.get('nivel').updateValueAndValidity({onlySelf: true, emitEvent: false});
                }
          }
      });

      this.newhijoform.get('nivel').valueChanges.subscribe((val) => {
        if (this.sistema == 1) {
          if (val != null && val != "" ||
              this.newhijoform.get('grado').value != null && this.newhijoform.get('grado').value != "" ||
              this.newhijoform.get('nombreescuela').value != null && this.newhijoform.get('nombreescuela').value != "" ||
              this.newhijoform.get('costoanual').value != null && this.newhijoform.get('costoanual').value != ""){
  
                this.newhijoform.get('costoanual').setValidators(Validators.required);
                this.newhijoform.get('costoanual').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('nombreescuela').setValidators(Validators.required);
                this.newhijoform.get('nombreescuela').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('grado').setValidators(Validators.required);
                this.newhijoform.get('grado').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('nivel').setValidators(Validators.required);
                this.newhijoform.get('nivel').updateValueAndValidity({onlySelf: true, emitEvent: false});
  
              } else {
                this.newhijoform.get('costoanual').setValidators(null);
                this.newhijoform.get('costoanual').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('nombreescuela').setValidators(null);
                this.newhijoform.get('nombreescuela').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('grado').setValidators(null);
                this.newhijoform.get('grado').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('nivel').setValidators(null);
                this.newhijoform.get('nivel').updateValueAndValidity({onlySelf: true, emitEvent: false});
              }
        }
    });

    this.newhijoform.get('costoanual').valueChanges.subscribe((val) => {
        if (this.sistema == 1) {
          if (val != null && val != "" ||
              this.newhijoform.get('grado').value != null && this.newhijoform.get('grado').value != "" ||
              this.newhijoform.get('nombreescuela').value != null && this.newhijoform.get('nombreescuela').value != "" ||
              this.newhijoform.get('nivel').value != null && this.newhijoform.get('nivel').value != ""){
  
                this.newhijoform.get('nombreescuela').setValidators(Validators.required);
                this.newhijoform.get('nombreescuela').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('grado').setValidators(Validators.required);
                this.newhijoform.get('grado').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('nivel').setValidators(Validators.required);
                this.newhijoform.get('nivel').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('costoanual').setValidators(Validators.required);
                this.newhijoform.get('costoanual').updateValueAndValidity({onlySelf: true, emitEvent: false});
  
              } else {
  
                this.newhijoform.get('nombreescuela').setValidators(null);
                this.newhijoform.get('nombreescuela').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('grado').setValidators(null);
                this.newhijoform.get('grado').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('nivel').setValidators(null);
                this.newhijoform.get('nivel').updateValueAndValidity({onlySelf: true, emitEvent: false});
                this.newhijoform.get('costoanual').setValidators(null);
                this.newhijoform.get('costoanual').updateValueAndValidity({onlySelf: true, emitEvent: false});
              }
        }
    });

    }

    ngAfterViewInit(): void {
    }
    ngAfterContentInit() {
        this.output.next(this);
        this.dtTrigger.next();
        if (!this.parametrosModal.pestanaDependientesEconomicos.datosgenerales && !this.parametrosModal.pestanaDependientesEconomicos.datoshijos && !this.parametrosModal.pestanaDependientesEconomicos.datosotrosdp) {
            this.datosGenerales();
        } else {
            this.datosgenerales = this.parametrosModal.pestanaDependientesEconomicos.datosgenerales;
            this.datoshijos = this.parametrosModal.pestanaDependientesEconomicos.datoshijos;
            this.datosotrosdp = this.parametrosModal.pestanaDependientesEconomicos.datosotrosdp;
        }

        this.cdr.detectChanges();
    }


    /*******************seccion de control de datos de hijos*********************/
    addhijo() {
        this.submitted = false;
        this.newhijo = true;
    }

    transformartexto(forname: FormControl) {
        let texto: string = forname.value;
        if (texto) {
        forname.setValue(this.sistema == 1 ? texto.toUpperCase() : this._help.capitalize(texto));
        }
    }

    removehijo() {
        this.newhijo = false;
        this.newhijoform.reset();
        this.submitted = false;
    }

    deletehijo(c) {
        let msg = Messenger({
            extraClasses: "messenger-fixed messenger-on-top"
        }).post({
            message: `¿Está seguro que desea eliminar el registro?`,
            hideAfter: false,
            actions: {
                cancel: {
                    label: "Cancelar",
                    action: () => {
                        msg.hide();
                    }
                },
                confirm: {
                    label: "Aceptar",
                    action: () => {
                        msg.hide();
                        this._httpService.deleteElemento("Becas/SolicitudBeca/DependientesEconomicos/Hijos", c.dependienteseconomicosid).subscribe(
                            res => {
                                if (res.status == 200) {
                                    Messenger().post({
                                        message: "El registro se ha eliminado con éxito",
                                        type: "success",
                                        showCloseButton: true
                                    });
                                    this.getHijos();
                                }
                            },
                            err => {
                                //handle your error here.
                                console.log(err);
                            }
                        );
                    }
                }
            }
        });
    }
    /*******************seccion de control de datos de dependientes*********************/
    adddependiente() {
        this.submitted = false;
        this.newdependiente = true;
    }

    removedependiente() {
        this.newdependiente = false;
        this.hijosform.reset();
        this.submitted = false;
    }

    deleteDependiente(c) {
        let msg = Messenger({
            extraClasses: "messenger-fixed messenger-on-top"
        }).post({
            message: `¿Está seguro que desea eliminar el registro?`,
            hideAfter: false,
            actions: {
                cancel: {
                    label: "Cancelar",
                    action: () => {
                        msg.hide();
                    }
                },
                confirm: {
                    label: "Aceptar",
                    action: () => {
                        msg.hide();
                        this._httpService.deleteElemento("Becas/SolicitudBeca/DependientesEconomicos/Otrosdependienteseconomicos", c.otrosdependientesid).subscribe(
                            res => {
                                if (res.status == 200) {
                                    Messenger().post({
                                        message: "el registro se ha eliminado con éxito",
                                        type: "success",
                                        showCloseButton: true
                                    });
                                    this.getdependientes();
                                }
                            },
                            err => {
                                //handle your error here.
                                console.log(err);
                            }
                        );
                    }
                }

            }
        });
    }
    /********************** Servicios GET **********************/
    datosGenerales() {
        this._httpService.getElemento("Becas/SolicitudBeca/DependientesEconomicos/" + this.parametrosModal.solicitudid).subscribe(
            res => {
                if (res.status == 200) {
                    this.datosgenerales = res.body;
                    this.parametrosModal.pestanaDependientesEconomicos.datosgenerales = this.datosgenerales;
                    this.datoshijos = res.body.dependienteseconomicoshijos;
                    this.parametrosModal.pestanaDependientesEconomicos.datoshijos = this.datoshijos;
                    this.datosotrosdp = res.body.otrosdependienteseconomicos;
                    this.parametrosModal.pestanaDependientesEconomicos.datosotrosdp = this.datosotrosdp;
                    this.selecsituacionConyugal = res.body.situacionconyugal;
                }
            },
            err => {
                //handle your error here.
                console.log(err);
            }
        );
    }

    getdependientes() {
        this._httpService.getElemento("Becas/SolicitudBeca/DependientesEconomicos/ObtenerOtrosDependientes/" + this.parametrosModal.solicitudid).subscribe(
            res => {
                if (res.status == 200) {
                    this.datosotrosdp = res.body.otrosdependienteseconomicos;
                    this.parametrosModal.pestanaDependientesEconomicos.datosotrosdp = this.datosotrosdp
                }
            },
            err => {
                //handle your error here.
                console.log(err);
            }
        );
    }

    getHijos() {
        this._httpService.getElemento("Becas/SolicitudBeca/DependientesEconomicos/ObtenerHijos/" + this.parametrosModal.solicitudid).subscribe(
            res => {
                if (res.status == 200) {
                    this.datoshijos = res.body.dependienteseconomicoshijos;
                    this.parametrosModal.pestanaDependientesEconomicos.datoshijos = this.datoshijos;
                }
            },
            err => {
                //handle your error here.
                console.log(err);
            }
        );
    }
    /********************** Servicios POST **********************/
    guardarHijo() {

        if (this.sistema == 2) {
            this.newhijoform.get('porcentaje').setValidators(null);
            this.newhijoform.get('tienebeca').setValidators(null);
            this.newhijoform.get('otorgadopor').setValidators(null);
            this.newhijoform.get('porcentaje').updateValueAndValidity({onlySelf: true, emitEvent: false});
            this.newhijoform.get('tienebeca').updateValueAndValidity({onlySelf: true, emitEvent: false});
            this.newhijoform.get('otorgadopor').updateValueAndValidity({onlySelf: true, emitEvent: false});
            this.newhijoform.get("nombreescuela").setValidators(Validators.required);
            this.newhijoform.get("nombreescuela").updateValueAndValidity();
        }
        else {
            this.newhijoform.get("nombreescuela").setValidators(null);
            this.newhijoform.get("nombreescuela").updateValueAndValidity();
        }

        this.newhijoform.get("solicitudid").setValue(this.parametrosModal.solicitudid);

        this.submitted = true;
        if (this.newhijoform.invalid) {
            return false;
        }

        this._httpService.postElemento( "Becas/SolicitudBeca/DependientesEconomicos/Hijos",this.newhijoform.value,null,true
        ).subscribe(
            res => {
                if (res.status == 200) {
                    this.removehijo();
                    this.getHijos();
                    Messenger().post({
                        message: "Se ha guardado el registro con éxito",
                        type: "success",
                        showCloseButton: true
                    });
                } else {
                    Messenger().post({
                        message: "Ocurrio un error al cargar la tabla",
                        type: "success",
                        showCloseButton: true
                    });
                }
            },
            err => {
                //handle your error here.
                console.log(err);
            }
            );
    }

    guardarDependiente() {

        if (this.sistema == 2) {
            this.hijosform.get('edad').setValidators(null);
            this.hijosform.get('situacionconyugalid').setValidators(null);
            this.hijosform.get('edad').updateValueAndValidity({onlySelf: true, emitEvent: false});
            this.hijosform.get('situacionconyugalid').updateValueAndValidity({onlySelf: true, emitEvent: false});
        }


        this.hijosform.get("solicitudid").setValue(this.parametrosModal.solicitudid);

        this.submitted = true;
        if (this.hijosform.invalid) {
            return false;
        }
        this._httpService.postElemento( "Becas/SolicitudBeca/DependientesEconomicos/OtrosDependientes",this.hijosform.value,null,true).subscribe(
            res => {
                if (res.status == 200) {
                    this.removedependiente();
                    this.getdependientes();
                    Messenger().post({
                        message: "Se ha guardado el registro con éxito",
                        type: "success",
                        showCloseButton: true
                    });
                } else {
                    Messenger().post({
                        message: "Ocurrio un error al cargar la tabla",
                        type: "success",
                        showCloseButton: true
                    });
                }
            },
            err => {
                //handle your error here.
                console.log(err);
            }
            );
    }

    guardar() {
        this.accionGuardar.next(true);
    }

    Limitporcentaje (event) {
        let str = event.target.value.replace('%','');
        console.log(str);
        if (str > 100){
            this.newhijoform.get("porcentaje").setValue("100%")
        }
    }

}
