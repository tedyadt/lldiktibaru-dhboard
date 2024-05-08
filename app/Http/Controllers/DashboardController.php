<?php

namespace App\Http\Controllers;
use App\Http\Controllers\UserController;
use App\Models\User;

use Illuminate\Http\Request;    

class DashboardController extends Controller
{   
    public function index(){        
        $total_users = User::count();
        
        return view('dashboard.index', compact('total_users'));     
        
    }

    
}
