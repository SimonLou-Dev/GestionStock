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

    public function add(){
        return view('Category.add');
    }
    public function remove(){
        $product = ItemsModel::get();
        return view('Category.remove', ['products'=> $product]);
    }

    public function additem($id, $space){
        $item = ItemsModel::find($id);
        $space == 1 ? ($item->home_items += 1) : $item->depot_items += 1;
        $item->save();
        $product = ItemsModel::get();
        return redirect()->route('index', ['products'=> $product]);
    }

    public function removeitem($id,$space){
        $item = ItemsModel::find($id);

        if($space == 0 & $item->depot_items > 0){
            $item->depot_items -= 1;
        }

        if($space == 1 & $item->home_items > 0){
            $item->home_items -= 1;
        }

        $item->save();

        $product = ItemsModel::get();
        return redirect()->route('index', ['products'=> $product]);
    }
}
