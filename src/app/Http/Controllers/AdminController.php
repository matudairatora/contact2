<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Models\Contact;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
{
   
        return view('auth.index');
}


}
