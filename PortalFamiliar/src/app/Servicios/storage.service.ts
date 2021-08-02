import { Injectable } from '@angular/core';
declare let CryptoJS: any;
/**
 * Este servicio sirve para encriptar y dividir en chunks el localStorage para mantener la seguridad * de los datos
 * Este servicio funciona como el uso normal del localStorage
 * this.storage.getItem()
 * this.storage.setItem()
 * this.storage.removeItem()
 * this.storage.clear()
 */
@Injectable()
export class StorageService {
    //Prefijo del sistema
    perfix: string = 'FAMILIAR';
    secret: string = 'Inceptio2019';
    // Metadata de encripción
    parts: any = {}
    /**
     * Inicializamos la variable parts(@metadata) obteniendo el binario guardado en el localStorage y * lo desencriptamos
     */
    constructor() {
        // Si existe el metadata
        if(localStorage.getItem(this.perfix + '_MJSDUDF76dHDGFnd')){
            // Lo desencriptamos y guardamos en la variable parts
            this.parts = JSON.parse(this.binaryToString(localStorage.getItem(this.perfix + '_MJSDUDF76dHDGFnd')))
        }
    }

    base64url(source) {
        // Encode in classical base64
        let encodedSource = CryptoJS.enc.Base64.stringify(source);
      
        // Remove padding equal characters
        encodedSource = encodedSource.replace(/=+$/, '');
      
        // Replace characters according to base64url specifications
        encodedSource = encodedSource.replace(/\+/g, '-');
        encodedSource = encodedSource.replace(/\//g, '_');
      
        return encodedSource;
    }

    EncodeJwt(data){
        var header = {
            "alg": "HS256",
            "typ": "JWT"
        };
          
        var stringifiedHeader = CryptoJS.enc.Utf8.parse(JSON.stringify(header));
        var encodedHeader = this.base64url(stringifiedHeader);
        
        var stringifiedData = CryptoJS.enc.Utf8.parse(JSON.stringify(data));
        var encodedData = this.base64url(stringifiedData);
        
        var token = encodedHeader + "." + encodedData;

        var signature = CryptoJS.HmacSHA256(token, this.secret);
        signature = this.base64url(signature);

        return token + "." + signature;
    }

    DecodeJwt (token) {
        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    
        try {
            return JSON.parse(jsonPayload)
        } catch (error) {
            return jsonPayload
        }
    }

    /**
     * Guardamos la variable encriptada dividida en chunks y guardamos en el localStorage
     * @param name 
     * @param value 
     */
    setItem(name, value){
        value = this.EncodeJwt(value);
        // Dividimos  el JWT por .
        let parts = value.split('.')
        // Reseteamos la llave del metadata
        this.parts[name] = []
        // Por cada parte en el JWT
        parts.map((part, i) => {
            // Si el index es mayor a 0 concatenamos un . al inicio de esta parte
            if(i > 0){
                // El punto sirve para la union de los tokens de JWT
                part = '.' + part
            }
            // Generamos un nombre random
            let token = this.makeid(20);
            // Agregamos al metadata el nombre creado
            this.parts[name].push(this.getName(token))
            // Guardamos esta parte encriptada en binario con el nombre creado
            localStorage.setItem(this.getName(token), this.stringToBinary(part))
        })
        // Guardamos el metadata
        this.save()
    }
    /**
     * Sirve para generar strings random
     * @param length 
     */
    makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
           result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    /**
     * Construimos el valor original de la variable y la regresamos
     * @param name 
     */
    getItem(name){
        
        // Obtenemos los chunks del localStorage para esta variable
        let chunks = this.getChunk(name)
        // Si no existe regresamos null
        if(!chunks){
            return null;
        }
        // Creamos la instancia del binario
        let binary = ''
        // Por cada chunk obtenemos el binario guardado en localStorage
        chunks.map(chunk => {
            // Lo concatenamos a la variable binary para ir construyendo el binario completo
            binary += localStorage.getItem(chunk)

        })

        // Convertimos el binario en encripción JWT
        let token = this.binaryToString(binary)
        try {
            return this.DecodeJwt(token)
        } catch (error) {
            return null;
        }

    }
    /**
     * Obtenemos los chunks por una variable
     * @param name 
     */
    getChunk(name){
        // Si existe el metadata en el localStorage
        if(localStorage.getItem(this.perfix + '_MJSDUDF76dHDGFnd')){
            // Desencriptamos el binario
            let parse = JSON.parse(this.binaryToString(localStorage.getItem(this.perfix + '_MJSDUDF76dHDGFnd')))
            // Obtenemos los chunks por el nombre buscado
            if(parse[name]){
                return parse[name]
            }
        }
        // Si no existe o no se encuentra la variable regresamos nulll
        return null
    }
    /**
     * Eliminamos los chunks del localStorage y del metadata
     * @param name 
     */
    removeItem(name){
        // Obtenemos los chunks por el nombre de la variable
        let chunks = this.getChunk(name)
        // Si existe
        if(chunks){
            // Eliminamos los chunks del metadata
            delete this.parts[name]
            // Por cada chunk
            chunks.map(chunk => {
                // lo eliminamos del localStorage
                localStorage.removeItem(chunk)
            })
        }
        // Guardamos el metadata
        this.save()
    }
    /**
     * Sirve para guardar el metadata y los chunks en el localStorage
     */
    save(){
        // Obtenemos todas las variables del localStorage
        let data = Object.assign({}, localStorage);
        // Limpiamos el localStorage
        this.ClearLocalStorage();
        // Por cada elemento del localStorage

        Object.keys(data).filter(storage=> {
            if(new RegExp(this.perfix).test(storage)) {
                return true;
            }
            return false;
        }).map(storage => {
            // Iteramos el metadata
            Object.keys(this.parts).map(part => {
                // Por cada chunk del metadata
                this.parts[part].map(key => {
                    // Si el elemento del localStorage aun existe en el metadata
                    if(key == storage){
                        // lo guardamos en el localStorage
                        localStorage.setItem(storage, data[storage])
                    }
                })
            })
        })
        // Guardamos en el localStorage el metadata
        localStorage.setItem(this.perfix + '_MJSDUDF76dHDGFnd', this.stringToBinary(JSON.stringify(this.parts)))
    }
    /**
     * Convierte un string a binario
     * @param input 
     */
    stringToBinary(input) {
        var characters = input.split('');
        return characters.map(function(char) {
          const binary = char.charCodeAt(0).toString(2)
          const pad = Math.max(8 - binary.length, 0);
          return '0'.repeat(pad) + binary;
        }).join('');
    }
    /**
     * Convierte un binario a un string
     * @param input 
     */
    binaryToString(input) {
        let bytesLeft = input;
        let result = '';
        while (bytesLeft.length) {
          const byte = bytesLeft.substr(0, 8);
          bytesLeft = bytesLeft.substr(8);
          result += String.fromCharCode(parseInt(byte, 2));
        }
        return result;
    }
    /**
     * Crea un nombre con el prefijo concatenado
     * @param name 
     */
    getName(name){
        return this.perfix + '_' + name
    }
    /**
     * Limpia todo el localStorage
     */
    clear(){
        this.ClearLocalStorage()
    }

    ClearLocalStorage() {
        let keys = Object.keys(localStorage);
        keys.map((x: string)=>{
            if(new RegExp(this.perfix).test(x)) {
                localStorage.removeItem(x);
            }
        })
    }
}
