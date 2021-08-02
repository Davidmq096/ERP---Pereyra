import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';

import {FechaEspPipe} from "./fecha.pipe";
import {SafePipe} from "./safe.pipe";
import {FechaEspFormatoPipe} from "./FechaEspFormato.pipe";
import {PhonePipe} from "./phone.pipe";

//-- directivas --
import {LadaDirective} from "../Directives/lada.directive";
import {PhonenumberDirective} from "../Directives/phonenumber.directive";


@NgModule({
    declarations:
        [
            FechaEspPipe,
            SafePipe,
            FechaEspFormatoPipe,
            PhonePipe,
            LadaDirective,
            PhonenumberDirective
        ],
    imports:
        [
            CommonModule
        ],
    exports:
        [
            FechaEspPipe,
            SafePipe,
            FechaEspFormatoPipe,
            PhonePipe,
            LadaDirective,
            PhonenumberDirective
        ]
})

export class PipeModule
{
}