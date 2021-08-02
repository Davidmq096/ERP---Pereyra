import {NgModule} from '@angular/core';
import {Routes,RouterModule} from '@angular/router';


const routes: Routes =
  [
    {path: 'ActualizacionDatos', loadChildren: './ActualizacionDatos/actualizacionDatos.module#ActualizacionDatosModule'},
    {path: '**', redirectTo: 'ActualizacionDatos', pathMatch: 'full'},
  ];

@NgModule(
  {
      declarations:
        [
        ],
      imports:
        [
          RouterModule.forChild(routes)
        ]
  })

export class DatosFamiliaModuleModule
{
}
