@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row py-3 justify-content-center">
            <div class="owl-carousel owl-theme" id="carouselPlans">
            @foreach($plans as $plan)
                <div class="item">
                    <div class="W-100">
                        <div class="card card-plan border-0 bg-transparent mb-5 pb-3">
                            <div class="card-header text-center rounded">
                                <h2 class="title mt-4"> {{$plan->name}}</h2>
                                <h3 class="price"> ${{ number_format($plan->product->price, 0, ',', '.')}}</h3>
                            </div>
                            <div class="card-frame rounded-bottom">
                                <div class="card-body bg-white p-4">
                                    {!!  $plan->description !!}
                                </div>
                                <div class="card-footer bg-white border-0 rounded-bottom text-center py-0">
                                    <a href="#"
                                       class="btn btn-primary rounded-pill">{{ trans('iplan::plans.button.buy') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection
@section('scripts-owl')
    @parent
    <script>
      $('#carouselPlans').owlCarousel({
        loop:true,
        autoplay: true,
        margin:10,
        nav:true,
        navText : ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
        autoplayTimeout: 10000,
        autoplayHoverPause: true,
        responsive:{
          0:{
            items:1
          },
          560:{
            items:2
          },
          1024:{
            items:3
          }
        }
      })
    </script>
    <style>
        #carouselPlans .owl-prev, #carouselPlans .owl-next {
            width: 15px;
            height: 100px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: block !important;
            border:0px solid black;
        }
        #carouselPlans .owl-prev:hover, #carouselPlans .owl-next:hover{
            background: transparent!important;

        }
        #carouselPlans .owl-prev:hover i, #carouselPlans .owl-next:hover i {
            color: #434343;
        }
        @media screen and (max-width: 560px){
            #carouselPlans .owl-prev, #carouselPlans .owl-next{
                display: none!important;
            }
        }
        #carouselPlans .owl-prev { left: -30px; }
        #carouselPlans .owl-next { right: -30px; }
        #carouselPlans .owl-prev i, .owl-next i {transform : scale(3,4); color: #ccc;}
    </style>
@stop
