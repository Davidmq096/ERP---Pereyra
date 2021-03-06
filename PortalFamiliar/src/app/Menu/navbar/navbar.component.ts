import {Component, EventEmitter, OnInit, ElementRef, Output, Input} from '@angular/core';
import {Router} from '@angular/router';
import {AppConfig} from '../../app.config';
import {StorageService} from 'app/Servicios/storage.service';

declare let jQuery: any;

import {Menu} from '../menu.component';

@Component({
    selector: '[navbar]',
    templateUrl: './navbar.template.html'
})
export class Navbar implements OnInit
{
    @Input() barraLateral:boolean;
    @Output() toggleSidebarEvent: EventEmitter<any> = new EventEmitter();
    @Output() toggleChatEvent: EventEmitter<any> = new EventEmitter();
    $el: any;
    config: any;
    router: Router;
    usuario:string;
    menu: Menu;
    foto:string;

    constructor(el: ElementRef, config: AppConfig, router: Router, menu: Menu, private storage: StorageService) 
    {
        this.$el = jQuery(el.nativeElement);
        this.config = config.getConfig();
        this.router = router;
        
        this.menu = menu;
    }

    toggleSidebar(state): void {
        this.toggleSidebarEvent.emit(state);
    }

    toggleChat(): void {
        this.toggleChatEvent.emit(null);
    }

    onDashboardSearch(f): void {
        this.router.navigate(['/app', 'extra', 'search'], {queryParams: {search: f.value.search}});
    }

    ngOnInit(): void
    {
      this.usuario = "Gabriel Eduardo Rivero";
        //alert(this.nivel);
        setTimeout(() => {
            let $chatNotification = jQuery('#chat-notification');
            $chatNotification.removeClass('hide').addClass('animated fadeIn')
                .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', () => {
                    $chatNotification.removeClass('animated fadeIn');
                    setTimeout(() => {
                        $chatNotification.addClass('animated fadeOut')
                            .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd' +
                            ' oanimationend animationend', () => {
                                $chatNotification.addClass('hide');
                            });
                    }, 8000);
                });
            $chatNotification.siblings('#toggle-chat')
                .append('<i class="chat-notification-sing animated bounceIn"></i>');
        }, 4000);

        this.$el.find('.input-group-addon + .form-control').on('blur focus', function (e): void {
            jQuery(this).parents('.input-group')
            [e.type === 'focus' ? 'addClass' : 'removeClass']('focus');
        });

        this.foto = this.storage.getItem("Foto");
    }
}