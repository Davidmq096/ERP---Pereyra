import {Component, OnInit, Input} from "@angular/core";
import {AppState} from "app/app.service";
import {FormGroup, FormControl, FormBuilder, Validators} from "@angular/forms";
import {parametrosModal} from './../../modal/modalsolicitud';
import {Helpers} from "app/app.helpers";

declare let Messenger: any;

@Component({
    selector: "vehiculo",
    templateUrl: "vehiculo.component.html",
    providers: [AppState]
})
export class VehiculoComponent implements OnInit {
    @Input() editable: boolean;
    @Input() sistema: any;
    @Input() solicitudid: number;
    @Input() selectEstatusvehiculo: any[];
    @Input() datosvehiculos: any[];
    @Input() yearMask
    @Input() parametrosModal: parametrosModal;

    formvehiculos: FormGroup;
    submitted: boolean;
    nuevo: any = false;

    constructor(private URLBase: AppState, private _httpService: AppState, private _help: Helpers, private _fb: FormBuilder) {
    }

    //Metodo de inicio
    ngOnInit(): void {
        this.formvehiculos = this._fb.group({
            nombre: [],
            estatus: [, <any> Validators.required],
            solicitudid: [this.solicitudid],
            marcamodelo: [, <any> Validators.required],
            tarjetacirculacion: [, <any> Validators.required],
            anio: [, <any> Validators.required],
            portal: 1
        });
    }

    cancelar() {
        this.submitted = false;
        this.nuevo = false;
        this.formvehiculos.reset({solicitudid: this.solicitudid, portal: 1});
    }

    transformartexto(forname: FormControl) {
        let texto: string = forname.value;
        if (texto) {
        forname.setValue(this.sistema == 1 ? texto.toUpperCase() : this._help.capitalize(texto));
        }
    }


    savevehiculo() {
        this.submitted = true;
        if (this.formvehiculos.invalid) {
            return false;
        }
        this._httpService.postElemento( "Becas/SolicitudBeca/SituacionEconomica/Vehiculos", (this.formvehiculos.value),null,true).subscribe(
            res => {
                if (res.status == 200) {
                    this.cancelar();
                    this.datosvehiculos = res.body;
                    Messenger().post({
                        message: "Se ha guardado el registro con éxito",
                        type: "success",
                        showCloseButton: true
                    });
                    this.parametrosModal.pestanaSituacionEconomica.datosvehiculos = res.body;
                } else {
                    Messenger().post({
                        message: "Ocurrio un error al guardar el registro",
                        type: "success",
                        showCloseButton: true
                    });
                }
            },
            err => {
                //handle your error here.
                console.log(err);
            }
        );
    }

    deletevehiculo(c) {
        let msg = Messenger({
            extraClasses: "messenger-fixed messenger-on-top"
        }).post({
            message: `¿Está seguro que desea eliminar el registro?`,
            hideAfter: false,
            actions: {
                cancel: {
                    label: "Cancelar",
                    action: () => {
                        msg.hide();
                    }
                },
                confirm: {
                    label: "Aceptar",
                    action: () => {
                        msg.hide();
                        var id = c.vehiculosid;
                        this._httpService.deleteElemento("Becas/SolicitudBeca/SituacionEconomica/Vehiculo", id).subscribe(
                            result => {
                                if (result.status == 200) {
                                    this.datosvehiculos = result.body;
                                    Messenger().post({
                                        message: "Se ha eliminado el registro exitosamente",
                                        type: "success",
                                        showCloseButton: true
                                    });
                                    this.parametrosModal.pestanaSituacionEconomica.datosvehiculos = result.body;
                                } else {
                                    Messenger().post({
                                        message: "Ocurrio un error al eliminar el registro",
                                        type: "success",
                                        showCloseButton: true
                                    });
                                }
                            },
                            error => {
                                Messenger().post({
                                    message: "No se pudo comunicar con el servidor",
                                    type: "error",
                                    showCloseButton: true
                                });
                            }
                        );
                    }
                }
            }
        });
    }

}
