<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getAll(){
        $payments = Payment::all();

        return response()->json($payments);
    }
    
    public function add(Request $request){
        $payments = Payment::create($request->all());

        return response()->json($payments);
    }
    public function detail($id){
        $payments = Payment::find($id);

        return response()->json($payments);
    }
    public function edit(Request $request,$id){
        $payments = Payment::where('id',$id)->update($request->all());

        return response()->json($payments);
    }
    
    public function remove($id){
        $payments = Payment::where('id',$id)->delete();

        return response()->json($payments);
    }
}
