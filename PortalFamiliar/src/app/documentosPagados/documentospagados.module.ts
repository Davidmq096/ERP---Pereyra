import {CommonModule} from '@angular/common';
import {FormsModule,ReactiveFormsModule} from '@angular/forms';
import {SuiModule} from 'ng2-semantic-ui';
import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {ModalModule, TooltipModule, AlertModule, DropdownModule} from 'ng2-bootstrap';
import {Select2Module} from 'ng2-select2';
import {DoctosPagados} from './documentospagados.component';
import {DataTablesModule} from 'angular-datatables';
import {MomentModule} from 'angular2-moment';
import {MomentTimezoneModule} from 'angular-moment-timezone';
import {PipeModule} from "../Pipes/pipe.module";
import {StorageService} from 'app/Servicios/storage.service';


export const routes = [
    {path: '', component: DoctosPagados, pathMatch: 'full'},
    {path: '**', redirectTo: '', pathMatch: 'full'},
];


@NgModule({
    declarations: [
        DoctosPagados
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
        MomentModule,
        MomentTimezoneModule,
        PipeModule
    ]
})

export class DoctosPagadosModule {
    static routes = routes;
}