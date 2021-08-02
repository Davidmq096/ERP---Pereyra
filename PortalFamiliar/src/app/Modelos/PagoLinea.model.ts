export class PagoLinea
{
    public dl_monto: string;
    public cl_concepto: string;
    public TipoPago: string;
    public UsuarioId: string;
    public Documento: Array<DocumentoPorPagar>;

    constructor()
    {
        this.dl_monto = null;
        this.cl_concepto= null;
        this.TipoPago= null;
        this.UsuarioId= null;
        this.Documento = [];
    }
}

export class DocumentoPorPagar
{
    public Documento: string;
    public AlumnoId: string;
    public CicloId: string;
    public DocumentoPorPagarId: string;

    constructor()
    {
        this.Documento = null;
        this.AlumnoId = null;
        this.CicloId = null;
        this.DocumentoPorPagarId = null;
    }
}

export class Multipagos
{
    public cl_folio: string;
    public cl_referencia: string;
    public dl_monto: string;
    public cl_concepto: string;
    public hash: string;
    public servicio: string;

    constructor()
    {
        this.cl_folio = null;
        this.cl_referencia = null;
        this.dl_monto = null;
        this.cl_concepto= null;
        this.hash = null;
        this.servicio = null;
    }
}