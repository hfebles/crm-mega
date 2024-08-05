<?php

namespace App\Http\Controllers\Mantenice;

use App\Http\Controllers\Controller;
use App\Models\Mantenice\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    protected $section = "Configuraciones";
    protected $subsection = "Tasas";

    public function index()
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
        ];
        $datas = Bank::paginate(10);
        // return $datas;
        return view('mantenice.banks.index', compact('config', 'datas'));
    }


    public function create()
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => "Crear Banco",
            'back' => route('banks.index'),
        ];
        return view('mantenice.banks.create', compact('config'));
    }



    public function store(Request $request)
    {

        $banco = new Bank();
        $banco->name = strtoupper($request->name);
        $banco->save();
        return back();
    }

    public function edit($id)
    {
        $data = Bank::find($id);

        $response = "
        <form method='POST' action=" . route('banks.update-bank', $id) . ">
            <input type='hidden' name='_token' value='" . csrf_token() . "' />
            <div class='row'>
                <div class='form-group col-md-12'>
                    <label for='name'>
                        Nombre del Banco
                    </label>
                    <div class='input-group'>
                        <input class='form-control form-control-sm' required name='name' placeholder='Nombre del Banco' value='" . $data->name . "' />
                    </div>
                    <div class='col-12 mt-4'>
                        <button class='btn btn-success btn-sm' type='submit'>Guardar</button>
                    </div>
                </div>
            </form>";
        return response()->json(array('response' => $response));
    }

    public function updateBank(Request $request, $id)
    {
        $data = Bank::find($id);
        $data->name = strtoupper($request->name);
        $data->save();
        return back();
    }

    public function searchBank($id)
    {
        $data = Bank::select("client_accounts._id", "client_accounts.headline", "client_accounts.headline_dni", "banks.name as bank_name", "banks._id as bankId")
            ->join("client_accounts", "client_accounts.bank_id", '=', 'banks._id')
            ->where("client_accounts._id", $id)
            ->get()[0];

        return $data;
    }
}
