import {AppState} from "../../../app.service";

export class AlumnoModel
{
  public AlumnoId:any;
  public PrimerNombre: any;
  public SegundoNombre: any;
  public ApellidoPaterno: any;
  public ApellidoMaterno: any;
  public Lada: any;
  public Telefono: any;
  public Tel: any;
  public Correo: any;
  public ViveConId: any;
  public Calle: any;
  public NumeroExterior: any;
  public NumeroInterior: any;
  public Colonia: any;
  public OtraColonia: any;
  public CiudadId: any;
  public EstadoId: any;
  public CodigoPostal: any;

  public PaisNacimiento:any;
  public EstadoNacimiento:any;
  public CiudadNacimiento:any;

  public Nivel:any;
  public NivelId:any;
  public Grado:any;
  public Matricula:any;


  constructor()
  {
    this.AlumnoId = null;
    this.PrimerNombre = null;
    this.SegundoNombre = null;
    this.ApellidoPaterno = null;
    this.ApellidoMaterno = null;
    this.Telefono = null;
    this.Lada = null;
    this.Tel = null;
    this.Correo = null;
    this.ViveConId = null;
    this.Calle = null;
    this.NumeroExterior = null;
    this.NumeroInterior = null;
    this.Colonia = null;
    this.OtraColonia = null;
    this.CiudadId = null;
    this.EstadoId = null;
    this.CodigoPostal = null;

    this.PaisNacimiento = null;
    this.EstadoNacimiento = null;
    this.CiudadNacimiento = null;

    this.Nivel = null;
    this.NivelId = null;
    this.Grado = null;
    this.Matricula = null;
  }


}


export class DinamicaFamiliar
{
  public AlumnoDinamicaFamiliarId:any;
  public Ninguna:any;
  public Divorcio:any;
  public Separacion:any;
  public Custodia:any;
  public ParentescoId:any;
  public EnfermedadGrave:any;
  public EspecificacionEnfermedadGrave:any;
  public Muerte:any;
  public EspecificacionMuertes:any;
  public CambioResidencia:any;
  public MedioHermano:any;
  public SegundoMatrimonio:any;
  public MadrePadreSoltero:any;
  public Otro:any;
  public EspecificacionOtro:any;

  constructor()
  {
    this.AlumnoDinamicaFamiliarId = null;
    this.Ninguna = null;
    this.Divorcio = null;
    this.Separacion = null;
    this.Custodia = null;
    this.ParentescoId = null;
    this.EnfermedadGrave = null;
    this.EspecificacionEnfermedadGrave = null;
    this.Muerte = null;
    this.EspecificacionMuertes = null;
    this.CambioResidencia = null;
    this.MedioHermano = null;
    this.SegundoMatrimonio = null;
    this.MadrePadreSoltero = null;
    this.Otro = null;
    this.EspecificacionOtro = null;
  }
}


export class DatoMedico
{
  public AlumnoDatoMedicoId:any;
  public ContactoEmergenciaNombre:any;
  public ContactoEmergenciaLada:any;
  public ContactoEmergenciaTelefono:any;
  public ContactoEmergenciaParentesco:any;
  public EnfermedadCronica:any;
  public Padece:any;
  public PadeceEnfermedadCuidaNombre:any;
  public PadeceEnfermedadTelefono:any;
  public PadeceEnfermedadLada:any;
  public PadeceEnfermedadDescripcion:any;
  public Alergico:any;
  public AlergicoDescripcion:any;
  public AntecedenteFamiliar:any;
  public AntecedenteFamiliarDescripcion:any;
  public ExamenVista:any;
  public ExamenAuditivo:any;
  public ExamenOrtopedico:any;
  public AparatoAuditivo:any;
  public AditamentoOrtopedico:any;
  public Talla:any;
  public Peso:any;
  public Lentes:any;
  public AutorizoAntihistaminico:any;
  public TipoSangineo:any;
  public NombreAutoriza:any;

  public TomaMedicamento:any;
  public TomaMedicamentoDescripcion:any;

  constructor()
  {
    this.AlumnoDatoMedicoId = null;
    this.ContactoEmergenciaNombre = null;
    this.ContactoEmergenciaLada = null;
    this.ContactoEmergenciaTelefono = null;
    this.ContactoEmergenciaParentesco = null;
    this.EnfermedadCronica = null;
    this.Padece = null;
    this.PadeceEnfermedadCuidaNombre = null;
    this.PadeceEnfermedadTelefono = null;
    this.PadeceEnfermedadLada = null;
    this.PadeceEnfermedadDescripcion = null;
    this.Alergico = null;
    this.AlergicoDescripcion = null;
    this.AntecedenteFamiliar = null;
    this.AntecedenteFamiliarDescripcion = null;
    this.ExamenVista = null;
    this.ExamenAuditivo = null;
    this.ExamenOrtopedico = null;
    this.AparatoAuditivo = null;
    this.AditamentoOrtopedico = null;
    this.Talla = null;
    this.Peso = null;
    this.Lentes = null;
    this.AutorizoAntihistaminico = null;
    this.TipoSangineo = null;
    this.NombreAutoriza = null;

    this.TomaMedicamento = null;
    this.TomaMedicamentoDescripcion = null;
  }
}

export class Hermano
{
  public HermanoId:any;
  public AlumnoId:any;
  public Nombre:any;
  public ApellidoPaterno:any;
  public ApellidoMaterno:any;
  public CURP:any;
  public Edad:any;

  constructor()
  {
    this.HermanoId = null;
    this.AlumnoId = null;
    this.Nombre = null;
    this.ApellidoPaterno = null;
    this.ApellidoMaterno = null;
    this.CURP = null;
    this.Edad = null;
  }
}

export class ContactoEmegrencia
{
  public ContactoEmergenciaId:any;
  public AlumnoId:any;
  public ContactoEmergenciaNombre:any;
  public ContactoEmergenciaLada:any;
  public ContactoEmergenciaTelefono:any;
  public ContactoEmergenciaParentesco:any;
  public ContactoEmergenciaEmail:any;

  constructor()
  {
    this.ContactoEmergenciaId = null;
    this.AlumnoId = null;
    this.ContactoEmergenciaNombre = null;
    this.ContactoEmergenciaLada = null;
    this.ContactoEmergenciaTelefono = null;
    this.ContactoEmergenciaParentesco = null;
    this.ContactoEmergenciaEmail = null;
  }
}

