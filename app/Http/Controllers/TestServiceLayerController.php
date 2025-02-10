<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestServiceLayerController extends Controller
{

    public function login()
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->post('https://20.188.75.138:50000/b1s/v1/Login', [
            'CompanyDB' => 'SBO_Pruebas',
            'Password'  => 'Wiin2012',
            'UserName'  => 'erp',
        ]);

        if ($response->successful()) {
            session(['sessionId' => $response->json()['SessionId']]);
        }

        return $response;
    }

    public function getProviders()
    {
        $sessionId = session('sessionId');

        if (!$sessionId) {
            return response()->json(['error' => 'No session found. Please login first.'], 401);
        }

        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Cookie' => "B1SESSION={$sessionId}",
        ])->get('https://20.188.75.138:50000/b1s/v1/BusinessPartners');

        return $response;
    }
    public function logout()
{
    $sessionId = session('sessionId');

    if (!$sessionId) {
        return response()->json(['error' => 'No session found. Please login first.'], 401);
    }

    $response = Http::withOptions([
        'verify' => false,
    ])->withHeaders([
        'Cookie' => "B1SESSION={$sessionId}",
    ])->post('https://20.188.75.138:50000/b1s/v1/Logout');

    // Limpiar la sesión en Laravel
    session()->forget('sessionId');

    if ($response->successful()) {
        return response()->json(['message' => 'Cierre de Sesion Exitoso']);
    } else {
        return response()->json(['error' => 'Failed to logout from SAP.'], $response->status());
    }
}
}
?>