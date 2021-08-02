import {AfterViewInit, ViewEncapsulation, Component, OnInit, Output, EventEmitter} from '@angular/core';
import {FormBuilder} from '@angular/forms';
import {Subject} from 'rxjs/Rx';

@Component({
    selector: 'mensaje',
    templateUrl: './mensaje.component.html',
    encapsulation: ViewEncapsulation.None,
})
export class MensajeComponent implements OnInit, AfterViewInit {
    @Output() output = new EventEmitter();
    submitted: boolean;

    dtOptions: any = {};
    dtTrigger = new Subject();

    constructor(private _fb: FormBuilder) {}

    //Metodo de inicio
    ngOnInit(): void {
    }

    ngAfterViewInit(): void {
        this.dtTrigger.next();
    }


    ngAfterContentInit() {
    }

}
