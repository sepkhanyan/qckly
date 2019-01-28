<?php

namespace App\Jobs;

use Mail;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailAndSMSAfterCompleteOrder implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $restaurants;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($restaurants)
	{
		$this->restaurants = $restaurants;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$restaurantIDs = $this->restaurants->pluck('id')->toArray();
		$users = User::whereIn('restaurant_id', $restaurantIDs)->get();

		foreach ($users as $user) {

			// $email = $user->email;
			$email = 'mabdulfattah@ebdaadt.com';
			// $email = 'sky933108@gmail.com';

			// $user_phone = $user->mobile_number;
			$user_phone = '30666303';

			Mail::send('welcome', [],
				function ($m) use ($email) {

					$title = 'Qckly';
					$subject = 'Qckly Order Request';

					$m->from(config('mail.from.address'), $title);
					$m->to($email, $email)->subject($subject);
				}
			);

			$url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=You%20have%20new%20order&destination=974$user_phone&source=97772&mask=Qckly";
			// space for sms content %20
			$ret = file($url);
		}
	}
}
