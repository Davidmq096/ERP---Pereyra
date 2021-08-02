import {Directive, ElementRef, forwardRef, Input, NgModule, OnInit, Renderer, SimpleChanges, OnChanges} from '@angular/core'
import { CommonModule } from '@angular/common'
import { NG_VALUE_ACCESSOR, ControlValueAccessor } from '@angular/forms'
import { createTextMaskInputElement } from 'text-mask-core/dist/textMaskCore'
import {AppState} from "../app.service";

@Directive({
    host: {
        '(input)': 'onInput($event)',
        '(blur)': '_onTouched()'
    },
    selector: '[lada]',
    providers: [{
        provide: NG_VALUE_ACCESSOR,
        useExisting: forwardRef(() => LadaDirective),
        multi: true
    }]
})
export class LadaDirective implements  ControlValueAccessor
{
    private textMaskInputElement: any;
    private inputElement:HTMLInputElement;

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
            lada2: [ '(', /\d/, /\d/, ')'],
            lada3: [ '(', /\d/, /\d/,/\d/, ')']
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

        this.FormatoLada( this.inputElement .value);
    }

    writeValue(value: any)
    {
        this.FormatoLada(value);

        if (this.textMaskInputElement !== undefined)
        {
            this.textMaskInputElement.update(value)
        }
    }

    registerOnChange(fn: (value: any) => any): void { this._onChange = fn }

    registerOnTouched(fn: () => any): void { this._onTouched = fn }

    onInput($event)
    {
        this.FormatoLada($event.target.value);

        this.textMaskInputElement.update($event.target.value);
        this._onChange($event.target.value);
    }

    setDisabledState(isDisabled: boolean)
    {
        this.renderer.setElementProperty(this.element.nativeElement, 'disabled', isDisabled)
    }

    FormatoLada(value)
    {
        var val = value ? value.replace(/[^0-9]/g, '').slice(0,3) : "";
        var numlada = val.length;
        this.textMaskConfig.mask =  numlada == 2 ? this.telefonomask.lada2 :  numlada == 3 ? this.telefonomask.lada3 : this.sistestema == 1 ?  this.telefonomask.lada3 :  this.telefonomask.lada2;
        this.textMaskInputElement = createTextMaskInputElement(Object.assign({inputElement: this.inputElement}, this.textMaskConfig));
    }
}

