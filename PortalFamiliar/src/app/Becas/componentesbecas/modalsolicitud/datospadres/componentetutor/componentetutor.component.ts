import {PadreoTutorModel} from './../../../../../../entity/Models/PadreoTutorModel';
import {AfterViewInit, ViewEncapsulation, Component, Input, Output, ViewChild, AfterContentInit, ChangeDetectorRef} from "@angular/core";
import {AppState} from "../../../../../app.service";
import {ModalDirective} from "ng2-bootstrap/modal";
import {FormGroup, FormControl, FormBuilder, Validators} from "@angular/forms";
import {Helpers} from "app/app.helpers";
import {parametrosModal} from "app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud";
import {DatosPadresComponent} from "app/Becas/componentesbecas/modalsolicitud/datospadres/datospadres.component"
import {NgForm} from "@angular/forms";

declare let Messenger: any;
declare let $: any;
declare var alasql: any;
declare let Pace: any;

import createNumberMask from 'text-mask-addons/dist/createNumberMask';

@Component({
    selector: "componentetutor",
    templateUrl: "componentetutor.component.html",
    encapsulation: ViewEncapsulation.None
})

export class Componentetutor implements AfterViewInit, AfterContentInit {
    @Input() submitted: boolean;
    @Input() selectParentesco: any[];
    //-- Datos de un padre
    @Input() DatosPadres: FormGroup;
    @Input() cambio: boolean;
    //Selece de estado civil
    @Input() estadocivil: Array<any>;
    @Input() escolaridad: Array<any>;
    @Input() index: any;
    parametros: parametrosModal;
    lada1: any;
    @Input() lada2: any;
    padres: any;
    selectOpciones: any[];

    school: [{escolaridadid: 1, nombre: "primaria"}, {escolaridadid: 2, nombre: "secundaria"}]

    @ViewChild('formapadre') forma: NgForm;

