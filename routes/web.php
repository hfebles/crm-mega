<?php

use App\Http\Controllers\Clients\{ClientAccountController, ClientController};
use App\Http\Controllers\Mantenice\{
    BankController,
    CountryController,
    PayMethodController,
    RateController,
    RoleController,
    TotalBsController,
    UserController
};
use App\Http\Controllers\Transfer\TransferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('adminlte::auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    // Mantenice
    Route::resource('mantenice/roles', RoleController::class);
    Route::resource('mantenice/users', UserController::class);
    Route::resource('mantenice/bs', TotalBsController::class);

    Route::post('mantenice/bs/{id}/update-bank', [TotalBsController::class, 'updateBank'])->name('bs.update-bank');



    Route::resource('/mantenice/banks', BankController::class);
    Route::get('/mantenice/banks/search/{id}', [BankController::class, 'searchBank'])->name('banks.search');
    Route::post('/mantenice/banks/{id}/update-bank', [BankController::class, 'updateBank'])->name('banks.update-bank');
    Route::get('/mantenice/banks/{id}/delete', [BankController::class, 'deleteBank'])->name('banks.delete-bank');

    Route::resource('/mantenice/pay-methods', PayMethodController::class);
    Route::post('/mantenice/pay-methods/{id}/update-method', [PayMethodController::class, 'updateMethod'])->name('pay-methods.update-method');
    Route::get('/mantenice/pay-methods/{id}/inactive', [PayMethodController::class, 'inactive'])->name('pay-methods.inactive');
    Route::get('/mantenice/pay-methods/{id}/delete', [PayMethodController::class, 'delete'])->name('pay-methods.delete');

    Route::resource('/mantenice/countries', CountryController::class);

    Route::resource('/mantenice/rates', RateController::class);
    Route::get('/mantenice/rates/find-rate/{id}', [RateController::class, 'findRate'])->name('rates.find-rate');
    Route::post('/mantenice/rates/update-rate/{id}', [RateController::class, 'updateRate'])->name('rates.update-rate');
    Route::post('/mantenice/rates/calculate-amount', [RateController::class, 'calculateAmount'])->name('rates.calculate-amount');
    Route::get('/mantenice/rates/{id}/delete', [RateController::class, 'delete'])->name('rates.delete');




    // Clients
    Route::resource('/clients', ClientController::class);
    Route::resource('/clients-accounts', ClientAccountController::class);
    Route::get('/clients-accounts/edit-account/{id}', [ClientAccountController::class, 'editClientAccount'])->name('clients-accounts.edit-account');



    Route::get('/clients/find-client/{id}', [ClientController::class, 'findClient'])->name('clients.find-client');
    Route::get('/clients/delete/{id}', [ClientController::class, 'delete'])->name('clients.delete');

    Route::post('/clients/search', [ClientController::class, 'searchClient'])->name('clients.search');



    Route::get('/clients/search-code/{country}', [ClientController::class, 'searchCode'])->name('clients.search-code');
    Route::get('/clients/search-dni/{dni}', [ClientController::class, 'searchDNI'])->name('clients.search-dni');

    // Transfers
    Route::resource('/transfers', TransferController::class);
    Route::get('/transfers/new-transfer/{id}', [TransferController::class, 'newTransfer'])->name('transfers.new-transfer');
    Route::get('/transfers/print-invoice/{id}', [TransferController::class, 'printInvoice'])->name('transfers.print-invoice');

    Route::get('/transfers/bank-report/{id}', [TransferController::class, 'bankReport'])->name('transfers.bank-report');;
});
