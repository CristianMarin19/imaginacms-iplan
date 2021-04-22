<?php

namespace Modules\Iplan\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Iplan\Entities\Subscription;

class NotifyExpiredSubscriptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $notification;

    public function __construct()
    {
        $this->notification = app("Modules\Notification\Services\Inotification");
    }

    public function handle()
    {
        $nowDate = date('Y-m-d h:i:s');
        \Log::info("Checking Subscriptions | Now Date: $nowDate");
        $result = Subscription::with('entityData')->select(
            \DB::raw("DATEDIFF('{$nowDate}', start_date) as days_elapsed"),
            \DB::raw("DATEDIFF(end_date, '{$nowDate}') as days_remaining"),
            \DB::raw("iplan__subscriptions.*")
        )
            ->where("status", 1)
            ->whereRaw(\DB::raw("DATEDIFF(end_date, '{$nowDate}') <= 3"))
            ->get();

        if(count($result) > 0) {
            foreach ($result as $item) {
                if($item->days_remaining >= -2 && $item->days_remaining <= 3) {
                    \Log::info("Sub Id {$item->id}: {$item->name} - To User: {$item->entityData->email} - Elapsed: {$item->days_elapsed} - Remaining: {$item->days_remaining}");

                    //send notification by email, broadcast and push -- by default only send by email
                    $this->notification->to([
                        "email" => $item->entityData->email,
                        "broadcast" => $item->entity_id,
                        "push" => $item->entity_id,
                    ])->push(
                        [
                            "title" => $item->days_remaining > 0 ? trans("iplan::subscriptions.alerts.subForSellOut") : trans("iplan::subscriptions.alerts.subSoldOut"),
                            "message" => $item->days_remaining > 0 ? trans("iplan::subscriptions.messages.subForSellOut", ["days" => $item->days_remaining, "name" => $item->name]) : trans("iplan::subscriptions.messages.subSoldOut", ["days" => $item->days_remaining, "name" => $item->name]),
                            "buttonText" => trans("iplan::plans.button.buy"),
                            "withButton" => true,
                            "link" => route(locale().'.iplan.plan.index'),
                        ]
                    );
                }
            }
        }else{
            \Log::info("Nothing to Expire");
        }
    }
}
