<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type'=> 'employee',
            'attributes' => [

                'id' => $this->id,
                'name'=>$this->name,
                'email' => $this->email,
                'phone'=> $this->phone,
                'start_date'=>$this->start_date,
                'birthdate'=>$this->birthdate,
              
                'salary'=>$this->salary,
            ]];
    }
}
