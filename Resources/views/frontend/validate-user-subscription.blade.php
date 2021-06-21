@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h4>{!! trans('iplan::common.messages.user-'.($userValidSubscription ?'valid':'not-valid').'-subscription', ['name' => $user->present()->fullName]) !!}</h4>
            </div>
        </div>
    </div>
@endsection
