import { Component, OnInit, OnDestroy, AfterViewInit, ElementRef } from '@angular/core';
import { Router, NavigationEnd } from '@angular/router';
import { Location } from '@angular/common';
import {StorageService} from 'app/Servicios/storage.service';

import { AppState } from "app/app.service";
import { Config } from 'app/config';
import { MenuList } from "entity/menulist.ts";
import { Menu } from '../menu.component';
declare let jQuery:any;

@Component({
    selector: '[sidebar]',
    templateUrl: './sidebar.template.html',
    styleUrls: ['./sidebar.component.css']
})

export class Sidebar implements OnInit{
    $el:any;
    router:Router;
    location:Location;
    menu:any;
    logo:string;
    rutaActual="";
    eventoRutaActual=null;
    layout:Menu;
    padreotutorid: any;
    arraydocumentos: any[] =[];
    bloqueopago: any;
    observacionespago: any;
    observacionesbloqueo: any;
    private callmodificar:boolean=false;

    constructor(private _httpService:AppState, el:ElementRef, router:Router, location:Location, layout:Menu, private storage: StorageService) {
        this.padreotutorid = this.storage.getItem('PadresOTutoresId');
        this.$el=jQuery(el.nativeElement);
        this.router=router;
        this.location=location;
        this.layout=layout;
        this.logo=_httpService.logobar;
        MenuList.create(this._httpService,(x)=>{
            this.menu=x;
            if(this.callmodificar){
                this.callmodificar=false;
                setTimeout(()=>{this.ModificarMenu();});
            }
        });
    }
    ngOnInit():void{
        jQuery(window).on('sn:resize', this.initSidebarScroll.bind(this));
        this.initSidebarScroll();
        this.router.events.subscribe((event)=>{
            if (event instanceof NavigationEnd){
                this.changeActiveNavigationItem(this.location);
            }
        });
    }
    ngOnDestroy() {
        this.eventoRutaActual.unsubscribe();
    }
    ngAfterViewInit():void{
        this.changeActiveNavigationItem(this.location);
        this.rutaActual=this.location.path();
        this.eventoRutaActual=this.router.events.subscribe((evento:any)=>{
            this.rutaActual=evento.urlAfterRedirects;
            this.ModificarMenu();
        });
        this.ModificarMenu();
    }

    initSidebarScroll():void{
        let sbContent=this.$el.find('.js-sidebar-content');
        if(this.$el.find('.slimScrollDiv').length!==0){
            sbContent.slimscroll({
                destroy: true
            });
        }
        sbContent.slimscroll({
            height: window.innerHeight,
            size: '4px'
        });
    }
    changeActiveNavigationItem(location):void{
        let $newActiveLink = this.$el.find('a[href="#' + location.path().split('?')[0] + '"]');
        if (!$newActiveLink.is('.active > .collapse > li > a')) {
            this.$el.find('.active .active').closest('.collapse').collapse('hide');
        }
        this.$el.find('.sidebar-nav .active').removeClass('active');

        $newActiveLink.closest('li').addClass('active')
            .parents('li').addClass('active');
        $newActiveLink.closest('.collapse').addClass('in').css('height', '')
            .siblings('a[data-toggle=collapse]').removeClass('collapsed');
    }

    ModificarMenu(){
        if(this.menu){
            let selected=this.menu.getByUrl(this.rutaActual);
            if(selected && selected.parent){
                $('#'+selected.parent.id).addClass('show');
            }
        }else{ this.callmodificar=true; }
    }


    RealizarFuncion(opt){
        switch(opt.action){
            case 'abrirProsa': 
            this.layout.bloqueopago = null;
            this.layout.observacionespago = null;
            this.layout.observacionesbloqueo = null;
            this._httpService.getElemento('portalfamiliar/pagoenlinea/bypadreotutor/2/' + this.padreotutorid +'?instituto=2').subscribe(
                result => {
                    if (result.status == 200) {
                        this.arraydocumentos = result.body;
                        let bloqueo = this.arraydocumentos.filter(x=> x.bloqueopago == true);
                        if(bloqueo.length > 0) {
                            this.layout.bloqueopago = true;
                            this.layout.observacionespago = "No se pueden realizar los pagos seleccionados porque existe un bloqueo relacionado al alumno "+ bloqueo[0].Matricula + " - " + bloqueo[0].Alumno;
                            this.layout.observacionesbloqueo =  bloqueo[0].observacionespago;
                            this.layout.modalProsa.show(); 
                            return false;
                        } else {
                            this.layout.bloqueopago = null;
                            this.layout.observacionespago = null;
                        }
                    }
                    this.layout.modalProsa.show(); 
                },
                error => {
                    this.layout.modalProsa.show(); 
                    console.log(error);
                }
            );
            break;
        }
    }
}