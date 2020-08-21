@extends('main.home')
@section('page title', 'Ocularlens')
@section('content')
<div class="container-fluid">
    <div class="row flex-row-reverse">
        <div class="col-lg-10">
            <div class="row">
                @foreach ($products as $product)
                    @if ($product->quantity !=0)
                        <div class="col-lg-3 card" style="margin:10px;">
                            <img style="width: inherit; height:250px;margin-top:10px;" src="{{asset('storage/product/'. $product->image_path)}}" alt="Card image">
                            <div class="card-body">
                                <h4 class="card-title">{{$product->name}}</h4>
                                @if (is_null($product->description))
                                    <br>
                                @else
                                    <p class="card-text">{{$product->description}}</p>
                                @endif
                                <p class="card-text">{{number_format($product->price, 2)}}</p>
                                <a href="/cart/add/{{$product->id}}" class="btn btn-primary">Add to Card <i class="fas fa-cart-plus"></i></a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    
</div>
@endsection