/*
 * Autor: Emmanuel Martinez Ayala
 * Creacion 09/09/2019
 * U. Modificacion: 09/09/2019
 */
import { Idle, DEFAULT_INTERRUPTSOURCES } from '@ng-idle/core';
import { Router, NavigationStart } from '@angular/router';
import { Subscription } from 'rxjs';
import { AppState } from 'app/app.service';
import { MenuList } from 'entity/menulist';
import {StorageService} from 'app/Servicios/storage.service';
declare let Pace:any;
declare let Messenger:any;

export class Session{
	private _isWatching:boolean=false;
	private _ka:any;
	private _ev:Subscription;
	private _kaTime:number=60;
	private _ilTime:number=0;
	private _ilGrace:number=30;

	public constructor(private storage: StorageService,
		private _aSt:AppState,
		private _rt:Router,
		private _il:Idle){
		let kaMinutes=this.storage.getItem('ValidarSesion'),
	      tInactividad=this.storage.getItem('TiempoInactividad');
		if(kaMinutes){
			let kaMinutesNumb=Number(kaMinutes);
			if(kaMinutesNumb===kaMinutesNumb){
				this._kaTime=Number(kaMinutes);
			}
		}
	    if(!tInactividad){ tInactividad="60"; }
	    this._ilTime=(Number(tInactividad)*60)-this._ilGrace;
	    //this._ilTime=11;//ONLY TEST
	    //this._ilGrace=10;//ONLY TEST
	    this.onInit();
	    //console.log("> Session: created");
	}
	private onInit(){
		if(this._ilTime<=0){
	      this._rt.navigate(['/Seguridad/Login'])
	      return false;
	    }
		if(this.isRouteWatch(this._rt.url)){
			this.idleStart();
		}
		this.eventStart();
		this.renewStart();
	}
	private onStop(){
		this.renewStop();
		this.eventStop();
		this.idleStop();
	}
	private onDestroy(){
		this._aSt=null;
		this._il=null;
		Session.cache=null;
	}

	private idleStart(){
		if(!this._isWatching){
			this._isWatching=true;
			//console.log(">> Idle: start");
			let idle=this._il;
			if(idle){
			    idle.setIdle(this._ilTime)
			    idle.setTimeout(this._ilGrace);
			    idle.setInterrupts(DEFAULT_INTERRUPTSOURCES);
			    idle.onIdleEnd.subscribe(()=>{ Messenger().hideAll() });
			    idle.onTimeoutWarning.subscribe((countdown)=>{
			    	this.message(true,"No se ha detectado actividad. La sesión se finalizará en "+countdown+".");
			    });
			    idle.onTimeout.subscribe(()=>{
			    	this.message(true,"La sesión se ha cerrado por inactividad.");
					this.logout()
			    });
			    idle.watch();
				//console.log(">> Idle: watch");
			}
		}
	}
	private idleStop(){
		if(this._isWatching){
			this._isWatching=false;
			//console.log(">> Idle: stop");
			if(this._il){
				this._il.stop();
			}
		}
	}
	private renewStart(){
		if(!this._ka){
			this._ka=setInterval(()=>{
				Pace.ignore(()=>{this.renew(this._rt.url);});
			}, 60000*this._kaTime);
		}
	}
	private renewStop(){
		if(this._ka){
	    	clearTimeout(this._ka);
	    	this._ka=null;
		}
	}
	private renew(url):boolean{
		if(this.isRouteWatch(url)){
			let token=this.storage.getItem('Token');
			if(token){
				this._aSt.postElemento('sesionactiva', token, true, true).subscribe(r=>{
					if(r.status!=200){
						this.message(true,"El tiempo de la sesión ha finalizado. Vuelva a iniciar sesión.");
						this.logout();
					}
				},e=>{
					this.message(true,"Se ha perdido la comunicación con el servidor.");
					this.logout();
				});
				return true;
			}
		}
		return false;
	}
	private eventStart(){
		if(!this._ev){
			this._ev=this._rt.events.subscribe(e=>{
				if(e instanceof NavigationStart){
					this.event(e);
				}
			});
		}
	}
	private eventStop(){
		if(this._ev){
		    this._ev.unsubscribe();
		    this._ev=null;
		}
	}
	private event(e){
		let url=e.url;
		if(this.renew(url)){ this.idleStart(); }
		else{ this.idleStop(); }
	}

	private isRouteWatch(url):boolean{
		switch(url){
			case "/Seguridad/Login":
			case "/Seguridad/Logout":
			case "/Seguridad/CambiarPassword":
				return false;
		}
		return true;
	}
	public isLogged(){
		return (this.storage.getItem("Sesion")=="true");
	}
	public isLoggedCheck(noChangePassword?){
		if(this.isLogged()){
			if(!noChangePassword && this.storage.getItem("ReiniciarPassword")=="1"){
				this._rt.navigate(['/Seguridad/CambiarPassword']);
				//window.location.href="#/Seguridad/CambiarPassword";
			}
			return true;
		}
		this._rt.navigate(['/Seguridad/Login']);
		return false;
	}
	public logout(){
	    this.onStop();
	    this.onDestroy();
	    //console.log('>>> Logout')
	    this.storage.removeItem("Sesion");
	    this.storage.removeItem("Nombre");
	    this.storage.removeItem("PadresOTutoresId");
	    this.storage.removeItem("ReiniciarPassword");
	    this.storage.removeItem("UsuarioId");
	    this.storage.removeItem("IntentoLogin");
	    this.storage.removeItem("TiempoInactividad");
	    this.storage.removeItem("Foto");
	    this.storage.removeItem("Token");
	    this.storage.removeItem("_mcache");
	    MenuList.cache=null;
		this._rt.navigate(['/Seguridad/Login']);
	}

	private message(success:boolean,message:string){
		Messenger().post({
			message:message,
			type:(success ? 'success' : 'error'),
			showCloseButton:true
		});
	}

	private static cache:Session=null;
	public static get instance():any{
		if(Session.cache){
			return Session.cache;
		}
		//console.log("Session not initialized.");
		return null;
	}
	public static set instance(x:any){
		if(!Session.cache){
			//console.log("> Session: start");
			let _try=new Session(x.storage,x.appstate,x.router,x.idle);
			Session.cache=_try;
		}
	}
}