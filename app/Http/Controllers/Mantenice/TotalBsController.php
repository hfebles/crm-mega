<?php

namespace App\Http\Controllers\Mantenice;

use App\Http\Controllers\Controller;
use App\Models\Mantenice\Bank;
use App\Models\Mantenice\TotalBs;
use App\Models\Transfer\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalBsController extends Controller
{
    protected $section = "Configuraciones";
    protected $subsection = "Total bolivares";

    public function index()
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
        ];

        $banks = Bank::pluck('name', '_id');

        $tBs = Transfer::select(DB::raw("sum(headline_amount) as total"), 'bank_id')
            ->where('created_at', '<=', date('y-m-d') . " 23:59:59")
            ->where('created_at', '>=', date('y-m-d') . " 00:00:00")
            ->groupBy('bank_id')
            ->get();


        $datas = TotalBs::select('b.name', 'tbs.amount', 'tbs._id', "tbs.bank_id", "tbs.created_at")
            ->from('total_bs as tbs')
            ->join('banks as b', 'b._id', '=', 'tbs.bank_id')
            ->where('tbs.created_at', '<=', date('y-m-d') . " 23:59:59")
            ->where('tbs.created_at', '>=', date('y-m-d') . " 00:00:00")
            ->get();


        if (count($tBs) > 0) {
            for ($i = 0; $i < count($datas); $i++) {
                if ($datas[$i]['bank_id'] == $tBs[$i]['bank_id']) {
                    $datas[$i]['resto'] = $datas[$i]['amount'] - $tBs[$i]['total'];
                }
            }
        }

        // return $datas;

        return view('mantenice.bs.index', compact('config', 'datas', 'tBs', 'banks'));
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
        // return $request;
        $bs = new TotalBs();
        $bs->bank_id = $request->bank_id;
        $bs->amount = self::limpiarMontos($request->amount);
        $bs->save();
        return back();
    }

    public function edit($id)
    {
        $data = TotalBs::select('b.name', 'tbs.amount')->from('total_bs as tbs')->join('banks as b', 'b._id', '=', 'tbs.bank_id')->where('tbs._id', $id)->get()[0];

        $response = "
        <form method='POST' action=" . route('bs.update-bank', $id) . ">
            <input type='hidden' name='_token' value='" . csrf_token() . "' />
            <div class='row'>
                <div class='form-group col-md-12'>
                    <label for='name'>
                        Nombre del Banco
                    </label>
                    <div class='input-group'>
                        <input class='form-control form-control-sm' disabled name='name' placeholder='Nombre del Banco' value='" . $data->name . "' />
                    </div>
                     <label class='mt-3' for='name'>
                        Monto
                    </label>
                    <input type='text' name='amount'  required  value='" . $data->amount . "' class='form-control form-control-sm'>
                    <div class='col-12 mt-4'>
                        <button class='btn btn-success btn-sm' type='submit'>Guardar</button>
                    </div>
                </div>
            </form>";
        return response()->json(array('response' => $response));
    }

    public function updateBank(Request $request, $id)
    {

        $data = TotalBs::find($id);
        $data->amount = self::limpiarMontos($request->amount);
        $data->save();
        return back();
    }

    public function searchBank($id)
    {
        $data = TotalBs::select("client_accounts._id", "client_accounts.headline", "client_accounts.headline_dni", "banks.name as bank_name", "banks._id as bankId")
            ->join("client_accounts", "client_accounts.bank_id", '=', 'banks._id')
            ->where("client_accounts._id", $id)
            ->get()[0];

        return $data;
    }


    public function deleteBank($id)
    {
        // return $id;
        TotalBs::destroy($id);
        return back();
    }
}
