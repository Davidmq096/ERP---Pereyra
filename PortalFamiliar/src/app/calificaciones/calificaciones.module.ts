import {NgModule} from '@angular/core';
import {Routes,RouterModule} from '@angular/router';
import {CommonModule} from '@angular/common';
import { TextMaskModule } from 'angular2-text-mask';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {ModalModule, TooltipModule, AlertModule, DropdownModule} from 'ng2-bootstrap';
import {SuiModule} from 'ng2-semantic-ui';
import {MyDatePickerModule} from 'mydatepicker';
import {StorageService} from 'app/Servicios/storage.service';

import {CalificacionesComponent} from "./calificaciones.component";
import {DataTablesModule} from "angular-datatables";
import {DirectiveUtilModule} from "angular-directive-utils";
import {PipeModule} from "../Pipes/pipe.module";


const routes: Routes =
  [
    {path: '', component:CalificacionesComponent},
    {path: '**', redirectTo: '', pathMatch: 'full'},
  ];

@NgModule(
  {
    declarations:
      [
        CalificacionesComponent,
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

export class CalificacionesModule
{
}
