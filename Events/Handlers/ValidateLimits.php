<?php


namespace Modules\Iplan\Events\Handlers;


use Modules\Iplan\Entities\EntityPlan;
use Modules\Iplan\Entities\SubscriptionLimit;
use Modules\Iplan\Entities\Subscription;
use Modules\User\Entities\Sentinel\User;
use Carbon\Carbon;

class ValidateLimits
{
    public function __construct()
    {

    }

    public function handle($event)
    {
        $model = $event->model;//Get model
        $allowedLimits = true;//Defualt response

        //Get entity attributes
        $entityNamespace = get_class($model);
        $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
        $moduleName = $entityNamespaceExploded[1];//Get module name
        $entityName = $entityNamespaceExploded[3];//Get entity name


        //Validate if entity require plan

        $requirePlan = EntityPlan::where('entity', $entityNamespace)->where('module', $moduleName)->where('status', 1)
            ->count() > 0 ? true : false;


        //Validate user limits
        if ($requirePlan) {
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
            if($userSubcriptionLimits->count() > 0) {
                foreach ($userSubcriptionLimits as $limitToValidate) {
                    $validateLimit = true;
                    $modelValue = null;
                    $limitAttribute = $limitToValidate->attribute; //get limit attribute name
                    //Validate if limit has attribute
                    if ($limitAttribute) {
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
            }else{
                $allowedLimits = false;
            }
        }

        //Response
        if($allowedLimits==false) throw new \Exception('Entity Creating/Updating Not Allowed');
   }
}
