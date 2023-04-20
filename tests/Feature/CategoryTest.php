<?php

namespace Tests\Feature;

use App\Models\ItemsModel;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    private static function CreateItem($name): ItemsModel
    {
        $item = new ItemsModel();
        $item->item_name = $name;
        $item->depot_items = 2;
        $item->home_items = 2;
        $item->save();

        return ItemsModel::where('item_name', $name)->first();
    }


    public function testCreateCategorie()
    {
        $response = $this->postJson('/add/product/post', [
            'product' => 'test',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('items_models', [
            'item_name' => 'test',
        ]);
        ItemsModel::where('item_name', 'test')->delete();
    }

    public function testDeleteCategorie()
    {
        $items = self::createItem('test');
        $response = $this->postJson('/remove/product/', [
            'delet' => $items->id,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('items_models', [
            'item_name' => 'test',
        ]);
    }


    public function testModifyItem()
    {
        $items = self::createItem('test');
        $homeItems = rand(0, 40);
        $depotItems = rand(0, 40);

        $response = $this->postJson("/update/item", [
            "home_items" => $homeItems,
            "depot_items" => $depotItems,
             "id_item" => $items->id
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('items_models', [
            'item_name' => 'test',
            "id" => $items->id,
            'home_items' => $homeItems,
            'depot_items' => $depotItems
        ]);

        ItemsModel::where('item_name', 'test')->delete();

    }

}
