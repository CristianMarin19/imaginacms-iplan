<?php

namespace Modules\Iplan\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePlanRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          "price"=>"required|numeric",
          "frequency"=>"required|numeric",
          "bill_cycle"=>"required|in:week,month,year",
        ];
    }

    public function translationRules()
    {
        return [
          "name"=>"required|string|max:30",
          "description"=>"string|max:250",
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
