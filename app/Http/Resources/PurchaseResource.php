<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'type'=> 'purchases',
            'attributes' => [
                'id'=>$this->id,
                'name'=>$this->name,
                'category_id'=>$this->category_id,
                'supplier_id'=>$this->supplier_id,
                'net_price'=>$this->net_price,
                'salling_price'=>$this->salling_price,
                'quantity'=>$this->quantity,
                'expiry_date'=>$this->expiry_date,
                'image'=>$this->image,
           
            ]];

    }
}
