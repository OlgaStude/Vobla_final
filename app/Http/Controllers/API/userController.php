<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginReques;
use App\Http\Requests\registerRequest;
use App\Http\Requests\registrationRequest;
use App\Models\Categories;
use App\Models\User;
use App\Models\userInfo;
use App\Models\UsersCategories;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function register(registerRequest $req)
    {
        if($req->hasFile('avatar')){
            $req->file('avatar')->store('public/profile_pics');
            $pfp_name = $req->file('avatar')->hashName();
        }else{
            $pfp_name = 'default_avatar.png';
        }

        $user = User::create(['password' => Hash::make($req->password), 'login' => $req->login]);
        if($req->categories != []){
            
            foreach($req->categories as $category){
                $category_id = Categories::where('name', '=', $category)->get();
                UsersCategories::create(['users_id' => $user->id, 'categories_id' => $category_id[0]->id]);
            }
        }
        userInfo::create(['users_id' => $user->id, 'name' => $req->name, 'avatar' => $pfp_name, 'email' => $req->email]);

        if ($user) {
            Auth::login($user);
            $user_id = User::where("login", $user['login'])->get();
            return response()->json(['status' => 200, 'message' => 'user is registreted!', 'user_id' => $user_id[0]->id]);
        }

        return response()->json(['status' => 422, 'message' => 'user is failed to be registreted!']);
    }


    public function login(loginReques $req)
    {

        $user = [
            'login' => $req->login,
            'password' => $req->password
        ];

        if (Auth::attempt($user)) {
            $user_id = User::where("login", $user['login'])->get();
            return response()->json(['status' => 200, 'message' => 'user logged in', 'user_id' => $user_id[0]->id]);
        }

        return response()->json(['status' => 400, 'message' => 'Неверный логин или пароль']);
    }


     public function logout()
    {
        try {
            Auth::logout();
            return response()->json(['status' => 200, 'message' => 'user is logged out!']);
        } catch (QueryException $e) {
            return response()->json(['status' => 422, 'message' => $e]);
        }
    }
}
