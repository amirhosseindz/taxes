<?php

namespace App\Http\Controllers;

use App\State;
use App\County;
use App\DataTables\CountyDataTable;
use App\Http\Requests\CountyFormRequest;

class CountyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CountyDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(CountyDataTable $dataTable)
    {
        $states = State::all();

        return $dataTable->render('counties', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CountyFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountyFormRequest $request)
    {
        $county = County::create($request->all());

        return response(['success' => (bool)$county]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param County $county
     * @return \Illuminate\Http\Response
     */
    public function edit(County $county)
    {
        return response($county->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CountyFormRequest $request
     * @param County $county
     * @return void
     * @throws \Throwable
     */
    public function update(CountyFormRequest $request, County $county)
    {
        $result = $county->update($request->validated());

        return response(['success' => (bool)$result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param County $county
     * @return void
     * @throws \Exception
     */
    public function destroy(County $county)
    {
        $result = $county->delete();

        return response(['success' => (bool)$result]);
    }
}
