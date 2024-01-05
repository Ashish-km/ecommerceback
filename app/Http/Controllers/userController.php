<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;


class userController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required',
            'name' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], status: 409);
        }
        $p = new User();
        $p->name = $request->name;
        $p->email = $request->email;
        $p->password = encrypt($request->password);
        $p->save();
        return response()->json(['message' =>"Sucessfully Registerd" ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required',


        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], status: 409);
        }
        $user = User::where('email', $request->email)->get()->first();
        $password = decrypt($request->password);

        if ($user && $password == $request->password) {
            return response()->json(['user' =>$user]);
        }
        else{
            return response()->json(['error' => ["opps! something   going wrong"]],status:409);
        }
    }
}
