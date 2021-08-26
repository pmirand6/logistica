<?php
/**
 * Class UserRepository
 * @package App\Repositories\User
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 12/12/20 21:44
 */

namespace App\Repositories\User;


use App\Models\User\User;
use App\Resources\User\UserResource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;


class UserRepository implements UserRepositoryInterface
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return User::all();
    }

    /**
     * @param $field
     * @param $request
     * @return mixed
     */
    public function show($field, $request)
    {
        return User::where($field, $request)->get();
    }

    /**
     * @param $jwtToken
     * @return mixed
     * @throws GuzzleException
     */
    public function getAuth0($jwtToken, $decodedToken)
    {
        $user = $this->getBySub($decodedToken);

        if(!$user){
            try{
                $response = $this->client->request(
                    'GET',
                    'https://feriame.us.auth0.com/userinfo',
                    ['headers' =>
                        [
                            'Authorization' => "Bearer {$jwtToken}"
                        ]
                    ]
                )->getBody()->getContents();

                Log::error(json_encode([
                    'method' => __METHOD__,
                    'response' => $response
                ]));
                return $response;

            } catch (\Exception $e){
                Log::error(json_encode([
                    'method' => __METHOD__,
                    'error' => $e->getMessage()
                ]));
            }
        }

        return $user;
    }

    /**
     * @return mixed
     */


    /**
     * @param $userAuth
     * @param $roleId
     * @return mixed
     */
    public function assignRole($userAuth, $roleId)
    {
        // TODO: Implement assignRole() method.
    }

    /**
     * @param $rolName
     * @param $jwtToken
     * @return mixed
     */
    public function getRolesAuth0($rolName, $jwtToken)
    {
        // TODO: Implement getRolesAuth0() method.
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateSub($request)
    {
        try {
            $user = User::where('id', $request['id'])->firstOrFail();
            $user->sub = $request['sub'];
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function create($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->userType = $request->userType;
        $user->sub = $request->sub ? $request->sub : null;
        $user->active = 1;
        $user->save();

        return $user;
    }

    public function getByEmail($email)
    {
        $user = User::where('email', $email)->get();

        return UserResource::collection($user);
    }

    public function getBySub($token)
    {
        return User::where('sub', $token['sub'])->first();
    }
}
