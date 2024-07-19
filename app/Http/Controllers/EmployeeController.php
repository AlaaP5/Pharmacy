<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::get();
        return EmployeeResource::collection($employee);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:employees'],
            'password' => ['required', 'string', 'min:8'],
            'birthdate' => ['required', 'date'],
         
            'phone' => ['required', 'string'],
            'salary' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
         
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
    
       
        $employee = new Employee();
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->password = bcrypt($request->input('password'));
        $employee->birthdate = $request->input('birthdate');
        $employee->phone = $request->input('phone');
        $employee->salary = $request->input('salary');
        $employee->start_date = $request->input('start_date');
        $employee->save();
    
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->type = 'user' ;
       
        $user->save();
        $user->update([
            'role_id' => 1,
        ]);

        return response()->json([
          
                new EmployeeResource($employee)
            
        ], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return [
            new EmployeeResource($employee)
          ]; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'max:200',
            'age'=>'min:2',
            'image'=>'',
            'phone'=>'',
            'startworkdate'=>'',
            'gender'=>'',
            'salary'=>'',
   
        ]);
        $employee = Employee::find($id);
        $employee ->update([
            'name'=>$request->name,
            'age'=> $request->age,
            'phone'=> $request->phone,
            'startworkdate'=>$request->startworkdate,
            'gender'=>$request->gender,
            'salary'=>$request->salary,
            'image' =>$request->image,

        ]);
        return [
            new EmployeeResource($employee)
          ]; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
       $employee->delete();
    }
}
