<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseResource;
use App\Models\Category;
use App\Models\ExperyDate;
use App\Models\Product;
use App\Models\Profit_percentage;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller

{





    
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $purchases = Purchase::paginate(10);
        return PurchaseResource::collection($purchases);

    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:200',
            'category'=>'required',
            'net_price'=>'required|min:1',
            'salling_price'=>'',
            'quantity'=>'required|min:1',
            'expiry_date'=>'required',
            'supplier'=>'required',
            'image'=>'file|image|mimes:jpg,jpeg,png,gif',
        ]);
        // $imageName = null;
        // if($request->hasFile('image')){
        //     $imageName = time().'.'.$request->image->extension();
        //     $request->image->move(public_path('storage/purchases'), $imageName);

        // if($request->hasFile('image')){
        //     $imageName = time().'.'.$request->image->extension();
        //     $request->image->move(public_path('storage/purchases'), $imageName);
        // }
        $input['image']=null;
        if($request->file('image')){
            $newfile=time().$request->file('image')->getClientOriginalName();
            $file_path=$request->file('image')->storeAs('images',$newfile,'pharam');
            $input['image'] = $file_path;
        }
        $DifExperyDate = Purchase::query()
        ->where('name', $request->name)
        ->where('expiry_date', '!=', $request->expiry_date)
        ->whereNotIn('expiry_date', [$request->expiry_date])
        ->first();

$num = Purchase::query()->where('name' , $request->name)->where('expiry_date' , $request->expiry_date)->first();
$pro = Profit_percentage::query()->first();


        if( $num == null && $DifExperyDate == null)

      {


        $input =   Purchase::create([
            'name'=>$request->name,
            'category_id'=>$request->category,
            'supplier_id'=>$request->supplier,
            'net_price'=>$request->net_price,
            'salling_price' => isset($request->salling_price) ? $request->salling_price :
             (($request->net_price * $pro->profit_percentage) + $request->net_price),
            'expiry_date'=>$request->expiry_date,
            'quantity'=>$request->quantity,
            'image'=>$input['image'],
            'paracode' => $request->paracode,
        ]);
    
        $product = Product::create ([
            'product_name'=>$request->name,
            'price' => isset($request->salling_price) ? $request->salling_price :
             (($request->net_price * $pro->profit_percentage) + $request->net_price),
            'quantity'=>$request->quantity,
            'purchase_id'=>$input['id'],
            'category_id'=> $request->category,
            'paracode' => $request->paracode,
        ]);

        $Date = ExperyDate::create ([
            'product_id'=>$product['id'],
            'expiry_date'=>$request->expiry_date,
            'quantity'=>$request->quantity

        ]);
        return [
            new PurchaseResource($input)
          ];


        }

        else if ($num != null)

        {


            Purchase::create([
                'name'=>$request->name,
                'category_id'=>$request->category,
                'supplier_id'=>$request->supplier,
                'net_price'=>$request->net_price,
                'salling_price' => isset($request->salling_price) ? $request->salling_price :
                 (($request->net_price * $pro->profit_percentage) + $request->net_price),
                'quantity'=>$request->quantity,
                'expiry_date'=>$request->expiry_date,
                'paracode' => $request->paracode,
                'image'=>$input['image'],

                  ]);


            DB::table('products')->where('product_name' ,$num['name'])
          ->update([
            'quantity'=> $num ['quantity'] + $request->quantity,
            ]);

             DB::table('expery_dates')->update([
                'quantity'=> $num ['quantity'] + $request->quantity,
            ]);


            return response()->json(['message' => 'quantity  has beem successsfully update']);
            }


          else if ($DifExperyDate != null)
          {
            $qty=Product::where('product_name' ,$DifExperyDate['name'])->first();
            DB::table('products')->where('product_name' ,$DifExperyDate['name'])
            ->update
            ([

                'quantity'=> $qty->quantity + $request->quantity,

            ]);

            $product = Product::where('product_name', $DifExperyDate['name'])->first();
            DB::table('expery_dates')->insert([

                'product_id'=>$product['id'],
                'expiry_date'=>$request->expiry_date,
                'quantity'=>$request->quantity
            ]);

            return response()->json(['message' => 'quantity  has beem successsfully update']);




        }


    }
    public function show($id)
    {
        $purchase = Purchase::find($id);
        return [
            new PurchaseResource($purchase)
          ];

    }
    /*
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Purchase $purchase
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      

       $purchase = Purchase::find($id);
       $purchase->update([
           'name'=>($request->name) ?$request->name :$purchase->name,
           'category_id'=>($request->category) ?$request->category :$purchase->category_id,
           'supplier_id'=>($request->supplier) ?$request->supplier :$purchase->supplier_id,
           'net_price'=>($request->net_price) ?$request->net_price :$purchase->net_price,
           'salling_price'=>($request->salling_price) ?$request->salling_price :$purchase->salling_price,
           'quantity'=>($request->quantity) ?$request->quantity :$purchase->quantity,
           'expiry_date'=>($request->expiry_date) ?$request->expiry_date :$purchase->expiry_date,
      
       ]);
      
       return [
        new PurchaseResource($purchase)
      ];

   }

   public function destroy(Request $request)
   {
       $purchase = Purchase::find($request->id);
       $purchase->delete();

   }

}