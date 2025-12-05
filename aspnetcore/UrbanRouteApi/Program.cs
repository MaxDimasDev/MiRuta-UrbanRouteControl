var builder = WebApplication.CreateBuilder(args);

// Add services to the container.
builder.Services.AddControllers();
// Learn more about configuring Swagger/OpenAPI at https://aka.ms/aspnetcore/swashbuckle
builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen(c =>
{
    c.EnableAnnotations();
    c.SwaggerDoc("v1", new Microsoft.OpenApi.Models.OpenApiInfo
    {
        Title = "UrbanRoute API",
        Version = "v1",
        Description = "API para rutas, paradas, servicios y viajes de transporte urbano"
    });
    c.OperationFilter<UrbanRouteApi.Swagger.ExamplesOperationFilter>();
});

// MySQL connection factory (Dapper)
builder.Services.AddSingleton<IDbConnectionFactory>(sp =>
{
    var configuration = sp.GetRequiredService<IConfiguration>();
    var connectionString = configuration.GetConnectionString("Default");
    return new MySqlConnectionFactory(connectionString);
});

var app = builder.Build();

// Configure the HTTP request pipeline.
// Swagger habilitado en todos los entornos para facilitar pruebas
app.UseSwagger();
app.UseSwaggerUI(options =>
{
    options.SwaggerEndpoint("/swagger/v1/swagger.json", "UrbanRoute API v1");
});

app.UseHttpsRedirection();

app.MapControllers();

app.Run();

// Infra: simple DB connection factory interface and implementation
public interface IDbConnectionFactory
{
    System.Data.IDbConnection CreateConnection();
}

public sealed class MySqlConnectionFactory : IDbConnectionFactory
{
    private readonly string _connectionString;

    public MySqlConnectionFactory(string connectionString)
    {
        _connectionString = connectionString;
    }

    public System.Data.IDbConnection CreateConnection()
    {
        return new MySqlConnector.MySqlConnection(_connectionString);
    }
}
