import {Routes} from '@angular/router';


export const ROUTES: Routes =
  [
    {path: 'Menu', loadChildren: './Menu/menu.module#MenuModule'},
    {path: 'Seguridad', loadChildren: './Seguridad/seguridad.module#SeguridadModule'},
    {path: '**', redirectTo: 'Seguridad', pathMatch: 'full'},
  ];
