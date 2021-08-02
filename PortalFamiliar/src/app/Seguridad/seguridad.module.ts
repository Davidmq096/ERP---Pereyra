import {CommonModule} from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {ModalModule} from 'ng2-bootstrap';
import {JsonpModule} from '@angular/http';
import {NgxPasswordToggleModule} from 'ngx-password-toggle';
import {Login} from "./login/login.component";
import { LogoutComponent } from "./logout/logout.component";
import {CambiarPasswordComponent} from "./CambiarPassword/CambiarPassword.component";
import {SolicitudCambioPasswordComponent} from "./login/SolcitudCambioPassword/solicitudCambioPassword.component";
import {registrousuario} from "./registrousuario/registrousuario.component";
import {RecaptchaModule} from 'ng-recaptcha';
import {StorageService} from 'app/Servicios/storage.service';

export const routes =
    [
        {path: 'Login', component: Login},
        {path: 'Logout', component: LogoutComponent},
        {path: 'CambiarPassword', component: CambiarPasswordComponent},
        {path: 'registrousuario', component: registrousuario},
        {path: '**', redirectTo: 'Login', pathMatch: 'full'},
    ];

@NgModule(
    {
        declarations: [
            Login,
            LogoutComponent,
            CambiarPasswordComponent,
            SolicitudCambioPasswordComponent,
            registrousuario
        ],
        providers: [
            StorageService
        ],
        imports: [
            CommonModule,
            FormsModule,
            ReactiveFormsModule,
            ModalModule.forRoot(),
            JsonpModule,
            NgxPasswordToggleModule,
            RouterModule.forChild(routes),
            RecaptchaModule.forRoot()
        ]
    })

export class SeguridadModule {
    static routes = routes;
}

