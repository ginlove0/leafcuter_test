<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('perPage') ?  $request->query('perPage') : 20;
        $query = $request->query('q') ? $request->query('q') : '';
        return User::with('userType')
            ->where('email', 'like', "%$query%")
            ->orWhere('name', 'like', "%$query%")
            ->paginate($perPage);
    }

    public function getAllUserType()
    {
        return UserType::all();
    }

    public function updateUserType( UserType $userType, User $user)
    {
        $user->user_type_id = $userType->id;
        $user->save();
    }

    public function updateUserAuthorization(User $user)
    {
        $user -> authorized = Carbon::now()->toDateTimeString();
        $user -> save();
    }
}
