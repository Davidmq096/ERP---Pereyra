import {CommonModule} from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {ModalModule, TooltipModule} from 'ng2-bootstrap';
import {DataTablesModule} from 'angular-datatables';
import {SuiModule} from 'ng2-semantic-ui';
import {StorageService} from 'app/Servicios/storage.service';

import {FamiliasComponent} from "./Familias/Familias.component";


import {SolicitudesBecaComponent} from "./solicitudesbeca.component";


export const routes = [
    {path: '', component: SolicitudesBecaComponent},
    {path: '**', redirectTo: '', pathMatch: 'full'},

];

@NgModule({
    declarations: [
        SolicitudesBecaComponent,
        FamiliasComponent
    ],
    providers: [
        StorageService
    ],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        RouterModule.forChild(routes),
        DataTablesModule,
        TooltipModule.forRoot(),
        SuiModule,
        ModalModule,
    ]
})


export class SolicitudesBecaModule {
    static routes = routes;
}
