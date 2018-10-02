<?php
/**
 * Created by PhpStorm.
 * User: nkramer
 * Date: 9/28/18
 * Time: 10:30 AM
 */

namespace App\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Lookups
{
    // Blizzard API character lookup
    public static function apiCharacter($characterName, $realmSlug, $region)
    {
        $requestUrl = "https://$region.api.battle.net/wow/character/$realmSlug/$characterName?fields=items,progression&locale=en_US&apikey=".env('BLIZZARD_KEY');
        $client = new Client();
        try {
            $res = $client->request('GET', $requestUrl);
            return json_decode($res->getBody());
        } catch (RequestException $e) {
            if($e->hasResponse()) {
                return back()->with('error', $e->getResponse()->getReasonPhrase());
            }
        }
    }

    // WarcraftLogs lookup
    public static function apiLogs($characterName, $realmSlug, $region)
    {

    }

    // Class lookup based on Blizzard class id
    public static function classLookup($classId)
    {
        switch($classId) {
            case 1:
                return 'warrior';
                break;
            case 2:
                return 'paladin';
                break;
            case 3:
                return 'hunter';
                break;
            case 4:
                return 'rogue';
                break;
            case 5:
                return 'priest';
                break;
            case 6:
                return 'death-knight';
                break;
            case 7:
                return 'shaman';
                break;
            case 8:
                return 'mage';
                break;
            case 9:
                return 'warlock';
                break;
            case 10:
                return 'monk';
                break;
            case 11:
                return 'druid';
                break;
            case 12:
                return 'demon-hunter';
                break;
        }
    }

    // Raid boss id's
    public static function bossLookup($boss)
    {
        switch($boss)
        {
            case "Taloc":
                return 2144;
                break;
            case 'MOTHER':
                return 2141;
                break;
            case "Fetid Devourer":
                return 2128;
                break;
            case "Zek'voz, Herald of N'zoth":
                return 2136;
                break;
            case "Vectis":
                return 2134;
                break;
            case "Zul, Reborn":
                return 2145;
                break;
            case "Mythrax the Unraveler":
                return 2135;
                break;
            case "G'huun":
                return 2122;
                break;
        }
    }
}