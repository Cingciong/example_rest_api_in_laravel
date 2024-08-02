<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{
    public function getUserByUsername(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    public function updateUserByUsername(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'firstName' => 'string|nullable',
                'lastName' => 'string|nullable',
                'email' => 'email|nullable',
                'password' => 'string|nullable',
                'phone' => 'string|nullable',

            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (isset($request->firstName)) {
            $user->firstName = $request->firstName;
        }
        if (isset($request->lastName)) {
            $user->lastName = $request->lastName;
        }
        if (isset($request->email)) {
            $user->email = $request->email;
        }
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        if (isset($request->phone)) {
            $user->phone = $request->phone;
        }

        $user->save();

        return response()->json($user, 200);
    }
    public function  deleteUserByUsername(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }

    public function createUserWithList(Request $request)
    {

        $users = unserialize($request->input('users'));

        foreach ($users as $user) {
            $validator = Validator::make($user, [
                'username' => 'required|string|unique:users,username',
                'email' => 'email|unique:users,email',
                'phone' => 'string|unique:users,phone',
                'firstName' => 'string',
                'lastName' => 'string',
                'password' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 422);
            }

            $newUser = new User;
            $newUser->username = $user['username'];
            $newUser->firstName = $user['firstName'];
            $newUser->lastName = $user['lastName'];
            $newUser->email = $user['email'];
            $newUser->password = bcrypt($user['password']);
            $newUser->phone = $user['phone'];
            $newUser->save();
        }

        return response()->json(['message' => 'Users created'], 200);
    }

    public function createUser(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|unique:users,username',
                'email' => 'email|unique:users,email',
                'phone' => 'string|unique:users,phone',
                'firstName' => 'string',
                'lastName' => 'string',
                'password' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 422);
            }

            $newUser = new User;
            $newUser->username = $request->username;
            $newUser->firstName = $request->firstName;
            $newUser->lastName = $request->lastName;
            $newUser->email = $request->email;
            $newUser->password = bcrypt($request->password);
            $newUser->phone = $request->phone;
            $newUser->save();

            return response()->json(['message' => 'User created'], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }
    }
}
