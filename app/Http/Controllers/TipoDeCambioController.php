<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TipoDeCambioController extends Controller
{
    public function obtenerTipoDeCambioActual()
    {
        $fechaActual = Carbon::now();
        $fechaActualFormatted = $fechaActual->format('Y-m-d');
        
        $url = "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/{$fechaActualFormatted}/{$fechaActualFormatted}";
        $token = 'bd753cf2dc6bf3c5e05b703fe31e8c7863f72dee60168eb6b9e18bf9c3ff96df';
        $response = Http::withHeaders([
            'Bmx-Token' => $token
        ])->get($url);
        
        if ($response->successful()) {
            $datos = $response->json();

            $tipoDeCambio = $datos['bmx']['series'][0]['datos'][0] ?? null;

            if ($tipoDeCambio) {
                return response()->json([
                    'fecha' => $tipoDeCambio['fecha'],
                    'tipo_de_cambio' => $tipoDeCambio['dato']
                ]);
            } else {
                return response()->json([
                    'mensaje' => 'No se encontraron datos para la fecha solicitada.'
                ], 404);
            }
        } else {
            return response()->json([
                'mensaje' => 'Error al consultar la API de Banxico.'
            ], $response->status());
        }
    }
}
?>
