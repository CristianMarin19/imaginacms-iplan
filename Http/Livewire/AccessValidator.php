<?php

namespace Modules\Iplan\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AccessValidator extends Component
{
  public $buttonHref;
  public $buttonLabel;
  public $hasSubscription;

  public function mount($buttonHref, $buttonLabel)
  {
    $this->buttonHref = $buttonHref;
    $this->buttonLabel = $buttonLabel;
  }

  /*
  * Render
  *
  */
  public function render()
  {
    $currentUser = Auth::user();
    if (!empty($currentUser)) {
      if (is_module_enabled('Iplan') && $currentUser) {
        $service = app('Modules\Iplan\Services\SubscriptionService');
        $this->hasSubscription = $service->validate(app('Modules\Iad\Entities\Ad'), $currentUser);
      }
    } else {
      $this->hasSubscription = false;
    }

    return view('iplan::frontend.livewire.access-validator');
  }
}
