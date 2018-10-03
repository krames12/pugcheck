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
        $logs = Lookups::apiLogs($character->name, $realm, $region);
        dd($logs);
        $class_name = Lookups::classLookup($character->class);
        // Returns array, but there is only one raid instance we care about.
        $progression = array_where($character->progression->raids, function($value, $key) {
            return $value->name == "Uldir";
        });
        $progression = array_pop($progression);

        $formattedProgression = new \stdClass();
        $formattedProgression->name = $progression->name;
        $formattedProgression->total_bosses = count($progression->bosses);
        $formattedProgression->difficulty = 2;
        $formattedProgression->highestDifficulty = "Looking For Raid";
        $formattedProgression->lfrProgress = $this->difficultyProgress('lfr', $progression->bosses);
        $formattedProgression->normalProgress = $this->difficultyProgress('normal', $progression->bosses);
        $formattedProgression->heroicProgress = $this->difficultyProgress('heroic', $progression->bosses);
        $formattedProgression->mythicProgress = $this->difficultyProgress('mythic', $progression->bosses);
        $formattedProgression->bosses = $progression->bosses;

        foreach($progression->bosses as $boss) {
            if($boss->mythicKills > 0) {
                $formattedProgression->difficulty = 5;
                $formattedProgression->highestDifficulty = 'Mythic';
            } else if($boss->heroicKills > 0 && $formattedProgression->difficulty < 4) {
                $formattedProgression->difficulty = 4;
                $formattedProgression->highestDifficulty = 'Heroic';
            } else if($boss->normalKills > 0 && $formattedProgression->difficulty < 3) {
                $formattedProgression->difficulty = 3;
                $formattedProgression->highestDifficulty = 'Normal';
            }
        }

        $progression = $formattedProgression;

        $difficulties = array();
        switch($progression->highestDifficulty) {
            case("Mythic"):
                $difficulties = ['Mythic', 'Heroic'];
                break;
            case("Heroic"):
                $difficulties = ['Heroic', 'Normal'];
                break;
            case("Normal"):
                $difficulties = ['Normal', 'Looking For Raid'];
                break;
            case("Looking For Raid"):
                $difficulties = ['Looking For Raid'];
                break;
        }

        return view('character', compact(['realms', 'character', 'class_name', 'progression', 'difficulties']));
    }

    private function difficultyProgress($difficulty, $bossData) {
        $killSearch = $difficulty.'Kills';
        $progress = 0;
        foreach($bossData as $boss) {
            if($boss->$killSearch > 0) {
                $progress+= 1;
            }
        }
        return $progress;
    }
}
