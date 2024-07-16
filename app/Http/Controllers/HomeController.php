<?php

namespace App\Http\Controllers;

use App\Siswa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $siswa = Siswa::orderBy('named', 'asc')->get();
        // return dd($siswa);
        return view('home', compact('siswa'));
    }

   
}
