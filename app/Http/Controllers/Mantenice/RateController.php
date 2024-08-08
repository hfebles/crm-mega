<?php

namespace App\Http\Controllers\Mantenice;

use App\Http\Controllers\Controller;
use App\Models\Mantenice\Country;
use App\Models\Mantenice\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{

    protected $section = "Configuraciones";
    protected $subsection = "Tasas";

    function __construct()
    {
        $this->middleware('permission:rate-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:rate-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:rate-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:rate-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
        ];
        $countries = Country::pluck('name', '_id');
        $datas = Rate::select('r.name', 'r.amount', "r._id", 'c.name as countryName')
            ->from('rates as r')
            ->join('countries as c', 'r.country', '=', 'c._id')
            ->paginate(10);
        return view('mantenice.rates.index', compact('config', 'datas', 'countries'));
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

    public function store(Request $request)
    {
        // return $request;
        $rate = new Rate();
        $rate->name = strtoupper($request->name);
        $rate->amount = self::limpiarMontos($request->amount);
        $rate->country = $request->country;
        $rate->type = 1;
        $rate->save();
        return back();
    }

    public function updateRate(Request $request, $id)
    {
        $rate = Rate::find($id);
        if ($request->name) {
            $rate->name = strtoupper($request->name);
        }

        if ($request->amount) {
            $rate->amount = self::limpiarMontos($request->amount);
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

    public function delete($id)
    {
        $rate = Rate::destroy($id);
        return back();
    }
}
