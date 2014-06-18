<?php

class SentryUserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

		Sentry::getUserProvider()->create(array(
	        'email'    => 'admin@example.com',
	        'password' => 'adminpassword',
	        'activated' => 1,
	    ));
	}

}