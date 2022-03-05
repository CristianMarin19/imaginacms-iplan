<?php

namespace Modules\Iplan\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Iplan\Entities\Frequency;

class PlanTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
  /*
    if(is_module_enabled('Icommerce')){
      $productTransformer = 'Modules\\Icommerce\\Transformers\\ProductTransformer';
      $data['productId'] = $this->product ? (string)$this->product->id : '';
      $data['product'] = new $productTransformer($this->whenLoaded('product'));
    }
    return $data;*/

    //dd($this->frequency_id);

    $frequencyClass = new Frequency();

    return [
      "frequency" => $frequencyClass->get($this->frequency_id)
    ];
  }
}
