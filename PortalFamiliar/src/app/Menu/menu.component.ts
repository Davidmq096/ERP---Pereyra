import {Component, ViewEncapsulation, ElementRef, Renderer, NgZone, ViewChild} from '@angular/core';
import {Router, Event as RouterEvent, NavigationStart, NavigationEnd, NavigationCancel, NavigationError, Event as NavigationEvent} from '@angular/router';
import { Idle } from '@ng-idle/core';
import {destroyView} from "@angular/core/src/view/view";
import {ModalDirective} from "ng2-bootstrap";
import { AppConfig } from 'app/app.config';
import { AppState } from "app/app.service";
import { Config } from "app/config";
import { Session } from "entity/session";
import {StorageService} from 'app/Servicios/storage.service';

declare let jQuery: any;
declare let Hammer: any;
declare let Raphael: any;
declare let Messenger: any;
declare let Pace: any;

@Component({
  selector: 'layout',
  encapsulation: ViewEncapsulation.None,
  templateUrl: './menu.template.html',
  host: {
    '[class.nav-static]' : 'true',
    '[class.chat-sidebar-opened]' : 'true',
    '[class.app]' : 'true',
    id: 'app'
  }
})
export class Menu{
  @ViewChild('spinnerElement') spinnerElement:ElementRef;
  @ViewChild('routerComponent') routerComponent:ElementRef;
  @ViewChild('modalProsa') modalProsa:ModalDirective;
  private config:any;
  $sidebar:any;
  chatOpened:boolean = false;

  nombreUsuario:string = "";
  padresOTutoresId:any = "";

  minutos:number;
  funcionvalidar:any ="";
  inicio:boolean = true;
  private configuracion:any;

  barraStatica:boolean = false;

  bloqueopago: any;
  observacionespago: any;
  observacionesbloqueo: any;

  constructor(private _httpService:AppState,
    private _config:AppConfig,
    private el:ElementRef,
    private router:Router,
    private renderer:Renderer,
    private ngZone:NgZone,
    private storage: StorageService,
    private idle:Idle){
    Session.instance={storage: storage, appstate:_httpService, router:router, idle:idle};
    let session=Session.instance;
    if(session){
      session.isLoggedCheck()
    }
    Raphael.prototype.safari = function(): any { return; };
    this.config=this._config.getConfig();
    this.configuracion=new Config();
  }

  toggleSidebarListener(state): void
  {
    let toggleNavigation = state === 'static'
      ? this.toggleNavigationState
      : this.toggleNavigationCollapseState;
    toggleNavigation.apply(this);
    this.storage.setItem('nav-static', this.config.state['nav-static']);
  }

  toggleChatListener(): void {
    jQuery(this.el.nativeElement).find('.chat-notification-sing').remove();
    this.chatOpened = !this.chatOpened;

    setTimeout(() => {
      // demo: add class & badge to indicate incoming messages from contact
      // .js-notification-added ensures notification added only once
      jQuery('.chat-sidebar-user-group:first-of-type ' +
        '.list-group-item:first-child:not(.js-notification-added)')
        .addClass('active js-notification-added')
        .find('.fa-circle')
        .before('<span class="badge badge-danger badge-pill ' +
          'flex-last animated bounceInDown">3</span>');
    }, 1000);
  }

  toggleNavigationState(): void
  {
    this.config.state['nav-static'] = !this.config.state['nav-static'];
    if (!this.config.state['nav-static']) {
      this.collapseNavigation();
    }
  }

  expandNavigation(): void
  {
    // this method only makes sense for non-static navigation state
    if (this.isNavigationStatic()
      && (this._config.isScreen('md') || this._config.isScreen('lg') || this._config.isScreen('xl') )) { return; }

    jQuery('layout').removeClass('nav-collapsed');
    this.$sidebar.find('.active .active').closest('.collapse').collapse('show')
      .siblings('[data-toggle=collapse]').removeClass('collapsed');
  }

  collapseNavigation(): void
  {
    // this method only makes sense for non-static navigation state
    if (this.isNavigationStatic()
      && (this._config.isScreen('md') || this._config.isScreen('lg') || this._config.isScreen('xl'))) { return; }

    jQuery('layout').addClass('nav-collapsed');
    this.$sidebar.find('.collapse.in').collapse('hide')
      .siblings('[data-toggle=collapse]').addClass('collapsed');
  }

  /**
   * Check and set navigation collapse according to screen size and navigation state
   */
  checkNavigationState(): void
  {
    if (this.isNavigationStatic())
    {
      if (this._config.isScreen('xs'))
      {
        this.collapseNavigation();
      }
    }
    else
    {
      if (this._config.isScreen('lg') || this._config.isScreen('xl'))
      {
        setTimeout(() => {
          this.collapseNavigation();
        }, this.config.settings.navCollapseTimeout);
      }
      else
      {
        //this.collapseNavigation();
      }
    }
  }

  isNavigationStatic(): boolean
  {
    return this.barraStatica;
  }

  toggleNavigationCollapseState(): void
  {
    if (jQuery('layout').is('.nav-collapsed'))
    {
      this.expandNavigation();
    }
    else
    {
      this.collapseNavigation();
    }
  }

  _sidebarMouseEnter(): void
  {
    if (this._config.isScreen('lg') || this._config.isScreen('xl'))
    {
      this.expandNavigation();
    }
  }
  _sidebarMouseLeave(): void {
    if (this._config.isScreen('lg') || this._config.isScreen('xl')) {
      this.collapseNavigation();
    }
  }

