<?php

namespace Azuriom\Plugin\AdvancedBan\Controllers;

use Azuriom\Http\Controllers\Controller;
use DB;

class AdvancedBanHomeController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if (config()->get('database.connections.advancedban') === null) {
			abort_if(setting('advancedban.host') === null, 404);

	        config()->set('database.connections.advancedban', [
	            'driver'    => 'mysql',
	            'host'      => setting('advancedban.host', '127.0.0.1'),
	            'port'      => setting('advancedban.port', '3306'),
	            'database'  => setting('advancedban.database', 'advancedban'),
	            'username'  => setting('advancedban.username', 'advancedban'),
	            'password'  => setting('advancedban.password'),
	            'charset'   => 'utf8',
	            'collation' => 'utf8_unicode_ci',
	            'prefix'    => '',
	            'strict'    => false
	        ]);
	    }

	    $punishmentHistory = DB::connection('advancedban')->select('SELECT * FROM punishmenthistory ORDER BY start DESC');
	    $punishments = DB::connection('advancedban')->select('SELECT * FROM punishments ORDER BY start DESC');
	    $allPunishments = collect(array_merge($punishmentHistory, $punishments))->unique();

        return view('advancedban::index', ['punishments' => $punishments, 'punishmentHistory' => $punishmentHistory, 'allPunishments' => $allPunishments]);
    }
}
