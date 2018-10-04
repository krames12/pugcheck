<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Realm;
class RealmController extends Controller
{
    public function updateRealms() {
        $usRequestUrl = "https://us.api.battle.net/wow/realm/status?locale=en_US&apikey=".env('BLIZZARD_KEY');
        $client = new Client();
        try
        {
            $res = $client->request('GET', $usRequestUrl);
            $realms = json_decode($res->getBody());
            foreach($realms->realms as $realm)
            {
                $realmExists = Realm::where([['name', '=', $realm->name], ['slug', '=', $realm->slug], ['region', '=', 'us']])->first();
                if($realmExists === null) {
                    $newRealm = new Realm();
                    $newRealm->name = $realm->name;
                    $newRealm->slug = $realm->slug;
                    $newRealm->region = 'us';
                    $newRealm->save();
                }
            }
        }
        catch (RequestException $exception)
        {
            if($exception->hasResponse()) {
                echo Psr7\str($exception->getResponse());
            }
        }

        echo "US completed";

        $euRequestUrl = "https://eu.api.battle.net/wow/realm/status?locale=en_US&apikey=".env('BLIZZARD_KEY');
        $client = new Client();
        try
        {
            $res = $client->request('GET', $euRequestUrl);
            $realms = json_decode($res->getBody());
            foreach($realms->realms as $realm)
            {
                $realmExists = Realm::where([['name', '=', $realm->name], ['slug', '=', $realm->slug], ['region', '=', 'eu']])->first();
                if($realmExists === null) {
                    $newRealm = new Realm();
                    $newRealm->name = $realm->name;
                    $newRealm->slug = $realm->slug;
                    $newRealm->region = 'eu';
                    $newRealm->save();
                }
            }
        }
        catch (RequestException $exception)
        {
            if($exception->hasResponse()) {
                echo Psr7\str($exception->getResponse());
            }
        }

        echo "EU completed";
        return;
    }
}
