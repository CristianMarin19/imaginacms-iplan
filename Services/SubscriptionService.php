<?php


namespace Modules\Iplan\Services;
use Modules\Iplan\Entities\Subscription;
use Carbon\Carbon;

class SubscriptionService
{

    public function validate($model, $user = null)
    {
        //Get entity attributes

        $userDriver = config('asgard.user.config.driver');

        $entityNamespace = get_class($model);
        $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
        $moduleName = $entityNamespaceExploded[1];//Get module name
        $entityName = $entityNamespaceExploded[3];//Get entity name
        //Get current full date
        $now = Carbon::now()->format('Y-m-d h:i:s');
        $subscription = Subscription::whereHas('limits', function ($q) use ($entityNamespace) {
            //filter limits
            $q->where('entity', $entityNamespace);
        })->whereDate('end_date', '>', $now)->whereDate('start_date', '<=', $now)->where(function ($query) use ($userDriver, $user){
            $query->whereNull('entity')->orWhere(function ($query) use ($userDriver, $user){
                $query->where('entity_id', ($user ? $user->id : auth()->user()->id))->where('entity', "Modules\\User\\Entities\\{$userDriver}\\User");
            });
        })->where('status',1)
            ->orderBy('id')
            ->first();
        if(!empty($subscription)) {
            $limitsDisabled = 0;
            $subLimits = $subscription->limits;
            foreach($subLimits as $limit) {
                $validateLimit = true;
                $modelValue = null;
                //Validate if limit has attribute
                if ($validateLimit) {
                    if((int)$limit->quantity > 0) {
                        if ((int)$limit->quantity_used >= (int)$limit->quantity) {
                            $limitsDisabled++;
                        }
                    }
                }
            }
            if($limitsDisabled==count($subLimits)){
                return false;
            }
            return $subscription;
        }
        return false;
    }
}
