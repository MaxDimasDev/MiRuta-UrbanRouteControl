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
}
