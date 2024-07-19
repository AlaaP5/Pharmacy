<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
    class InvoiceController extends Controller
    {
    public function store(Request $request)
    {

     $request->validate
     ([

    'customer_name'=>'required|max:200',
    'products' => 'required|array',
    'products.*.product_id' => 'required',
    'products.*.quantity' => 'required|integer|min:1' ,
     ]);





     
     $input = Invoice::create
     ([
     'total_invoices_price' => 0 ,
     'customer_name' => $request->customer_name,
     ]);
     // fro expire product 
$productsExpired = [];
     

//send in body  (from data)  not raw
     $product = $request->input('products');


// start foreach
     foreach($product as $p)
     {

// find product
         $pr = Product::find($p['product_id']);
         //search for expiry
         $exper = DB::table('expery_dates')
         ->where('product_id', $pr->id) 
         ->where('quantity', '>', 0) 
         ->orderBy('expiry_date', 'asc')
         ->first();


         // quantity aviliable and not expiry
     if ($pr['quantity'] >= $p['quantity'] && $exper->expiry_date >= date('Y-m-d')  )

     {
//create 
     DB::table('invoice_products')->insert
     ([
    'product_id'=>$p['product_id'],
    'quantity'=>$p['quantity'],
    'total_price'=>$p['quantity'] * $pr->price,
    'price' => $pr->price,
    'invoice_id'=>$input['id'],
    ]);

//update quantity
    Product::where('id' , $pr->id)->update
    ([
    'quantity'=> $pr->quantity   - $p['quantity'],
    ]);

     // find expiry date for sell from old
$products = DB::table('expery_dates')
    ->where('product_id', $pr->id) 
    ->where('quantity', '>', 0) 
    ->orderBy('expiry_date', 'asc')
    ->get();


if ($products->isNotEmpty())
{
    foreach ($products as $product) {
        if ($product->quantity >= $p['quantity']) {   
            $updatedQty = $product->quantity - $p['quantity'];
            DB::table('expery_dates')
                ->where('id', $product->id)
                ->update(['quantity' => $updatedQty]);
            break; 
        }
         else {
            $p['quantity'] -= $product->quantity;
            DB::table('expery_dates')
                ->where('id', $product->id)
               ->delete();
        }
    }
}

     $total = $input->products()->sum('total_price');
     $input->update
     ([
    'total_invoices_price' => $total,
     ]);

  

}
if ( $exper->expiry_date < date('Y-m-d') ) {

    $productsExpired = $p;
    
    }
    
}
if (!empty($productsExpired)) {
  

   $product_id = $productsExpired['product_id'];
   $product = Product::find($product_id);
   if ($product) {
    return $product->product_name. " this product is expired "  ;
}
}
}

public function TodaySales(Request $request){
    
    $today_sales = Invoice::whereDate('created_at','=',Carbon::now())->sum('total_invoices_price');


    return response()->json(['sales_value' => $today_sales ]);


}
public function DaySales(Request $request){
    $request->validate
    ([
        'select_the_day'=>'required|date',
    ]);
    $day_sales = Invoice::whereDate('created_at','=',$request->select_the_day)->sum('total_invoices_price');
    return response()->json(['sales_value'=> $day_sales ]);
}


public function towdaysales(Request $request){
    $request->validate
    ([
        'day_one'=>'required|date',
        'day_two'=>'required|date',
    ]);
    $salles = Invoice::whereDate('created_at', '>=', $request->day_one)
    ->whereDate('created_at', '<=', $request->day_two)
    ->sum('total_invoices_price');

    return response()->json(['sales_value'=> $salles ]);
}
public function towdayprofit(Request $request){
    $request->validate
    ([
        'day_one'=>'required|date',
        'day_two'=>'required|date',
    ]);
    $salles = Invoice::whereDate('created_at', '>=', $request->day_one)
    ->whereDate('created_at', '<=', $request->day_two)
    ->sum('total_invoices_price');
$profit = $salles *0.3 ;
return response()->json(['profit_value'=> $profit ]);
}
public function BestSelling(Request $request){ 
   
 
     
    $bestSellingProducts = DB::table('invoice_products') 
        ->select('invoice_products.product_id', 'products.product_name', 'products.quantity'  
        , 'products.price', 'products.expiry_date', 
     
            DB::raw('SUM(invoice_products.quantity) as selling_quantity')) 
     
        ->join('products', 'products.id', '=', 'invoice_products.product_id') 
        ->groupBy('invoice_products.product_id', 'products.product_name', 
         'products.quantity','products.price','products.expiry_date',) 
        ->orderBy('selling_quantity', 'desc') 
        ->take(10) 
        ->get(); 
    return $bestSellingProducts; 
                    
    }
public function dailyPurchases(Request $request){
    $today_Purchases = Purchase::whereDate('created_at','=',Carbon::now())->sum('net_price');

    if (!$today_Purchases) {
        return response()->json(['message' => 'there are no purcheses'], 404);
    }
    return response()->json(['Purchases_value'=> $today_Purchases ]);

}




    }