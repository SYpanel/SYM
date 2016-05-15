<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Package;
use App\SYPanel\Ngnix\Server;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Piwik\Ini\IniWriter;

class AccountsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$accounts = Account::all();

		return view('account.index', compact('accounts'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$packages = Package::all();

		return view('account.create', compact('packages'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		$account           = Account::create($request->all());
		$account->password = bcrypt($request->password);
		if(!empty($request->input('package_id')))
		{
			$account->package_id = $request->package_id;
		}
		$account->save();

		/** Create user */
		$password = sy_exec('mkpasswd -m sha-512 ' . $request->password);
		sy_exec('useradd -d /home/' . $request->username . ' -m -s /bin/bash -p \'' . $password . '\' ' . $request->username);
		/** Create php-fpm pool*/
		$pool[$request->username] = [
			'user'                 => $request->username,
			'group'                => $request->username,
			'listen'               => '127.0.0.1:' . (9010 + $account->id),
			'listen.owner'         => $request->username,
			'listen.group'         => $request->username,
			'pm'                   => 'dynamic',
			'pm.max_children'      => 5,
			'pm.start_servers'     => 2,
			'pm.min_spare_servers' => 1,
			'pm.max_spare_servers' => 3,
		];

		$ini  = new IniWriter();
		$file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . rand(1, 999999) . time();
		file_put_contents($file, (string)$ini->writeToString($pool));
		sy_exec("mv {$file} /etc/php5/fpm/pool.d/{$request->username}.conf");

		/** Create nginx config*/
		$nginx              = new Server();
		$nginx->listen      = '80';
		$nginx->access_log  = '/home/' . $request->username . '/log/nginx_access.log';
		$nginx->error_log   = '/home/' . $request->username . '/log/nginx_error.log';
		$nginx->root        = '/home/' . $request->username . '/public_html';
		$nginx->index       = 'index.php index.html index.htm';
		$nginx->server_name = $request->domain;
		$nginx->locations['/'];
		$nginx->locations['~ \.php$']->try_files               = '$uri /index.php =404';
		$nginx->locations['~ \.php$']->fastcgi_split_path_info = '^(.+\.php)(/.+)$';
		$nginx->locations['~ \.php$']->fastcgi_pass            = '127.0.0.1:' . (9010 + $account->id);
		$nginx->locations['~ \.php$']->fastcgi_index           = 'index.php';
		$nginx->locations['~ \.php$']->fastcgi_param           = 'SCRIPT_FILENAME $document_root$fastcgi_script_name';
		$nginx->locations['~ \.php$']->include                 = 'fastcgi_params';
		$nginx->toFile('/etc/nginx/conf.d/' . $request->username . '.conf');

		sy_exec('sleep 2;service nginx reload',true,false);
		sy_exec('sleep 2;service php5-fpm reload',true,false);

		return redirect(action('AccountsController@index'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
