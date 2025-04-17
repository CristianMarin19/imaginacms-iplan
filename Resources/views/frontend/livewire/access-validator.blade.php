<div wire:init="validateAccess">
  @if(!$hasSubscription)
    <div class="d-flex justify-content-center">
      <a href="{{$buttonHref}}" target="_self">
        <button class="button-base button-base button-primary button-custom button-normal">
          {{$buttonLabel}}
        </button>
      </a>
    </div>
  @endif
</div>
