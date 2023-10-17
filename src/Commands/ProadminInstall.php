<?php

namespace Probytech\Proadmin\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Probytech\Proadmin\Templates\TemplateComponents;
use Probytech\Proadmin\Templates\TemplateDefault;
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
		$type_template = $this->import_template();
	}

	private function template_add_folder ($path) {

		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
	}

	private function path_package ($path) {

		return base_path("/vendor/probytech/proadmin" . $path);
	}

	private function publish_parts_folder ($source, $destination) {

		$this->template_add_folder($destination);

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
			$this->path_package('/core/Proadmin'),
			base_path('/app/Proadmin')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/views'),
			base_path('/resources/views/proadmin')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/migrations'),
			base_path('/database/migrations')
		);

		$this->publish_parts_folder(
			$this->path_package('/core/lang'),
			base_path('/lang')
		);

		$this->publish_parts_folder(
			$this->path_package('/public'),
			public_path('/vendor/proadmin')
		);

		copy(
			$this->path_package('/core/routes.php'),
			base_path('/routes/proadmin.php')
		);

		copy(
			$this->path_package('/core/proadmin.php'),
			base_path('/config/proadmin.php')
		);

		// register provider
		$provider = file_get_contents(base_path("/config/app.php"));
		
		if (strpos($provider, 'ProadminServiceProvider::class') === false) {

			$pos = strpos($provider, 'Package Service Providers...');
			$pos = strpos($provider, '*/', $pos);
			
			file_put_contents(
				base_path("/config/app.php"),
				substr_replace($provider, '*/ App\Proadmin\Providers\ProadminServiceProvider::class,', $pos, 2)
			);
		}
	}

	private function import_template () {

		$answer = $this->ask('Import template (only on fresh installation): converter, layout, header, footer, pagination, JS, route, SitemapController, PagesController (Y/n)?');

		$type = '';

		if ($answer != 'n') {

			$type = $this->choice('Which type of template do you want?', [
				'Default',
				'With Components',
			]);

			if ($type == 'Default'){
				$template = new TemplateDefault();
			} else {
				$template = new TemplateComponents();
			}

			$template->import();
			
		}

		return $type;
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