<?php

namespace Modules\Iplan\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Icommerce\Transformers\ProductTransformer;

class PlanTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data= [
      'id' => $this->when($this->id,$this->id),
      'name' => $this->when($this->name,$this->name),
      'description' => $this->when($this->description,$this->description),
      'frequencyId' => $this->when($this->frequency_id,$this->frequency_id),
      'categoryId' => $this->when($this->category_id,$this->category_id),
      'category' => $this->whenLoaded('category'),
      'product' => new ProductTransformer($this->product()),
      'productId' => $this->product()->id ?? null,
      'products' => ProductTransformer::collection($this->products),
      'productIds' => $this->products()->pluck('product_id'),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'limits' => $this->whenLoaded('limits'),
    ];
    return $data;
  }//toArray()
}
