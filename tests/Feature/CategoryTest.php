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

    public function testAddItemHome()
    {
        $items = self::createItem('test');

        $response = $this->getJson('/add/item/'.$items->id.'/1');

        $response->assertStatus(302);
        $this->assertDatabaseHas('items_models', [
            'item_name' => 'test',
            'home_items' => 3,
        ]);
        ItemsModel::where('item_name', 'test')->delete();
    }

    public function testAddItemDepot()
    {
        $items = self::createItem('test');

        $response = $this->getJson('/add/item/'.$items->id.'/0');

        $response->assertStatus(302);
        $this->assertDatabaseHas('items_models', [
            'item_name' => 'test',
            'depot_items' => 3,
        ]);
        ItemsModel::where('item_name', 'test')->delete();
    }

    public function testRemoveItemHome()
    {
        $items = self::createItem('test');

        $response = $this->getJson('/remove/item/'.$items->id.'/1');

        $response->assertStatus(302);
        $this->assertDatabaseHas('items_models', [
            'item_name' => 'test',
            'home_items' => 1,
        ]);
        ItemsModel::where('item_name', 'test')->delete();
    }

    public function testRemoveItemDepot()
    {
        $items = self::createItem('test');

        $response = $this->getJson('/remove/item/'.$items->id.'/0');

        $response->assertStatus(302);
        $this->assertDatabaseHas('items_models', [
            'item_name' => 'test',
            'depot_items' => 1,
        ]);
        ItemsModel::where('item_name', 'test')->delete();
    }

}
