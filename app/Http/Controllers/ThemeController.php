<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $current = $request->cookie('theme', 'light');
        $next = $current === 'dark' ? 'light' : 'dark';

        // Cookie valid for 1 year (minutes)
        cookie()->queue(cookie('theme', $next, 60 * 24 * 365));

        return back();
    }
}
