<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;

class AdminController extends Controller
{
    public function index()
{
    return view('admin.index');
}

public function login(AdminRequest $request)
{
    $user = $request->only([
            'name','email', 'password'
        ]); 
    User::create($user);
  return view('admin.login');
}

}
