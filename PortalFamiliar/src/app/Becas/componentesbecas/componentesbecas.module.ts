import {CommonModule} from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {NgModule} from '@angular/core';
import {ModalModule} from 'ng2-bootstrap';
import {DataTablesModule} from 'angular-datatables';
import {SuiModule} from 'ng2-semantic-ui';
import {MomentModule} from 'angular2-moment';
import {MomentTimezoneModule} from 'angular-moment-timezone';
import {MensajeComponent} from 'app/Becas/componentesbecas/mensaje/mensaje.component';
import {MyDatePickerModule} from 'mydatepicker';


import {SolicitudBecaComponent} from './modalsolicitud/solicitudbeca/solicitudbeca.component';
import {DatosPadresComponent} from './modalsolicitud/datospadres/datospadres.component';
import {DatosDependientesComponent} from './modalsolicitud/dependienteseconomicos/dependienteseconomicos.component';

import {SituacionEconomicaComponent} from './modalsolicitud/situacioneconomica/situacioneconomica.component';
import {DeudasComponent} from './modalsolicitud/situacioneconomica/deudas/deudas.component';
import {InmuebleComponent} from './modalsolicitud/situacioneconomica/inmueble/inmueble.component';
import {VehiculoComponent} from './modalsolicitud/situacioneconomica/vehiculo/vehiculo.component';
import {BancoComponent} from './modalsolicitud/situacioneconomica/banco/banco.component';
import {ReferenciasComponent} from './modalsolicitud/referencias/referencias.component';
import {ModalSolicitudComponent} from 'app/Becas/componentesbecas/modalsolicitud/modal/modalsolicitud.component';
import {TextMaskModule} from "angular2-text-mask";
import {CurrencyMaskModule} from "ng2-currency-mask";
import {PipeModule} from "../../Pipes/pipe.module";
import {IngreosmensualesComponent} from './modalsolicitud/situacioneconomica/ingresosmensuales/ingresosmensuales.component';
import {Componentetutor} from "./modalsolicitud/datospadres/componentetutor/componentetutor.component";


@NgModule({
    declarations: [
        SolicitudBecaComponent,
        DatosPadresComponent,
        DatosDependientesComponent,
        SituacionEconomicaComponent,
        DeudasComponent,
        InmuebleComponent,
        VehiculoComponent,
        BancoComponent,
        ReferenciasComponent,
        ModalSolicitudComponent,
        Componentetutor,
        IngreosmensualesComponent,
        MensajeComponent

    ],
    entryComponents: [
        ModalSolicitudComponent,
        SolicitudBecaComponent,
        DatosPadresComponent,
        DatosDependientesComponent,
        SituacionEconomicaComponent,
        DeudasComponent,
        InmuebleComponent,
        VehiculoComponent,
        BancoComponent,
        ReferenciasComponent,
        Componentetutor,
        IngreosmensualesComponent,
        MensajeComponent
    ],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        DataTablesModule,
        SuiModule,
        ModalModule,
        MomentModule,
        MomentTimezoneModule,
        TextMaskModule,
        CurrencyMaskModule,
        PipeModule,
        MyDatePickerModule
    ]
})
export class ComponentesbecasModule {
}
