<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{//
    public function index()
    {
        $dis = Discount::all();
        return response()->json(['data' => $dis]);
    }

    public function show($id)
    {
        $dis = Discount::find($id);
        if (!$dis) {
            return response()->json(['message' => 'discount not found'], 404);
        }
        return response()->json(['data' => $dis]);
    }




    public function store(Request $request)
    {

        $this->validate($request,[
            'discount'=>'required',
            'product_id'=>'required',
        ]);
        $dis = new Discount();
      
        $dis->product_id = $request->input('product_id');
        $dis->discount = $request->input('discount');
        $dis->save();
        $product = Product::query()->where('id' , $request->input('product_id'))->first();

        $product->update([
    'price' =>  $product->price   - ($product->price * $request->input('discount')),

        ]);
        // , 'data' =>  $product
        return response()->json(['message' => 'discount created successfully', 'data' => $dis ]);
    }


    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'discount'=>'required',
        ]);
        $Dis = Discount::find($id);
        if (!$Dis) {
            return response()->json(['message' => 'discount not found'], 404);
        }

         $Dis->update([
           
            'product_id'=>($request->product_id) ?$request->product_id :$Dis->product_id,
            'discount'=>($request->discount) ?$request->discount :$Dis->discount,
        ]);
        $Dis->save();
        $product = Product::query()->where('id' , $Dis->product_id)->first();

        $product->update([
    'price' =>  $product->price   - ($product->price * $request->input('discount')),

        ]);

        return response()->json(['message' => 'Donation updated successfully', 'data' => $Dis]);
    }

    public function destroy($id)
    {
        $Dis = Discount::find($id);
        if (!$Dis) {
            return response()->json(['message' => 'discount not found'], 404);
        }
        $Dis->delete();
        return response()->json(['message' => 'discount deleted successfully']);
    }
}
