<?php


namespace Modules\Iplan\Events\Handlers;


use Modules\Iplan\Entities\Limit;
use Modules\Iplan\Entities\SubscriptionLimit;
use Modules\Iplan\Entities\Subscription;
use Modules\User\Entities\Sentinel\User;
use Carbon\Carbon;

class HandleModulesLimits
{
  private $logTitle;

  public function __construct()
  {
    $this->logTitle = '[Iplan-Validate-Limit-Event]::';
  }

  //Handle to "IsCreating"
  public function handleIsCreating($event)
  {
    $this->validateLimits($event, 'isCreating');
  }

  //Handle to "WasCreated"
  public function handleWasCreated($event)
  {
    $this->handleLimits($event, 'wasCreated');
  }

  //Handle to "IsUpdating"
  public function handleIsUpdating($event)
  {
    $this->validateLimits($event, 'isUpdating');
  }

  //Handle to "WasUpdated"
  public function handleWasupdated($event)
  {
    $this->handleLimits($event, 'wasUpdated');
  }

  //Main Handle
  public function validateLimits($event, $eventType)
  {
    $model = $event->model;//Get model

    $allowedLimits = true;//Defualt response

    //Get entity attributes
    $entityNamespace = get_class($model);
    $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
    $moduleName = $entityNamespaceExploded[1];//Get module name
    $entityName = $entityNamespaceExploded[3];//Get entity name

    //Validate if exist plan limits to current entity (if not found, allow trigger action)
    $existEntityLimits = Limit::where('entity', $entityNamespace)->count();

    //Validate user limits
    if ($existEntityLimits) {
      //Get user limits
      $userSubcriptionLimits = SubscriptionLimit::whereHas('subscription', function ($q) {
        //Get current full date
        $now = Carbon::now()->format('Y-m-d h:i:s');
        //Filter subscriptions
        $q->whereDate('end_date', '>', $now)->whereDate('start_date', '<=', $now)->where(function ($query) {
          $query->whereNull('entity')->orWhere(function ($query) {
            $query->where('entity_id', auth()->user()->id)->where('entity', User::class);
          });
        });
      })->groupBy(["attribute", "attribute_value", "entity"])
        ->orderBy('id')
        ->where('entity', $entityNamespace)
        ->selectRaw('sum(quantity) as quantity, sum(quantity_used) as quantity_used, entity, attribute, attribute_value')
        ->get();

      //validate limits
      if ($userSubcriptionLimits->count() > 0) {
        foreach ($userSubcriptionLimits as $limitToValidate) {
          $validateLimit = true;
          $modelValue = null;
          $limitAttribute = $limitToValidate->attribute; //get limit attribute name
          //Validate if limit has attribute
          if ($limitAttribute && isset($model->$limitAttribute)) {
            $modelValue = (string)$model->$limitAttribute ?? null;
            if ($modelValue != $limitToValidate->attribute_value) $validateLimit = false;
          }
          //validate limit quantities
          if ($validateLimit) {
            if ((int)$limitToValidate->quantity_used >= (int)$limitToValidate->quantity) {
              $allowedLimits = false;
              break;//end loop
            }
          }
        }
      } else {
        $allowedLimits = false;
      }
    }

    //Response forbidden
    if (!$allowedLimits) throw new \Exception('Entity Creating/Updating Not Allowed', 403);
  }

  //Handle limits after trigger event
  public function handleLimits($event, $eventType)
  {
    dd('Handler limits');
  }
}
