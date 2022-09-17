<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function userInfo()
    {
        $user = User::with('role')->where('id', Auth::id())->first();
        return response()->json($user);
    }

    public function login(Request $request)
    {
        $data = [
            'email' =>  $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($data)) {
            $token = auth()->user()->createToken('myapp')->plainTextToken;

            return response()->json(['message' => 'Success', 'user' => $request->email, 'token' => $token]);
        } else {
            return response()->json(['message' => 'Login Fail']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json('Logut');
    }

    public function register(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        $patient = Patients::create([
            'user_id' => $user->id
        ]);


        return response()->json(['message' => 'Success', 'user' => $user]);
    }

    public function userUpdate(Request $request)
    {

        User::where('id', Auth::id())->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        $user = User::where('id', Auth::id())->first();
        return response()->json($user);
    }

    public function userPass(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        $userPass = $user->password;

        $pass = $request->old_pass;

        if (Hash::check($pass, $userPass)) {

            $user->update([
                'password' => Hash::make($request->new_pass)
            ]);

            return response()->json(['msg' => 'Updated']);
        } else {
            return response()->json(['msg' => 'Fail']);
        }
    }
}
