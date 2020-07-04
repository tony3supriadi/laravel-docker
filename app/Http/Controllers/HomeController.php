<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array(
            'title' => 'Dashboard',
            'actived' => 'dashboard',
            'navigate' => ''
        );
        return view('home', $data);
    }
}
