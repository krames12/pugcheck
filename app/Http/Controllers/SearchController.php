<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Realm;

class SearchController extends Controller
{
    //

    public function search($region, $realm, $character)
    {
        $realms = Realm::all();

        return view('character', compact(['realms']));
    }
}
