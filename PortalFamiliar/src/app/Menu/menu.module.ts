import 'jquery-slimscroll';

import { NgModule }      from '@angular/core';
import { CommonModule }  from '@angular/common';
import { FormsModule }  from '@angular/forms';
import { ModalModule, TooltipModule, AlertModule } from 'ng2-bootstrap';
import {StorageService} from 'app/Servicios/storage.service';

import { ROUTES }       from './menu.routes';

import { Menu } from './menu.component';
import { Sidebar } from './sidebar/sidebar.component';
import { Navbar } from './navbar/navbar.component';


@NgModule(
  {
    imports: [
      CommonModule,
      TooltipModule.forRoot(),
      ROUTES,
      FormsModule,
        ModalModule
    ],
    providers: [
      StorageService
    ],
    declarations: [
      Menu,
      Sidebar,
      Navbar,
    ]
  })
export class MenuModule
{
}
