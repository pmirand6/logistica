<?php
/**
 * Class UserController
 * @package App\Http\Controllers\Api
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 13/12/20 13:35
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->userRepository = $user;
    }

    public function show(Request $request)
    {
        $requestUser = $request->instance()->query('userAuth0') == null ? $request->userAuth0 : $request->instance()->query('userAuth0');
        $requestUserEmail = $request->instance()->query('userAuth0') == null ? $request->userAuth0->email : $requestUser[0]['email'];
        Log::info(json_encode([
            'request' => $request->all(),
            'requestUser' => $requestUser,
            'email' => $requestUserEmail
        ]));
        $user = $this->userRepository->getByEmail($requestUserEmail);
        return response()->json($user);
    }

}
