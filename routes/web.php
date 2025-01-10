<?php


use App\Livewire\PaymentProofManager;
use App\Livewire\TransactionItemManager;
use App\Livewire\ProductManager;
use App\Livewire\TransactionManager;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum', 'verified', AdminMiddleware::class])->group(function () {
    Route::get('/admin/products', ProductManager::class)->name('admin.products');
    Route::get('/admin/transactions', TransactionManager::class)->name('admin.transactions');
    Route::get('/admin/transaction-items', TransactionItemManager::class)->name('admin.transaction-items');
    Route::get('/admin/payment-proofs', PaymentProofManager::class)->name('admin.payment-proofs');
});
