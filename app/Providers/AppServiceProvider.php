<?php

namespace App\Providers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       //* Configuración de una macro con la sesión de login guardada
       Http::macro('sapSL', function () {
        $sessionId = session('sessionId'); // Recuperar el SessionId de la sesión

        $request = Http::withOptions([
            'verify' => false, // Deshabilitar la verificación SSL
        ])->baseUrl('https://20.188.75.138:50000/b1s/v1/'); // URL base para SAP SL

        // Si el usuario está autenticado, agregar el SessionId a los encabezados
        if ($sessionId) {
            $request = $request->withHeaders([
                'Cookie' => "B1SESSION={$sessionId}",
            ]);
        }

        return $request;
    });
    }
}
