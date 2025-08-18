<?php

namespace Probytech\Proadmin\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Artisan;

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
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 */
	public function handle() {

		$this->info('Please note: Proadmin requires fresh Laravel installation!');
		$this->publish_parts();
		
		Artisan::call('migrate');
		$this->info('Migrated successfully!');
		
		$this->add_user();
	}

	private function path_package ($path) {

		return base_path("/vendor/probytech/proadmin" . $path);
	}

	private function publish_parts_folder ($source, $destination) {

		if (!is_dir($destination)) {
			mkdir($destination, 0777, true);
		}

		$files = scandir($source);

		foreach ($files as $file) {

			if ($file == '.' || $file == '..')
				continue;

			if (is_dir($source . '/' . $file)) {

				$this->publish_parts_folder($source . '/' . $file, $destination . '/' . $file);

			} else {

				copy(
					$source . '/' . $file,
					$destination . '/' . $file
				);
			}
		}
	}

	private function publish_parts () {

		$this->publish_parts_folder(
			$this->path_package('/src/Proadmin'),
			base_path('/app/Proadmin')
		);

		$this->publish_parts_folder(
			$this->path_package('/resources/views'),
			base_path('/resources/views/proadmin')
		);

		$this->publish_parts_folder(
			$this->path_package('/migrations'),
			base_path('/database/migrations')
		);

		$this->publish_parts_folder(
			$this->path_package('/lang'),
			base_path('/lang')
		);

		$this->publish_parts_folder(
			$this->path_package('/public'),
			public_path('/vendor/proadmin')
		);

		$this->publish_parts_folder(
			$this->path_package('/public/icons'),
			storage_path('/app/public/vendor/proadmin/icons')
		);

		copy(
			$this->path_package('/config/proadmin.php'),
			base_path('/config/proadmin.php')
		);

		copy(
			$this->path_package('/storage/collections.json'),
			storage_path('/collections.json')
		);

		$this->info('Published successfully!');
	}

	private function add_user() {

		User::create([
			'name'		=> $this->ask('Administrator name'),
			'email'		=> $this->ask('Administrator email'),
			'password'	=> bcrypt($this->secret('Administrator password')),
			'roles_id'	=> 1,
		]);
	}
}