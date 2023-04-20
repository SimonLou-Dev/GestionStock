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
                    <td>valider</td>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <form action="{{route("update.item")}}" method="POST">
                            @csrf
                            <td class="product">{{$product->item_name}}</td>
                            <td class="number">
                                <input class="form-control" type="number" min="0" name="home_items" value="{{$product->home_items}}">
                            </td>
                            <td class="number">
                                <input class="form-control" type="number" min="0" name="depot_items" value="{{$product->depot_items}}">
                            </td>
                            <td class="number"> {{$product->home_items+$product->depot_items}} </td>
                            <td>
                                <input type="submit" value="valider" class="btn btn-primary">
                                <input type="hidden" name="id_item" value="{{$product->id}}">
                            </td>
                        </form>
                    </tr>

                @endforeach
            </tbody>


        </table>
    </div>

@endsection
