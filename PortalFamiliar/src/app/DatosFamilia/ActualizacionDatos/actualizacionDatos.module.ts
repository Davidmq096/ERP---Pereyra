import {NgModule} from '@angular/core';
import {Routes,RouterModule} from '@angular/router';
import {CommonModule} from '@angular/common';
import { TextMaskModule } from 'angular2-text-mask';
import { FormsModule } from '@angular/forms';
import {Numbers} from "../../Directives/number.directive";
import {ModalModule, TooltipModule, AlertModule, DropdownModule} from 'ng2-bootstrap';
import {SuiModule} from 'ng2-semantic-ui';
import {MyDatePickerModule} from 'mydatepicker';
import {StorageService} from 'app/Servicios/storage.service';

import {AlumnoDatos} from "./AlumnoDatos/alumnoDatos.component";
import {ActualizacionDatos} from "./actualizacionDatos.component";
import {DataTablesModule} from "angular-datatables";
import {DirectiveUtilModule} from "angular-directive-utils";

//componentes generales
import {HermanoComponent} from "./AlumnoDatos/Datos/Hermano/hermano.component";
import {PersonasAutorizadasRecogerComponent} from "./AlumnoDatos/Datos/PersonaAutorizadaRecoger/PersonaAutorizadaRecoger.component";
import {AvisoPrivacidadComponent} from "../../ComponenteGeneral/AvisoPrivacidad.component";
import {DomicilioAlumnoComponent} from "./AlumnoDatos/Datos/Domicilio/DomicilioAlumno.component";
import {DatosGeneralesComponent} from "./AlumnoDatos/Datos/DatosGenerales/DatosGenerales.component";

//lux
import {PadreTutorComponent} from "./AlumnoDatos/Datos/PadreTutor/LUX/PadreTutor.component";
import {DinamicaFamiliarComponent} from "./AlumnoDatos/Datos/DinamicaFamiliar/LUX/DinamicaFamiliar.component";
import {DatosMedicosComponent} from "./AlumnoDatos/Datos/DatosMedicos/LUX/DatosMedicos.component";

//
import {PadreTutorIDECComponent} from "./AlumnoDatos/Datos/PadreTutor/Ciencias/PadreTutor.component";
import {DatosMedicosCienciasComponent} from "./AlumnoDatos/Datos/DatosMedicos/Ciencias/DatosMedicos.component";
import {PipeModule} from "../../Pipes/pipe.module";


const routes: Routes =
  [
    {path: '', component:ActualizacionDatos},
    {path: 'AlumnoDatos/:actualizar/:id/:clavefamiliar', component:AlumnoDatos},
    {path: '**', redirectTo: '', pathMatch: 'full'},
  ];

@NgModule(
  {
    declarations:
      [
        ActualizacionDatos,
        AlumnoDatos,
        Numbers,
        HermanoComponent,
        PersonasAutorizadasRecogerComponent,
        AvisoPrivacidadComponent,
        PadreTutorComponent,
        DinamicaFamiliarComponent,
        DatosMedicosComponent,
        DomicilioAlumnoComponent,
        DatosGeneralesComponent,
        PadreTutorIDECComponent,
        DatosMedicosCienciasComponent,
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
        TextMaskModule,
        CommonModule,
        DataTablesModule,
        MyDatePickerModule,
        DirectiveUtilModule.forRoot(),
        PipeModule
      ]
  })

export class ActualizacionDatosModule
{
}
