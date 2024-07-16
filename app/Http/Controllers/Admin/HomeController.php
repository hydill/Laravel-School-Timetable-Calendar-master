<?php

namespace App\Http\Controllers\Admin;

use App\Siswa;
use App\User;

class HomeController
{
    public function index()
    {
        $siswa = Siswa::orderBy('named', 'asc')->get();
        $user = User::orderBy('name', 'asc')->get();
        return view('home', compact('siswa', 'user'));
    }
}
