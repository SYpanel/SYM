<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\SYpanel\NginxConfig;
use Illuminate\Http\Request;
use Piwik\Ini\IniWriter;

class ServerController extends Controller
{
    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function services()
    {
        $services_raw = sy_exec('service --status-all | egrep \'mysql|php|bind9|dovecot|nginx|postfix|ssh\'');
        $services_raw = explode("\n", $services_raw);

        $services = [];
        foreach ($services_raw as $service) {
            if (preg_match('/^ \[ ([+-]) \] (.*)$/', $service, $match)) {
                $services[$match[2]] = ($match[1] == '+' ? true : false);
            }
        }

        return view('server.services', compact('services'));
    }

    public function serviceChange(Request $request)
    {
        switch ($request->action) {
            case 'change':
                sy_exec('service ' . $request->service . ' ' . ($request->status === 'true' ? 'start' : 'stop'));
                break;

            case 'reload':
                sy_exec('service ' . $request->service . ' reload');
                break;

            case 'restart':
                sy_exec('service ' . $request->service . ' restart');
                break;
        }
        return ['success' => 'yes'];
    }

    public function updates()
    {
        //TODO
        sy_exec('sudo apt-get update');
        //$updates = shell_exec('sudu ');
        return view('server.updates');
    }
}
