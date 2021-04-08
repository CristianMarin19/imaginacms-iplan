<?php


namespace Modules\Iplan\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Iplan\Events\Handlers\ProcessPlanOrder;
use Modules\Iplan\Events\Handlers\RegisterNewSubscription;
use Modules\Iplan\Events\Handlers\UpdateUserLimits;
use Modules\Iplan\Events\Handlers\ValidateLimits;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
  private $module;

  protected $listen = [];

  public function boot()
  {
    $this->module = app('modules');//Get modules
    $entities = [];//Default entities

    //Get config to limits entities
    foreach ($this->module->allEnabled() as $name => $module) {
      $configLimitEntities = config('asgard.' . strtolower($name) . '.config.limitEntities');
      if (!empty($configLimitEntities)) $entities = array_merge($entities, $configLimitEntities);
    }

    //Add dynamic events handler
    foreach ($entities as $entity) {
        //Get info form entity
        $entityPath = explode('\\', $entity["entity"]);
        $entityName = end($entityPath);
        $moduleName = $entityPath[1];

        //Listen Creating Event
        Event::listen(
            "Modules\\" . $moduleName . "\\Events\\" . $entityName . "IsCreating",
            [ValidateLimits::class, 'handle']
        );

        //Listen Updating Event
        Event::listen(
            "Modules\\" . $moduleName . "\\Events\\" . $entityName . "IsUpdating",
            [ValidateLimits::class, 'handle']
        );

        //Listen Created Event
        Event::listen(
            "Modules\\" . $moduleName . "\\Events\\" . $entityName . "WasCreated",
            [UpdateUserLimits::class, 'handle']
        );

        //Listen Updating Event
        Event::listen(
            "Modules\\" . $moduleName . "\\Events\\" . $entityName . "WasUpdated",
            [UpdateUserLimits::class, 'handle']
        );

        Event::listen(
            "Modules\\Icommerce\\Events\\OrderWasProcessed",
            [ProcessPlanOrder::class, 'handle']
        );

        Event::listen(
            "Modules\\Iprofile\\Events\\UserCreatedEvent",
            [RegisterNewSubscription::class, 'handle']
        );
    }
  }
}
