import {Injectable} from '@angular/core';

declare var $: any;

@Injectable()
export class Helpers {

    constructor() {}

    /**
    * Esta función sirve para imprimir HTML
    * @param {contenido} HTML
    * @returns PRINT
    */
    print(contenido: string) {
        // Primero obtenemos todos los <style></style> del <head>
        let styles = $('head').find('style')
        // Declaramos una variable donde alojaremos todos los CSS
        let style = ''
        // Recorremos cada <style>
        styles.each(function (i, e) {
            // Obtenemos el css y lo agregamos a nuestra variable style
            style += $(e)[0].innerText;
        })
        var hiddenFrame = $('<iframe></iframe>').appendTo('body')[0];
        hiddenFrame.contentWindow.printAndRemove = function () {
            hiddenFrame.contentWindow.print();
            $(hiddenFrame).remove();
        };
        var htmlDocument = "<!doctype html>" +
            `<html>
            <style>${style}</style>
            <body onload="printAndRemove();">${contenido}</body></html>`;
        var doc = hiddenFrame.contentWindow.document.open("text/html", "replace");
        doc.write(htmlDocument);
        doc.close();
    }

    /**
     * Esta función sirve para imprimir archivos PDF desde un BLOB o bien
     * desde una URL
     * @param {blob}
     * @param {type}
     * @return Empty
     */
    printPDF(blob: any, type: string = 'blob') {
        // Verificamos si el tipo de impresión viene de un blob o una URL
        if (type == 'url') {
            // Hacemos una llamada AJAX al archivo
            var oReq = new XMLHttpRequest();
            // Abrimos la conexión AJAX
            oReq.open("GET", blob, true);
            // Le decimos a la petición que la respuesta deberá ser  {arraybuffer}
            oReq.responseType = "arraybuffer";
            // Asignamos una función callback cuando recibamos una respuesta
            oReq.onload = function (oEvent) {
                // Generamos un blob del buffer recibido
                var blob = new Blob([oReq.response], {type: 'application/pdf'});
                // Generamos una URL con este blob
                const blobUrl = URL.createObjectURL(blob);
                // Creamos un iframe
                const iframe = document.createElement('iframe');
                // Le asignamos a este iframe un display: none para que no se muestre
                iframe.style.display = 'none';
                // Le añadimos al src la url recien creada
                iframe.src = blobUrl;
                // Agregamos nuestor iframe a nuestro body
                document.body.appendChild(iframe);
                // Ejecutamos la función print en este iframe
                iframe.contentWindow.print();
            };

            oReq.send();
        } else {
            // Generamos un blob del buffer recibido
            blob = new Blob([blob], {type: 'application/pdf'});
            // Generamos una URL con este blob
            const blobUrl = URL.createObjectURL(blob);
            // Creamos un iframe
            const iframe = document.createElement('iframe');
            // Le asignamos a este iframe un display: none para que no se muestre
            iframe.style.display = 'none';
            // Le aÃ±adimos al src la url recien creada
            iframe.src = blobUrl;
            // Agregamos nuestor iframe a nuestro body
            document.body.appendChild(iframe);
            // Ejecutamos la funciÃ³n print en este iframe
            iframe.contentWindow.print();
        }
    }

    /**
     * Esta función sirve para dividir el telefono en lada y telefono
     * @param {telefono}
     * @return [lada,telefono]
     */
    ParseTelefono(telefono: string): string[] {
        try {
            if (telefono) {
                telefono = telefono.replace(/ +?/g, '')
                let lada;
                let tel;
                if (telefono.length == 10) {
                    lada = "(" + telefono.substring(0, 3) + ")";
                    tel = telefono.substring(3, 10).substring(0, 3) + "-" + telefono.substring(3, 10).substring(3, 7);
                } else if (telefono.length == 11) {
                    lada = "(" + telefono.split("-")[0] + ")";
                    telefono = telefono.split("-")[1];
                    if (lada.length == 5) {
                        tel = telefono.substring(0, 3) + "-" + telefono.substring(3, 7);
                    } else {
                        tel = telefono.substring(0, 4) + "-" + telefono.substring(4, 8);
                    }
                } else {
                    lada = null;
                    tel = null;
                }
                return [lada, tel]
            } else {
                return [null, null];
            }
        } catch (error) {
            return [null, null];
        }
    }

    /**
    * Esta función sirve para unir el telefono quitandole la mascara
    * @param {lada}
    * @param {telefono}
    * @return telefono
    */
    UnitTelefono(lada: string, telefono: string): string {
        if (lada && telefono) {
            //Quitamos las mascara
            lada = lada.match(/\d/g).join('');
            telefono = telefono.match(/\d/g).join('');
            //Unimos el telefono
            return lada + "-" + telefono;
        } else {
            return null;
        }
    }

    /**
    * Esta función sirve para convertir el objeto del control de fecha por un string con formato yyyy-mm-dd
    * @param {objFecha}
    * @return fecha
    */
    FechaObjetoToString(date: {day: number, month: number, year: number}) {
        return date.year + '-' + date.month + '-' + date.day;
    };


    /**
    * Esta función sirve para convertir una fecha string en el objeto para setar al control de la fecha
    * @param fecha
    * @return {day: number, month: number, year: number}
    */
    FechaToStringObjeto(date: string) {
        if (date) {
            let fecha = date.split("T")
            if (fecha[0]) {
                fecha = fecha[0].split("-");
                return {year: Number(fecha[0]), month: Number(fecha[1]), day: Number(fecha[2])}
            } else {
                null;
            }
        } else {
            return null;
        }
    };

    /**
    * Esta función sirve para capitalizar un string (primera letra de una palabra en mayuscula)
    * @param texto
    * @return texto
    */
    capitalize(texto: string) {
        if (texto) {
            texto = texto.toLowerCase();
            return texto.replace(/(^|\s)[a-z\u00E0-\u00FC]/g, c => c.toUpperCase());
        } else {
            return null;
        }
    }

}
