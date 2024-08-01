<?php

namespace App\Http\Controllers;

use App\Models\Clients\Client;
use App\Models\Mantenice\Bank;
use App\Models\Mantenice\Rate;
use App\Models\Transfer\Transfer;
use Illuminate\Http\Request;
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

        $tBs = Transfer::select(DB::raw("sum(headline_amount) as total"))
            ->where('created_at', '<=', date('y-m-d') . " 23:59:59")
            ->where('created_at', '>=', date('y-m-d') . " 00:00:00")
            ->get();


        $totalBs = $tBs[0]->total ?? 0;


        $rates = Rate::select("_id", "name", 'amount', "country")
            ->where('updated_at', '<=', date('y-m-d') . " 23:59:59")
            ->where('updated_at', '>=', date('y-m-d') . " 00:00:00")
            ->get();




        return view('home', compact('banks', 'totalBs', 'rates'));
    }
}
