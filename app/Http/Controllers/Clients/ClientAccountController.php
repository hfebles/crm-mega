<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\ClientAccount;
use App\Models\Mantenice\Bank;
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

    public function editClientAccount($id)
    {
        $clientAccount = ClientAccount::find($id);
        $banks = Bank::pluck('name', '_id');

        $response = "
        <form method='POST' action='" . route('clients-accounts.update', $clientAccount->_id) . "'>
            <input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='_token' value='" . csrf_token() . "' />
            <div class='row'>
                <div class='form-group col-md-12'>
                    <label for='name'>Bancos:</label>
                    <select required class='form-select form-select-sm' name='bank_id' id='bank_id'>
                                        <option value=''>Seleccione</option>";
        foreach ($banks as $kBank => $VBank) {
            $response .= "<option value='" . $kBank . "'>" . $VBank . "</option>";
        }
        $response .= "</select></div>
                <div class='form-group col-md-12'>
                    <label for='name'>Nro de cuenta:</label>
                    <input value='" . $clientAccount->bank_account_number . "' onkeypress='return soloNumeros(event);' required autocomplete='off' type='text' class='form-control form-control-sm' name='bank_account_number' id='bank_account_number2'>
                </div>
                <div class='form-group col-md-12'>
                    <label for='name'>Nombre del titular</label>
                    <input required value='" . $clientAccount->headline . "' autocomplete='off' type='text' class='form-control form-control-sm'
                            name='headline' id='headline'>
                </div>
                <div class='form-group col-md-12'>
                    <label for='name'>DNI del titular</label>
                    <input required value='" . $clientAccount->headline_dni . "' autocomplete='off' type='text' class='form-control form-control-sm' name='headline_dni' id='headline_dni'>
                </div>
                    <div class='col-12 mt-4'>
                        <button class='btn btn-success btn-sm' type='submit'>Guardar</button>
                    </div>
                </div>
            </form>";
        return response()->json(array('response' => $response));
    }


    public function update(Request $request, $id)
    {
        $data = ClientAccount::find($id);
        $data->headline_dni = strtoupper($request->headline_dni);
        $data->headline = strtoupper($request->headline);
        $data->bank_account_number = $request->bank_account_number;
        $data->bank_id = $request->bank_id;
        $data->save();
        return back();
    }
}
