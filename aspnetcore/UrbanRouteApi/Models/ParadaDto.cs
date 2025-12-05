namespace UrbanRouteApi.Models;

public sealed class ParadaDto
{
    public int eCodParada { get; set; }
    public string tNombre { get; set; } = string.Empty;
    public string? tDireccion { get; set; }
    public string? tSentido { get; set; }
    public decimal dLatitud { get; set; }
    public decimal dLongitud { get; set; }
}

