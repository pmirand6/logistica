<?php

namespace App\Http\Middleware;

use App\Repositories\Auth0\Auth0RepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
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

            if (!in_array('role:admin', $permissions)) {
                throw new \Exception('Usuario sin permisos');
            }

            //Verifico si existe en base
            $userData = ($this->userRepository->show('email', $userAuth0->email));


            if ($userData->isEmpty()) {
                throw new \Exception("Usuario con el email {$userAuth0->email} no encontrado");
            }

            $userSub = $userData[0]['sub'];
            if (!$userSub) {
                $params = collect([
                    'id' => $userData[0]['id'],
                    'sub' => $userAuth0->sub
                ]);
                $this->userRepository->updateSub($params);
            }

            //Si el token no tiene Scope me fijo si existe en la BD y le asigno un rol en base al perfil
            if (!$permissions) {

                //Verifico si existe en la base de datos
                $userResponse = json_decode($userData, true);
                $userType = $userResponse[0]['userType'];

                //Verifico si el usuario tiene Sub de Auth0
                //en el caso de que no tenerlo, se lo asigno
                $userSub = $userResponse[0]['sub'];
                if (!$userSub) {
                    $request = collect([
                        'id' => $userResponse[0]['id'],
                        'sub' => $userAuth0->sub
                    ]);
                    $this->userRepository->updateSub($request);
                }

                //Busco el ID del Rol en Base al nombre que me devuelve la búsqueda del usuario
                $rolResponse = $this->auth0Repository->getRolesAuth0($userType);
                $rol = json_decode($rolResponse, true);

                //Asigno el rol al usuario
                $this->auth0Repository->assignRole($userSub, $rol[0]['id']);

                throw new \Exception('Se asignaron permisos, debe loguearse nuevamente');
            }

            $request->merge(array("userData" => $userData));
            return $next($request);
        } catch (\Exception $e){
            Log::error(__class__ . " " . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => __class__ . " " . $e->getMessage()
            ], 403);
        }

    }
}
