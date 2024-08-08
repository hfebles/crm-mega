<?php

namespace App\Http\Controllers\Mantenice;

use App\Http\Controllers\Controller;
use App\Models\Mantenice\PayMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



class PayMethodController extends Controller
{
    protected $section = "Configuraciones";
    protected $subsection = "Metodos de pagos";
    protected $prefix = 'pay-methods';

    function __construct()
    {
        $this->middleware('permission:method-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:method-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:method-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:method-delete', ['only' => ['destroy']]);
    }

    protected $routes = [
        'index' => "index",
        'create' => "create",
        'store' => "store",
        'update' => "update",
        'edit' => "edit",
        'back' => "home",
    ];

    public function index()
    {

        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
            "back" => route($this->routes['back']),
            "store" => route($this->prefix . "." . $this->routes['store']),
            'prefix' => $this->prefix
        ];


        $datas = PayMethod::paginate(10);
        return view('mantenice.paymethods.index', compact('config', 'datas'));
    }


    public function store(Request $request)
    {

        $pay_method = new PayMethod();
        $pay_method->name = strtoupper($request->name);
        $pay_method->short = strtoupper($request->short);

        $pay_method->save();
        return back();
    }

    public function edit($id)
    {
        $data = PayMethod::find($id);

        $response = "
        <form method='POST' action=" . route('pay-methods.update-method', $id) . ">
            <input type='hidden' name='_token' value='" . csrf_token() . "' />
            <div class='row'>
                <div class='form-group col-md-12'>
                    <label for='name'>
                        Nombre del Banco
                    </label>
                    <div class='input-group'>
                        <input class='form-control form-control-sm' required name='name' placeholder='Nombre del Banco' value='" . $data->name . "' />
                    </div>
                    <label for='name'>
                        Abreviacion
                    </label>
                    <div class='input-group'>
                        <input class='form-control form-control-sm' required name='short'  value='" . $data->short . "' placeholder='Abreviacion' />
                    </div>
                    <div class='col-12 mt-4'>
                        <button class='btn btn-success btn-sm' type='submit'>Guardar</button>
                    </div>
                </div>
            </form>";
        return response()->json(array('response' => $response));
    }

    public function updateMethod(Request $request, $id)
    {
        // return $request;
        $data = PayMethod::find($id);
        $data->name = strtoupper($request->name);
        if ($request->short) {
            $data->short = strtoupper($request->short);
        }
        $data->save();
        return back();
    }
    public function inactive($id)
    {
        $data = PayMethod::find($id);
        if ($data->enable == 0) {
            $data->enable = 1;
        } else {
            $data->enable = 0;
        }


        $data->save();
        return back();
    }
    public function delete($id)
    {
        PayMethod::destroy($id);
        return back();
    }



    // public function searchBank($id)
    // {
    //     $data = Bank::select("client_accounts._id", "client_accounts.headline", "client_accounts.headline_dni", "banks.name as bank_name", "banks._id as bankId")
    //         ->join("client_accounts", "client_accounts.bank_id", '=', 'banks._id')
    //         ->where("client_accounts._id", $id)
    //         ->get()[0];

    //     return $data;
    // }
}
