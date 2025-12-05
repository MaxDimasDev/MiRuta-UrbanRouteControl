using Dapper;
using Microsoft.AspNetCore.Mvc;
using System.Data;
using UrbanRouteApi.Models;
using UrbanRouteApi;

namespace UrbanRouteApi.Controllers;

[ApiController]
[Route("api/[controller]")]
public sealed class ServiciosController : ControllerBase
{
    private readonly IDbConnectionFactory _dbFactory;

    public ServiciosController(IDbConnectionFactory dbFactory)
    {
        _dbFactory = dbFactory;
    }

    [HttpGet]
    public async Task<ActionResult<IEnumerable<ServicioDto>>> Get()
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT eCodServicio, tNombre,
                                     bLunes, bMartes, bMiercoles, bJueves, bViernes, bSabado, bDomingo,
                                     fhFechaInicio, fhFechaFinal
                              FROM pro_servicios
                              WHERE tCodEstatus = 'AC'
                              ORDER BY eCodServicio";

        var servicios = await conn.QueryAsync<ServicioDto>(sql);
        return Ok(servicios);
    }

    [HttpGet("{id}")]
    public async Task<ActionResult<ServicioDto>> GetById(int id)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string sql = @"SELECT eCodServicio, tNombre,
                                     bLunes, bMartes, bMiercoles, bJueves, bViernes, bSabado, bDomingo,
                                     fhFechaInicio, fhFechaFinal
                              FROM pro_servicios
                              WHERE eCodServicio = @ServicioId AND tCodEstatus = 'AC'";

        var servicio = await conn.QueryFirstOrDefaultAsync<ServicioDto>(sql, new { ServicioId = id });
        if (servicio is null) return NotFound();
        return Ok(servicio);
    }

    [HttpPost]
    public async Task<ActionResult<ServicioDto>> Create([FromBody] CreateServicioRequest req)
    {
        if (!FeatureFlags.AllowCreationAndDeletion)
            return StatusCode(405, "Operación deshabilitada durante la migración: no crear nuevos servicios.");
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string ins = @"INSERT INTO pro_servicios (tNombre,
                              bLunes,bMartes,bMiercoles,bJueves,bViernes,bSabado,bDomingo,
                              fhFechaInicio, fhFechaFinal, tCodEstatus)
                             VALUES (@tNombre,
                              @bLunes,@bMartes,@bMiercoles,@bJueves,@bViernes,@bSabado,@bDomingo,
                              @fhFechaInicio, @fhFechaFinal, 'AC');
                             SELECT LAST_INSERT_ID();";
        var id = await conn.QuerySingleAsync<int>(ins, req);
        const string sel = @"SELECT eCodServicio, tNombre,
                                     bLunes, bMartes, bMiercoles, bJueves, bViernes, bSabado, bDomingo,
                                     fhFechaInicio, fhFechaFinal
                              FROM pro_servicios WHERE eCodServicio=@id";
        var created = await conn.QueryFirstAsync<ServicioDto>(sel, new { id });
        return Created($"/api/servicios/{id}", created);
    }

    [HttpPatch("{id}")]
    public async Task<ActionResult<ServicioDto>> Update(int id, [FromBody] UpdateServicioRequest req)
    {
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string upd = @"UPDATE pro_servicios SET
                              tNombre = COALESCE(@tNombre, tNombre),
                              bLunes  = COALESCE(@bLunes,  bLunes),
                              bMartes = COALESCE(@bMartes, bMartes),
                              bMiercoles = COALESCE(@bMiercoles, bMiercoles),
                              bJueves = COALESCE(@bJueves, bJueves),
                              bViernes = COALESCE(@bViernes, bViernes),
                              bSabado = COALESCE(@bSabado, bSabado),
                              bDomingo = COALESCE(@bDomingo, bDomingo),
                              fhFechaInicio = COALESCE(@fhFechaInicio, fhFechaInicio),
                              fhFechaFinal  = COALESCE(@fhFechaFinal,  fhFechaFinal)
                            WHERE eCodServicio=@id AND tCodEstatus='AC'";
        var rows = await conn.ExecuteAsync(upd, new {
            id,
            req.tNombre,
            req.bLunes,
            req.bMartes,
            req.bMiercoles,
            req.bJueves,
            req.bViernes,
            req.bSabado,
            req.bDomingo,
            req.fhFechaInicio,
            req.fhFechaFinal
        });
        if (rows == 0) return NotFound();
        const string sel = @"SELECT eCodServicio, tNombre,
                                     bLunes, bMartes, bMiercoles, bJueves, bViernes, bSabado, bDomingo,
                                     fhFechaInicio, fhFechaFinal
                              FROM pro_servicios WHERE eCodServicio=@id";
        var updated = await conn.QueryFirstAsync<ServicioDto>(sel, new { id });
        return Ok(updated);
    }

    [HttpDelete("{id}")]
    public async Task<IActionResult> Delete(int id)
    {
        if (!FeatureFlags.AllowCreationAndDeletion)
            return StatusCode(405, "Operación deshabilitada durante la migración: no eliminar servicios existentes.");
        using IDbConnection conn = _dbFactory.CreateConnection();
        const string del = @"UPDATE pro_servicios SET tCodEstatus='EL' WHERE eCodServicio=@id AND tCodEstatus='AC'";
        var rows = await conn.ExecuteAsync(del, new { id });
        if (rows == 0) return NotFound();
        return NoContent();
    }
}
