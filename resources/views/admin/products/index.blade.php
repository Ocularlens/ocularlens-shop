@extends('main.admin')
@section('page title', 'Ocularlens')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3 class="card-title">Products</h3>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>            
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{$product->name}}</td>
                                <td>{{$product->description ?? 'None'}}</td>
                                <td>{{number_format($product->price, 2)}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>
                                    <a href="/admin/products/edit/{{$product->id}}" class="btn btn-success btn-sm">Edit</a>
                                    <a href="" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="/admin/products/new" class="btn btn-info btn-sm">New Product</a>
        </div>
    </div>
</div>
@endsection