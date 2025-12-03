using Dapper;
using Microsoft.AspNetCore.Mvc;
using System.Data;
using UrbanRouteApi.Models;

namespace UrbanRouteApi.Controllers;

[ApiController]
[Route("api/[controller]")]
public sealed class ParadasController : ControllerBase
{
    private readonly IDbConnectionFactory _dbFactory;

    public ParadasController(IDbConnectionFactory dbFactory)
    {
        _dbFactory = dbFactory;
    }

    [HttpGet]
    public async Task<ActionResult<IEnumerable<ParadaDto>>> Get()
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT eCodParada, tNombre, tDireccion, tSentido, dLatitud, dLongitud
                             FROM cat_paradas
                             WHERE tCodEstatus = 'AC'
                             ORDER BY eCodParada";

        var paradas = await conn.QueryAsync<ParadaDto>(sql);
        return Ok(paradas);
    }

    [HttpGet("{id}")]
    public async Task<ActionResult<ParadaDto>> GetById(int id)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT eCodParada, tNombre, tDireccion, tSentido, dLatitud, dLongitud
                             FROM cat_paradas
                             WHERE eCodParada = @ParadaId AND tCodEstatus = 'AC'";

        var parada = await conn.QueryFirstOrDefaultAsync<ParadaDto>(sql, new { ParadaId = id });
        if (parada is null) return NotFound();
        return Ok(parada);
    }

    [HttpPost]
    public async Task<ActionResult<ParadaDto>> Create([FromBody] CreateParadaRequest req)
    {
        if (!FeatureFlags.AllowCreationAndDeletion)
            return StatusCode(405, "Operación deshabilitada durante la migración: no crear nuevas paradas.");
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string ins = @"INSERT INTO cat_paradas (tNombre, tDireccion, tSentido, dLatitud, dLongitud, tCodEstatus, fhFechaRegistro)
                             VALUES (@tNombre, @tDireccion, @tSentido, @dLatitud, @dLongitud, 'AC', NOW());
                             SELECT LAST_INSERT_ID();";
        var id = await conn.QuerySingleAsync<int>(ins, req);
        const string sel = @"SELECT eCodParada, tNombre, tDireccion, tSentido, dLatitud, dLongitud FROM cat_paradas WHERE eCodParada=@id";
        var created = await conn.QueryFirstAsync<ParadaDto>(sel, new { id });
        return Created($"/api/paradas/{id}", created);
    }

    [HttpPatch("{id}")]
    public async Task<ActionResult<ParadaDto>> Update(int id, [FromBody] UpdateParadaRequest req)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string upd = @"UPDATE cat_paradas SET
                               tNombre   = COALESCE(@tNombre, tNombre),
                               tDireccion= COALESCE(@tDireccion, tDireccion),
                               tSentido  = COALESCE(@tSentido, tSentido),
                               dLatitud  = COALESCE(@dLatitud, dLatitud),
                               dLongitud = COALESCE(@dLongitud, dLongitud),
                               fhFechaActualizacion = NOW()
                             WHERE eCodParada=@id AND tCodEstatus='AC'";
        var rows = await conn.ExecuteAsync(upd, new { id, req.tNombre, req.tDireccion, req.tSentido, req.dLatitud, req.dLongitud });
        if (rows == 0) return NotFound();
        const string sel = @"SELECT eCodParada, tNombre, tDireccion, tSentido, dLatitud, dLongitud FROM cat_paradas WHERE eCodParada=@id";
        var updated = await conn.QueryFirstAsync<ParadaDto>(sel, new { id });
        return Ok(updated);
    }

    [HttpDelete("{id}")]
    public async Task<IActionResult> Delete(int id)
    {
        if (!FeatureFlags.AllowCreationAndDeletion)
            return StatusCode(405, "Operación deshabilitada durante la migración: no eliminar paradas existentes.");
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string del = @"UPDATE cat_paradas SET tCodEstatus='EL', fhFechaActualizacion=NOW() WHERE eCodParada=@id AND tCodEstatus='AC'";
        var rows = await conn.ExecuteAsync(del, new { id });
        if (rows == 0) return NotFound();
        return NoContent();
    }
}
