<?php

class SentryUserGroupSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users_groups')->delete();

		$adminUser = Sentry::getUserProvider()->findByLogin('admin@example.com');

		$userGroup = Sentry::getGroupProvider()->findByName('Users');
		$adminGroup = Sentry::getGroupProvider()->findByName('Admins');

	    // Assign the groups to the users
	    $adminUser->addGroup($userGroup);
	    $adminUser->addGroup($adminGroup);
	}

}