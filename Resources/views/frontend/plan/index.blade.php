@extends('layouts.master')
@section('content')
    <x-isite::breadcrumb>
        <li class="breadcrumb-item active" aria-current="page"> {{trans('iplan::plans.title.buy-plan')}}</li>
    </x-isite::breadcrumb>
    <div class="container">
        <div class="row py-3 justify-content-center">
            <x-isite::carousel.owl-carousel
                    id="carouselPlans"
                    repository="Modules\Iplan\Repositories\PlanRepository"
                    itemComponent="iplan::plan-list-item"
                    :loop="false"
                    :responsive="[
                      '0' => [
                        'items' => 1,
                      ],
                      '560' => [
                        'items' => 2,
                      ],
                      '1024' => [
                        'items' => 3
                      ]
                    ]"
            />
        </div>
    </div>
@endsection
