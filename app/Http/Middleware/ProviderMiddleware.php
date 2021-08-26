<?php

namespace App\Http\Middleware;

use App\Repositories\Auth0\Auth0RepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;

class ProviderMiddleware
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var Auth0RepositoryInterface
     */
    private $auth0Repository;

    public function __construct(UserRepositoryInterface $userRepository, Auth0RepositoryInterface $auth0Repository)
    {
        $this->userRepository = $userRepository;
        $this->auth0Repository = $auth0Repository;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {

            $userAuth0 = $request->instance()->query('userAuth0') == null ? $request->userAuth0 : $request->instance()->query('userAuth0');
            $permissions = $request->instance()->query('permissions') == null ? $request->permissions : $request->instance()->query('permissions');

            Log::alert(json_encode([
                'method' => __METHOD__,
                'userAuth0' => $userAuth0,
                'permissions' => $permissions
            ]));

            if (in_array('role:provider', $permissions)) {
                $this->checkProviderUser($userAuth0);
                return $next($request);
            }

            throw new \Exception('Usuario sin permisos');

        } catch (\Exception $e) {
            Log::error(__class__ . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => __class__ . $e->getMessage()
            ], 403);
        }
    }

    /**
     * @param $userAuth0
     */
    private function checkProviderUser(stdClass $userAuth0)
    {
        //Verifico si existe en base
        $userData = ($this->userRepository->show('email', $userAuth0->email));
        if ($userData->isEmpty()) {
            $params = new stdClass();
            $params->email = $userAuth0->email;
            $params->name = $userAuth0->name;
            $params->sub = $userAuth0->sub;
            $params->userType = 'Proveedor';

            return $this->userRepository->create($params);
        }

        $userSub = $userData[0]['sub'];
        if (!$userSub) {
            $params = collect([
                'id' => $userData[0]['id'],
                'sub' => $userAuth0->sub
            ]);
            return $this->userRepository->updateSub($params);
        }
    }
}
