<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DebtRecordController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Models\Donation;
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
 Route::get('p_outstock',[ProductController::class,'outstock']);
Route::post('password/forget',[AuthController::class, 'ForgetPassword']);
Route::post('password/reset',[AuthController::class, 'ResetPassword']);
Route::post('login',[AuthController::class, 'Login']);
Route::post('register',[AuthController::class, 'Register']);

Route::group( ['middleware' => [ 'auth:api' , 'access']],
   function()
{
    Route::delete('Delete-suppliers/{supplier}',[SupplierController::class,'destroy'])->name('delete-supplier');
    Route::get('employees',[EmployeeController::class,'index'])->name('get-employee');
    Route::post('add-employee',[EmployeeController::class,'store'])->name('create-employee');
    Route::get('Get-Employee/{id}',[EmployeeController::class,'show'])->name('show-employee');
    Route::delete('Delet-Employee/{id}',[EmployeeController::class,'destroy'])->name('delete-employee');

    //profit_percentage
    Route::get('profit_percentage',[ProfitController::class,'index']);
    Route::post('add-profit_percentage',[ProfitController::class,'store']);
    Route::get('profit_percentage/{id}',[ProfitController::class,'show']);
    Route::post('profit_percentage-update/{id}',[ProfitController::class,'update']);
    Route::delete('profit_percentage-delete/{id}',[ProfitController::class,'destroy']);

  //discount

  Route::get('discount',[DiscountController::class,'index'])->name('get-discount');;
  Route::post('add-discount',[DiscountController::class,'store'])->name('add-discount');;
  Route::get('discounts/{id}',[DiscountController::class,'show'])->name('show-discount');;
  Route::post('discount-update/{id}',[DiscountController::class,'update'])->name('update-discount');;
  Route::post('discount-delete/{id}',[DiscountController::class,'destroy'])->name('delete-discount');;


});

    Route::group( ['middleware' => ['auth:api']],function(){

        Route::get('get-debt',[DebtRecordController::class,'index']);
        Route::post('add-a-debt',[DebtRecordController::class,'store']);
        Route::post('debt-update/{id}',[DebtRecordController::class,'update']);
        Route::get('debt-search/{name}',[DebtRecordController::class,'search']);
        Route::delete('debt-delete/{id}',[DebtRecordController::class,'destroy']);

    Route::get('logout',[AuthController::class, 'Logout']);
    Route::get('Get-Gategorie',[CategoryController::class,'index']);
    Route::post('categories',[CategoryController::class,'store']);
    Route::post('categories/{category}/update',[CategoryController::class,'update']);
    Route::delete('categories/{category}/delete',[CategoryController::class,'destroy']);

    //Product
    Route::get('products/{id}',[ProductController::class,'show']);
    Route::get('p_expired',[ProductController::class,'expired']);
    Route::post('products/create',[ProductController::class,'store']);
    Route::post('products/{product}',[ProductController::class,'update']);
    Route::post('search/{name}',[ProductController::class,'search']);
    Route::post('SearchByCategory/{name}',[ProductController::class,'SearchByCategory']);
    Route::get('p_outstock',[ProductController::class,'outstock']);


    Route::post('store',[InvoiceController::class,'store']);
    Route::post('DaySales',[InvoiceController::class,'DaySales']);
    Route::get('TodaySales',[InvoiceController::class,'TodaySales']);
    Route::get('Profet_T',[InvoiceController::class,'Profet_T']);
    Route::get('Best-Selling',[InvoiceController::class,'BestSelling']);
    Route::get('Daily-Purchases',[InvoiceController::class,'dailyPurchases']);
    Route::post('two-day-salles',[InvoiceController::class,'towdaysales']);
    Route::post('two-day-profit',[InvoiceController::class,'towdayprofit']);

    Route::get('suppliers',[SupplierController::class,'index']);
    Route::post('add-supplier',[SupplierController::class,'store']);
    Route::get('suppliers/{supplier}',[SupplierController::class,'show']);




    Route::post('Update-supplier/{supplier}',[SupplierController::class,'update']);

    Route::get('purchases',[PurchaseController::class,'index']);
    Route::post('add-purchase',[PurchaseController::class,'store']);
    Route::get('purchases/{id}',[PurchaseController::class,'show']);
    Route::post('update-purchases/{id}',[PurchaseController::class,'update']);
    Route::delete('delete-purchases/{id}',[PurchaseController::class,'destroy']);

//customer
    Route::get('customers',[CustomerController::class,'index']);
    Route::post('add-customer',[CustomerController::class,'store']);
    Route::get('customers/{customer}',[CustomerController::class,'show']);
    Route::post('customers/{customer}/update',[CustomerController::class,'update']);
    Route::post('customers/{customer}/delete',[CustomerController::class,'destroy']);
// //company
    Route::get('companies',[CompanyController::class,'index']);
    Route::post('add-company',[CompanyController::class,'store']);
    Route::get('companies/{company}',[CompanyController::class,'show']);
    Route::post('companies/{company}/update',[CompanyController::class,'update']);
    Route::delete('companies/{company}/delete',[CompanyController::class,'destroy']);
//donatin
    Route::get('donations',[DonationController::class,'index']);
    Route::post('add-donation',[DonationController::class,'store']);
    Route::post('add-donationFromPharmacy',[DonationController::class,'storepharmacy']);
    Route::get('donations/{donation}',[DonationController::class,'show']);
    Route::post('donations/{donation}/update',[DonationController::class,'update']);
    Route::delete('donations/{donation}/delete',[DonationController::class,'destroy']);
    Route::get('search-donations',[DonationController::class,'search']);




   });
