<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cliente-listar', ['only' => ['index', 'show']]);
        $this->middleware('permission:cliente-criar', ['only' => ['create', 'store']]);
        $this->middleware('permission:cliente-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cliente-deletar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::where('user_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        $client          = new Client();
        $client->user_id = auth()->user()->id;
        $client->name    = $request->get('name');
        $client->email   = $request->get('email');
        $client->save();

        if ($request->filled('phones')) {

            foreach ($request->get('phones') as $phone)
                $phones[] = ['phone' => $phone];

            $client->phone()->createMany($phones);
        }
        return redirect()->route('client.index')
            ->with('message', 'Cliente adicionado com sucesso.');
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
        $client = Client::findOrFail($id);

        $this->authorize('permission', $client);

        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        $client        = Client::findOrFail($id);
        $client->name  = $request->get('name');
        $client->email = $request->get('email');

        $this->authorize('permission', $client);

        $client->save();

        $phones_front = $request->get('phones') ?? [];
        $phones_db    = $client->phone()->get();

        foreach ($phones_db as $phone) {
            if (!array_key_exists($phone->id, $phones_front))
                $phone->delete();
        }

        foreach ($phones_front as $id => $phone) {
            if ($phones_db->find($id)) {
                $phones_db->find($id)->phone = $phone;
                $phones_db->find($id)->save();
            } else {
                $client->phone()->create(['phone' => $phone]);
            }
        }

        return redirect()->route('client.index')
            ->with('message', 'Cliente editado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        $this->authorize('permission', $client);

        $client->delete();
        return redirect()->route('client.index')
            ->with('message', 'Cliente deletado com sucesso.');
    }
}
