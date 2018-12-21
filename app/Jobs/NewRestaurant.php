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
    protected $name_en;
    protected $name_ar;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($usersId, $from, $restaurant_id, $name_en, $name_ar)
    {
        $this->usersId = $usersId;
        $this->from = $from;
        $this->restaurant_id = $restaurant_id;
        $this->name_en = $name_en;
        $this->name_ar = $name_ar;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->usersId as $userId){
            if (!$userId->lang) {
                \App::setLocale("en");
                $name = $this->name_en;
            } else {
                \App::setLocale($userId->lang);
                if ($userId == 'ar') {
                    $name = $this->name_ar;
                } else {
                    $name = $this->name_en;
                }
            }
            $user_id = $userId->id;
            $message =  \Lang::get('message.newRestaurant', ['restaurant_name' => $name]);
            $NotificationType = 2;
            $Not_id = Notification::create([
                'to_device' => $user_id,
                'from_device' => $this->from,
                'message' => $message,
                'notification_type' =>  $NotificationType,
                'restaurant_id' => $this->restaurant_id

            ]);
            $messages =
                [
                    'NotificationId' => $Not_id->id,
                    'message' => $message,
                    'restaurant_id' => $this->restaurant_id,
                    'NotificationType' => $NotificationType,

                ];
            dispatch(new SendToAndroid($user_id, $messages));
            dispatch(new SendToIos($user_id, $message,  $messages));

        }
    }
}
