@extends('layouts.app')

@section('content')
    <div id="table_main">
        <table>
            <thead>
                <tr>
                    <td>Produit</td>
                    <td>Quantité</td>
                    @if (Auth::check())
                        <td>Actions</td>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="product">{{$product->item_name}}</td>
                        <td class="number">{{$product->number_of_items}}</td>
                        @if (Auth::check())
                            <td class="form">
                                <a href="{{route('add.item', $product->id)}}" class="btn"><i class="fas fa-plus"></i>1</a>
                                <a href="{{route('remove.item', $product->id)}}" class="btn"><i class="fas fa-minus"></i>1</a>
                            </td>
                        @endif

                    </tr>

                @endforeach
            </tbody>


        </table>
    </div>

@endsection