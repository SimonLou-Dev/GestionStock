<?php

namespace App\Http\Controllers;

use App\Models\ItemsModel;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = ItemsModel::get();
        return view('index', ['products'=> $product]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new ItemsModel();
        $item->item_name = $request->input('product');
        $item->save();
        $product = ItemsModel::get();
        return redirect()->route('index', ['products'=> $product]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = (integer) $request->input('delet');
        $item = ItemsModel::find($id);
        $item->delete();
        $product = ItemsModel::get();
        return redirect()->route('index', ['products'=> $product]);
    }

    public function add()
    {
        return view('Category.add');
    }
    public function remove()
    {
        $product = ItemsModel::get();
        return view('Category.remove', ['products'=> $product]);
    }

    public  function updateItem(Request $request){


        $validated = $request->validate([
            "home_items"=> ["numeric", "min:0"],
            "depot_items"=> ["numeric", "min:0"],
            "id_item" => "numeric"
        ]);

        $product = ItemsModel::where('id', $validated["id_item"])->first();
        $product->home_items = $validated["home_items"];
        $product->depot_items = $validated["depot_items"];
        $product->save();

        return redirect()->back();
    }
}
