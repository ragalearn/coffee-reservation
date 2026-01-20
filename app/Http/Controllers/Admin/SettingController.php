<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        // 🔥 PAKSA CHECKBOX JADI 0 JIKA TIDAK DICENTANG
        if (!array_key_exists('auto_confirm_reservation', $data)) {
            $data['auto_confirm_reservation'] = 0;
        }

        foreach ($data as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Settings updated successfully');
    }
}