    //variable para identificar el sistema; 1 = lux, 2 = ciencias
    sistema: number;
    unamePattern: any;
    unamePattern2: any;
    numberMaskNoComma = createNumberMask({
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

    @ViewChild("modalbeca")
    public modalbeca: ModalDirective;

    // En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private _fb: FormBuilder, private _help: Helpers, public datopadre: DatosPadresComponent, private _cdRef: ChangeDetectorRef) {
        this.sistema = this._httpService.sistema;
    }

    // Metodo de inicio
    ngOnInit(): void {
        this.padres = this.DatosPadres.value;
        this.parametros = this.parametros;
        if (this.DatosPadres.get("disabled").value) {
            this.DatosPadres.get("nombre").disable();

        } else {
            this.DatosPadres.get("vive").disable();
        }
        this.selectOpciones = [{id: true, nombre: "SI"}, {id: false, nombre: "NO"}];

    }

    ngAfterViewInit() {

        if (this.padres.parentesco) {
            this.DatosPadres.get("parentescoid").setValidators(null);
            this.DatosPadres.get("parentescoid").updateValueAndValidity();
        }
        
        if (this.sistema==2){
            this.DatosPadres.get('fechanacimiento').setValidators(null);
             this.DatosPadres.get("fechanacimiento").updateValueAndValidity();
        }
        this.DatosPadres.get("empresa").setValidators(null);
        this.DatosPadres.get("empresa").updateValueAndValidity();
        this.DatosPadres.get("telempresatemp").setValidators(null);
        this.DatosPadres.get("telempresatemp").updateValueAndValidity();
        this.DatosPadres.get("ramo").setValidators(null);
        this.DatosPadres.get("ramo").updateValueAndValidity();
        this.DatosPadres.get("horariotrabajo").setValidators(null);
        this.DatosPadres.get("horariotrabajo").updateValueAndValidity();
        this.DatosPadres.get("ramo").setValidators(null);
        this.DatosPadres.get("ramo").updateValueAndValidity();
        this.DatosPadres.get("antiguedad").setValidators(null);
        this.DatosPadres.get("antiguedad").updateValueAndValidity();
        this.DatosPadres.get("ladatelempresa").setValidators(null);
        this.DatosPadres.get("ladatelempresa").updateValueAndValidity();
        this.DatosPadres.get("telempresa").setValidators(null);
        this.DatosPadres.get("telempresa").updateValueAndValidity();
        this.DatosPadres.get("domicilioempresa").setValidators(null);
        this.DatosPadres.get("domicilioempresa").updateValueAndValidity();
        this.DatosPadres.get("escolaridadid").setValidators(null);
        this.DatosPadres.get("escolaridadid").updateValueAndValidity();
        this.DatosPadres.get("especificacionocupacion").setValidators(null);
        this.DatosPadres.get("especificacionocupacion").updateValueAndValidity();
        this.DatosPadres.get("extensionempresa").setValidators(null);
        this.DatosPadres.get("extensionempresa").updateValueAndValidity();
        this.DatosPadres.get("nombrejefeinmediato").setValidators(null);
        this.DatosPadres.get("nombrejefeinmediato").updateValueAndValidity();
        this.DatosPadres.get("ocupacion").setValidators(null);
        this.DatosPadres.get("ocupacion").updateValueAndValidity();
        this.DatosPadres.get("vive").setValidators(Validators.required);
        this.DatosPadres.get("vive").updateValueAndValidity();
        //
        if (!this.DatosPadres.get("vive").value) {
            this.DatosPadres.get("ladacelular").setValidators(null);
            this.DatosPadres.get("ladacelular").updateValueAndValidity({emitEvent: false});
            this.DatosPadres.get("celtemp").setValidators(null);
            this.DatosPadres.get("celtemp").updateValueAndValidity({emitEvent: false});
            this.DatosPadres.get("situacionconyugalid").setValidators(null);
            this.DatosPadres.get("situacionconyugalid").updateValueAndValidity();
        } else {
            this.DatosPadres.get("situacionconyugalid").setValidators(Validators.required);
            this.DatosPadres.get("situacionconyugalid").updateValueAndValidity();
            this.DatosPadres.get('ladacelular').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
            this.DatosPadres.get('ladacelular').updateValueAndValidity({emitEvent: false});

            if (this.DatosPadres.get("ladacelular").value) {
                var p;
                if (this.DatosPadres.get("ladacelular").value.length == 4) {
                    p = '\\d{4}.\\d{4}';
                } else if (this.DatosPadres.get("ladacelular").value.length == 5) {
                    p = '\\d{3}.\\d{4}';
                } else {
                    p = '\\d{10}.\\d{10}';
                }
                this.DatosPadres.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                this.DatosPadres.get('celtemp').updateValueAndValidity({emitEvent: false});
            } else {
                p = '\\d{10}.\\d{10}';
                this.DatosPadres.get('celtemp').setValidators([Validators.required, Validators.pattern(p)]);
                this.DatosPadres.get('celtemp').updateValueAndValidity({emitEvent: false});
            }
        }

        if (this.DatosPadres.get("vive").value && this.sistema == 1) {
            this.DatosPadres.get("ocupacion").setValidators(Validators.required);
            this.DatosPadres.get("ocupacion").updateValueAndValidity();
            this.DatosPadres.get("horariotrabajo").setValidators(null);
            this.DatosPadres.get("horariotrabajo").updateValueAndValidity();
        }



        if (this.DatosPadres.get("ocupacion").value == "Económicamente activo" && this.DatosPadres.get("vive").value && this.sistema == 1 || (this.DatosPadres.get("vive").value && this.sistema == 2)) {
            this.DatosPadres.get("especificacionocupacion").setValidators(Validators.required);
            this.DatosPadres.get("especificacionocupacion").updateValueAndValidity();
            this.DatosPadres.get("ramo").setValidators(Validators.required);
            this.DatosPadres.get("ramo").updateValueAndValidity();
            this.DatosPadres.get("empresa").setValidators(Validators.required);
            this.DatosPadres.get("empresa").updateValueAndValidity();
            if (this.sistema == 1) {
                this.DatosPadres.get("horariotrabajo").setValidators(null);
                this.DatosPadres.get("horariotrabajo").updateValueAndValidity();
            } else {
                this.DatosPadres.get("horariotrabajo").setValidators(Validators.required);
                this.DatosPadres.get("horariotrabajo").updateValueAndValidity();
            }

            this.DatosPadres.get("antiguedad").setValidators(Validators.required);
            this.DatosPadres.get("antiguedad").updateValueAndValidity();

            this.DatosPadres.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
            this.DatosPadres.get('ladatelempresa').updateValueAndValidity({emitEvent: false});

            if (this.DatosPadres.get("ladatelempresa").value) {
                var p;
                if (this.DatosPadres.get("ladatelempresa").value.length == 4) {
                    p = '\\d{4}.\\d{4}';
                } else if (this.DatosPadres.get("ladatelempresa").value.length == 5) {
                    p = '\\d{3}.\\d{4}';
                } else {
                    p = '\\d{10}.\\d{10}';
                }
                this.DatosPadres.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                this.DatosPadres.get('telempresatemp').updateValueAndValidity({emitEvent: false});
            } else {
                p = '\\d{10}.\\d{10}';
                this.DatosPadres.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                this.DatosPadres.get('telempresatemp').updateValueAndValidity({emitEvent: false});
            }
        } else if (this.DatosPadres.get("ocupacion").value == "Económicamente activo" && this.sistema == 1 && this.DatosPadres.get("vive").value || this.DatosPadres.get("vive").value && this.sistema == 2) {

            this.DatosPadres.get('ladatelempresa').setValidators([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))]);
            this.DatosPadres.get('ladatelempresa').updateValueAndValidity({emitEvent: false});

            this.DatosPadres.get('extensionempresa').setValidators(Validators.required);
            this.DatosPadres.get('extensionempresa').updateValueAndValidity({emitEvent: false});

            if (this.DatosPadres.get("ladatelempresa").value) {
                var p;
                if (this.DatosPadres.get("ladatelempresa").value.length == 4) {
                    p = '\\d{4}.\\d{4}';
                } else if (this.DatosPadres.get("ladatelempresa").value.length == 5) {
                    p = '\\d{3}.\\d{4}';
                } else {
                    p = '\\d{10}.\\d{10}';
                }
                this.DatosPadres.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                this.DatosPadres.get('telempresatemp').updateValueAndValidity({emitEvent: false});
            } else {
                p = '\\d{10}.\\d{10}';
                this.DatosPadres.get('telempresatemp').setValidators([Validators.required, Validators.pattern(p)]);
                this.DatosPadres.get('telempresatemp').updateValueAndValidity({emitEvent: false});
            }
        }

