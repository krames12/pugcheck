<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Realm;

class HomeController extends Controller
{
    // Home page
    public function show()
    {
        $realms = Realm::orderBy('slug')->get();
        return view('index', compact(['realms']));
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
