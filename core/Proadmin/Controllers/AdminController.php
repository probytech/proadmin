<?php 

namespace App\Proadmin\Controllers;

use Auth;
use App;
use DB;

class AdminController extends \App\Http\Controllers\Controller
{
	public function admin()
	{
		$languages = DB::table('languages')->get();
		$custom_components_path = resource_path('views/proadmin/components/custom');
		$custom_components_files = scandir($custom_components_path);
		$custom_components = [];

		foreach ($custom_components_files as $custom_component) {
			$pathinfo = pathinfo($custom_component);
			if ($pathinfo['extension'] == 'php') {
				$custom_components[] = [
					'name'	=>	$pathinfo['filename'],
					'path'	=> 'proadmin/components/custom/'.$pathinfo['filename'],
				];
			}
		}

		App::setLocale(Auth::user()->admin_lang_tag);

		return view('proadmin.pages.admin')->with([
			'languages'			=> $languages,
			'custom_components'	=> $custom_components,
		]);
	}

	public function login()
	{
		return view('proadmin.pages.login')->with([]);
	}

	public function signIn()
	{
		$request = request();

		$email = $request->get('email');
		$password = $request->get('password');

		if (Auth::attempt(['email' => $email, 'password' => $password], $request->get('remember') === 'true')) {

			return redirect('/admin');
		}

		setcookie('password', 'incorrect', time() + 3600 * 5);

		return redirect('/login');
	}

	public function logout()
	{
		Auth::logout();

		return redirect('/login');
	}
}