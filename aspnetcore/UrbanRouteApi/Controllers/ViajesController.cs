using Dapper;
using Microsoft.AspNetCore.Mvc;
using System.Data;
using UrbanRouteApi.Models;
using UrbanRouteApi;
using Swashbuckle.AspNetCore.Annotations;
using Microsoft.AspNetCore.Http;

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

    [HttpPost]
    [SwaggerOperation(Summary = "Crea un nuevo viaje", Tags = new[] { "Viajes" })]
    [ProducesResponseType(StatusCodes.Status201Created)]
    [ProducesResponseType(StatusCodes.Status405MethodNotAllowed)]
    public async Task<ActionResult<RutaViajeDto>> Create([FromBody] CreateViajeRequest req)
    {
        if (!FeatureFlags.AllowCreationAndDeletion)
            return StatusCode(405, "Operación deshabilitada durante la migración: no crear nuevos viajes.");
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string ins = @"INSERT INTO pro_viajes (eCodRuta, eCodServicio, tNombre, tSentido, tCodEstatus)
                             VALUES (@eCodRuta, @eCodServicio, @tNombre, @tSentido, 'AC');
                             SELECT LAST_INSERT_ID();";
        var id = await conn.QuerySingleAsync<int>(ins, req);
        const string sel = @"SELECT eCodViaje, eCodRuta, eCodServicio, tNombre, tSentido
                             FROM pro_viajes WHERE eCodViaje=@id";
        var created = await conn.QueryFirstAsync<RutaViajeDto>(sel, new { id });
        return Created($"/api/viajes/{id}", created);
    }

    [HttpPatch("{id}")]
    [SwaggerOperation(Summary = "Actualiza un viaje existente", Tags = new[] { "Viajes" })]
    [ProducesResponseType(StatusCodes.Status200OK)]
    [ProducesResponseType(StatusCodes.Status404NotFound)]
    public async Task<ActionResult<RutaViajeDto>> Update(int id, [FromBody] UpdateViajeRequest req)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string upd = @"UPDATE pro_viajes SET
                               eCodRuta = COALESCE(@eCodRuta, eCodRuta),
                               eCodServicio = COALESCE(@eCodServicio, eCodServicio),
                               tNombre = COALESCE(@tNombre, tNombre),
                               tSentido = COALESCE(@tSentido, tSentido)
                             WHERE eCodViaje=@id AND tCodEstatus='AC'";
        var rows = await conn.ExecuteAsync(upd, new { id, req.eCodRuta, req.eCodServicio, req.tNombre, req.tSentido });
        if (rows == 0) return NotFound();
        const string sel = @"SELECT eCodViaje, eCodRuta, eCodServicio, tNombre, tSentido
                             FROM pro_viajes WHERE eCodViaje=@id";
        var updated = await conn.QueryFirstAsync<RutaViajeDto>(sel, new { id });
        return Ok(updated);
    }

    [HttpDelete("{id}")]
    [SwaggerOperation(Summary = "Elimina lógicamente un viaje", Tags = new[] { "Viajes" })]
    [ProducesResponseType(StatusCodes.Status204NoContent)]
    [ProducesResponseType(StatusCodes.Status404NotFound)]
    [ProducesResponseType(StatusCodes.Status405MethodNotAllowed)]
    public async Task<IActionResult> Delete(int id)
    {
        if (!FeatureFlags.AllowCreationAndDeletion)
            return StatusCode(405, "Operación deshabilitada durante la migración: no eliminar viajes existentes.");
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string del = @"UPDATE pro_viajes SET tCodEstatus='EL' WHERE eCodViaje=@id AND tCodEstatus='AC'";
        var rows = await conn.ExecuteAsync(del, new { id });
        if (rows == 0) return NotFound();
        return NoContent();
    }

    [HttpGet("{id}")]
    [SwaggerOperation(Summary = "Obtiene un viaje por su ID", Tags = new[] { "Viajes" })]
    [ProducesResponseType(StatusCodes.Status200OK)]
    [ProducesResponseType(StatusCodes.Status404NotFound)]
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
    [SwaggerOperation(Summary = "Lista tiempos y paradas del viaje", Tags = new[] { "Viajes" })]
    [ProducesResponseType(StatusCodes.Status200OK)]
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
