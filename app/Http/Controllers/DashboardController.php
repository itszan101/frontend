<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (session()->exists('token')) {
            return view('dashboard'); // Redirect to a different route after login
        }
        return redirect(route('login'));
    }
}
