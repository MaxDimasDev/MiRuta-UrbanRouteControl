namespace UrbanRouteApi.Models;

public sealed class ServicioDto
{
    public int eCodServicio { get; set; }
    public string tNombre { get; set; } = string.Empty;
    public bool bLunes { get; set; }
    public bool bMartes { get; set; }
    public bool bMiercoles { get; set; }
    public bool bJueves { get; set; }
    public bool bViernes { get; set; }
    public bool bSabado { get; set; }
    public bool bDomingo { get; set; }
    public DateTime fhFechaInicio { get; set; }
    public DateTime fhFechaFinal { get; set; }
}

