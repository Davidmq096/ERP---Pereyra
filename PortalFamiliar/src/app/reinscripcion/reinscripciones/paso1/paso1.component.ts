import {ViewEncapsulation, Component,  AfterViewInit,  OnInit, Output, EventEmitter, Input, ElementRef,  ViewChild} from '@angular/core';
import {AppState} from 'app/app.service';
import { MenuList } from "entity/menulist.ts";
import {StorageService} from 'app/Servicios/storage.service';
import {FormGroup, FormBuilder, Validators, FormArray} from '@angular/forms';
import {ModalDirective} from 'ng2-bootstrap/modal';
import {TelefonoService} from "app/Servicios/Telefono.Service";
import {Reinscripciones} from 'app/reinscripcion/reinscripciones/reinscripciones';
import {saveAs as importedSaveAs} from "file-saver";
import {Helpers} from 'app/app.helpers';

declare let Messenger: any;

@Component({
    selector: 'paso1',
    templateUrl: './paso1.component.html',
    providers: [AppState],
    encapsulation: ViewEncapsulation.None,
})
export class Paso1Component implements OnInit, AfterViewInit {
    @Input() reinscripciones: Reinscripciones;
    @Output() output = new EventEmitter();
    @Output() paso2 = new EventEmitter(); 

    @ViewChild('modal') public modal: ModalDirective; 

    arrayDocumentos: any[] = [];
    tramitobecaSelect: any[] = [];
    FormGuardar: FormGroup;
    mensaje: string;
    submitted: boolean;
    arrayPagocolegiaturas: any[] = [];
    arrayPagoadelantada: any[] = [];
    arrayInscripcion: any[] = [];
    arrayTipocolegiatura: any[] = [];
    arrayTipopago: any[] = [];
    mostrarpagoanticipado: boolean;
    mostrarpagocolegiatura: boolean;
    cambio: boolean = false;
    tutor: any;
    Parentesco: any;
    Padres: any;
    padresotutor: any;
    padreotutorid: any;
    preview: any;
    reinscripcionid: any;    

    //En el contructor se declara la llamada a los servicios
    constructor(private _he:ElementRef, private _httpService: AppState, private _fb: FormBuilder, public helpers: Helpers, private storage: StorageService, public telefonoService: TelefonoService) {
        this.padreotutorid = this.storage.getItem('PadresOTutoresId');
        MenuList.visible = true;
        window.onpopstate = null;
    }

