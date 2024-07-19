<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\ExperyDate;
use App\Models\Product;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::all();
        return response()->json(['data' => $donations]);
    }

    public function show($id)
    {
        $donation = Donation::find($id);
        if (!$donation) {
            return response()->json(['message' => 'Donation not found'], 404);
        }
        return response()->json(['data' => $donation]);
    }




    public function store(Request $request)
    {
        $donation = new Donation();
        $donation->product_name = $request->input('product_name');
        $donation->paracode = $request->input('paracode');
        $donation->quantity = $request->input('quantity');
        $donation->expiry_date = $request->input('expiry_date');
        $donation->save();
        return response()->json(['message' => 'Donation created successfully', 'data' => $donation]);
    }








    public function storePharmacy(Request $request)
    {
        $this->validate($request,[
            'product_name'=>'required|max:200',
            'quantity'=>'required|min:1',
        ]);

        $product = Product::query()->where('product_name' , $request->input('product_name'))->first();

        if ($request->quantity  > $product->quantity){

            return response()->json(['message' => 'There is not enough quantity'], 404);
        }
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $date = ExperyDate::query()->where('product_id' , $product['id'])->orderBy('expiry_date','desc')->first();
        $Don = Donation::query()->where('product_name' , $request->input('product_name'))->first();
         if (!$Don)
        {
        $donation = new Donation();
        $donation->product_name = $product['product_name'];
        $donation->paracode = $product['paracode'];
        $donation->quantity = $request->input('quantity');
        $donation->expiry_date = $date['expiry_date'];
        $donation->save();
        $product->update([
      'quantity' => $product->quantity - $request->quantity,


        ]);




        return response()->json(['message' => 'Donation created successfully', 'data' => $donation]);
    
    }


        else if ($Don) {
            $Don->update([
                'quantity' => $Don->quantity + $request->quantity,
          
                  ]);
                  $product->update([
                    'quantity' => $product->quantity - $request->quantity,
              
              
                      ]);
                  return response()->json(['message' => 'quantity  has beem successsfully update']);  
                              }
        }
    


    public function update(Request $request, $id)
    {
        $donation = Donation::find($id);
        if (!$donation) {
            return response()->json(['message' => 'Donation not found'], 404);
        }

         $donation->update([
            'product_name'=>($request->product_name) ?$request->product_name :$donation->product_name,
            'paracode'=>($request->paracode) ?$request->paracode :$donation->paracode,
            'quantity'=>($request->quantity) ?$request->quantity :$donation->quantity,
            'expiry_date'=>($request->expiry_date) ?$request->expiry_date :$donation->expiry_date,
      
        ]);
        $donation->save();
        return response()->json(['message' => 'Donation updated successfully', 'data' => $donation]);
    }

    public function destroy($id)
    {
        $donation = Donation::find($id);
        if (!$donation) {
            return response()->json(['message' => 'Donation not found'], 404);
        }
        $donation->delete();
        return response()->json(['message' => 'Donation deleted successfully']);
    }

    public function search(Request $request)
    {
        $product_name = $request->input('product_name');
        $paracode = $request->input('paracode');
        $expiry_date = $request->input('expiry_date');

        $donations = Donation::where('product_name', 'like', "%$product_name%")->get();

        if ($donations->isEmpty()) {
            return response()->json(['message' => 'Donations not found']);
            
        }
        return response()->json(['data' => $donations]);
    }
}