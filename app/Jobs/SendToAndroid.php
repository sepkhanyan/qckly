<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Device;
use App\Notification;

class SendToAndroid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;
    protected $messages;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $messages)
    {
        $this->user_id = $user_id;
        $this->messages = $messages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $devicetoken = Device::where('user_id', $this->user_id)->where('device_type', 'android')->get();
        $device = array();
        foreach ($devicetoken as $dev) {
            $device[] = $dev->device_token;

        }
        $msg = array
        (
            'message' => $this->messages
        );
        $fields = array
        (
            'registration_ids' => $device,
            'data' => $msg
        );

        $headers = array
        (
            'Authorization: key=AAAADqKcxjE:APA91bEBFOqJeois_VnE6TIT33Nax62sCHwDKm_YHb9scdCrQ65i_rluwqwVKsCcDzVnzwbFEzx38XhvhPmapqXSDlqtNQgRSB9lGzZLiELjdFVv-G2XluwKYdTWxhBN72bSGc5FoiTw',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        \Log::info($result);

        curl_close($ch);
    }
}
