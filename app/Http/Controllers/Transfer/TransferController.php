<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Clients\Client;
use App\Models\Clients\ClientAccount;
use App\Models\Mantenice\Bank;
use App\Models\Mantenice\Country;
use App\Models\Mantenice\PayMethod;
use App\Models\Mantenice\Rate;
use App\Models\Transfer\Transfer;
use Illuminate\Http\Request;
use App\Exports\TransfersExport;
use Maatwebsite\Excel\Facades\Excel;

class TransferController extends Controller
{
    protected $section = "Transaferencias";
    protected $subsection = "Transaferencias";

    function __construct()
    {
        $this->middleware('permission:transfer-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:transfer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:transfer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transfer-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
            'create' => route('transfers.create')
        ];

        $datas = Transfer::select('transfers._id', "transfers.client_id", "transfers.client_account_id", "transfers.date", "transfers.headline_amount", "transfers.client_amount", 'clients.country', 'clients.code', 'clients.names')
            ->join('clients', 'clients._id', '=', 'transfers.client_id')
            ->orderBy('transfers._id', 'DESC')
            ->paginate(10);


        return view('transfers.transfers.index', compact('datas', 'config'))->with('i', ($request->input('page', 1) - 1) * 10);
    }


    public function newTransfer($id)
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
            'back' => route('transfers.index')
        ];

        // Paises:
        $countries = Country::pluck('name', 'short');

        // Bancos: 
        $banks = Bank::pluck('name', '_id');

        $methodPays = PayMethod::pluck('name', '_id');

        $client = Client::find($id);
        $accountClient = ClientAccount::where('client_id', '=', $id)->get();

        $ratex = Rate::pluck('amount', '_id');


        $datas = ['client' => $client, 'client_account' => $accountClient,  'methodPays' => $methodPays];

        return view('transfers.transfers.newTrasnfer', compact('datas', 'config', 'countries', 'banks', 'ratex'));
    }

    public function create()
    {
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
            'back' => route('transfers.index')
        ];
        $rate = Rate::pluck('amount', '_id');
        $clients = Client::pluck('names', '_id');
        $methodPays = PayMethod::where('enable', '=', 1)->pluck('name', '_id');
        $countries = Country::pluck('name', 'short');
        $banks = Bank::pluck('name', '_id');


        $datas = ['clients' => $clients, 'rates' => $rate, "method_pay" => $methodPays];
        return view('transfers.transfers.create', compact('datas', 'config', 'countries', 'banks'));
    }



    public function store(Request $request)
    {
        $rate = Rate::select('amount', 'type')->find($request->rate);
        $rate->type;
        $transfer = new Transfer();
        $transfer->client_id = $request->client_id;
        $transfer->client_account_id = $request->client_account_id;
        $transfer->date = date('Y-m-d');
        $transfer->headline_amount = self::limpiarMontos($request->headline_amount);
        $transfer->client_amount = self::limpiarMontos($request->client_amount);
        $transfer->rate_amount = $rate->amount;
        $transfer->rate_type = $rate->type;
        $transfer->bank_id = $request->bank_id;
        $transfer->pay_method_id = $request->pay_method;
        $transfer->save();




        return redirect()->route('transfers.show', $transfer->_id);
    }


    public function show($id)
    {
        //  $transfer = Transfer::find($id);
        $config = [
            'subtitle' => $this->subsection,
            'content_header_title' => $this->section,
            'content_header_subtitle' => $this->subsection,
            'back' => route('transfers.index')
        ];

        $data = Transfer::select(
            "transfers._id as transferId",
            "transfers.created_at as transferDate",
            "transfers.*",
            "clients.*",
            "pay_methods.name as payment_name",
            "client_accounts.headline",
            "client_accounts.headline_dni",
            "client_accounts.headline_phone",
            "client_accounts.bank_account_number",
            "banks.name as bankName"
        )
            ->join("clients", "clients._id", "=", "transfers.client_id")
            ->join("pay_methods", "pay_methods._id", "=", "transfers.pay_method_id")
            ->join("client_accounts", "client_accounts.client_id", "=", "clients._id")
            ->join("banks", "client_accounts.bank_id", "=", "banks._id")
            // ->where("transfers._id", "=", $id)
            // ->get()[0];
            ->find($id);

        return view('transfers.transfers.show', compact('data', 'config'));
    }


    public function printInvoice($id)
    {
        $data = Transfer::select(
            "transfers._id as transferId",
            "transfers.created_at as transferDate",
            "transfers.*",
            "clients.*",
            "pay_methods.name as payment_name",
            "client_accounts.headline",
            "client_accounts.headline_dni",
            "client_accounts.bank_account_number",
            "banks.name as bankName"
        )
            ->join("clients", "clients._id", "=", "transfers.client_id")
            ->join("pay_methods", "pay_methods._id", "=", "transfers.pay_method_id")
            ->join("client_accounts", "client_accounts.client_id", "=", "clients._id")
            ->join("banks", "client_accounts.bank_id", "=", "banks._id")


            ->where("transfers._id", "=", $id)
            ->get()[0];


        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('transfers.transfers.pdf.boucher', compact('id', 'data'));
        return $pdf->stream('ejemplo.pdf');
    }

    public function bankReport($id)
    {
        return Excel::download(new TransfersExport($id), 'transfers.xlsx');
    }


    public function export() {}
}
