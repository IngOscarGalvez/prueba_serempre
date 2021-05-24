<?php

namespace App\Http\Controllers\api;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\EloquentVueTables;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = City::query();
        $tablePaginate = new EloquentVueTables();
        return $tablePaginate->get($query, ['id', 'name']);
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
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        $city = new City();
        if ($validator->passes()) {
            $city->fill($validator->validated());
            $city->save();
            return response()->json(['messages' => "La Ciudad se guardó correctamente", 'success' => true], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::find($id);
        if ($city) {
            return  $city;
        } else {
            return response()->json(['errors' => 'No se encontro la Ciudad!', 'success' => false], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        if ($validator->passes()) {
            $name = $request->name;
            $city = City::find($id);

            if ($city) {
                $city->name = $name;
                $city->save();
                return response()->json(['messages' => "la Ciudad se actualizó correctamente", 'success' => true], 201);
            } else {
                return response()->json(['messages' => "No se encuentra la Ciudad", 'success' => true], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);

        if (!$city) {
            return response()->json(['errors' => 'No se encuentra la Ciudad', 'success' => false], 422);
        } else {
            $city = City::destroy($id);
            return response()->json(['messages' => "La Ciudad se Eliminó correctamente", 'success' => true], 200);
        }
    }

    public function listCities()
    {
        $cities = City::all();
        $response = [];
        array_push($response, [
            'value' => 0,
            'text' => 'Seleccione una Ciudad'
        ]);
        if (count($cities)) {
            foreach ($cities as $city) {
                array_push($response, [
                    'value' => $city->id,
                    'text' => $city->name
                ]);
            }
        }
        return $response;
    }
}
