<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Lookups;
use App\Realm;

class SearchController extends Controller
{
    //

    public function search($region, $realm, $character)
    {
        $realms = Realm::all();
        $character = Lookups::apiCharacter($character, $realm, $region);
        $class_name = Lookups::classLookup($character->class);

        return view('character', compact(['realms', 'character', 'class_name']));
    }
}
