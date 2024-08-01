<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\Client;
use App\Models\Clients\ClientAccount;
use App\Models\Mantenice\Bank;
use App\Models\Mantenice\Country;
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

        if ($request->has('value')) {
            $query->where('names', 'like', '%' . $request->value . '%');
        }

        $datas = $query->paginate(10);

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


    public function store(Request $request)
    {
        // return $request;
        $client = new Client();

        $client->names = strtoupper($request->name);
        $client->country = strtoupper($request->country);
        $client->code = strtoupper($request->code);

        $client->phone = strtoupper($request->phone);
        $client->dni = strtoupper($request->dni);
        $client->save();

        $clientId = $client->_id;

        $clientAccount = new ClientAccount();
        $clientAccount->client_id = $clientId;
        $clientAccount->headline_dni = strtoupper($request->headline_dni);
        $clientAccount->headline = strtoupper($request->headline);
        $clientAccount->bank_account_number = $request->bank_account_number;
        $clientAccount->bank_id = $request->bank_id;
        $clientAccount->save();


        return redirect()->route('clients.index');
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
    }

    public function findClient($id)
    {

        $client = Client::find($id);
        $clientAccounts = ClientAccount::select("client_accounts._id", "client_accounts.bank_account_number", "client_accounts.headline", "client_accounts.headline_dni", "banks.name as bank_name")
            ->join("banks", "banks._id", '=', 'client_accounts.bank_id')
            ->where("client_id", $id)
            ->get();



        return ['client' => $client, 'clientAccounts' => $clientAccounts];
    }
}
