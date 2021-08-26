<?php

namespace App\Http\Middleware;

use App\Repositories\Auth0\Auth0RepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Auth0\SDK\Exception\ApiException;
use Auth0\SDK\Exception\CoreException;
use Closure;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\TokenVerifier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class Auth0Middleware
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var Auth0RepositoryInterface
     */
    private $auth0Repository;
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(UserRepositoryInterface $userRepository, Auth0RepositoryInterface $auth0Repository)
    {
        $this->userRepository = $userRepository;
        $this->auth0Repository = $auth0Repository;
    }

    /**
     * Run the request filter.
     *
     * @param Request $request
     * @param Closure $next
     * @param null $scopeRequired
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $scopeRequired = null)
    {
        $token = $request->bearerToken();



        try {
            //Validacion de token no especificado
            if (!$token) {
                throw new Exception('Sin Token en Header Authorization');
            }
            try {
                $decodedToken = $this->validateAndDecode($token);
            } catch (Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => 'ERROR_TOKEN'
                ], 403);
            }

            Log::info(json_encode([
                'method' => __METHOD__,
                'token_decoded' => $decodedToken
            ]));


            //Obtengo la información del Usuario en Auth0 a través del token
            $userData = $this->userRepository->getAuth0($token, $decodedToken);
            $userAuth0 = json_decode($userData);

            if ($scopeRequired && !$this->tokenHasScope($decodedToken, $scopeRequired)) {
                throw new Exception('Insufficient scope');
            }

            $request->merge(array("userAuth0" => $userAuth0, "permissions" => $decodedToken['permissions']));

            return $next($request);
        } catch (Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'ERROR_TOKEN'
            ],403);
        }


    }

    public function validateAndDecode($token): array
    {
        try {
            $jwksUri = env('AUTH0_DOMAIN') . '.well-known/jwks.json';

            $jwksFetcher = new JWKFetcher(null, ['base_uri' => $jwksUri]);
            $signatureVerifier = new AsymmetricVerifier($jwksFetcher);
            $tokenVerifier = new TokenVerifier(env('AUTH0_DOMAIN'), env('AUTH0_AUD'), $signatureVerifier);

            return $tokenVerifier->verify($token);
        } catch (InvalidTokenException $e) {
            throw $e;
        }
    }

    /**
     * Check if a token has a specific scope.
     *
     * @param array $token - JWT access token to check.
     * @param string $scopeRequired - Scope to check for.
     *
     * @return bool
     */
    protected function tokenHasScope($token, $scopeRequired)
    {
        if (empty($token['scope'])) {
            return false;
        }

        $items = $token['permissions'];

        return in_array($scopeRequired, $items);

    }

}
