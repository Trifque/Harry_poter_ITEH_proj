<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /* SVE ZA USER-A */

    /* GET-eri */

        public function getAllAdmins()
        {
            $admins = User::where('role', 'admin')->get();
            $admins = $admins->map(function ($admin) 
            {
                $admin['id'] = $admin['user_id'];
                $admin['bio'] = $admin['biography'];
                $admin['member_since'] = $admin['join_date'];
                unset($admin['user_id']);
                unset($admin['biography']);
                unset($admin['join_date']);
                return $admin;
            });
            
            if(is_null($admins)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($admins);
        }

        public function getAllRegularUsers()
        {
            $users = User::where('role', 'user')->get();
            $users = $users->map(function ($user) 
            {
                $user['id'] = $user['user_id'];
                $user['bio'] = $user['biography'];
                $user['member_since'] = $user['join_date'];
                unset($user['user_id']);
                unset($user['biography']);
                unset($user['join_date']);
                return $user;
            });
            
            if(is_null($users)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($users);
        }

        public function getUserById($user_id)
        {
            $users = User::where('user_id', $user_id)->get();

            $user = $users[0];
            $user['id'] = $user['user_id'];
            $user['bio'] = $user['biography'];
            $user['member_since'] = $user['join_date'];
            unset($user['user_id']);
            unset($user['biography']);
            unset($user['join_date']);
            
            if(is_null($user)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($user);
        }

        public function loginUser(Request $request)
        {
            $username = $request->input('username');
            $password = $request->input('password');
            $users = User::where('username', $username)->where('password',$password)->get();

            $user = $users[0];
            $user['id'] = $user['user_id'];
            $user['bio'] = $user['biography'];
            $user['member_since'] = $user['join_date'];
            unset($user['user_id']);
            unset($user['biography']);
            unset($user['join_date']);
            
            if(is_null($user)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($user);
        }

    /* POST-eri */

        public function createUser(Request $request)
        {
            $validatedData = $request->validate
            ([
                'username' => 'required|string',
                'password' => 'required|string',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'country' => 'required|string',
                'gender' => 'required|string',
                'house' => 'required|string',
                'role' => 'required|string',
                'email' => 'required|string',
                'birth_date' => 'required|date',
                'biography' => 'required|string',
            ]);

            $validatedData['join_date'] = date('Y-m-d');

            echo("Bilo sta bukvalno");

            $user = User::create($validatedData);

            return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
        }
}