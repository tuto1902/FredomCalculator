<?php

namespace Tests\Feature;

use App\Item;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FinancialGoalsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function it_can_display_monthly_yearly_and_financial_goal()
    {
        // Create Items
        DB::table('items')->insert([
            ['label' => 'Item 1', 'amount' => 100, 'goal_id' => 1],
            ['label' => 'Item 2', 'amount' => 100, 'goal_id' => 1],
            ['label' => 'Item 3', 'amount' => 100, 'goal_id' => 1]
        ]);

        // The monthly cost is the sum of all items on the goal
        $monthlyCost = Item::where('goal_id', 1)->sum('amount');

        // The yearly cost is just the monthly cost times 12
        $yearlyCost = $monthlyCost * 12;

        // To obtain the goal, multiply the yearly cost by the number of years you want the money to last
        // In this case we will assume 25 years after retirement
        $goal = $yearlyCost * 25;

        // Visit the home page and assert that you can see the monthly & yearly cost, as well as the goal
        $this->get('/')
            ->assertSee(number_format($monthlyCost))
            ->assertSee(number_format($yearlyCost))
            ->assertSee(number_format($goal));

    }

    /**
    * @test
    */
    public function it_can_display_goal_names ()
    {
        // Create goals
        DB::table('goals')->insert([
            ['name' => 'Goal 1'],
            ['name' => 'Goal 2'],
            ['name' => 'Goal 3'],
        ]);

        $this->get('/')
            ->assertSee('Goal 1')
            ->assertSee('Goal 2')
            ->assertSee('Goal 3');
    }
}
