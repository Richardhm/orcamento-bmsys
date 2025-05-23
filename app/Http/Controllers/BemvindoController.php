<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BemvindoController extends Controller
{
    public function index($userId)
    {
        $user = User::findOrFail($userId);
        return view('bemvindo', compact('user'));
    }

    public function pix($user)
    {
        $user = User::findOrFail($user);
    }

}
