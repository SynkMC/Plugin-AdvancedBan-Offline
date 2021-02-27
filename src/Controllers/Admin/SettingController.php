<?php

namespace Azuriom\Plugin\AdvancedBan\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the AdvancedBan settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('advancedban::admin.settings', [
            'host' => setting('advancedban.host', '127.0.0.1'),
            'port' => setting('advancedban.port', '3306'),
            'database' => setting('advancedban.database', 'advancedban'),
            'username' => setting('advancedban.username', 'advancedban'),
            'password' => setting('advancedban.password'),
            'perPage' => setting('advancedban.perPage', 10),
            'historyTable' => setting('advancedban.historyTable', 'PunishmentHistory'),
            'punishmentTable' => setting('advancedban.punishmentTable', 'Punishments'),
        ]);
    }

    public function save(Request $request)
    {
        $data = $this->validate($request, [
            'host' => ['required', 'string', 'max:255'],
            'port' => ['required', 'integer', 'between:1,65535'],
            'database' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'perPage' => ['required', 'integer', 'between:1,100'],
            'historyTable' => ['required', 'string', 'between:1,100'],
            'punishmentTable' => ['required', 'string', 'between:1,100'],
        ]);

        Setting::updateSettings([
            'advancedban.host' => $request->input('host'),
            'advancedban.port' => $request->input('port'),
            'advancedban.database' => $request->input('database'),
            'advancedban.username' => $request->input('username'),
            'advancedban.password' => $request->input('password'),
            'advancedban.perPage' => $request->input('perPage'),
            'advancedban.historyTable' => $request->input('historyTable'),
            'advancedban.punishmentTable' => $request->input('punishmentTable'),
        ]);

        return redirect()->route('advancedban.admin.settings')->with('success', trans('admin.settings.status.updated'));
    }
}
