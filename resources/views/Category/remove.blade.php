@extends('layouts.app')
@section('content')
    <div class="jumbotron" id="remove">
        <form method="post" action="{{route('product.destroy')}}">
            @csrf
            <div class="form-group">
                <label for="categorydelet">Supprimer le produit : </label>
                <select class="form-control" id="categorydelet" name="delet">
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->item_name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>
@endsection