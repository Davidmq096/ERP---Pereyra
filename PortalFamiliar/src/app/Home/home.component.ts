import { Component } from '@angular/core';
import { AppState } from "../app.service";

import { Config } from 'app/config';
import { MenuList } from "entity/menulist.ts";

@Component({
    selector: 'home',
    templateUrl: './home.component.html'
})
export class Home{
    public opcionPadre:Array<any>=[];
    public constructor(private _httpService:AppState){
        MenuList.create(this._httpService,(x)=>{
        	x.removeKey("HOME");
        	this.opcionPadre=x.menu;
        });
    }
}