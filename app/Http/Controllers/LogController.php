<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = [];
        if (Auth::user()->hasRole(config('desafio.role-admin'))) {
            $logs = Activity::all();
        }

        if (Auth::user()->hasRole(config('desafio.role-default')) ||
            Auth::user()->hasPermissionTo("Visualizar Histórico Todos")) {

            $owner = Auth::user()->from_guest;
            $id    = is_null($owner) ? Auth::id() : $owner->user_id;

            $guests = Guest::where('user_id', $id)->pluck('guest_id')->toArray();

            $guests[] = $id;
            $logs     = User::log($guests);
        }

        if (Auth::user()->hasRole(config('desafio.role-guest'))) {
            $logs = User::log([Auth::id()]);
        }
        $users = User::withTrashed()->get();
        return view('log.index', compact('logs', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