    //Metodo de inicio
    ngOnInit(): void {

        this._httpService.inputValidateSuccess('tel');
        this.FormGuardar = this._fb.group({
            reinscripcionid: [],
            correo: [, Validators.pattern(
                /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            )],
            tramitobeca: [, <any> Validators.required],
            formapagocolegiaturaid: [, <any> Validators.required],
            formapagocolegiaturaanticipadaid: [],
            formapagoinscripcion: [],
            //lada: [, <any>Validators.compose([Validators.required, Validators.pattern(new RegExp('\([1-9][0-9]{1,2}\)'))])],
            tel: [, <any> Validators.required],
            pagocolegiaturas: [, <any> Validators.required],
            firmantenombre: [, <any> Validators.required],
            firmanteap: [, <any> Validators.required],
            firmanteam: [, <any> Validators.required],
            firmanteparentesco: [, <any> Validators.required],
            tipopagocolegiaturas: [],
            responsableid: []
        });
        this.datosAlumnos();
        this.tramitobecaSelect = [
            {id: 1, nombre: "SI"},
            {id: 0, nombre: "NO"}
        ]        
        if(this.reinscripciones.catalogos) {
            let docs = this.reinscripciones.catalogos.arrayDocumentos;
            this.arrayPagocolegiaturas = this.reinscripciones.catalogos.arrayPagocolegiaturas;
            this.arrayPagoadelantada = this.reinscripciones.catalogos.arrayPagoadelantada;
            this.arrayInscripcion = this.reinscripciones.catalogos.arrayInscripcion;
            this.arrayDocumentos = docs.filter(x=> x.grados.includes(this.reinscripciones.alumno.gradoid));
            this.arrayTipopago = this.reinscripciones.catalogos.arrayTipopago;
        }
        if(this.reinscripciones.formPaso1) {
            this.mostrarpagoanticipado = this.reinscripciones.formPaso1.formapagocolegiaturaanticipadaid ? true : false;
            this.FormGuardar.get("correo").setValue(this.reinscripciones.formPaso1.correo);
            this.FormGuardar.get("tramitobeca").setValue(this.reinscripciones.formPaso1.tramitobeca);
            this.FormGuardar.get("formapagocolegiaturaid").setValue(this.reinscripciones.formPaso1.formapagocolegiaturaid);
            this.FormGuardar.get("formapagocolegiaturaanticipadaid").setValue(this.reinscripciones.formPaso1.formapagocolegiaturaanticipadaid);
            this.FormGuardar.get("formapagoinscripcion").setValue(this.reinscripciones.formPaso1.formapagoinscripcion);
            this.FormGuardar.get("tel").setValue(this.reinscripciones.formPaso1.telefono);
            this.FormGuardar.get("reinscripcionid").setValue(this.reinscripciones.formPaso1.reinscripcionid);
            this.mostrarpagocolegiatura = this.reinscripciones.formPaso1.pagocolegiaturas ? true : false;
            this.FormGuardar.get("pagocolegiaturas").setValue(this.reinscripciones.formPaso1.pagocolegiaturas);
            this.FormGuardar.get("tipopagocolegiaturas").setValue(this.reinscripciones.formPaso1.tipopagocolegiaturas);        
            if(this.reinscripciones.formPaso1.firmanteam) {
                console.log('Entro');
                console.log(this.reinscripciones.formPaso1);
                this.FormGuardar.get("firmantenombre").setValue(this.reinscripciones.formPaso1.firmantenombre);
                this.FormGuardar.get("firmanteap").setValue(this.reinscripciones.formPaso1.firmanteap);
                this.FormGuardar.get("firmanteam").setValue(this.reinscripciones.formPaso1.firmanteam);
                this.FormGuardar.get('firmanteparentesco').setValue(this.reinscripciones.formPaso1.firmanteparentesco);
            }
        } else {
            
            let t = this.reinscripciones.alumno.tramitobeca == false ? "viene" : "no viene"
            this.mostrarpagoanticipado = this.reinscripciones.alumno.formapagocolegiaturaanticipadaid ? true : false;
            this.mostrarpagocolegiatura = this.reinscripciones.alumno.pagocolegiaturas ? true : false;

            this.FormGuardar.get("correo").setValue(this.reinscripciones.alumno.correo);

            this.FormGuardar.get("tramitobeca").setValue(this.reinscripciones.alumno.tramitobeca == false ? 0 : this.reinscripciones.alumno.tramitobeca ?
                1 : null);

            this.FormGuardar.get("pagocolegiaturas").setValue(this.reinscripciones.alumno.pagocolegiaturas == false ? 0 : this.reinscripciones.alumno.pagocolegiaturas ?
                1 : null);

            this.FormGuardar.get("tipopagocolegiaturas").setValue(this.reinscripciones.alumno.tipopagocolegiaturas ?
                parseInt(this.reinscripciones.alumno.tipopagocolegiaturas) : null);    

            this.FormGuardar.get("formapagocolegiaturaid").setValue(this.reinscripciones.alumno.formapagocolegiaturaid ?
                parseInt(this.reinscripciones.alumno.formapagocolegiaturaid) : null);

            this.FormGuardar.get("formapagocolegiaturaanticipadaid").setValue(this.reinscripciones.alumno.formapagocolegiaturaanticipadaid ? 
                parseInt(this.reinscripciones.alumno.formapagocolegiaturaanticipadaid) : null);

            this.FormGuardar.get("formapagoinscripcion").setValue(this.reinscripciones.alumno.formapagoinscripcionyfoid ? 
                parseInt(this.reinscripciones.alumno.formapagoinscripcionyfoid) : null);
            this.FormGuardar.get("reinscripcionid").setValue(this.reinscripciones.alumno.reinscripcionid);
            if(this.reinscripciones.alumno.telefono) {
                /* Ya no existe lada */
               // this.FormGuardar.get("lada").setValue(this.helpers.ParseTelefono(this.reinscripciones.alumno.telefono)[0]);
               // this.FormGuardar.get("tel").setValue(this.helpers.ParseTelefono(this.reinscripciones.alumno.telefono)[1]);
               this.FormGuardar.get("tel").setValue(this.reinscripciones.alumno.telefono);
            }            
            if(this.reinscripciones.alumno.documentoresponsable.length > 0) {
               let firmante = this.reinscripciones.alumno.documentoresponsable.filter(x=> x.documentoid.documentoid == 1 );
               this.FormGuardar.get("firmantenombre").setValue(firmante[0].nombre);
               this.FormGuardar.get("firmanteap").setValue(firmante[0].apellidopaterno);
               this.FormGuardar.get("firmanteam").setValue(firmante[0].apellidomaterno);
               this.FormGuardar.get("firmanteparentesco").setValue(firmante[0].tutorid.tutorid);
               this.FormGuardar.get("responsableid").setValue(firmante[0].responsablecontratoid);
            }
        }
    }

