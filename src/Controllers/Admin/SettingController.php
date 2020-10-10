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
        ]);
    }

    public function save(Request $request)
    {
        Setting::updateSettings('advancedban.host', $this->validate($request, [
            'host' => ['required', 'string', 'max:255'],
        ])['host']);
        Setting::updateSettings('advancedban.port', $this->validate($request, [
            'port' => ['required', 'integer', 'between:1,65535'],
        ])['port']);
        Setting::updateSettings('advancedban.database', $this->validate($request, [
            'database' => ['required', 'string', 'max:255'],
        ])['database']);
        Setting::updateSettings('advancedban.username', $this->validate($request, [
            'username' => ['required', 'string', 'max:255'],
        ])['username']);
        Setting::updateSettings('advancedban.password', $this->validate($request, [
            'password' => ['required', 'string', 'max:255'],
        ])['password']);

        return redirect()->route('advancedban.admin.settings')->with('success', trans('admin.settings.status.updated'));
    }
}
