<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\SYPanel\Ngnix\Server;
use Illuminate\Http\Request;
use Piwik\Ini\IniWriter;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {/*
        $server = Server::fileOrContent('/etc/nginx/conf.d/sypanel.conf')[0];

        $server->toFile('/etc/nginx/conf.d/new_fish.conf');*/
/*
        // create new system user
        // useradd -d /home/username -m -s /bin/bash -p password username
        $pool['msbyorg'] = [
            'user' => 'msbyorg',
            'group' => 'msbyorg',
            'listen' => '127.0.0.1:9001',
            'listen.owner' => 'msbyorg',
            'listen.group' => 'msbyorg',
        ];
        $ini = new IniWriter();
        echo '<pre>';
        echo $ini->writeToString($pool);
        die();*/

        return view('app');
    }
}
