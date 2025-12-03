namespace UrbanRouteApi;

public static class FeatureFlags
{
    // Controla si se permiten operaciones de creación y eliminación.
    // Se habilita únicamente cuando la variable de entorno URBANROUTE_ENABLE_CREATION_DELETION=true
    public static bool AllowCreationAndDeletion
    {
        get
        {
            var value = Environment.GetEnvironmentVariable("URBANROUTE_ENABLE_CREATION_DELETION");
            return bool.TryParse(value, out var enabled) && enabled;
        }
    }
}

