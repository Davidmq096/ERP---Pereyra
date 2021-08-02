import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {CommonModule} from '@angular/common';
import {TextMaskModule} from 'angular2-text-mask';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {ModalModule, TooltipModule, AlertModule, DropdownModule} from 'ng2-bootstrap';
import {SuiModule} from 'ng2-semantic-ui';
import {MyDatePickerModule} from 'mydatepicker';
import {StorageService} from 'app/Servicios/storage.service';


import {MisBoletosComponent} from './misboletos/misboletos.component';
import {CompraBoletosComponent} from './compraboletos/compraboletos.component';

import {DataTablesModule} from "angular-datatables";
import {DirectiveUtilModule} from "angular-directive-utils";
import {PipeModule} from "../Pipes/pipe.module";


const routes: Routes =
    [
        {path: '', redirectTo: 'boletos'},
        {path: 'boletos', component: MisBoletosComponent, pathMatch: 'full'},
        {path: 'compraboletos', component: CompraBoletosComponent, pathMatch: 'full'},
    ];

@NgModule(
    {
        declarations:
        [
            MisBoletosComponent,
            CompraBoletosComponent
        ],
        providers: [
            StorageService
        ],
        imports:
        [
            RouterModule.forChild(routes),
            SuiModule,
            ModalModule,
            FormsModule,
            ReactiveFormsModule,
            TextMaskModule,
            CommonModule,
            DataTablesModule,
            MyDatePickerModule,
            DirectiveUtilModule.forRoot(),
            PipeModule
        ]
    })

export class TransporteModule {
}
