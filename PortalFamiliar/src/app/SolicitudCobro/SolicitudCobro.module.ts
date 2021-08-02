import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';

import {SolicitudCobroComponent} from "./SolicitudCobro.component";
import {ModalModule} from 'ng2-bootstrap';
import {PipeModule} from "../Pipes/pipe.module";


@NgModule({
    declarations:
        [
            SolicitudCobroComponent
        ],
    imports:
        [
            CommonModule,
            ModalModule,
            PipeModule
        ],
    exports:
        [
            SolicitudCobroComponent
        ]
})

export class SolicitudCobroModule
{
}