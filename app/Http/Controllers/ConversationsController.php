<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ConversationsController extends Controller
{
    public function index() {
        //we get all users except the current user
        $users = User::select('id', 'name')->where('id', '!=', Auth::user()->id)->get();
        
        return view('conversations/index', compact('users'));
    }
    
    public function show(int $id) {
        
    }
}
