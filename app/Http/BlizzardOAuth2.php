<?php

namespace App\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;

class BlizzardOAuth2
{
    public function oAuthTokenGenerator()
    {
        $tokenClient = new Client([
           'base_uri' => "https://us.battle.net/oauth/token",
        ]);

        $tokenConfig = [
            'client_id' => env('BLIZZARD_CLIENTID'),
            'client_secret' => env('BLIZZARD_CLIENTSECRET'),
        ];

        $grantType = new ClientCredentials($tokenClient, $tokenConfig);
        $oauth = new OAuth2Middleware($grantType);
        $stack = HandlerStack::create();
        $stack->push($oauth);

        return $stack;
    }
}