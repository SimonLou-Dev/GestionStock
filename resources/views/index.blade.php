@extends('layouts.app')

@section('content')
    <div id="table_main">
        <table>
            <thead>
                <tr>
                    <td>Produit</td>
                    <td>Quantité LNSM</td>
                    <td>Quantité dépot</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="product">{{$product->item_name}}</td>
                        <td class="number">{{$product->home_items}}
                            <div>
                                <a href="{{route('add.item', ['id' => $product->id, 'space' =>1])}}" class="btn"><i class="fas fa-plus"></i>1</a>
                                <a href="{{route('remove.item', ['id' => $product->id, 'space' =>1])}}" class="btn"><i class="fas fa-minus"></i>1</a>
                            </div>
                        </td>
                        <td class="number">{{$product->depot_items}}
                            <div>
                                <a href="{{route('add.item', ['id' => $product->id, 'space' =>0])}}" class="btn"><i class="fas fa-plus"></i>1</a>
                                <a href="{{route('remove.item', ['id' => $product->id, 'space' =>0])}}" class="btn"><i class="fas fa-minus"></i>1</a>
                            </div>
                        </td>
                        <td class="number">{{$product->home_items+$product->depot_items}}</td>
                    </tr>

                @endforeach
            </tbody>


        </table>
    </div>

@endsection
