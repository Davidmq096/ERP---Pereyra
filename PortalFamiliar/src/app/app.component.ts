/*
 * Angular 2 decorators and services
 */
import {Component, ViewEncapsulation} from '@angular/core';

import {AppState} from './app.service';
import {Config} from './config';
import * as config from './config.json';
declare let Messenger: any;

/*
 * App Component
 * Top Level Component
 */
@Component({
    selector: 'app',
    encapsulation: ViewEncapsulation.None,
    styleUrls: [
        '../assets/general.css',
        '../assets/general2.css',
        '../assets/Semantic/semantic.css',
        '../assets/scss/application.scss',
        '../../node_modules/datatables.net-dt/css/jquery.dataTables.css',
        '../../node_modules/datatables.net-buttons-dt/css/buttons.dataTables.css',
        '../assets/alert/notifications.style.scss',
        '../assets/fileinput/fileinput.min.css',
        '../../node_modules/pace/themes/pace-theme-center-radar.css',
        '../assets/icon/google-icons.css',
        '../assets/datapicker/bootstrap-material-datetimepicker.css'
    ],
    template: `<router-outlet></router-outlet>`
})
export class App {
    config: Config = new Config();

    constructor(
        public appState: AppState) {

    }

    ngOnInit() {
        let title = '';
        switch (config.sistema) {
            case 1:
                title = this.config.config.titulo;
                break;
            case 2:
                title = this.config.config.titulo;
                break;
        }
        
        document.title = title;
        Messenger.options = {
            extraClasses: 'messenger-fixed messenger-on-bottom',
            maxMessages: 1,
            theme: 'ice',
            parentLocations: ['#mensaje']
        };
        localStorage.setItem("videoinicio", "0");
    }
}
