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

  public function validateAccess()
  {
    $currentUser = Auth::user();
    if (!empty($currentUser)) {
      if (is_module_enabled('Iplan') && $currentUser) {
        $service = app('Modules\Iplan\Services\SubscriptionService');
        $subscription = $service->validate(app('Modules\Iad\Entities\Ad'), $currentUser);
        $this->hasSubscription = isset($subscription->id);
        return;
      }
    }
    $this->hasSubscription = false;
  }

  /*
  * Render
  *
  */
  public function render()
  {
    return view('iplan::frontend.livewire.access-validator');
  }
}
