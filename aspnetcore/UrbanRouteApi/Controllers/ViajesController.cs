using Dapper;
using Microsoft.AspNetCore.Mvc;
using System.Data;
using UrbanRouteApi.Models;

namespace UrbanRouteApi.Controllers;

[ApiController]
[Route("api/[controller]")]
public sealed class ViajesController : ControllerBase
{
    private readonly IDbConnectionFactory _dbFactory;

    public ViajesController(IDbConnectionFactory dbFactory)
    {
        _dbFactory = dbFactory;
    }

    [HttpGet("{id}")]
    public async Task<ActionResult<RutaViajeDto>> GetById(int id)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT eCodViaje, eCodRuta, eCodServicio, tNombre, tSentido
                             FROM pro_viajes
                             WHERE eCodViaje = @ViajeId AND tCodEstatus = 'AC'";

        var viaje = await conn.QueryFirstOrDefaultAsync<RutaViajeDto>(sql, new { ViajeId = id });
        if (viaje is null) return NotFound();
        return Ok(viaje);
    }

    [HttpGet("{id}/tiempos")]
    public async Task<ActionResult<IEnumerable<ViajeTiempoDto>>> GetTiemposPorViaje(int id)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT tp.eCodTiempoParada, tp.eCodParada, tp.fhHoraLlegada, tp.fhHoraSalida, tp.eOrden,
                                    p.tNombre, p.dLatitud, p.dLongitud
                             FROM pro_tiemposparada tp
                             INNER JOIN cat_paradas p ON p.eCodParada = tp.eCodParada
                             WHERE tp.eCodViaje = @ViajeId AND tp.tCodEstatus = 'AC' AND p.tCodEstatus = 'AC'
                             ORDER BY tp.eOrden";

        var tiempos = await conn.QueryAsync<ViajeTiempoDto>(sql, new { ViajeId = id });
        return Ok(tiempos);
    }
}
