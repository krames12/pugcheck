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
        $request->validate([
            'region'    => 'required',
            'realm'     => 'required',
            'character' => 'required'
        ]);
        return redirect("/$request->region/$request->realm/$request->character");
    }
}
