export class LoginModel
{
     public clave: any;
    public cuenta: any;
    public id:boolean;
    public ip:number;
    public captcha:boolean;
    public origen:number;
    
    constructor() 
    {
        this.clave = null;
        this.cuenta = null;
        this.id = null;
        this.ip = null;
        this.captcha = false;
        this.origen = null;
    }
}


