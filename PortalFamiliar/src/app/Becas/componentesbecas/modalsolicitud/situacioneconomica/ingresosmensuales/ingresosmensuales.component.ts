import {Component, OnInit, Input, Output, EventEmitter} from "@angular/core";
import {AppState} from "app/app.service";
import {FormGroup, FormBuilder, Validators} from "@angular/forms";
import {parametrosModal} from './../../modal/modalsolicitud';
import createNumberMask from 'text-mask-addons/dist/createNumberMask';


@Component({
    selector: "ingresosmensuales",
    templateUrl: "ingresosmensuales.component.html",
    providers: [AppState]
})
export class IngreosmensualesComponent implements OnInit {
    @Input() ingresos: FormGroup;
    @Input() sistema: any;
    @Input() solicitudid: number;
    @Input() submitted: boolean;
    @Input() parametrosModal: parametrosModal;
    @Output() output = new EventEmitter();

    numberMask = createNumberMask({
        prefix: '',
        suffix: '',
        includeThousandsSeparator: true,
        thousandsSeparatorSymbol: ',',
        allowDecimal: false,
        decimalSymbol: '',
        decimalLimit: 0,
        integerLimit: null,
        requireDecimal: false,
        allowNegative: false,
        allowLeadingZeroes: false
    });
 

    nombre: string;
    constructor(private URLBase: AppState, private _httpService: AppState, private _fb: FormBuilder) {
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.ingresos = this.ingresos;
        this.nombre = this.ingresos.value.nombre;


    }

    ngAfterContentInit() {
        this.output.next(this.ingresos);
    }

}
