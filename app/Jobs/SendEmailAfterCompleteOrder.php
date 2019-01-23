<?php

namespace App\Jobs;

use Mail;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\SendSMS\sendSMS;

class SendEmailAfterCompleteOrder implements ShouldQueue
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

			$email = $user->email;

			Mail::send('welcome', [],
				function ($m) use ($email) {

					$title = 'Qckly';
					$subject = 'Qckly Order Request';

					$m->from(config('mail.from.address'), $title);
					$m->to($email, $email)->subject($subject);
				}
			);
		}
	}
}
