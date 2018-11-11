<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FinancialItemsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function it_can_create_financial_items_in_bulk()
    {
        $this->post('/items', [
            'items' => [
                ['label' => 'Item 1', 'amount' => 100, 'goal_id' => 1],
                ['label' => 'Item 2', 'amount' => 100, 'goal_id' => 2],
                ['label' => 'Item 3', 'amount' => 100, 'goal_id' => 3],
            ]
        ]);

        $this->assertDatabaseHas('items', ['label' => 'Item 1', 'amount' => 100, 'goal_id' => 1]);
        $this->assertDatabaseHas('items', ['label' => 'Item 2', 'amount' => 100, 'goal_id' => 2]);
        $this->assertDatabaseHas('items', ['label' => 'Item 3', 'amount' => 100, 'goal_id' => 3]);
    }
}
