import { AfterViewInit, Component, OnInit } from '@angular/core';
import { AppState } from "app/app.service";
import { Router } from '@angular/router';
import { FormGroup, FormBuilder, FormArray, Validators } from '@angular/forms';
import createNumberMask from 'text-mask-addons/dist/createNumberMask';
import {StorageService} from 'app/Servicios/storage.service';

import { Helpers } from '../../app.helpers';

declare let Messenger: any;
declare let $: any;

import * as moment from 'moment'
moment.locale('es')

@Component({
    selector: 'compraboletos',
    templateUrl: './compraboletos.component.html'
})

export class CompraBoletosComponent implements OnInit, AfterViewInit {
    padreotutorid = this.storage.getItem('PadresOTutoresId');
    FormGuardar: FormGroup;
    submitted: boolean;

    RutaIdaSelect: any[];
    totalida: number = 0;

    RutaRegresoSelect: any[];
    totalregreso: number = 0;

    cuentatotal: number = 0;

    numberMask = createNumberMask({
        prefix: '',
        suffix: '',
        includeThousandsSeparator: true,
        thousandsSeparatorSymbol: ',',
        allowDecimal: false,
        decimalSymbol: '',
        decimalLimit: 0,
        integerLimit: null,
        requireDecimal: false,
        allowNegative: false,
        allowLeadingZeroes: false
    });

    //En el contructor se declara la llamada a los servicios
    constructor(private _httpService: AppState, private _fb: FormBuilder, public _helpers: Helpers, private _router: Router, private storage: StorageService) {
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.FormGuardar = this._fb.group({
            fecha: [, <any>Validators.required],
            rutaidida: [],
            ida: this._fb.array([]),
            rutaidregreso: [],
            regreso: this._fb.array([]),
            alumnos: this._fb.array([])
        });
    }

    ngAfterViewInit(): void {
        this.datosiniciales();
    }

