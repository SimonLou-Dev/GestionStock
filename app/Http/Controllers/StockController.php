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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function additem($id){
        $item = ItemsModel::find($id);
        $item->number_of_items = $item->number_of_items +1;
        $item->save();
        $product = ItemsModel::get();
        return redirect()->route('index', ['products'=> $product]);
    }

    public function removeitem($id){
        $item = ItemsModel::find($id);
        if($item->number_of_items > 0){
            $item->number_of_items = $item->number_of_items-1;
            $item->save();
        }
        $product = ItemsModel::get();
        return redirect()->route('index', ['products'=> $product]);
    }
}
