<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CEO;
use App\Http\Resources\CEOResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CEOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ceo=CEO::all();
        return response([ 'ceos' => CEOResource::collection($ceo), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator =Validator::make($data, [
            'name' => 'required|max:255',
            'year' => 'required|max:255',
            'company_headquarters' => 'required|max:255',
            'what_company_does' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $ceo = CEO::create($data);

        return response([ 'ceo' => new CEOResource($ceo), 'message' => 'Created successfully'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CEO  $cEO
     * @return \Illuminate\Http\Response
     */
    public function show(CEO $cEO)
    {
        return response([ 'ceo' => new CEOResource($cEO), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CEO  $cEO
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CEO $ceo)
    {
        $ceo->update($request->all());

        return response([ 'ceo' => new CEOResource($ceo), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CEO  $cEO
     * @return \Illuminate\Http\Response
     */
    public function destroy(CEO $cEO)
    {
        $cEO->delete();

        return response(['message' => 'Deleted']);
    }
}