    //Accion de busqueda de inicio
    datosiniciales() {
        this._httpService.getElemento('Transporte/Boleto').subscribe(
            result => {
                if (result.status == 200) {
                    this.FormGuardar.get('fecha').setValue({ date: this._helpers.FechaToStringObjeto(result.body.fecha) })
                    this.RutaIdaSelect = (result.body.ruta as any[]).filter(x => x.tipoviajeid == 1);
                    this.RutaRegresoSelect = (result.body.ruta as any[]).filter(x => x.tipoviajeid == 2);
                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                var errorMessage = <any>error;
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );

        this._httpService.getElemento('portalfamiliar/hijos/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    let a = this.FormGuardar.get('alumnos') as FormArray;
                    (result.body as any[]).forEach((x) => {
                        let alumno = this._fb.group({
                            alumnoid: [x.alumnoid],
                            nivel: [x.grado + " de " + x.nivel],
                            nombre: [x.apellidopaterno + " " + x.apellidomaterno + " " + x.primernombre],
                            cantidad: []
                        })
                        alumno.valueChanges.subscribe(() => {
                            this.resultado();
                        })
                        a.push(alumno)
                    });
                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                var errorMessage = <any>error;
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    paradas(tipoviaje: number, rutaid: number) {
        let ruta;
        switch (tipoviaje) {
            case 1:
                let ida = this.FormGuardar.get('ida') as FormArray;
                ida.controls = [];

                ruta = this.RutaIdaSelect.find(x => x.rutaid == rutaid);
                if (!ruta) {
                    this.totalida = 0;
                    return false;
                }
                ruta.paradas.forEach(x => {
                    let parada = this._fb.group({
                        paradaid: [x.rutaprecioparadaid],
                        parada: [x.parada],
                        tiempo: [x.duracion],
                        costo: [x.precio],
                        activo: []
                    });
                    ida.push(parada)
                });
                break;
            case 2:
                let regreso = this.FormGuardar.get('regreso') as FormArray;
                regreso.controls = [];

                ruta = this.RutaRegresoSelect.find(x => x.rutaid == rutaid);
                if (!ruta) {
                    this.totalregreso = 0;
                    return false;
                }
                ruta.paradas.forEach(x => {
                    let parada = this._fb.group({
                        paradaid: [x.rutaprecioparadaid],
                        parada: [x.parada],
                        tiempo: [x.duracion],
                        costo: [x.precio],
                        activo: []
                    });
                    regreso.push(parada)
                });
                break;
        }
        if (ruta.tipoprecioid == 1) {
            this.calcular(tipoviaje, ruta.tipoprecioid);
        }
    }

    select(e: any, tipoviaje: number, index: number, tipoprecioid: number) {
        var check = $(e.srcElement).is(':checked');
        let r;
        switch (tipoviaje) {
            case 1:
                r = this.FormGuardar.get('ida') as FormArray;
                break;
            case 2:
                r = this.FormGuardar.get('regreso') as FormArray;
                break;
        }
        r.controls.forEach((x, i) => {
            x.get('activo').setValue(index == i && check);
            index > i && check ? x.get('activo').disable() : x.get('activo').enable();
        });

        if (tipoprecioid == 2) {
            this.calcular(tipoviaje, tipoprecioid);
        }
    }

    calcular(tipoviaje: number, tipodeprecio: number) {
        let r;
        let fecha = this._helpers.FechaObjetoToString(this.FormGuardar.get('fecha').value);
        switch (tipoviaje) {
            case 1:
                this.totalida = 0;
                switch (tipodeprecio) {
                    case 1:
                        let ruta = this.RutaIdaSelect.find(x => x.rutaid == this.FormGuardar.get('rutaidida').value);
                        let fijo = ruta.preciosfijos.find(x => moment(fecha).isBetween(x.fechainicio, x.fechafin, null, '[]'));
                        fijo = fijo ? fijo : ruta.preciosfijos[ruta.preciosfijos.length - 1];
                        this.totalida = fijo.precio;
                        break;
                    case 2:
                        r = this.FormGuardar.get('ida') as FormArray;
                        let parada = r.controls.find(x => x.get('activo').value);
                        this.totalida = parada ? parada.get('costo').value : 0;
                        break;
                }
                break;
            case 2:
                this.totalregreso = 0;
                switch (tipodeprecio) {
                    case 1:
                        let ruta = this.RutaRegresoSelect.find(x => x.rutaid == this.FormGuardar.get('rutaidregreso').value);
                        let fijo = ruta.preciosfijos.find(x => moment(fecha).isBetween(x.fechainicio, x.fechafin, null, '[]'));
                        fijo = fijo ? fijo : ruta.preciosfijos[ruta.preciosfijos.length - 1];
                        this.totalregreso = fijo.precio;
                        break;
                    case 2:
                        r = this.FormGuardar.get('regreso') as FormArray;
                        let parada = r.controls.find(x => x.get('activo').value);
                        this.totalregreso = parada ? parada.get('costo').value : 0;
                        break;
                }
                break;
        }
        this.resultado();
    }

    resultado() {
        let r = this.FormGuardar.get('alumnos') as FormArray;
        let boletos = r.controls.reduce((a, b) => a + Number(b.get('cantidad').value), 0);
        this.cuentatotal = (this.totalida + this.totalregreso) * boletos;
    }

    guardar() {
        this.submitted = true;
        if (this.FormGuardar.get('fecha').invalid) {
            return false;
        }
        let datos = this.FormGuardar.value;

        if (!datos.rutaidida && !datos.rutaidregreso) {
            Messenger().post({
                message: "Selecciona una ruta de ida o de regreso",
                type: 'success',
                showCloseButton: true
            });
            return false;
        }
        if (datos.rutaidida) {
            let ida = (datos.ida as any[]).find(x => x.activo);
            if (!ida) {
                Messenger().post({
                    message: "Selecciona en donde te vas a subir",
                    type: 'success',
                    showCloseButton: true
                });
                return false;
            }
        }
        if (datos.rutaidregreso) {
            let regreso = (datos.regreso as any[]).find(x => x.activo);
            if (!regreso) {
                Messenger().post({
                    message: "Selecciona en donde te vas a bajar",
                    type: 'success',
                    showCloseButton: true
                });
                return false;
            }
        }
        if (this.cuentatotal == 0) {
            Messenger().post({
                message: "Indica la cantidad de boletos a comprar de al menos un alumno",
                type: 'success',
                showCloseButton: true
            });
            return false;
        }
        this.submitted = false;

        let fecha = this._helpers.FechaObjetoToString(datos.fecha.date);
        let ruta = [];
        if (datos.rutaidida) {
            let ida = (datos.ida as any[]).find(x => x.activo);
            ruta.push({
                rutaid: datos.rutaidida,
                precio: this.totalida,
                paradaid: ida.paradaid
            })
        }
        if (datos.rutaidregreso) {
            let regreso = (datos.regreso as any[]).find(x => x.activo);
            ruta.push({
                rutaid: datos.rutaidregreso,
                precio: this.totalregreso,
                paradaid: regreso.paradaid
            })
        }

        let d = [];
        (datos.alumnos as any[]).forEach((x) => {
            if (x.cantidad > 0)
                ruta.forEach((y) => {
                    d.push({
                        usuarioid: this.storage.getItem("UsuarioId"),
                        alumnoid: x.alumnoid,
                        fecha: fecha,
                        cantidad: x.cantidad,
                        rutaid: y.rutaid,
                        precio: y.precio,
                        paradaid: y.paradaid,
                        portal: 3
                    })
                })
        })

        this._httpService.postElemento('Transporte/Boleto/Vender', d, null, true).subscribe(
            result => {
                if (result.status == 200) {
                    Messenger().post({
                        message: result.body.msj,
                        type: 'success',
                        showCloseButton: true
                    });
                    this.imprimir(result.body.boletos).then(() => this._router.navigate(['/Menu/transporte/boletos']));
                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                var errorMessage = <any>error;
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    imprimir(boletos: number[]): Promise<any> {
        var promise = new Promise((resolve, reject) => {
            let data = $.param({ boletos: boletos });
            this._httpService.getArchivo('Transporte/Boleto/pdf', '?' + data).subscribe(
                result => {
                    if (result.status == 200) {
                        this._helpers.printPDF(result.body);
                        resolve();
                        //importedSaveAs(result.body, "Boletos");
                    } else {
                        Messenger().post({
                            message: result.body,
                            type: 'success',
                            showCloseButton: true
                        });
                        reject();
                    }
                },
                error => {
                    var errorMessage = <any>error;
                    Messenger().post({
                        message: 'No se pudo comunicar con el servidor',
                        type: 'error',
                        showCloseButton: true
                    });
                    reject();
                }
            );
        });
        return promise;
    }
}
