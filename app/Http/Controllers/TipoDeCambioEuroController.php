<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

class TipoDeCambioEuroController extends Controller
{
    public function obtenerTipoDeCambioActual()
    {
        $url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';

        $response = Http::get($url);
        if ($response->successful()) {
            $xml = simplexml_load_string($response->body());
            $json = json_encode($xml);
            $datos = json_decode($json, true);
            $tipoDeCambio = null;
            foreach ($datos['Cube']['Cube']['Cube'] as $rate) {
                if ($rate['@attributes']['currency'] === 'MXN') {
                    $tipoDeCambio = $rate['@attributes']['rate'];
                    break;
                }
            }
            if ($tipoDeCambio) {
                return response()->json([
                    'fecha' => now()->toDateString(),
                    'tipo_de_cambio' => $tipoDeCambio
                ]);
            } else {
                return response()->json([
                    'mensaje' => 'No se encontraron datos para la conversión solicitada.'
                ], 404);
            }
        } else {
            return response()->json([
                'mensaje' => 'Error al consultar la API del BCE.'
            ], $response->status());
        }
    }
    
}
?>