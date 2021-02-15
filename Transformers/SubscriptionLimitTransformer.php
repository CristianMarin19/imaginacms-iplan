<?php

namespace Modules\Iplan\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SubscriptionLimitTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id,$this->id),
      'name' => $this->when($this->name,$this->name),
      'entity' => $this->when($this->entity,$this->entity),
      'quantity' => $this->when($this->quantity,$this->quantity),
      'quantityUsed' => $this->when($this->quantity_used,$this->quantity_used),
      'attribute' => $this->when($this->attribute,$this->attribute),
      'attributeValue' => $this->when($this->attribute_value,$this->attribute_value),
      'subscriptionId' => $this->when($this->subscription_id,$this->subscription_id),
      'subscription' => new SubscriptionTransformer($this->whenLoaded('subscription')),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];

    return $data;
  }
}
