export class PadreTutorModel
{
  public PadresOTutoresId:any;
  public Nombre: any;
  public ApellidoPaterno: any;
  public ApellidoMaterno: any;
  public Lada: any;
  public Telefono: any;
  public Correo: any;
  public TutorId: any;
  public Antiguedad: any;

  public AlumnoInstituto: any;
  public EspecificarAlumno: any;
  public Nacionalidad: any;
  public SituacionConyugalId: any;
  public NivelEstudioId: any;

  public Ocupacion: any;
  public EspecificacionOcupacion: any;
  public Ramo: any;
  public Empresa: any;
  public TelefonoEmpresa: any;
  public LadaEmpresa: any;
  public ExtensionEmpresa: any;
  public HorarioTrabajo: any;

  public ExLux: any;
  public GeneracionId: any;

  public Vive: any;
  public Tutor: any;
  public FechaNacimiento: any;

  constructor()
  {
    this.PadresOTutoresId = null;
    this.Nombre = null;
    this.ApellidoPaterno = null;
    this.ApellidoMaterno = null;
    this.TutorId = null;
    this.Lada = null;
    this.Telefono = null;
    this.AlumnoInstituto = null;
    this.EspecificarAlumno = null;
    this.Antiguedad = null;

    this.Nacionalidad = [];
    this.SituacionConyugalId = null;
    this.NivelEstudioId = null;

    this.Ocupacion = null;
    this.EspecificacionOcupacion = null;
    this.Ramo = null;
    this.Empresa = null;
    this.TelefonoEmpresa = null;
    this.LadaEmpresa = null;
    this.ExtensionEmpresa = null;
    this.HorarioTrabajo = null;

    this.ExLux = null;
    this.GeneracionId = null;

    this.Vive = null;
    this.Tutor = null;
    this.FechaNacimiento = null;
  }
}

export class PersonaAutorizadaRecogerModel
{
  public PersonaAutorizadaRecogerPorAlumnoId:any;
  public PersonaAutorizadaRecogerId:any;
  public Nombre: any;
  public ParentescoId: any;
  public Descripcion: any;
  public AlumnoId: any;

  constructor()
  {
    this.PersonaAutorizadaRecogerPorAlumnoId = null;
    this.Nombre = null;
    this.ParentescoId = null;
    this.Descripcion = null;
    this.AlumnoId = null;
    this.PersonaAutorizadaRecogerId = null;
  }
}
