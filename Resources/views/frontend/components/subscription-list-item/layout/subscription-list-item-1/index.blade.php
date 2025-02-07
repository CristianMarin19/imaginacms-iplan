<div class="item-layout item-list-layout-1">
    <div class="card card-category card-item border-0">
        <div class="row align-items-center">
            <div class="col-12 {{$orderClasses["title"] ?? 'order-0'}} item-title">
                @if(isset($item->url))
                    <a href="{{$item->url}}">
                        @endif
                        <h3 class="title">
                            {{$item->title ?? $item->name}}
                        </h3>
                        @if(isset($item->url))
                    </a>
                @endif
            </div>
            <div class="col-12 {{$orderClasses["status"] ?? 'order-1'}}">
                {{trans('iplan::subscriptions.status.title')}}:
                {!!
                    $item->status == '1' ?
                          "<b class='text-success'>". trans('iplan::subscriptions.status.active'). "</b>" :
                          "<b class='text-danger'>". trans('iplan::subscriptions.status.inactive'). "</b>"
                  !!}
            </div>
            <div class="col-12 {{$orderClasses["date"] ?? 'order-2'}} item-created-date">
                <div class="created-date">
                    {{--  Here word  "From"     --}}
                    {{trans('iplan::common.date.from')}}
                    {{--  First data to show   --}}
                    {{ $item->start_date->format($formatCreatedDate) }}
                    {{--  Here word  "to"     --}}
                    {{trans('iplan::common.date.since')}}
                    {{--  First data to show      --}}
                    {{ $item->end_date->format($formatCreatedDate) }}</div>
            </div>
        </div>
    </div>
</div>
