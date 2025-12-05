using Microsoft.OpenApi.Any;
using Microsoft.OpenApi.Models;
using Swashbuckle.AspNetCore.SwaggerGen;
using UrbanRouteApi.Models;

namespace UrbanRouteApi.Swagger;

// OperationFilter que agrega ejemplos de request/response a operaciones relevantes
public sealed class ExamplesOperationFilter : IOperationFilter
{
    public void Apply(OpenApiOperation operation, OperationFilterContext context)
    {
        var path = context.ApiDescription.RelativePath?.ToLowerInvariant() ?? string.Empty;
        var method = context.ApiDescription.HttpMethod?.ToUpperInvariant() ?? string.Empty;

        // Ejemplos para Rutas
        if (path.StartsWith("api/rutas") && method == "POST")
        {
            SetRequestExample(operation, new CreateRutaRequest
            {
                tNombre = "Ruta Centro",
                tCodigo = "R-01",
                tColor = "#FF0000",
                tSentido = "NORTE-SUR"
            });
        }

        if (path.StartsWith("api/rutas") && method == "PATCH")
        {
            SetRequestExample(operation, new UpdateRutaRequest
            {
                tNombre = "Ruta Centro Actualizada",
                tColor = "#00AAFF"
            });
        }

        // Ejemplos para Paradas
        if (path.StartsWith("api/paradas") && method == "POST")
        {
            SetRequestExample(operation, new CreateParadaRequest
            {
                tNombre = "Parada Av. Principal",
                tDireccion = "Av. Principal 123",
                tSentido = "SUR",
                dLatitud = 19.4326,
                dLongitud = -99.1332
            });
        }

        if (path.StartsWith("api/paradas") && method == "PATCH")
        {
            SetRequestExample(operation, new UpdateParadaRequest
            {
                tDireccion = "Av. Principal 456",
                dLatitud = 19.4330,
                dLongitud = -99.1335
            });
        }

        // Ejemplos para Servicios
        if (path.StartsWith("api/servicios") && method == "POST")
        {
            SetRequestExample(operation, new CreateServicioRequest
            {
                tNombre = "Servicio Diario",
                bLunes = true,
                bMartes = true,
                bMiercoles = true,
                bJueves = true,
                bViernes = true,
                bSabado = false,
                bDomingo = false,
                fhFechaInicio = DateTime.Parse("2025-01-01"),
                fhFechaFinal = DateTime.Parse("2025-12-31")
            });
        }

        if (path.StartsWith("api/servicios") && method == "PATCH")
        {
            SetRequestExample(operation, new UpdateServicioRequest
            {
                tNombre = "Servicio Ajustado",
                bSabado = true,
                bDomingo = true
            });
        }

        // Ejemplos para Viajes
        if (path.StartsWith("api/viajes") && method == "POST")
        {
            SetRequestExample(operation, new CreateViajeRequest
            {
                eCodRuta = 1,
                eCodServicio = 2,
                tNombre = "Viaje Matutino",
                tSentido = "NORTE"
            });
        }

        if (path.StartsWith("api/viajes") && method == "PATCH")
        {
            SetRequestExample(operation, new UpdateViajeRequest
            {
                tNombre = "Viaje Matutino Ajustado",
                tSentido = "SUR"
            });
        }
    }

    private static void SetRequestExample(OpenApiOperation operation, object exampleObject)
    {
        if (operation.RequestBody == null)
            return;

        foreach (var content in operation.RequestBody.Content)
        {
            // Asignar ejemplo como JSON
            content.Value.Example = new OpenApiString(System.Text.Json.JsonSerializer.Serialize(exampleObject));
        }
    }
}
