<?php

namespace App\Http\Controllers;

use App\Models\DebtRecord;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DebtRecordController extends Controller
{
    public function index()
    {
        $debt = DebtRecord::get();
        return response()->json([
            'data' => $debt]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            // 'invoice_id'=>'required',
            'customer_name'=>'required|max:200',
            'debt_value'=>'required',
        ]);

        $debt = DebtRecord::where('customer_name',$request->customer_name) 
        ->first(); 

 if ($debt == null) 

{
        $cus= Invoice::query()->where('customer_name' , $request->customer_name)->latest()->first();
        
        if ($cus == null){
            DebtRecord::create
            ([
                'customer_name'=>$request->customer_name,
                'invoice_id'=> null,
                'debt_value'=> $request['debt_value'],
                'debt_date'=> Carbon::now(),
    
            ]);
            return response()->json(['message' => '  a-debt has been successsfully create'
        ]);
    }
    else if ($cus){
        DebtRecord::create
        ([
            'customer_name'=>$request->customer_name,
            'invoice_id'=> $cus->id,
            'debt_value'=> $request['debt_value'],
            'debt_date'=> Carbon::now(),
    
        ]);
        return response()->json(['message' => '  a-debt has been successsfully create'
    ]);
    
    
    }
}
    else {

        
            return response()->json(['message' => '  customer name is already taken'
            ],203);
         
    }
}





public function update(Request $request, $id)

{ $Debt= DebtRecord::find($id);
    $Debt->update([
        'customer_name'=>($request->customer_name) ?$request->customer_name :$Debt->customer_name,

        'debt_value'=>($request->debt_value) ?$request->debt_value :$Debt->debt_value,
    ]);

    return response()->json($Debt,200); 
}  

public function search(Request $request) 
{ 
    $name=request('name'); 
    if(isset($name)){ 
        $debt = DebtRecord::where('customer_name', 'LIKE', '%' . $request->name . '%') 

        ->get(); 
 
        if($debt->isEmpty()){ 
           return response()->json(['message' => ' there is no result '],202); 
        } 
     
       } 
       return response()->json(['message' => ' you don'.'t send any thing'],203); 
    }

    public function destroy(Request $request)
    {
        $debt = DebtRecord::find($request->id);
        $debt->delete();
        return response()->json(['a-debt has been successsfully delete ']); 
    }

}