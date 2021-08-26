<?php


namespace App\Repositories\Admin;


use App\Models\Admins\Admins;
use App\Models\User\User;
use App\Resources\Admin\AdminCollection;
use App\Resources\User\UserResource;

class AdminRepository implements AdminRepositoryInterface
{


    public function index()
    {
        return AdminCollection::collection(Admins::paginate(5));
    }

    public function show($field, $request)
    {
        return Admins::where($field, $request);
    }

    public function store($request)
    {
        try {
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->e_mail,
                'userType' => 'Administrador',
                'active' => 1
            ]);

            $admin = new Admins();
            $admin->active = $request->active;
            $admin->user_id = $user->id;

            $admin->save();

            $user->admin()->save($admin);

            return new UserResource($user);
        } catch (\Exception $e){
            return response()->json([
               'error' => true,
               'message' => $e->getMessage()
            ]);
        }


    }

    public function update($request)
    {
        // TODO: Implement update() method.
    }
}
