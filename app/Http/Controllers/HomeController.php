<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Home page
    public function show()
    {
        return view('index');
    }

    // Search
    public function search(Request $request)
    {
        redirect()->route('search', [
            'region'    => $request->region,
            'realm'     => $request->realm,
            'character' => $request->character
        ]);
    }
}
