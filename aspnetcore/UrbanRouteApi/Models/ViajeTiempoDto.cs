namespace UrbanRouteApi.Models;

public sealed class ViajeTiempoDto
{
    public int eCodTiempoParada { get; set; }
    public int eCodParada { get; set; }
    public TimeSpan fhHoraLlegada { get; set; }
    public TimeSpan fhHoraSalida { get; set; }
    public int eOrden { get; set; }
    public string? tNombre { get; set; }
    public double? dLatitud { get; set; }
    public double? dLongitud { get; set; }
}
