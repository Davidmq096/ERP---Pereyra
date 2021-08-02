import {CommonModule,CurrencyPipe} from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {SuiModule} from 'ng2-semantic-ui';
import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {ModalModule, TooltipModule, AlertModule, DropdownModule} from 'ng2-bootstrap';
import {Select2Module} from 'ng2-select2';
import {DatosFacturacion} from './datosFacturacion.component';
import {DataTablesModule} from 'angular-datatables';
import {StorageService} from 'app/Servicios/storage.service';

import {TextMaskModule} from "angular2-text-mask";
import {PipeModule} from "../Pipes/pipe.module";


export const routes = [
    {path: '', component: DatosFacturacion, pathMatch: 'full'},
    {path: '**', redirectTo: '', pathMatch: 'full'},
];


@NgModule({
    declarations: [
        DatosFacturacion
    ],
    providers: [
        StorageService
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
        PipeModule,
        TextMaskModule
    ]
})

export class DatosFacturacionModule {
    static routes = routes;
}