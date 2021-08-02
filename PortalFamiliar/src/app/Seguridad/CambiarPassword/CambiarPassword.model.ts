
export class CambiarPasswordModel
{
  public Correo:string;
  public UsuarioId:number;
  public Password:any;
  public NuevoPassword:any;
  public ConfirmarPassword:any;

  constructor()
  {
    this.Correo = null;
    this.UsuarioId = null;;
    this.Password = null;
    this.NuevoPassword = null;;
    this.ConfirmarPassword = null;;
  }

}
