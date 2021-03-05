@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row py-3 justify-content-center">
            @foreach($plans as $plan)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $plan->name }}</h5>
                            <p class="card-text">{!! $plan->description !!}</p>
                            <p class="card-text"><small class="text-muted">{{ localesymbol()->symbol_left }} {{ formatMoney($plan->product->price) }}</small></p>
                            <a href="{{ route(locale().'.iplan.plan.index') }}" class="btn btn-primary">Solicitar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
