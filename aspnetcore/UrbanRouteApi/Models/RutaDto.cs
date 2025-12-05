namespace UrbanRouteApi.Models;

public sealed class RutaDto
{
    public int eCodRuta { get; set; }
    public string tNombre { get; set; } = string.Empty;
    public string? tCodigo { get; set; }
    public string? tColor { get; set; }
    public string? tSentido { get; set; }
}

