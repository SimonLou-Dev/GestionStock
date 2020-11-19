@extends('layouts.app')
@section('content')
    <div class="jumbotron" id="add">
        <form method="post" action="{{route('product.add.post')}}">
            @csrf
            <div class="form-group">
                <label for="addproduct">Ajouter le produit : </label>
                <input type="text" class="form-control" name="product" id="addproduct">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection