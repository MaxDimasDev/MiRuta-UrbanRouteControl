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
}
