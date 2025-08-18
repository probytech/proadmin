<?php

namespace Probytech\Proadmin\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

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
		$this->publishParts();
		
		Artisan::call('migrate');
		$this->info('Migrated successfully!');
		
		$this->addUser();

		$this->publishLfm();

		Artisan::call('route:clear');
		Artisan::call('config:clear');
	}

	private function pathPackage ($path) 
	{
		return base_path("/vendor/probytech/proadmin" . $path);
	}

	private function publishPartsFolder ($source, $destination)
	{
		if (!is_dir($destination)) {
			mkdir($destination, 0777, true);
		}

		$files = scandir($source);

		foreach ($files as $file) {

			if ($file == '.' || $file == '..')
				continue;

			if (is_dir($source . '/' . $file)) {

				$this->publishPartsFolder($source . '/' . $file, $destination . '/' . $file);

			} else {

				copy(
					$source . '/' . $file,
					$destination . '/' . $file
				);
			}
		}
	}

	private function publishParts ()
	{
		$this->publishPartsFolder(
			$this->pathPackage('/src/Proadmin'),
			base_path('/app/Proadmin')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/resources/views'),
			base_path('/resources/views/proadmin')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/migrations'),
			base_path('/database/migrations')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/lang'),
			base_path('/lang')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/public'),
			public_path('/vendor/proadmin')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/public/icons'),
			storage_path('/app/public/vendor/proadmin/icons')
		);

		copy(
			$this->pathPackage('/routes/web.php'),
			base_path('/routes/proadmin.php')
		);

		copy(
			$this->pathPackage('/routes/api.php'),
			base_path('/routes/proadmin_api.php')
		);

		copy(
			$this->pathPackage('/config/proadmin.php'),
			base_path('/config/proadmin.php')
		);

		copy(
			$this->pathPackage('/bootstrap/providers.php'),
			base_path('/bootstrap/providers.php')
		);

		copy(
			$this->pathPackage('/storage/collections.json'),
			storage_path('/collections.json')
		);

		$this->info('Published successfully!');
	}

	private function addUser()
	{
		User::create([
			'name'		=> $this->ask('Administrator name'),
			'email'		=> $this->ask('Administrator email'),
			'password'	=> Hash::make($this->secret('Administrator password')),
			'roles_id'	=> 1,
		]);
	}

	private function publishLfm ()
	{
		Artisan::call('vendor:publish', ['--tag' => 'lfm_public']);

		copy(
			$this->pathPackage('/config/lfm.php'),
			base_path('/config/lfm.php')
		);
	}
}