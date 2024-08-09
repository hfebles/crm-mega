<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\Client;
use App\Models\Clients\ClientAccount;
use App\Models\Mantenice\Bank;
use App\Models\Mantenice\Country;
use App\Models\Mantenice\Rate;
use App\Models\Transfer\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    protected $section = "Clientes";
    protected $subsection = "Clientes";
    public function index(Request $request)
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
        ];

        $query = Client::query();


        // return $request->campo;

        if ($request->has('value')) {
            $query->where($request->campo, 'like', '%' . $request->value . '%');
        }

        $query->where('enable', 1);

        $datas = $query->paginate(20);


        if ($request->ajax()) {
            return response()->json([
                'clients' => view('clients.clients.partials.client_list', compact('datas'))->render(),
                'pagination' => view('clients.clients.partials.pagination', compact('datas'))->render(),
            ]);
        }

        return view('clients.clients.index', compact('config', 'datas'))->with('i', ($request->input('page', 1) - 1) * 10);
    }


    public function searchClient(Request $request)
    {

        // return $datas;
    }

    public function create()
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
            'back' => route('clients.index'),
        ];

        // Paises:
        $countries = Country::pluck('name', 'short');

        // Bancos: 
        $banks = Bank::pluck('name', '_id');
        return view('clients.clients.create', compact('config', 'countries', 'banks'));
    }

    public function searchCode($country)
    {
        $lastCode = Client::select('code')->where('country', '=', $country)->orderBy('code', 'DESC')->get();
        if (count($lastCode) > 0) {
            $lastCode = $lastCode[0]->code + 1;
        } else {
            $lastCode = 1;
        }

        $codeVisual = str_pad($lastCode, 4, "0", STR_PAD_LEFT);
        $codeVisual = $country . $codeVisual;
        return ["code" => $codeVisual, 'lastCode' => $lastCode];
    }


    public function store(Request $request)
    {
        // return $request;
        $client = new Client();

        $client->names = strtoupper($request->name);
        $client->country = strtoupper($request->country);
        $client->code = strtoupper($request->code);
        $client->phone = strtoupper($request->phone);
        $client->dni = strtoupper($request->dni);
        $client->cedula = strtoupper($request->cedula);
        $client->save();

        $clientId = $client->_id;

        $clientAccount = new ClientAccount();
        $clientAccount->client_id = $clientId;
        $clientAccount->headline_dni = strtoupper($request->headline_dni);
        $clientAccount->headline = strtoupper($request->headline);
        $clientAccount->bank_account_number = $request->bank_account_number;
        $clientAccount->bank_id = $request->bank_id;
        $clientAccount->save();

        if ($request->clientNew == 2) {
            return back();
        }


        return redirect()->route('clients.index');
    }
    public function edit($id)
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
            'back' => route('clients.index'),
        ];
        $client = Client::select(
            'cl._id',
            'cl.code',
            'cl.names',
            'cl.dni',
            'cl.phone',
            'cl.country',
            'cl.cedula',
            'c.name as country_name',
        )
            ->from('clients as cl')
            ->join('countries as c', 'c.short', '=', 'cl.country')
            ->find($id);

        // Paises:
        $countries = Country::pluck('name', 'short');

        return view('clients.clients.edit', compact('client', 'config', 'countries'));
    }

    public function show($id)
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
            'back' => route('clients.index'),
        ];
        $client = Client::find($id);
        $clientAccounts = ClientAccount::select(
            "client_accounts._id",
            "client_accounts.bank_account_number",
            "client_accounts.headline",
            "client_accounts.headline_dni",
            "banks.name as bank_name",
        )
            ->join("banks", "banks._id", '=', 'client_accounts.bank_id')
            ->where("client_id", $id)
            ->get();

        $transfers = Transfer::select(
            't._id',
            "t.client_account_id",
            "t.date",
            "t.headline_amount",
            "t.client_amount",
            "t.rate_amount",
            "ca.headline",
            "ca.bank_account_number",
            "b.name as bank_name",
        )
            ->from("transfers as t")
            ->join("client_accounts as ca", 'ca._id', '=', "t.client_account_id")
            ->join("banks as b", "b._id", '=', 't.bank_id')

            ->orderBy('t._id', 'DESC')
            ->where("t.client_id", $id)
            ->get();
        // Bancos: 
        $banks = Bank::pluck('name', '_id');
        return view('clients.clients.show', compact('client', 'config', 'clientAccounts', 'transfers', 'banks'));
    }
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $client->names = strtoupper($request->name);
        $client->country = strtoupper($request->country);
        $client->code = strtoupper($request->code);
        $client->phone = strtoupper($request->phone);
        $client->dni = strtoupper($request->dni);
        $client->cedula = strtoupper($request->cedula);
        $client->save();
        return redirect()->route('clients.show', $id);
    }

    public function delete($id)
    {
        $client = Client::find($id);
        $client->enable = 0;
        $client->save();
        return redirect()->route('clients.index');
    }

    public function searchDNI($dni)
    {
        $exist = Client::where('dni', '=', $dni)->get();
        if (count($exist) > 0) {
            return ['result' => 'true'];
        } else {
            return ['result' => 'false'];
        }
    }
    public function searchDNIHeadline($dni)
    {
        $exist = ClientAccount::where('headline_dni', '=', $dni)->get();
        if (count($exist) > 0) {
            return ['result' => 'true'];
        } else {
            return ['result' => 'false'];
        }
    }

    public function findClient($id)
    {

        $client = Client::find($id);
        $clientAccounts = ClientAccount::select(
            "client_accounts._id",
            "client_accounts.bank_account_number",
            "client_accounts.headline",
            "client_accounts.headline_dni",
            "banks.name as bank_name",
            // "rates.amount"
        )
            ->join("banks", "banks._id", '=', 'client_accounts.bank_id')
            // ->join("banks", "banks._id", '=', 'client_accounts.bank_id')
            ->where("client_id", $id)
            ->get();

        $ratex = Rate::select("r._id", "r.name", "r.amount")
            ->from("rates as r")
            ->join('countries as c', 'c._id', '=', 'r.country')
            ->join('clients as cl', 'cl.country', '=', 'c.short')
            ->where('cl._id', '=', $id)
            ->get();
        return ['client' => $client, 'clientAccounts' => $clientAccounts, 'rates' => $ratex];
    }
}
