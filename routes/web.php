<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Models\Purchase;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Cashier;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('admin')) {

        return view('admin_dashboard', [
            'users' => \App\Models\User::all(),
        ]);
    }
    
    return view('dashboard');


    // $stripe = Cashier::stripe();

    // // $payment_intent = $stripe->paymentIntents->retrieve(
    // //     "pi_3NskKVKqbwGrjZyu12CnKGPP"
    // // );

    // $payment_method = $stripe->paymentMethods->retrieve(
    //     // $payment_intent->payment_method
    //     "pm_1NskllKqbwGrjZyuUzjUjhLd"
    // );

    // dd($payment_method->card->last4);


})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('purchases', PurchaseController::class)->only(['index', 'show', 'create', 'store']);

    Route::post('purchases/{purchase}/refund', [PurchaseController::class, 'refund'])->name('purchases.refund');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::post('users/{user}/cancel_access', [ProfileController::class, 'cancelAccess'])->name('users.cancel_access');
    });

    Route::get('payment/cancelled', [PurchaseController::class, 'cancelled'])->name('purchases.cancelled');

});

require __DIR__.'/auth.php';
