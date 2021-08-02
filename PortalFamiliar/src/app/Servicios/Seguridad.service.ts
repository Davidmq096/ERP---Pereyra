import { Injectable } from '@angular/core';
import { Router, ActivatedRouteSnapshot, CanLoad, CanActivate, CanActivateChild } from '@angular/router';
import { Observable } from 'rxjs';
import {StorageService} from 'app/Servicios/storage.service';

import {l} from "@angular/core/src/render3";
import {AppState} from "../app.service";

@Injectable()
export class SeguridadService implements CanActivate, CanLoad
{
    private perfilUsuario: string;

    constructor(private _httpService:AppState, private router: Router, private storage: StorageService)
    {

    }

    canActivate(route: ActivatedRouteSnapshot): Observable<boolean>
    {
        return new Observable(
        observer =>
        {
            if(route.data.perfil.includes(this.storage.getItem('PerfilSeleccionado')))
            {
                observer.next(true);
            }
            else
            {
                this.router.navigateByUrl('Menu/Inicio');
                observer.next(false);
            }

            observer.next(true);

            observer.complete();
        });
    }


    canLoad(): Observable<boolean>
    {
        return new Observable(
        observer =>
        {
            if (!this.storage.getItem('PerfilSeleccionado'))
            {
                this.router.navigateByUrl('Menu/Inicio');
                observer.next(false);
            }
            else {
                observer.next(true);
            }

            observer.complete();
        });
    }
}
