<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function getAll(){
        $data=[];
        $patients = Patients::with('user');

        $data['data']=$patients->paginate(10);

        return response()->json($data);
    }

    public function add(Request $request){
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'role_id'=>2
        ]);

        $patient = Patients::create([
            'user_id'=>$user->id
        ]);

        return response()->json(['message'=>'Success','user'=>$user]);

    }

    public function detail($id){
        $patient = Patients::with('user')->where('id',$id)->first();

        return response()->json($patient);
    }
    
    public function edit(Request $request,$id){
        $patient = Patients::where('id',$id)->first();

        $user = User::where('id',$patient->user_id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'role_id'=>2
        ]);

        return response()->json(['message'=>'Success','user'=>$user]);
    }

    public function remove($id){
        $patient = Patients::where('id',$id)->first();
        $user = User::where('id',$patient->user_id)->delete();
        $patient->delete();

        return response()->json(['message'=>'Success']);
    }
}