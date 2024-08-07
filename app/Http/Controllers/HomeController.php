<?php

namespace App\Http\Controllers;

use App\Models\Clients\Client;
use App\Models\Mantenice\Bank;
use App\Models\Mantenice\Rate;
use App\Models\Mantenice\TotalBs;
use App\Models\Transfer\Transfer;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $banks = Bank::select("b._id", "b.name", "b.color", DB::raw("count(t._id) as transfers"))
            ->from('banks as b')
            ->join("transfers as t", 'b._id', '=', 't.bank_id', 'left')
            ->where('t.created_at', '<=', date('y-m-d') . " 23:59:59")
            ->where('t.created_at', '>=', date('y-m-d') . " 00:00:00")
            ->groupBy('b._id', 'b.name', "b.color")
            ->get();

        $tBs = Transfer::select(DB::raw("sum(headline_amount) as total"), 'bank_id')
            ->where('created_at', '<=', date('y-m-d') . " 23:59:59")
            ->where('created_at', '>=', date('y-m-d') . " 00:00:00")
            ->groupBy('bank_id')
            ->get();

        $bancoBs = [];

        $bs = TotalBs::select('b.name', 'tbs.amount', 'tbs._id', "tbs.bank_id", "tbs.created_at", "b.color")
            ->from('total_bs as tbs')
            ->join('banks as b', 'b._id', '=', 'tbs.bank_id')
            ->where('tbs.created_at', '<=', date('y-m-d') . " 23:59:59")
            ->where('tbs.created_at', '>=', date('y-m-d') . " 00:00:00")
            ->get();


        for ($i = 0; $i < count($bs); $i++) {
            if ($bs[$i]['bank_id'] == $tBs[$i]['bank_id']) {
                $bs[$i]['resto'] = $bs[$i]['amount'] - $tBs[$i]['total'];
            }
        }


        $rates = Rate::select("_id", "name", 'amount', "country")
            ->where('updated_at', '<=', date('y-m-d') . " 23:59:59")
            ->where('updated_at', '>=', date('y-m-d') . " 00:00:00")
            ->get();

        if (count($rates) <= 0) {
            return redirect()->route('rates.index');
        }
        return view('home', compact('banks', 'rates', 'bs'));
    }


    public function reportByDay($bank_id, $day)
    {
    }
}
