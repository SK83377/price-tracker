<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SubscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Log;

Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        Log::info('Conn+ ');
        return "Connected to database: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        Log::info('Conn- ');
        return "Could not connect to the database. Error: " . $e->getMessage();
    }
});

Route::post('/refreshPrices', [SubscriptionController::class, 'refreshPrices']);

Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);

Route::get('/', function () {
    return view('welcome');
});
