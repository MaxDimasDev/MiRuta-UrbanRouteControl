namespace UrbanRouteApi.Models;

public sealed class RutaViajeDto
{
    public int eCodViaje { get; set; }
    public int eCodRuta { get; set; }
    public int eCodServicio { get; set; }
    public string? tNombre { get; set; }
    public string? tSentido { get; set; }
}

