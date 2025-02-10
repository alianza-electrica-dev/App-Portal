<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;


class TestServiceLayerMacroController extends Controller
{
    public function loginMacro()
    {
        $response = Http::sapSL()->post('Login', [
            'CompanyDB' => 'SBO_Pruebas',
            'Password'  => 'Wiin2012',
            'UserName'  => 'erp',
        ]);

        if ($response->successful()) {
            session(['sessionId' => $response->json()['SessionId']]);
        }

        return $response;
    }

    public function getProvidersMacro()
    {
        $response = Http::sapSL()->get('BusinessPartners');

        if ($response->status() === 401) {
            return response()->json(['error' => 'Session expired. Please log in again.'], 401);
        }

        return $response;
    }
    public function logoutMacro()
{
    $response = Http::sapSL()->post('Logout');

    session()->forget('sessionId');

    if ($response->successful()) {
        return response()->json(['message' => 'Logged out successfully from macro.']);
    } else {
        return response()->json(['error' => 'Failed to logout from SAP via macro.'], $response->status());
    }
}

}

?>