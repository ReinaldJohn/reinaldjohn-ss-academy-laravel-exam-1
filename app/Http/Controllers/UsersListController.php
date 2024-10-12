<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersListController extends Controller
{
    public function index() {
        $allUsers = User::all();
        return view('users.index', [
            'users' => $allUsers
        ]);
    }

    public function fetchUser() {
        $user = User::inRandomOrder()->first();
        return view('user.index', [
            'user' => $user
        ]);
    }
}
