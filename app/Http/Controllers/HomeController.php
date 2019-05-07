<?php

namespace App\Http\Controllers;

use App\County;
use App\State;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $states = State::with('counties')->get();
        $countryAvgTaxRate = County::all()->avg('tax_rate');

        $countryCollectedOverallTaxes = 0;
        foreach ($states as $state) {
            $countryCollectedOverallTaxes += $state->counties->sum('collected_taxes');
        }

        return view('home', compact('states', 'countryAvgTaxRate', 'countryCollectedOverallTaxes'));
    }
}
