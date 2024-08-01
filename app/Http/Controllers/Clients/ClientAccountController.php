<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\ClientAccount;
use Illuminate\Http\Request;

class ClientAccountController extends Controller
{

    public function store(Request $request)
    {

        $clientAccount = new ClientAccount();
        $clientAccount->client_id = $request->client_id;
        $clientAccount->headline_dni = strtoupper($request->headline_dni);
        $clientAccount->headline = strtoupper($request->headline);
        $clientAccount->bank_account_number = $request->bank_account_number;
        $clientAccount->bank_id = $request->bank_id;
        $clientAccount->save();
        return back();
    }
}
