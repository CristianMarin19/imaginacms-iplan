<?php

namespace Modules\Iplan\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Iplan\Entities\Subscription;
use Modules\Iplan\Events\SubscriptionHasFinished;

class NotifyExpiredSubscriptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $notification;
    public $user;

    public function __construct()
    {
        $this->notification = app("Modules\Notification\Services\Inotification");
        $this->user = app("Modules\Iprofile\Repositories\UserApiRepository");
    }

    public function handle()
    {
        $nowDate = date('Y-m-d h:i:s');
        $driver = config('asgard.user.config.driver');
        $userNamespace = "Modules\\User\\Entities\\{$driver}\\User";

        \Log::info("Iplan: Jobs|Checking Subscriptions|Now Date: $nowDate");

        $result = Subscription::select(
            \DB::raw("DATEDIFF(end_date, '{$nowDate}') as days_remaining"),
            \DB::raw("iplan__subscriptions.*")
        )
            ->where("status", 1)
            ->where("entity",$userNamespace)
            ->whereRaw(\DB::raw("DATEDIFF(end_date, '{$nowDate}') <= 3"))
            ->get();

        //\Log::info("Iplan|Jobs|Checking Subscriptions|result: ".json_encode($result));

        if(count($result) > 0) {
            $params = ["filter" => ["userId" => $result->pluck("entity_id")->toArray()]];
            $users = $this->user->getItemsBy(json_decode(json_encode($params)));

            foreach ($result as $item) {
                $user = $users->where("id",$item->entity_id)->first();

                \Log::info("Subs Id {$item->id}: {$item->name} - To User: {$user->email} - Remaining: {$item->days_remaining}");

                //send notification by email, broadcast and push -- by default only send by email
                $this->notification->to([
                    "email" => $user->email,
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
        }else{
            \Log::info("Iplan: Jobs|Checking Subscriptions|Nothing to Expire");
        }
    }
}
