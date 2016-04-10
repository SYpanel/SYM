<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function index()
	{
		return view('auth.login');
	}

	/**
	 * @param Request $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function login(Request $request)
	{
		if(isset($request->username) && isset($request->password))
		{
			if(static::PAMAuth($request->username, $request->password))
			{
				static::doLogin($request->username);

				return redirect(action('HomeController@index'));
			}
		}

		return redirect(action('AuthController@index'))->withInput();
	}

	public function logout(Request $request)
	{
		$request->session()->forget('user_login');
		$request->session()->flush();

		return redirect(action('AuthController@index'));
	}

	/**
	 * @param $username
	 */
	public static function doLogin($username)
	{
		session(['user_login' => $username]);
	}

	public static function check()
	{
		return (session('user_login') !== null);
	}

	/**
	 * Authenticate system users (PAM)
	 *
	 * @param string $username system username (linux)
	 * @param string $password password for username in plain text
	 *
	 * @return bool
	 */
	public static function PAMAuth($username, $password)
	{
		/** run shell command to output shadow file, and extract line for $user
		 * then split the shadow line by $ or : to get component parts
		 * store in $shad as array
		 */
		$shad = preg_split("/[$:]/", `sudo cat /etc/shadow | grep "^$username\:"`);
		/** use mkpasswd command to generate shadow line passing $pass and $shad[3] (salt)
		 * split the result into component parts and store in array $mkps
		 */
		$mkps = preg_split("/[$:]/", trim(`mkpasswd -m sha-512 $password $shad[3]`));

		/** compare the shadow file hashed password with generated hashed password and return
		 */
		return ($shad[4] == $mkps[3]);
	}
}