  enableSwipeCollapsing(): void
  {
    let swipe = new Hammer(document.getElementById('content-wrap'));
    let d = this;

    swipe.on('swipeleft', () =>
    {
      setTimeout(() => {
        if (d._config.isScreen('md')) { return; }

        if (!jQuery('layout').is('.nav-collapsed')) {
          d.collapseNavigation();
        }
      });
    });

    swipe.on('swiperight', () => {
      if (d._config.isScreen('md')) { return; }

      if (jQuery('layout').is('.chat-sidebar-opened')) { return; }

      if (jQuery('layout').is('.nav-collapsed')) {
        d.expandNavigation();
      }
    });
  }

  collapseNavIfSmallScreen(): void
  {
    if (this._config.isScreen('xs') || this._config.isScreen('sm'))
    {
      this.collapseNavigation();
    }
  }

  ngOnInit():void{
    this.config.state['nav-static'] = true;
    this.padresOTutoresId = this.storage.getItem('PadresOTutoresId');
    this.nombreUsuario = this.storage.getItem('Nombre');

    let $el = jQuery(this.el.nativeElement);
    this.$sidebar = $el.find('[sidebar]');

    this.router.events.subscribe((event) => {
      this._navigationInterceptor(event);
      if (event instanceof NavigationEnd) {
        setTimeout(() => {
          this.collapseNavIfSmallScreen();
          window.scrollTo(0, 0);

          $el.find('a[href="#"]').on('click', (e) => {
            e.preventDefault();
          });
        });
      }
    });

    this.$sidebar.on('mouseenter', this._sidebarMouseEnter.bind(this));
    this.$sidebar.on('mouseleave', this._sidebarMouseLeave.bind(this));

    this.checkNavigationState();

    this.$sidebar.on('click', () => {
      if (jQuery('layout').is('.nav-collapsed')) {
        this.expandNavigation();
      }
    });

    if ('ontouchstart' in window) {
      this.enableSwipeCollapsing();
    }

    this.$sidebar.find('.collapse').on('show.bs.collapse', function(e): void
    {
      // execute only if we're actually the .collapse element initiated event
      // return for bubbled events
      if (e.target !== e.currentTarget) { return; }

      let $triggerLink = jQuery(this).prev('[data-toggle=collapse]');
      jQuery($triggerLink.data('parent'))
        .find('.collapse.show').not(jQuery(this)).collapse('hide');
    })
    /* adding additional classes to navigation link li-parent
     for several purposes. see navigation styles */
      .on('show.bs.collapse', function(e): void {
        // execute only if we're actually the .collapse element initiated event
        // return for bubbled events
        if (e.target !== e.currentTarget) { return; }

        jQuery(this).closest('li').addClass('open');
      }).on('hide.bs.collapse', function(e): void {
      // execute only if we're actually the .collapse element initiated event
      // return for bubbled events
      if (e.target !== e.currentTarget) { return; }

      jQuery(this).closest('li').removeClass('open');
    });

    this.router.events.forEach((event:NavigationEvent)=>{
      if(event instanceof NavigationStart){
        this.OcultarSideBar(event.url);
      }
    });
    this.OcultarSideBar(this.router.url);
  }

   OcultarSideBar(route)
   {
       this.barraStatica = route != '/Menu/Inicio';

       this.$sidebar.find('.collapse.in').collapse('hide')
           .siblings('[data-toggle=collapse]').addClass('hide');
   }

  private _navigationInterceptor(event: RouterEvent): void {

    if (event instanceof NavigationStart) {
      // We wanna run this function outside of Angular's zone to
      // bypass change detection
      this.ngZone.runOutsideAngular(() => {

        // For simplicity we are going to turn opacity on / off
        // you could add/remove a class for more advanced styling
        // and enter/leave animation of the spinner
        this.renderer.setElementStyle(
          this.spinnerElement.nativeElement,
          'opacity',
          '1'
        );
        this.renderer.setElementStyle(
          this.routerComponent.nativeElement,
          'opacity',
          '0'
        );
      });
    }
    if (event instanceof NavigationEnd) {
      this._hideSpinner();
    }

    // Set loading state to false in both of the below events to
    // hide the spinner in case a request fails
    if (event instanceof NavigationCancel) {
      this._hideSpinner();
    }
    if (event instanceof NavigationError) {
      this._hideSpinner();
    }
  }

  private _hideSpinner(): void
  {
    // We wanna run this function outside of Angular's zone to
    // bypass change detection,
    this.ngZone.runOutsideAngular(() => {

      // For simplicity we are going to turn opacity on / off
      // you could add/remove a class for more advanced styling
      // and enter/leave animation of the spinner
      this.renderer.setElementStyle(
        this.spinnerElement.nativeElement,
        'opacity',
        '0'
      );
      this.renderer.setElementStyle(
        this.routerComponent.nativeElement,
        'opacity',
        '1'
      );
    });
  }


  GetNombreUsuario()
  {
      return this.nombreUsuario;
  }

  GetPadresOTutoresId()
  {
      return this.padresOTutoresId;
  }

  IrProsa()
  {
      console.log("entrar a prosa")
      let datos =
      {
        Sesion: this.storage.getItem("Sesion"),
        Nombre: this.storage.getItem("Nombre"),
        PadresOTutoresId: this.storage.getItem("PadresOTutoresId"),
        ReiniciarPassword: this.storage.getItem("ReiniciarPassword"),
        IntentoLogin: 0,
        TiempoInactividad: this.storage.getItem("TiempoInactividad"),
        Token: this.storage.getItem("Token"),
        UsuarioId: this.storage.getItem("UsuarioId"),
        ValidarSesion: this.storage.getItem("ValidarSesion"),
      };

      let llave = this._httpService.encodePassword(datos);

      window.open(this.configuracion.config.urlProsa + llave, '_blank');
      this.modalProsa.hide();
  }
}