    ngAfterViewInit() {
        this.FormGuardar.get("formapagocolegiaturaid").valueChanges.subscribe((mat) => {
            this.FormGuardar.get("formapagocolegiaturaanticipadaid").setValidators(mat && mat == 3 ? Validators.required : null);
            this.FormGuardar.get("formapagocolegiaturaanticipadaid").updateValueAndValidity();
            this.mostrarpagoanticipado = mat && mat == 3 ? true: false;
            if (mat && mat != 3) {
                this.FormGuardar.get("formapagocolegiaturaanticipadaid").setValue(null);
            }
        });
        /*this.FormGuardar.get('tel').valueChanges.subscribe(() => {
            let p = '\\d{10}';
            this.FormGuardar.get('tel').setValidators([Validators.required, Validators.pattern(p)]);
            this.FormGuardar.get('tel').updateValueAndValidity();
        });*/
        /*this.FormGuardar.valueChanges.subscribe(() => {
            console.log('Entro');
            this.cambio = true;
        });*/
        this.FormGuardar.get("pagocolegiaturas").valueChanges.subscribe((mat) => {
            let val=''+mat;
            this.FormGuardar.get("tipopagocolegiaturas").setValidators(val && val == '1' ? Validators.required : null);
            this.FormGuardar.get("tipopagocolegiaturas").updateValueAndValidity();
            this.mostrarpagocolegiatura = val && val == '1' ? true: false;
            if (val && val != '1') {
                this.FormGuardar.get("tipopagocolegiaturas").setValue(null);
            }
        });
    }


    descargar(id) {
        this._httpService.getArchivo("Reinscripcion/Documentoalumno/descargar", + "?reinscripcionid=" + this.reinscripcionid).subscribe(
            result => {
                if (result.status == 200) {
                    let docs = this.arrayDocumentos.find(x=> x.documentoid == id);
                    importedSaveAs(result.body, docs.nombre);
                    this.cancelar();
                } else {
                    Messenger().post({
                        message: result.body,
                        type: "success",
                        showCloseButton: true
                    });
                }
            },
            error => {
                var errorMessage = <any> error;
                Messenger().post({
                    message: "No se pudo comunicar con el servidor",
                    type: "error",
                    showCloseButton: true
                });
            }
        );
    }

