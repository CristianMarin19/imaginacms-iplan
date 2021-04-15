<?php

namespace Modules\Iplan\Events\Handlers;


class ProcessPlanOrder
{

    public function __construct()
    {

    }

    public function handle($event)
    {
        $order = $event->order;
        //Order is Proccesed
        if($order->status_id==13){

            foreach($order->orderItems as $item){

                switch($item->entity_type){
                  case 'Modules\Iplan\Entities\Plan':


                    break;
                }

            }

        }// end If


    }// If handle



}
