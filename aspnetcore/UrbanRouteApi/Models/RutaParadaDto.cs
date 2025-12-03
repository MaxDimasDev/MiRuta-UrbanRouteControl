namespace UrbanRouteApi.Models;

public sealed class RutaParadaDto
{
    public int eCodParada { get; set; }
    public string tNombre { get; set; } = string.Empty;
    public string? tDireccion { get; set; }
    public string? tSentido { get; set; }
    public decimal dLatitud { get; set; }
    public decimal dLongitud { get; set; }
    public int eOrden { get; set; }
}

