<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['status' => true ,'data'=>$users]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json(['status' => true ,'data'=>$user]);

    }
    public function store(Request $request)
    {
       $validator = validator($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:6',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
       if($validator->fails()){
           return response()->json($validator->errors()->toJson(),400);
       }
        $profileImagePath = null;
        if ($request->hasFile('image')) {
            $profileImagePath = $request->file('image')->store('profiles', 'public');
        }


       $user = User::create([
           'name' => $request->get('name'),
           'email' => $request->get('email'),
           'password' => Hash::make($request->get('password')),
           'image' => $profileImagePath
       ]);
       return response()->json(['status' => true ,'data'=>$user],201);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = validator($request->all(),[
            'name'=>'sometimes|string',
            'email'=>'sometimes|email|unique:users,email,'.$id,
            'password'=>'sometimes|string|min:6',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $data = $request->only('name','email','password');
        $profileImagePath = null;
        if ($request->hasFile('image_url')) {
            $profileImagePath = $request->file('image_url')->store('profiles', 'public');
        }
        $data['image'] = $profileImagePath;

        $user->update($data);
        $user->refresh();
        return response()->json(['status' => true ,'data'=>$user],201);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['status' => true ,'message'=>'deleted successfully']);
    }
}
