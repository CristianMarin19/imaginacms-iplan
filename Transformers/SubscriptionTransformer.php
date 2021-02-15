<?php

namespace Modules\Iplan\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data= [
      'id' => $this->when($this->id,$this->id),
      'name' => $this->when($this->name,$this->name),
      'description' => $this->when($this->description,$this->description),
      'frequency' => $this->when($this->frequency,$this->frequency),
      'entityId' => $this->when($this->entity_id,$this->entity_id),
      'entity' => $this->when($this->entity),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];

    return $data;
  }//toArray()
}
