<?php

namespace Probytech\Proadmin\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Probytech\Proadmin\Models\Role;

class ProadminInstall extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'proadmin:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run installation of Proadmin.';

	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$this->info('Please note: Proadmin requires fresh Laravel installation!');

		Artisan::call('migrate');

		$this->info('Migrated successfully!');

		$this->addUser();

        Artisan::call('vendor:publish', ['--provider' => 'Probytech\Proadmin\ProadminServiceProvider']);

		Artisan::call('route:clear');
		Artisan::call('config:clear');

        $this->info('Proadmin installed successfully! Enjoy 🎉');
	}

	private function addUser()
	{
		User::create([
			'name'		=> $this->ask('Administrator name'),
			'email'		=> $this->ask('Administrator email'),
			'password'	=> Hash::make($this->secret('Administrator password')),
			'roles_id'	=> Role::ADMIN,
		]);
	}
}
