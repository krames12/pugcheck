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
        $realms = Realm::orderBy('slug')->get();

        $character = Lookups::apiCharacter(htmlspecialchars($character), $realm, $region);
        if(!isset($character->name)) {
            return redirect()->to('/')->with('error', $character);
        }
        $logs = Lookups::apiLogs(htmlspecialchars($character->name), $realm, $region);
        $class_name = Lookups::classLookup($character->class);
        // Returns array, but there is only one raid instance we care about.
        $currentRaids = array_where($character->progression->raids, function($value, $key) {
            return $value->name == "Uldir" || $value->name == "Battle of Dazar'alor";
        });

        $progression = array();
        foreach($currentRaids as $raid) {
            $formattedProgression = new \stdClass();
            $formattedProgression->name = $raid->name;
            $formattedProgression->total_bosses = count($raid->bosses);
            $formattedProgression->difficulty = 2;
            $formattedProgression->highestDifficulty = "Looking For Raid";
            $formattedProgression->lfrProgress = $this->difficultyProgress('lfr', $raid->bosses);
            $formattedProgression->normalProgress = $this->difficultyProgress('normal', $raid->bosses);
            $formattedProgression->heroicProgress = $this->difficultyProgress('heroic', $raid->bosses);
            $formattedProgression->mythicProgress = $this->difficultyProgress('mythic', $raid->bosses);
            $formattedProgression->bosses = $raid->bosses;

            foreach ($raid->bosses as $boss) {
                if ($boss->mythicKills > 0) {
                    $formattedProgression->difficulty = 5;
                    $formattedProgression->highestDifficulty = 'Mythic';
                } else if ($boss->heroicKills > 0 && $formattedProgression->difficulty < 4) {
                    $formattedProgression->difficulty = 4;
                    $formattedProgression->highestDifficulty = 'Heroic';
                } else if ($boss->normalKills > 0 && $formattedProgression->difficulty < 3) {
                    $formattedProgression->difficulty = 3;
                    $formattedProgression->highestDifficulty = 'Normal';
                }

                foreach ($logs as $log) {
                    if ($boss->name == $log->encounterName) {
                        if ($log->difficulty == 5) {
                            $boss->mythicLogUrl = "https://www.warcraftlogs.com/reports/$log->reportID#fight=$log->fightID";
                        }
                        if ($log->difficulty == 4) {
                            $boss->heroicLogUrl = "https://www.warcraftlogs.com/reports/$log->reportID#fight=$log->fightID";
                        }
                        if ($log->difficulty == 3) {
                            $boss->normalLogUrl = "https://www.warcraftlogs.com/reports/$log->reportID#fight=$log->fightID";
                        }
                        if ($log->difficulty == 2) {
                            $boss->lfrLogUrl = "https://www.warcraftlogs.com/reports/$log->reportID#fight=$log->fightID";
                        }
                    }
                }
            }

            switch($formattedProgression->highestDifficulty) {
                case("Mythic"):
                    $formattedProgression->difficulties = ['Mythic', 'Heroic'];
                    break;
                case("Heroic"):
                    $formattedProgression->difficulties = ['Heroic', 'Normal'];
                    break;
                case("Normal"):
                    $formattedProgression->difficulties = ['Normal', 'Looking For Raid'];
                    break;
                case("Looking For Raid"):
                    $formattedProgression->difficulties = ['Looking For Raid'];
                    break;
            }
            $progression[] = $formattedProgression;
        }

        $progression = array_reverse($progression);

        return view('character', compact(['realms', 'character', 'class_name', 'progression']));
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
