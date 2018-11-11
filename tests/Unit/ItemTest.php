<?php

namespace Tests\Unit;

use App\Item;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function it_has_a_goal()
    {
        // Create Items
        DB::table('items')->insert([
            ['label' => 'Item 1', 'amount' => 100, 'goal_id' => 1],
            ['label' => 'Item 2', 'amount' => 100, 'goal_id' => 1],
            ['label' => 'Item 3', 'amount' => 100, 'goal_id' => 1]
        ]);

        $goal = (Item::where('goal_id', 1)->sum('amount') * 12) * 25;
        $this->assertEquals($goal, Item::goal(1));
    }

    /**
     * @test
     */
    public function it_has_a_monthly_cost()
    {
        // Create Items
        DB::table('items')->insert([
            ['label' => 'Item 1', 'amount' => 100, 'goal_id' => 1],
            ['label' => 'Item 2', 'amount' => 100, 'goal_id' => 1],
            ['label' => 'Item 3', 'amount' => 100, 'goal_id' => 1]
        ]);

        $monthly = (Item::where('goal_id', 1)->sum('amount'));
        $this->assertEquals($monthly, Item::monthly(1));
    }

    /**
     * @test
     */
    public function it_has_a_yearly_cost()
    {
        // Create Items
        DB::table('items')->insert([
            ['label' => 'Item 1', 'amount' => 100, 'goal_id' => 1],
            ['label' => 'Item 2', 'amount' => 100, 'goal_id' => 1],
            ['label' => 'Item 3', 'amount' => 100, 'goal_id' => 1]
        ]);

        $monthly = (Item::where('goal_id', 1)->sum('amount') * 12);
        $this->assertEquals($monthly, Item::yearly(1));
    }
}
