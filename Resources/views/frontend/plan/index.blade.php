@extends('layouts.master')
@section('content')
    <x-isite::breadcrumb>
        @if(isset($category))
        <li class="breadcrumb-item">
            <a href="{{ route(locale().'.iplan.plan.index') }}">{{ trans('iplan::plans.title.breadcrumb') }}</a>
        </li>
        @endif
        <li class="breadcrumb-item active" aria-current="page"> {{ isset($category) ? $category->title : trans('iplan::plans.title.breadcrumb') }}</li>
    </x-isite::breadcrumb>
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {!! $errors->first() !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row py-3 justify-content-center">
            @php
                $params = [];
                if(isset($category)){
                    $params = [
                        'filter' =>[
                            'category' => "$category->id"
                        ]
                    ];
                }
            @endphp
            <x-isite::carousel.owl-carousel
                    id="carouselPlans"
                    repository="Modules\Iplan\Repositories\PlanRepository"
                    itemComponent="iplan::plan-list-item"
                    :loop="false"
                    :params="$params"
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
