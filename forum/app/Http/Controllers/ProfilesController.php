<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class ProfilesController extends Controller
{
    public function show(\App\User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => \App\Activity::feed($user)
        ]);
    }
}
