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
        $this->authorize('advancedban.view');

        if (config()->get('database.connections.advancedban') === null) {
            abort_if(setting('advancedban.host') === null, 404);

            config()->set('database.connections.advancedban', [
                'driver' => 'mysql',
                'host' => setting('advancedban.host', '127.0.0.1'),
                'port' => setting('advancedban.port', '3306'),
                'database' => setting('advancedban.database', 'advancedban'),
                'username' => setting('advancedban.username', 'advancedban'),
                'password' => setting('advancedban.password'),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
                'strict' => false,
            ]);
        }

        $query = $request->input('q');

        $punishmentHistory = DB::connection('advancedban')
            ->table(setting('advancedban.historyTable', 'PunishmentHistory'))
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('reason', 'LIKE', "%{$query}%")
            ->orWhere('operator', 'LIKE', "%{$query}%")
            ->orWhere('punishmentType', 'LIKE', "%{$query}%")
            ->orderByDesc('start')
            ->get();
        $allPunishments = $punishmentHistory->merge($punishments)->unique();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = setting('advancedban.perPage', 10);

        $currentItems = $allPunishments->slice(
            $perPage * ($currentPage - 1),
            $perPage
        );
        $paginator = new LengthAwarePaginator(
            $currentItems,
            count($allPunishments),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('advancedban::index', [
            'punishments' => $punishments,
            'punishmentHistory' => $punishmentHistory,
            'allPunishments' => $paginator,
        ]);
    }
}
