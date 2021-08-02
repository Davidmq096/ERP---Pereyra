import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { Session } from "entity/session";
import { AppState } from "app/app.service";

@Component({
    selector: 'logout',
    templateUrl: './logout.component.html'
})
export class LogoutComponent{
    constructor(private _aSt:AppState,
    	private _rt:Router){
	    Session.instance={appstate:_aSt, router:_rt, idle:null};
	    let session=Session.instance;
	    if(session){
	      session.logout()
	    }
    }
}