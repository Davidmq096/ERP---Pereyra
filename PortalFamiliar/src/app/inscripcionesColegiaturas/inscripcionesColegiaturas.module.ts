import {CommonModule} from '@angular/common';
import {FormsModule,ReactiveFormsModule} from '@angular/forms';
import {SuiModule} from 'ng2-semantic-ui';
import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {ModalModule, TooltipModule, AlertModule, DropdownModule} from 'ng2-bootstrap';
import {Select2Module} from 'ng2-select2';
import {InscripcionesColegiaturas} from './inscripcionesColegiaturas.component';
import {DataTablesModule} from 'angular-datatables';
import {MomentModule} from 'angular2-moment';
import {MomentTimezoneModule} from 'angular-moment-timezone';
import {CurrencyMaskModule} from "ng2-currency-mask";

import {PipeModule} from "../Pipes/pipe.module";
import {SolicitudCobroModule} from "../SolicitudCobro/SolicitudCobro.module";
import {MensajePagoComponent} from "./MensajePago/mensajePago.component";

export const routes = [
    {path: '', component: InscripcionesColegiaturas},
    {path: '**', redirectTo: '', pathMatch: 'full'},
];


@NgModule({
    declarations: [
        InscripcionesColegiaturas,
        MensajePagoComponent
    ],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        RouterModule.forChild(routes),
        TooltipModule.forRoot(),
        Select2Module,
        SuiModule,
        ModalModule,
        DataTablesModule,
        MomentModule,
        MomentTimezoneModule,
        CurrencyMaskModule,
        PipeModule,
        SolicitudCobroModule
    ]
})

export class InscripcionesColegiaturasModule {
    static routes = routes;
}