<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
        $clientes = Client::where('user_id', auth()->user()->id);
        $total    = $clientes->count();
        $clientes = $clientes->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        return view('home.index', compact('clientes','total'));
    }
}
