using Dapper;
using Microsoft.AspNetCore.Mvc;
using System.Data;
using UrbanRouteApi.Models;

namespace UrbanRouteApi.Controllers;

[ApiController]
[Route("api/[controller]")]
public sealed class RutasController : ControllerBase
{
    private readonly IDbConnectionFactory _dbFactory;

    public RutasController(IDbConnectionFactory dbFactory)
    {
        _dbFactory = dbFactory;
    }

    [HttpGet]
    public async Task<ActionResult<IEnumerable<RutaDto>>> Get()
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT eCodRuta, tNombre, tCodigo, tColor, tSentido
                             FROM cat_rutas
                             WHERE tCodEstatus = 'AC'
                             ORDER BY eCodRuta";

        var rutas = await conn.QueryAsync<RutaDto>(sql);
        return Ok(rutas);
    }

    [HttpGet("{id}")]
    public async Task<ActionResult<RutaDto>> GetById(int id)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT eCodRuta, tNombre, tCodigo, tColor, tSentido
                             FROM cat_rutas
                             WHERE eCodRuta = @RutaId AND tCodEstatus = 'AC'";

        var ruta = await conn.QueryFirstOrDefaultAsync<RutaDto>(sql, new { RutaId = id });
        if (ruta is null) return NotFound();
        return Ok(ruta);
    }

    [HttpGet("{id}/paradas")]
    public async Task<ActionResult<IEnumerable<RutaParadaDto>>> GetParadasPorRuta(int id)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT p.eCodParada, p.tNombre, p.tDireccion, p.tSentido, p.dLatitud, p.dLongitud, rp.eOrden
                             FROM rel_rutasparadas rp
                             INNER JOIN cat_paradas p ON p.eCodParada = rp.eCodParada
                             WHERE rp.eCodRuta = @RutaId AND rp.tCodEstatus = 'AC' AND p.tCodEstatus = 'AC'
                             ORDER BY rp.eOrden";

        var paradas = await conn.QueryAsync<RutaParadaDto>(sql, new { RutaId = id });
        return Ok(paradas);
    }

    [HttpGet("{id}/viajes")]
    public async Task<ActionResult<IEnumerable<RutaViajeDto>>> GetViajesPorRuta(int id)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT eCodViaje, eCodRuta, eCodServicio, tNombre, tSentido
                             FROM pro_viajes
                             WHERE eCodRuta = @RutaId AND tCodEstatus = 'AC'
                             ORDER BY eCodViaje";

        var viajes = await conn.QueryAsync<RutaViajeDto>(sql, new { RutaId = id });
        return Ok(viajes);
    }

    [HttpGet("{id}/forma")]
    public async Task<ActionResult<RutaFormaDto>> GetFormaPorRuta(int id)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT eCodFormaRuta, eCodRuta, tPolyline
                             FROM cat_formasruta
                             WHERE eCodRuta = @RutaId AND tCodEstatus = 'AC'
                             ORDER BY eCodFormaRuta ASC";

        var forma = await conn.QueryFirstOrDefaultAsync<RutaFormaDto>(sql, new { RutaId = id });
        if (forma is null) return NotFound();
        return Ok(forma);
    }

    [HttpPost]
    public async Task<ActionResult<RutaDto>> Create([FromBody] CreateRutaRequest req)
    {
        if (!FeatureFlags.AllowCreationAndDeletion)
            return StatusCode(405, "Operación deshabilitada durante la migración: no crear nuevas rutas.");
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"INSERT INTO cat_rutas (tNombre, tCodigo, tColor, tSentido, tCodEstatus, fhFechaRegistro)
                             VALUES (@tNombre, @tCodigo, @tColor, @tSentido, 'AC', NOW());
                             SELECT LAST_INSERT_ID();";

        var id = await conn.QuerySingleAsync<int>(sql, req);
        const string sel = @"SELECT eCodRuta, tNombre, tCodigo, tColor, tSentido
                             FROM cat_rutas WHERE eCodRuta=@id";
        var created = await conn.QueryFirstAsync<RutaDto>(sel, new { id });
        return Created($"/api/rutas/{id}", created);
    }

    [HttpPatch("{id}")]
    public async Task<ActionResult<RutaDto>> Update(int id, [FromBody] UpdateRutaRequest req)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string upd = @"UPDATE cat_rutas SET
                               tNombre = COALESCE(@tNombre, tNombre),
                               tCodigo = COALESCE(@tCodigo, tCodigo),
                               tColor  = COALESCE(@tColor,  tColor),
                               tSentido= COALESCE(@tSentido,tSentido),
                               fhFechaActualizacion = NOW()
                             WHERE eCodRuta=@id AND tCodEstatus='AC'";

        var rows = await conn.ExecuteAsync(upd, new { id, req.tNombre, req.tCodigo, req.tColor, req.tSentido });
        if (rows == 0) return NotFound();
        const string sel = @"SELECT eCodRuta, tNombre, tCodigo, tColor, tSentido
                             FROM cat_rutas WHERE eCodRuta=@id";
        var updated = await conn.QueryFirstAsync<RutaDto>(sel, new { id });
        return Ok(updated);
    }

    [HttpDelete("{id}")]
    public async Task<IActionResult> Delete(int id)
    {
        if (!FeatureFlags.AllowCreationAndDeletion)
            return StatusCode(405, "Operación deshabilitada durante la migración: no eliminar rutas existentes.");
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string del = @"UPDATE cat_rutas SET tCodEstatus='EL', fhFechaActualizacion=NOW() WHERE eCodRuta=@id AND tCodEstatus='AC'";
        var rows = await conn.ExecuteAsync(del, new { id });
        if (rows == 0) return NotFound();
        return NoContent();
    }
}
