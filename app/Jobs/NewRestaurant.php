<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\SendToAndroid;
use App\Jobs\SendToIos;
use App\Notification;

class NewRestaurant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $usersId;
    protected $from;
    protected $restaurant_id;
    protected $msg;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($usersId, $from, $restaurant_id, $msg)
    {
        $this->usersId = $usersId;
        $this->from = $from;
        $this->restaurant_id = $restaurant_id;
        $this->msg = $msg;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->usersId as $userId){
            $user_id = $userId->id;
            $NotificationType = 2;
            $Not_id = Notification::create([
                'to_device' => $user_id,
                'from_device' => $this->from,
                'message' => $this->msg,
                'notification_type' =>  $NotificationType,
                'restaurant_id' => $this->restaurant_id

            ]);
            $messages =
                [
                    'NotificationId' => $Not_id->id,
                    'message' => $this->msg,
                    'restaurant_id' => $this->restaurant_id,
                    'NotificationType' => $NotificationType,

                ];
            \Log::info($messages);
            dispatch(new SendToAndroid($user_id, $messages));
            dispatch(new SendToIos($user_id, $this->msg,  $messages));
        }
    }
}