    cancelar() {
        this.submitted = true;
        if(!this.cambio) {
            this.output.next();
            return false;
        }
        if(this.FormGuardar.invalid) {
            return false;
        }
        this.reinscripciones.formPaso1 = this.FormGuardar.value;
        let data = this.FormGuardar.value;
        //data.telefono = this.helpers.UnitTelefono(data.lada, data.tel);
        data.telefono = data.tel;
        data.info = [{nombre: this.FormGuardar.get('firmantenombre').value,
        ap: this.FormGuardar.get('firmanteap').value,
        am: this.FormGuardar.get('firmanteam').value,
        responsableid: this.FormGuardar.get('responsableid').value,
        parentesco: this.FormGuardar.get('firmanteparentesco').value,
        documentoid: 1}
       ];
        this._httpService.postElemento('Controlescolar/Reinscripcion/AlumnoPago/', this.FormGuardar.value, null, true).subscribe(
            res => {
                if (res.status == 200) {
                    this.output.next();
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                } else {
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            err => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'success',
                    showCloseButton: true
                });
                console.log('error');
            }
        );
    }

    siguiente() {

        this.submitted = true;        
        if(this.FormGuardar.invalid) {   
            window.scrollTo(0, 0);      
            return false;
        }
        if (this.FormGuardar.get('tel').value == '' || this.FormGuardar.get('tel').value == null){
            this._httpService.inputValidateDanger('tel', 'Ingrese un teléfono valido');
            return false;
        }
        /*if(!this.cambio) {
            console.log('test2');
            return false;
        }*/
        this.reinscripciones.formPaso1 = this.FormGuardar.value;
        let data = this.FormGuardar.value;
        data.telefono = data.tel;
        data.info = [{nombre: this.FormGuardar.get('firmantenombre').value,
                     ap: this.FormGuardar.get('firmanteap').value,
                     am: this.FormGuardar.get('firmanteam').value,
                     responsableid: this.FormGuardar.get('responsableid').value,
                     parentesco: this.FormGuardar.get('firmanteparentesco').value,
                     documentoid: 1}
                    ];

        //data.telefono = this.helpers.UnitTelefono(data.lada, data.tel);
        this._httpService.postElemento('Controlescolar/Reinscripcion/AlumnoPago/', this.FormGuardar.value, null, true).subscribe(
            res => {
                if (res.status == 200) {
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                    this.paso2.next();
                } else {
                    Messenger().post({
                        message: res.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            err => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'success',
                    showCloseButton: true
                });
                console.log('error');
            }
        );
    }
    /* Elegir un padreotutor */
    seleccionPadre(e: any){
        let ev_padre = this.Padres.filter(x=> x.padresotutoresid == e);
        this.FormGuardar.get('firmanteam').setValue(ev_padre[0].apellidomaterno);
        this.FormGuardar.get('firmanteap').setValue(ev_padre[0].apellidopaterno);
        this.FormGuardar.get('firmantenombre').setValue(ev_padre[0].nombre);
        this.FormGuardar.get('firmanteparentesco').setValue(ev_padre[0].parentescoid);
        this.FormGuardar.get('correo').setValue(ev_padre[0].correo);
        this.FormGuardar.get('tel').setValue(ev_padre[0].celular);
    }

    /* Buscar información */
    datosAlumnos() {
        this._httpService.getElemento('Controlescolar/Reinscripcion/Alumnosbypadretutor/' + this.padreotutorid).subscribe(
            result => {
                if (result.status == 200) {
                    let res = result.body;
                    this.Padres = [];                   
                    res.padresotutores.forEach(element => {
                        element.padresotutoresid.nombrecompleto = element.padresotutoresid.nombre + ' ' + element.padresotutoresid.apellidopaterno + ' ' +  element.padresotutoresid.apellidomaterno;
                        element.padresotutoresid.parentescoid = element.tutorid.tutorid;
                        this.Padres.push(element.padresotutoresid);
                    });                    
                    let tutores = res.tutores.filter(x=> x.descripcion !== 'Aspirante');
                    this.Parentesco =  tutores;
                    if (this.reinscripciones.formPaso1){
                        this.reinscripcionid = this.reinscripciones.formPaso1.reinscripcionid;                        
                        let responsable = res.alumnos.filter(x=> x.reinscripcionid == this.reinscripciones.formPaso1.reinscripcionid);
                        console.log(responsable);
                        let firmante = responsable[0].documentoresponsable.filter(x=> x.documentoid.documentoid == 1);
                        console.log(firmante);
                        this.FormGuardar.get('responsableid').setValue(firmante[0].responsablecontratoid);
                    }else{
                        this.reinscripcionid = this.reinscripciones.alumno.reinscripcionid;
                    }
                } else {
                    Messenger().post({
                        message: result.body,
                        type: 'success',
                        showCloseButton: true
                    });
                }
            },
            error => {
                Messenger().post({
                    message: 'No se pudo comunicar con el servidor',
                    type: 'error',
                    showCloseButton: true
                });
            }
        );
    }

    //vista de contratos
    openContrato(id){
        this.modal.show();
        this.preview=true;
		this._httpService.getArchivo("Controlescolar/Reinscripcion/Documentoalumno/descargar", id + "?reinscripcionid=" + this.reinscripcionid).subscribe(
			result=>{
				if(result.status == 200){
					let iframe=this._he.nativeElement.querySelector('iframe');
                    iframe.src=window.URL.createObjectURL(result.body) + '#toolbar=0&zoom=100&navpanes=0';
				}else{ this._httpService.mensajeDanger('No se encontro ningún documento: ' + id); }
			},
			error=>{ this._httpService.mensajeDanger('No se encontro ningún documento: ' + id);;}
		);
    }

    closeContrato(){
        this.modal.hide();
    }
}
