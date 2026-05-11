<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginView(){
        return null;
    }

    public function DashboardView(){
        return view('AdminViews.dashboard');
    }
}