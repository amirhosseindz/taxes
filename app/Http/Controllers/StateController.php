<?php

namespace App\Http\Controllers;

use App\State;
use App\Http\Requests\StateFormRequest;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();

        return view('states', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StateFormRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(StateFormRequest $request)
    {
        $state = State::create($request->all());

        return response([
            'success' => (bool)$state,
            'tr' => view('partials.state-tr', compact('state'))->render()
        ]);
    }

    public function tr(State $state)
    {
        return view('partials.state-tr', compact('state'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param State $state
     * @return void
     */
    public function edit(State $state)
    {
        return response($state->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StateFormRequest $request
     * @param State $state
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(StateFormRequest $request, State $state)
    {
        $this->ajaxValidate($request, [
            'name' => 'required|string|max:191'
        ]);

        $result = $state->update(['name' => $request->input('name')]);

        return response([
            'success' => (bool)$result,
            'tr' => view('partials.state-tr', compact('state'))->render()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param State $state
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(State $state)
    {
        $result = $state->delete();

        return response(['success' => (bool)$result]);
    }
}
