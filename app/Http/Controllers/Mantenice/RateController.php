<?php

namespace App\Http\Controllers\Mantenice;

use App\Http\Controllers\Controller;
use App\Models\Mantenice\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function calculateAmount(Request $request)
    {
        $rate = Rate::find($request->rateId)->amount;
        $finalAmount = $rate * $request->amount;
        return ['amount' => $finalAmount];
    }

    public function updateRate(Request $request, $id)
    {

        $rate = Rate::find($id);
        $rate->amount = $request->amount;
        $rate->save();

        return $rate;
    }



    public function findRate($id)
    {
        $rate = Rate::find($id);
        return $rate;
    }
}
