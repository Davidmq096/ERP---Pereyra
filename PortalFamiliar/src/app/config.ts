import { Injectable } from '@angular/core';
import * as config from './config.json'

export class ConfigModel {
    version: number;
    logo: string;
    titulo: string;
    favicon: string;
    logobar: string;
    avisoPrivacidad: string;
    urlProsa: string;
    url: {
        qa: {
            servicios: string
            seguridad: string
        },
        produccion: {
            servicios: string
            seguridad: string
        }
    }
}

@Injectable()
export class Config {
    //1 = lux;  2 = "ciencias"
    sistema: number = config.sistema;
    config: ConfigModel;

    constructor() {
        switch (this.sistema) {
            case 1:
                this.config =
                {
                    version: this.sistema,
                    titulo: 'Portal Familiar - Instituto Lux',
                    avisoPrivacidad: "http://www.lux.edu.mx/avisodeprivacidad/",
                    url: {
                        qa: {
                            servicios: "https://lux.org.mx/QA/Jesuitas_webServices/web/app.php/api/",
                            seguridad: "https://secapp.lux.org.mx:8018/api/"
                        },
                        produccion: {
                            servicios: "https://lux.org.mx/Jesuitas_webServices/web/app.php/api/",
                            seguridad: "https://secapp.lux.org.mx:8015/api/"
                        }
                    },
                    //imagenes
                    logo: 'assets/img/logo/logoEPereyra.png',
                    favicon: 'assets/img/logo/logoBPereyra.png',
                    logobar: 'assets/img/logo/logoBPereyra.png',
                    //becas
                    urlProsa: ""
                }
                break;
            case 2:
                this.config =
                {
                    version: this.sistema,
                    titulo: 'Portal Familiar - Carlos Pereyra',
                    avisoPrivacidad: "https://www.pereyra.edu.mx/aviso-de-privacidad/",
                    url: {
                        qa: {
                            servicios: "https://www.idc.edu.mx/QA/Jesuitas_webServices/web/api/",
                            seguridad: "https://prosa-sj.com:8018/api/"
                        },
                        produccion: {
                            servicios: "https://www.idc.edu.mx/Jesuitas_webServices/web/api/",
                            seguridad: "https://prosa-sj.com:8015/api/"
                        }
                    },

                    //imagenes
                    logo: 'assets/img/logo/logoEPereyra.png',
                    favicon: 'assets/img/logo/logoBPereyra.png',
                    logobar: 'assets/img/logo/logoBPereyra.png',

                    //becas
                    urlProsa: "https://www.idc.edu.mx/PROSA/#/EntrarPROSA/"
                }
                break;
        }
    }
    getConfig(): ConfigModel {
        return this.config;
    }
}
