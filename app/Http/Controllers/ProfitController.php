<?php

namespace App\Http\Controllers;

use App\Models\Profit_percentage;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    public function index()
    {
        $profit_per = Profit_percentage::all();
        return response()->json(['data' => $profit_per]);
    }

    public function show($id)
    {
        $profit_per = Profit_percentage::find($id);
        if (!$profit_per) {
            return response()->json(['message' => 'profit_per not found'], 404);
        }
        return response()->json(['data' => $profit_per]);
    }




    public function store(Request $request)
    {

        $this->validate($request,[
            'profit_percentage'=>'required',
        ]);
        $Pro = new Profit_percentage();
      
        $Pro->profit_percentage = $request->input('profit_percentage');
        $Pro->save();
        return response()->json(['message' => 'Donation created successfully', 'data' => $Pro]);
    }








  

    public function update(Request $request, $id)
    {
        $Pro = Profit_percentage::find($id);
        if (!$Pro) {
            return response()->json(['message' => 'Profit_percentage not found'], 404);
        }

         $Pro->update([
           
            'Profit_percentage'=>($request->Profit_percentage) ?$request->Profit_percentage :$Pro->Profit_percentage,
      
        ]);
        $Pro->save();
        return response()->json(['message' => 'Donation updated successfully', 'data' => $Pro]);
    }

    public function destroy($id)
    {
        $Pro = Profit_percentage::find($id);
        if (!$Pro) {
            return response()->json(['message' => 'Profit_percentage not found'], 404);
        }
        $Pro->delete();
        return response()->json(['message' => 'Profit_percentage deleted successfully']);
    }
     
}
