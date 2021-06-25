@extends('iprofile::frontend.layouts.master')
@section('profileBreadcrumb')
    <x-isite::breadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('iplan::common.title.my-qrs') }}</li>
    </x-isite::breadcrumb>
@endsection

@section('profileTitle')
    {{ trans('iplan::common.title.my-qrs') }}
@endsection
@section('profileContent')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="my-2 text-right">
                    <x-isite::print-button containerId="qrPrint" icon="fa fa-file-pdf-o" text="{{ trans('iplan::common.title.print') }}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="my-2">
                    @php $defaultImage = url("modules/iprofile/img/default.jpg"); @endphp
                    <!-- imagen -->
                        <div class="img-frame mx-auto">
                            @if(isset($fields['mainImage']) &&  !empty($fields['mainImage']) && $fields['mainImage']!=null )
                                <img id="mainImage" class="mx-auto img-fluid rounded-circle bg-white" src="{{ url($fields['mainImage']).'?'.strtotime(now()) }}" alt="Logo" >
                            @else
                                <img id="mainImage" class="mx-auto img-fluid rounded-circle bg-white" src="{{$defaultImage}}" alt="Logo">
                            @endif
                        </div>
                </div>
                <div class="my-2 text-center">
                    {{ $user->present()->fullName }}
                </div>
            </div>
            <div class="col-12 col-sm-9">
                <div class="my-2 text-center" id="qrPrint">
                    @php
                        $qrs = $user->qrs()->where('zone','subscriptions')->get();
                    @endphp
                    @foreach($qrs as $qr)
                        <img src="{{ $qr->code }}" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

