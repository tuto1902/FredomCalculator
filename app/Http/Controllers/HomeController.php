<?php

namespace App\Http\Controllers;

use App\Goal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $goals = Goal::all();

        // Investment value over time
        $interest_rate = request()->has('interest_rate') ? request('interest_rate') / 100 : 0.06;
        $monthly_investment = request()->has('monthly_investment') ? request('monthly_investment') : 100;
        $plot_data = [];

        for ($i = 1; $i <= 50; $i++) {
            $investment_value = pow((1 + $interest_rate), $i) + ($monthly_investment * ( ( pow(1 + ($interest_rate/12), $i * 12 ) - 1) / ( $interest_rate / 12 )));
            $plot_data[] = [$i, $investment_value];
        }

        return view('home.index', [
            'goals' => $goals,
            'interest_rate' => $interest_rate,
            'monthly_investment' => $monthly_investment,
            'plot_data' => $plot_data
        ]);
    }
}
