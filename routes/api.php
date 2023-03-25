<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::apiResource('/user','Api\UserController');
Route::apiResource('/employee','Api\EmployeeController');
Route::apiResource('/supplier','Api\SupplierController');
Route::apiResource('/tax', 'Api\TaxController');
Route::apiResource('/unit','Api\UnitController');
Route::apiResource('/brand','Api\BrandController');
Route::apiResource('/category','Api\CategoryController');
Route::apiResource('/product','Api\ProductController');
Route::apiResource('/expense','Api\ExpenseController');
Route::apiResource('/salary','Api\SalaryController');
Route::apiResource('/customer','Api\CustomerController');

Route::post('/salary/paid/{id}','Api\SalaryController@paid');
Route::get('/edit/salary/{id}','Api\SalaryController@EditSalary');
Route::post('/salary/update/{id}','Api\SalaryController@salaryUpdate');

Route::get('/getting/product/{id}','Api\PosController@GetProduct');
Route::get('/addToCart/{id}','Api\CartController@addToCart');
Route::get('/cart/product','Api\CartController@CartProduct');
Route::get('/remove/cart/{id}','Api\CartController@removeCart');
Route::get('/increment/{id}','Api\CartController@increment');
Route::get('/checkquantity/{id}','Api\CartController@checkquantity');
Route::get('/decrement/{id}','Api\CartController@decrement');

Route::get('/vat','Api\TaxController@vat');
Route::post('/orderdone','Api\PosController@OrderDone');

Route::get('/orders','Api\OrderController@index');
Route::get('/order/details/{id}','Api\OrderController@OrderDetails');
Route::get('/order/orderdetails/{id}','Api\OrderController@OrderDetailsAll');
Route::post('/search/order','Api\OrderController@SearchOrderDate');
Route::post('/search/month','Api\OrderController@SearchOrderMonth');

Route::get('/today/sell','Api\PosController@TodaySell');
Route::get('/today/income','Api\PosController@TodayIncome');
Route::get('/today/due','Api\PosController@TodayDue');
Route::get('/today/expense','Api\PosController@TodayExpense');
Route::get('/stockout/product','Api\PosController@Stockout');
Route::get('/profit/loss','Api\PosController@profitLoss');






