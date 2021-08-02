import {CommonModule} from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {DataTablesModule} from 'angular-datatables';
import {SuiModule} from 'ng2-semantic-ui';
import {ModalModule, TooltipModule, AlertModule, DropdownModule} from 'ng2-bootstrap';
import {ReinscripcionesComponent} from './reinscripciones/reinscripciones.component';
import {StorageService} from 'app/Servicios/storage.service';
import {ListareinscripcionesComponent} from './reinscripciones/listareinscripciones/listareinscripciones.component';
import {Paso1Component} from './reinscripciones/paso1/paso1.component';
import {Paso2Component} from './reinscripciones/paso2/paso2.component';
import {Paso3Component} from './reinscripciones/paso3/paso3.component';
import {PipeModule} from "app/Pipes/pipe.module";

export const routes = [
    {path: '', component: ReinscripcionesComponent},
    {path: '**', redirectTo: '', pathMatch: 'full'},
];

@NgModule({
    declarations: [
        ReinscripcionesComponent,
        ListareinscripcionesComponent,
        Paso1Component,
        Paso2Component,
        Paso3Component
    ],
    providers: [
        StorageService
    ],
    entryComponents: [
        ListareinscripcionesComponent,
        Paso1Component,
        Paso2Component,
        Paso3Component
    ],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        RouterModule.forChild(routes),
        DataTablesModule,
        PipeModule,
        SuiModule,
        ModalModule
    ]
})
export class ReinscripcionesModule {
    static routes = routes;
}
