<?php

namespace Azuriom\Plugin\AdvancedBan\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdvancedBanHomeController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

	    $query = strtolower($request->input('q'));

	    $punishmentHistory = DB::connection('advancedban')->select('SELECT * FROM ' . setting('advancedban.historyTable', 'PunishmentHistory') . ' ORDER BY start DESC');
	    $punishments = DB::connection('advancedban')->select('SELECT * FROM ' . setting('advancedban.punishmentTable', 'Punishments') . ' ORDER BY start DESC');
	    
	    $allPunishments = collect(array_merge($punishmentHistory, $punishments))->unique();

	    if ($query) {
	    	$allPunishments = $allPunishments->filter(function ($item) use ($query) {
		    	return Str::contains(strtolower($item->name), $query) || 
		    		Str::contains(strtolower($item->reason), $query) ||
		    		Str::contains(strtolower($item->operator), $query) ||
		    		Str::contains(strtolower($item->punishmentType), $query);
	    	});
	    }

	    $currentPage = LengthAwarePaginator::resolveCurrentPage();
	    $perPage = setting('advancedban.perPage', 10);

	    $currentItems = $allPunishments->slice($perPage * ($currentPage - 1), $perPage);
	    $paginator = new LengthAwarePaginator($currentItems, count($allPunishments), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        return view('advancedban::index', ['punishments' => $punishments, 'punishmentHistory' => $punishmentHistory, 'allPunishments' => $paginator]);
    }
}
