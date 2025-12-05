namespace UrbanRouteApi.Models;

public sealed class CreateRutaRequest
{
    public string tNombre { get; set; } = string.Empty;
    public string? tCodigo { get; set; }
    public string? tColor { get; set; }
    public string? tSentido { get; set; }
}

public sealed class UpdateRutaRequest
{
    public string? tNombre { get; set; }
    public string? tCodigo { get; set; }
    public string? tColor { get; set; }
    public string? tSentido { get; set; }
}

public sealed class CreateParadaRequest
{
    public string tNombre { get; set; } = string.Empty;
    public string? tDireccion { get; set; }
    public string? tSentido { get; set; }
    public double dLatitud { get; set; }
    public double dLongitud { get; set; }
}

public sealed class UpdateParadaRequest
{
    public string? tNombre { get; set; }
    public string? tDireccion { get; set; }
    public string? tSentido { get; set; }
    public double? dLatitud { get; set; }
    public double? dLongitud { get; set; }
}

public sealed class CreateServicioRequest
{
    public string tNombre { get; set; } = string.Empty;
    public bool bLunes { get; set; } = true;
    public bool bMartes { get; set; } = true;
    public bool bMiercoles { get; set; } = true;
    public bool bJueves { get; set; } = true;
    public bool bViernes { get; set; } = true;
    public bool bSabado { get; set; } = false;
    public bool bDomingo { get; set; } = false;
    public DateTime fhFechaInicio { get; set; }
    public DateTime fhFechaFinal { get; set; }
}

public sealed class UpdateServicioRequest
{
    public string? tNombre { get; set; }
    public bool? bLunes { get; set; }
    public bool? bMartes { get; set; }
    public bool? bMiercoles { get; set; }
    public bool? bJueves { get; set; }
    public bool? bViernes { get; set; }
    public bool? bSabado { get; set; }
    public bool? bDomingo { get; set; }
    public DateTime? fhFechaInicio { get; set; }
    public DateTime? fhFechaFinal { get; set; }
}

public sealed class CreateViajeRequest
{
    public int eCodRuta { get; set; }
    public int eCodServicio { get; set; }
    public string? tNombre { get; set; }
    public string? tSentido { get; set; }
}

public sealed class UpdateViajeRequest
{
    public int? eCodRuta { get; set; }
    public int? eCodServicio { get; set; }
    public string? tNombre { get; set; }
    public string? tSentido { get; set; }
}

