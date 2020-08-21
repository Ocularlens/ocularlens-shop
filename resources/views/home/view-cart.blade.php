@extends('main.home')
@section('page title', 'Ocularlens')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-xs-12">
            @php
                $products = Session::get('my-cart');  
            @endphp
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-12 card" style="margin-bottom: 20px;">
                        <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    <img style="width: 100px; height:100px;margin-top:10px;" src="{{asset('storage/product/'. $product->image_path)}}" alt="Card image">
                                </td>
                                <td>{{$product->name}}</td>
                                <td>&times; {{$product->qty}}</td>
                                <td>{{number_format($product->price * $product->qty, 2)}}</td>
                                @if ($product->qty ==1)
                                <td>
                                    <a href="/cart/remove/{{$product->id}}" class="btn"><i class="fas fa-trash-alt"></i></a>
                                </td>
                                @else
                                <td>
                                    <a href="/cart/remove/{{$product->id}}" class="btn"><i class="fas fa-trash-alt"></i></a>
                                    <a href="/cart/deduct/{{$product->id}}" class="btn"><i class="fas fa-minus"></i></a>
                                </td>
                                @endif
                                
                            </tr>
                        </table> 
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div class="d-flex">
                <div class="p-2 flex-grow-1">
                    <h4>Total: </h4>
                </div>
                <div class="p-2">
                    <h4>{{$total}}</h4>
                </div>
            </div>
            <div class="d-flex">
                <div class="p-2">
                    <a href="/cart/clear" class="btn btn-warning form-control">CLEAR CART</a>
                </div>
                <div class="p-2 flex-grow-1">
                    <a href="" class="btn btn-info form-control">CHECK OUT</a> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection