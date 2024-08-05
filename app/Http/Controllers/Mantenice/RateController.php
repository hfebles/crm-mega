<?php

namespace App\Http\Controllers\Mantenice;

use App\Http\Controllers\Controller;
use App\Models\Mantenice\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{

    protected $section = "Configuraciones";
    protected $subsection = "Bancos";

    public function index()
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
        ];
        $datas = Rate::paginate(10);
        // return $datas;
        return view('mantenice.rates.index', compact('config', 'datas'));
    }


    public function edit($id)
    {
        $data = Rate::find($id);

        $response = "
        <form method='POST' action=" . route('rates.update-rate', $id) . ">
            <input type='hidden' name='_token' value='" . csrf_token() . "' />
            <div class='row'>
                <div class='form-group col-md-12'>
                    <label for='name'>
                        Nombre de la tasa
                    </label>
                    <div class='input-group'>
                        <input class='form-control form-control-sm' required name='name' placeholder=' Nombre de la tasa' value='" . $data->name . "' />
                    </div>
                    <label for='name'>
                        Valor de la tasa
                    </label>
                    <div class='input-group'>
                        <input class='form-control form-control-sm' required name='amount' placeholder='Valor de la tasa' value='" . $data->amount . "' />
                    </div>
                    <input type='hidden' name='site' value='true'/>
                    <div class='col-12 mt-4'>
                        <button class='btn btn-success btn-sm' type='submit'>Guardar</button>
                    </div>
                </div>
            </form>";
        return response()->json(array('response' => $response));
    }



    public function calculateAmount(Request $request)
    {
        $rate = Rate::find($request->rateId)->amount;
        $finalAmount = $rate * $request->amount;
        return ['amount' => $finalAmount];
    }



    public function updateRate(Request $request, $id)
    {
        // return $request;
        $rate = Rate::find($id);
        if ($request->name) {
            $rate->name = $request->name;
        }

        if ($request->amount) {
            $rate->amount = $request->amount;
        }

        $rate->save();

        if ($request->site === "true") {
            return back();
        } else {
            return $rate;
        }
    }



    public function findRate($id)
    {
        $rate = Rate::find($id);
        return $rate;
    }
}