        if (this.DatosPadres.get("ocupacion").value == "Económicamente activo") {
            if (this.sistema == 1 && this.DatosPadres.get("vive").value) {
                this.DatosPadres.get("extensionempresa").setValidators(Validators.required);
                this.DatosPadres.get("extensionempresa").updateValueAndValidity();
                this.DatosPadres.get("nombrejefeinmediato").setValidators(Validators.required);
                this.DatosPadres.get("nombrejefeinmediato").updateValueAndValidity();
                this.DatosPadres.get("domicilioempresa").setValidators(Validators.required);
                this.DatosPadres.get("domicilioempresa").updateValueAndValidity();
                this.DatosPadres.get("escolaridadid").setValidators(Validators.required);
                this.DatosPadres.get("escolaridadid").updateValueAndValidity();
                this.DatosPadres.get("ladatelempresa").setValidators(Validators.required);
                this.DatosPadres.get("ladatelempresa").updateValueAndValidity({emitEvent: false});
                this.DatosPadres.get("telempresa").setValidators(Validators.required);
                this.DatosPadres.get("telempresa").updateValueAndValidity({emitEvent: false});
            }

        }

        if (this.sistema == 2) {
            this.DatosPadres.get("ladatelempresa").setValidators(null);
            this.DatosPadres.get("ladatelempresa").updateValueAndValidity({emitEvent: false});
            this.DatosPadres.get("telempresatemp").setValidators(null);
            this.DatosPadres.get("telempresatemp").updateValueAndValidity({emitEvent: false});
            this.DatosPadres.get("ramo").setValidators(null);
            this.DatosPadres.get("ramo").updateValueAndValidity();
            this.DatosPadres.get("empresa").setValidators(null);
            this.DatosPadres.get("empresa").updateValueAndValidity();
            this.DatosPadres.get("horariotrabajo").setValidators(null);
            this.DatosPadres.get("horariotrabajo").updateValueAndValidity();
            this.DatosPadres.get("antiguedad").setValidators(null);
            this.DatosPadres.get("antiguedad").updateValueAndValidity();
        }

        this._cdRef.detectChanges();
        this.cambio = false;
    }

    ngAfterContentInit() {
        this.cambio = false;
    }

    transformartexto(forname: FormControl) {
        let texto: string = forname.value;
        if (texto) {
            forname.setValue(this.sistema == 1 ? texto.toUpperCase() : this._help.capitalize(texto));
        }
    }






}
