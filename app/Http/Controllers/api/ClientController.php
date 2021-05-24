<?php

namespace App\Http\Controllers\api;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\EloquentVueTables;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::table('clients')
            ->join('cities', 'clients.city_id', '=', 'cities.id');


        $tablePaginate = new EloquentVueTables();
        return $tablePaginate->get($query, [
            'clients.name AS client_name',
            'cities.name AS city_name',
            'clients.id AS client_id',
            'cities.id AS city_id',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'city_id' => 'required|numeric|exists:App\City,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        $client = new Client();
        if ($validator->passes()) {
            $client->fill($validator->validated());
            $client->save();
            return response()->json(['messages' => "La Ciudad se guardó correctamente", 'success' => true], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::with('city')->find($id);
        if ($client) {
            return $client;
        } else {
            return response()->json(['errors' => 'No se encontro el Cliente!', 'success' => false], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $rules = [
            'name' => 'required',
            'city_id' => 'required|numeric|exists:App\City,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        if ($validator->passes()) {
            $name = $request->name;
            $city_id = $request->city_id;
            $client = Client::find($id);

            if ($client) {
                $client->name = $name;
                $client->city_id = $city_id;
                $client->save();
                return response()->json(['messages' => "El Cliente se actualizó correctamente", 'success' => true], 201);
            } else {
                return response()->json(['messages' => "No se encuentra el Cliente", 'success' => true], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['errors' => 'No se encuentra el Cliente', 'success' => false], 422);
        } else {
            $client = Client::destroy($id);
            return response()->json(['messages' => "El Cliente se Eliminó correctamente", 'success' => true], 200);
        }
    }
}
