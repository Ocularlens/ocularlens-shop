@extends('main.home')
@section('page title', 'Ocularlens')
@section('content')
<div class="container">
    
    <div class="row">
        <div class="col-md-8 col-xs-12">
            @php
                $products = Session::get('my-cart');  
            @endphp
            <div class="row card">
                <div class="col-md-12 card-body">
                    <form action="/checkout" method="POST">
                        @csrf
                        <h1>Payment Details</h1>
                        <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                     
                        <div class="form-group">
                            <label for="number">Name on card</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}"
                            @if ($errors->has('name'))
                                style="border-color:red;"
                            @endif>
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="number">Card number</label>
                            <input type="number" name="number" value="{{old('number')}}" id="number" class="form-control"
                            @if ($errors->has('number'))
                                style="border-color:red;"
                            @endif>
                            @error('number')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="number">Expiration</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="MM" name="expiration-m" id="expiration-m" value="{{old('expiration-m')}}" class="form-control"
                                            @if ($errors->has('expiration-m'))
                                                style="border-color:red;"
                                            @endif>
                                            @error('expiration-m')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="YY" name="expiration-y" id="expiration-y" value="{{old('expiration-y')}}" class="form-control"
                                            @if ($errors->has('expiration-y'))
                                                style="border-color:red;"
                                            @endif>
                                            @error('expiration-y')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="number">CVV</label>
                                    <input type="number" name="cvv" id="cvv"  value="{{old('cvv')}}"class="form-control"
                                    @if ($errors->has('cvv'))
                                        style="border-color:red;"
                                    @endif>
                                    @error('cvv')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="submit" value="Pay" class="btn btn-success form-control">
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>        
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div class="d-flex">
                <div class="p-2 flex-grow-1">
                    <h4>Address: </h4>
                </div>
                <div class="p-2">
                    <h5>{{Auth::guard('members')->user()->address}}</h5>
                </div>
            </div>
            <div class="d-flex">
                <div class="p-2 flex-grow-1">
                    @foreach ($products as $product)
                        <table class="table table-borderless">
                            <tr>
                                <td style="text-align: left">{{$product->name}}</td>
                                <td style="text-align: right">{{$product->qty}}</td>
                                <td style="text-align: right">{{number_format($product->price * $product->qty, 2)}}</td>
                            </tr>
                        </table>   
                @endforeach
                </div>
            </div>
            <div class="d-flex">
                <div class="p-2 flex-grow-1">
                    <h4>Total: </h4>
                </div>
                <div class="p-2">
                    <h4>{{number_format($total, 2)}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection