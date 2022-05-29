<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminCred;
class AdminController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $encryptedPassword = Hash::make($request['password']);

        $admin = AdminCred::create([
            'username' => $request['username'],
            'password' => $encryptedPassword
        ]);

        return response($admin, 200);
    }
}
