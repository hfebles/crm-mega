<?php

namespace App\Exports;

use App\Models\Transfer\Transfer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransfersExport implements FromQuery, WithHeadings
{
    use Exportable;


    private $id;


    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function query()
    {
        return DB::table('transfers as t')
            ->select(
                DB::raw("LPAD(`t`.`_id`, 8, '0') as id"),
                DB::raw("CONCAT(c.country, LPAD(c.code, 4, '0')) as code"),
                'c.names',
                'c.dni',
                't.client_amount',
                'ca.headline',
                'ca.headline_dni',
                'ca.bank_account_number',
                't.headline_amount',
                't.rate_amount',
                'b.name as bank_name',
                't.created_at'
            )
            ->join('clients as c', 'c._id', '=', 't.client_id')
            ->join('client_accounts as ca', 'ca._id', '=', 't.client_account_id')
            ->join('banks as b', 'b._id', '=', 't.bank_id')
            ->where('b._id', '=', $this->id)
            ->orderBy('t._id', 'asc');
    }

    public function headings(): array
    {
        return [
            'Transaccion',
            'Código Cliente',
            'Nombre Cliente',
            'DNI Cliente',
            'Monto Cliente',
            'Titular de Cuenta',
            'DNI Titular',
            'Número de Cuenta',
            'Monto Recibido',
            'Tasa',
            'Banco',
            'Fecha de Creación'
        ];
    }
}
