<?php

namespace Modules\Iplan\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data= [
      'id' => $this->when($this->id,$this->id),
      'name' => $this->when($this->name,$this->name),
      'description' => $this->when($this->description,$this->description),
      'frequencyId' => $this->when($this->frequency_id, (string)$this->frequency_id),
      'categoryId' => $this->when($this->category_id,$this->category_id),
      'category' => new CategoryTransformer($this->whenLoaded('category')),
      'categories' => CategoryTransformer::collection($this->whenLoaded('categories')),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'limits' => $this->whenLoaded('limits'),
      'options' => $this->when($this->options, $this->options),
    ];

    if(is_module_enabled('Icommerce')){
        $productTransformer = 'Modules\\Icommerce\\Transformers\\ProductTransformer';
        $data['productId'] = $this->product ? (string)$this->product->id : '';
        $data['product'] = new $productTransformer($this->whenLoaded('product'));
    }

    return $data;
  }//toArray()
}
