import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { Home } from './home.component';
import {CommonModule} from '@angular/common';

export const routes =
  [
    {path: '', component: Home},
    {path: '**', redirectTo: '', pathMatch: 'full'},
  ];

@NgModule(
  {
    declarations: [
      Home
    ],
    imports: [
      RouterModule.forChild(routes),
      CommonModule
    ]
  })

export class HomeModule
{
  static routes = routes;
}
