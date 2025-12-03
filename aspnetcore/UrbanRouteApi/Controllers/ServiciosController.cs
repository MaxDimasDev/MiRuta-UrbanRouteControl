using Dapper;
using Microsoft.AspNetCore.Mvc;
using System.Data;
using UrbanRouteApi.Models;

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
}

