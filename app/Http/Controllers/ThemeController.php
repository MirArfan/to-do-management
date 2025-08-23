<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function readCookie(Request $request)
    {
       $theme = $request->cookie('theme', 'light'); // default light
      return view('app', compact('theme'));
    }

    public function createAndUpdate(Request $request)
    {
         $theme = $request->input('theme', 'light'); // default light
            if(!in_array($theme, ['light', 'dark'])) {
                $theme = 'light';
            }

            $cookie = cookie('theme', $theme, 60*24*365); // 1 year

            return back()->withCookie($cookie);}
}
