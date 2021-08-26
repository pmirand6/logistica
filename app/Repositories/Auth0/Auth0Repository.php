<?php
/**
 * Class Auth0Repository
 * @package App\Repositories
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 12/12/20 23:54
 */

namespace App\Repositories\Auth0;

use App\Models\Auth0Tokens\Auth0Tokens;
use Auth0\SDK\Auth0;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Auth0Repository implements Auth0RepositoryInterface
{


    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getUserInfo($jwtToken): string
    {
        try {
            return $this->client->request(
                'GET',
                'https://feriame.us.auth0.com/userinfo',
                ['headers' =>
                    [
                        'Authorization' => "Bearer {$jwtToken}"
                    ]
                ]
            )->getBody()->getContents();
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }

    public function getRolesAuth0($rolName): string
    {
        try {
            $jwtToken = $this->getToken();

            return $this->client->request(
                'GET',
                env('AUTH0_ADMIN_AUD') . "roles?name_filter={$rolName}",
                ['headers' =>
                    [
                        'Authorization' => "Bearer {$jwtToken->access_token}"
                    ]
                ]
            )->getBody()->getContents();
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getToken()
    {
        $clientId = env('AUTH0_CLIENT_ID');
        $clientSecret = env('AUTH0_CLIENT_SECRET');
        $auth0Domain = env('AUTH0_DOMAIN');

        $accessToken = Auth0Tokens::where('client_id', env('AUTH0_CLIENT_ID'))->first('access_token');

        if (!$accessToken) {
            $response = $this->client->request(
                'POST',
                env('AUTH0_DOMAIN') . "oauth/token",
                [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ],
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => env('AUTH0_CLIENT_ID'),
                        'client_secret' => env('AUTH0_CLIENT_SECRET'),
                        'audience' => env('AUTH0_ADMIN_AUD')
                    ]
                ]
            )->getBody()->getContents();

            $responseArray = json_decode($response);


            Auth0Tokens::create([
                'client_id' => env('AUTH0_CLIENT_ID'),
                'access_token' => $responseArray->access_token
            ]);

            return response()->json(
                ['access_token' => $responseArray->access_token]
            );
        }

        return $accessToken;
    }

    /**
     * @param $userSub
     * @param $rolId
     * @return mixed
     */
    public function assignRole($userSub, $rolId)
    {
        try {
            $jwtToken = $this->getToken();

            $guzzle = new Client(['base_uri' => env('AUTH0_ADMIN_AUD')]);
            return $guzzle->post("users/{$userSub}/roles",
                [
                    'headers' => [
                        'Authorization' => "Bearer {$jwtToken->access_token}"
                    ],
                    'json' => ['roles' => [
                        $rolId
                    ]]
                ]
            )->getBody()->getContents();

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        } catch (GuzzleException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }

    }
}
