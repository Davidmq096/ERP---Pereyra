/*
 * Autor: Emmanuel Martinez Ayala
 * Creacion 20/08/2019
 * U. Modificacion: 06/09/2019
 */
import { AppState } from 'app/app.service';
import {StorageService} from 'app/Servicios/storage.service';

export class MenuCache{
	public pos:{source:MenuItem[],index:any}
	public constructor(public item:MenuItem,
		public parent:MenuItem,
		source:MenuItem[],index:any){
		this.pos={source:source, index:index};
	}
}
export class MenuItem{
	private _data:any;
	private _type:number=0;
	private _icon:string="";
	private _color:string="";
	public constructor(private _id:number,
		private _key:string,
		private _name:string){}
	public set action(x:any){
		this._data=x;
		this._type=(x[0]==="/" ? 1 : 2);
	}
	public set menu(x:any){
		if(!Array.prototype.isPrototypeOf(this._data)){
			this._data=[];
			this._type=3;
		}
		this._data.push(x);
	}
	public set icon(x:string){ this._icon=x; }
	public set color(x:string){ this._color=x; }
	public get tipo(){ return MenuItem.TYPE[this._type]; }
	public get id(){ return this._id; }
	public get key(){ return this._key; }
	public get title(){ return this._name; }
	public get icon(){ return this._icon; }
	public get hover(){ return this._color; }
	public get isMenu(){ return this._type===3; }
	public get isLink(){ return this._type===1; }
	public get isFunction(){ return this._type===2; }
	public get menu(){ return (this.isMenu ? this._data : null); }
	public get link(){ return (this.isLink ? this._data : null); }
	public get action(){ return (this.isFunction ? this._data : null); }
	public get linkforce(){
		if(this.isLink){ return this._data; }
		else if(this.isMenu){ return this._data[0].link; }
		return null;
	}

	private static TYPE:string[]=["texto","enlace","funcion","menu"];
}
export class MenuList{
	private _key:any;
	private _url:any;
	private _index:any;
	private _menu:MenuItem[];
	public storage: StorageService;
	public constructor(st: boolean = false){
		this.storage = new StorageService();
		if(!st) {
			this._menu = [...MenuList.cache];
			this.cache();
		}
	}
	public get menu():MenuItem[]{
		return this._menu;
	}
	public getById(id:number):MenuCache{
		return this._index[id];
	}
	public getByUrl(url:string):MenuCache{
		return this._url[url];
	}
	public getByKey(key:string):MenuCache{
		return this._key[key];
	}
	public remove(id:number):void{
		let d=this.getById(id);
		if(d){
			let di=d.pos;
			di.source.splice(di.index,1);
			this.cache();
		}
	}
	public removeKey(key:string):void{
		let d=this.getByKey(key);
		if(d){
			let di=d.pos;
			di.source.splice(di.index,1);
			this.cache();
		}
	}
	public cache(){
		this._key={};
		this._url={};
		this._index={};
		this._cache(this.menu,null);
	}
	private _cache(data,parent){
		for(let k in data){
			let i=data[k],
				op=i.menu,
				cached=new MenuCache(i, parent, data, k);
			this._index[i.id]=cached;
			if(i.key){ this._key[i.key]=cached; }
			if(op){
				this._cache(op,i);
			}else if(i.isLink){
				this._url[i.link]=cached;
			}
		}
	}

	public static cache:MenuItem[]=null;
	public static create(_aSt:AppState, callback:any):void{
		let onReady=()=>{ callback(new MenuList()); };
		let menuliststorage = new MenuList(true);
		if(!MenuList.cache){
			let menu=menuliststorage.storage.getItem("_mcache");
			if(!menu){
				_aSt.getElemento("Parametros/Menu/"+AppState.SISTEMAID).subscribe(r=>{
					if(r.status==200){
						let data=r.body,
							dataraw=JSON.stringify(data);
							menuliststorage.storage.setItem("_mcache",dataraw);
						MenuList.buildFromString(dataraw);
						onReady();
					}else{ console.error("Couldn´t load menu data."); }
				},e=>{ console.error("Couldn´t load menu data."); });
				return;
			}
			MenuList.buildFromString(menu);
		}
		onReady();
	}
	private static buildFromString(raw:string){
		let menuraw=JSON.parse(raw),
			data=[];
        for (let i of menuraw){
			let di=new MenuItem(i.id,i.key,i.title);
			if(i.icon){ di.icon=i.icon; }
			if(i.color){ di.color=i.color; }
			if(i.action){ di.action=i.action; }
			data.push(di);
		}
        for (let i of menuraw){
			if(i.parentid){
				let di=data.find(x=>{ return x.id==i.id; }),
					dp=data.find(x=>{ return x.id==i.parentid; });
				if(di && dp){
					dp.menu=di;
					data.splice(data.indexOf(di),1);
				}
			}
		}
		MenuList.cache=data;
	}
}