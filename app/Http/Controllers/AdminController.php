<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function loginView(){
        return null;
    }

    public function DashboardView(){
        return view('AdminViews.dashboard');
    }

    public function SettingsView(){
        return view('AdminViews.settings');
    }
}
