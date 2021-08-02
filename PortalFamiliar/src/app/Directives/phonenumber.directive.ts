import { Directive, ElementRef, forwardRef, Input, NgModule, OnInit, Renderer } from '@angular/core'
import { CommonModule } from '@angular/common'
import { NG_VALUE_ACCESSOR, ControlValueAccessor } from '@angular/forms'
import { createTextMaskInputElement } from 'text-mask-core/dist/textMaskCore'
import {AppState} from "../app.service";

@Directive({
    host: {
        '(input)': 'onInput($event)',
        '(blur)': '_onTouched()'
    },
    selector: '[phonenumber]',
    providers: [{
        provide: NG_VALUE_ACCESSOR,
        useExisting: forwardRef(() => PhonenumberDirective),
        multi: true
    }]
})
export class PhonenumberDirective implements OnInit, ControlValueAccessor{
    private textMaskInputElement: any
    private inputElement:HTMLInputElement

    @Input('phonenumber')
    telefono =
        {
            telefono: "",
            lada: ""
        }

    private  textMaskConfig = {
        mask:  [ ],
        guide: false,
        placeholderChar: '_',
        pipe: undefined,
        keepCharPositions: false,
        onReject: undefined,
        onAccept: undefined
    }

    private telefonomask =
    {
        lada2: [ /\d/, /\d/, /\d/,/\d/, '-', /\d/,/\d/,/\d/,/\d/],
        lada3: [ /\d/, /\d/,/\d/, '-', /\d/,/\d/,/\d/,/\d/],
        sinLada: [ /\d/,/\d/,/\d/,/\d/,/\d/,/\d/,/\d/,/\d/,/\d/,/\d/   ]
    }

    private sistestema:number;

    _onTouched = () => {}
    _onChange = (_: any) => {}

    constructor(private renderer: Renderer, private element: ElementRef, private appState:AppState)
    {
        this.sistestema = this.appState.sistema;
    }

    ngOnInit()
    {
        if (this.element.nativeElement.tagName === 'INPUT') {
            // `textMask` directive is used directly on an input element
            this.inputElement = this.element.nativeElement
        } else {
            // `textMask` directive is used on an abstracted input element, `ion-input`, `md-input`, etc
            this.inputElement = this.element.nativeElement.getElementsByTagName('INPUT')[0]
        }

        this.FormatoMask();
    }

    writeValue(value: any)
    {
        this.FormatoMask();

        if (this.textMaskInputElement !== undefined)
        {
            this.textMaskInputElement.update(value)
        }
    }

    registerOnChange(fn: (value: any) => any): void { this._onChange = fn }

    registerOnTouched(fn: () => any): void { this._onTouched = fn }

    onInput($event)
    {
        this.FormatoMask();

        this.textMaskInputElement.update($event.target.value)
        this._onChange($event.target.value)
    }

    setDisabledState(isDisabled: boolean)
    {
        this.renderer.setElementProperty(this.element.nativeElement, 'disabled', isDisabled)
    }

    FormatoMask()
    {
        var numlada = this.telefono.lada ? this.telefono.lada.length : 0;
        /* Se agrega la opción para que pueda no tener lada el teléfono que se verífica. */
        //this.textMaskConfig.mask =  numlada == 4 ? this.telefonomask.lada2 :  numlada == 5 ? this.telefonomask.lada3 : this.sistestema == 1 ?  this.telefonomask.lada3 :  this.telefonomask.lada2;
        this.textMaskConfig.mask =  numlada == 4 ? this.telefonomask.lada2 :  numlada == 5 ? this.telefonomask.lada3 : this.sistestema == 1 ?  this.telefonomask.lada3 :  numlada == 0 ? this.telefonomask.sinLada : this.telefonomask.lada2;
        this.textMaskInputElement = createTextMaskInputElement(Object.assign({inputElement: this.inputElement}, this.textMaskConfig))
    }


}

