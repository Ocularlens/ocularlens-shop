@extends('main.admin')
@section('page title', 'Ocularlens')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center" id="app">
        <div class="col-md-12">
            <h3 class="card-title">Edit Product ({{$product->name}})</h3>
            <form action="/admin/products/edit/{{$product->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="email">Product name:</label>
                    <input type="text" class="form-control" value="{{$product->name}}" id="name" name="name">
                    @error('name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="comment">Desription:</label>
                    <textarea class="form-control" rows="100" name="description"
                    @if ($errors->has('description'))
                        style="border-color:red;"
                    @endif>{{$product->description}}</textarea>
                    @error('description')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                  </div>
                <div class="form-group">
                    <label for="email">Price:</label>
                    <input type="number" step="0.01" class="form-control" value="{{$product->price}}" id="price" name="price">
                    @error('price')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Quantity:</label>
                    <input type="number" class="form-control" value="{{$product->quantity}}" id="quantity" name="quantity">
                    @error('quantity')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <img style="width:300px;height:300px;" src="{{asset('storage/product/'. $product->image_path)}}" alt="" class="img-thumbnail">
                <br>
                Upload new photo to replace <br>
                <input type="file" name="files" id="files">
                
                @error('files')
                    <p class="text-danger">{{$message}}</p>
                @enderror<br><br>
                <input type="submit" value="Save" class="btn btn-info btn-sm">
            </form>
        </div>
    </div>
</div>
@endsection