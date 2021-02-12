<?php

namespace Modules\Iplan\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PlanTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data= [
      'id' => $this->when($this->id,$this->id),
      'name' => $this->when($this->name,$this->name),
      'description' => $this->when($this->description,$this->description),
      'frequencyId' => $this->when($this->frequency,$this->frequency),
      'categoryId' => $this->when($this->category_id,$this->category_id),
      'category' => $this->whenLoaded($this->category),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];

    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        $data[$lang]['name'] = $this->hasTranslation($lang) ? $this->translate("$lang")['name'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ? $this->translate("$lang")['description'] : '';
      }
    }//isset
    return $data;
  }//toArray()
}
