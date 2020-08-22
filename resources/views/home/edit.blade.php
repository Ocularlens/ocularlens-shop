@extends('main.home')
@section('page title', 'Ocularlens')
@section('content')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-8 col-xs-12 card">
            <div class="card-body">
                <h4 class="card-title">Register</h4>
                <form action="/member/edit" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">First name:</label>
                        <input type="text" class="form-control" value="{{$member->first_name}}" id="first-name" name="first-name" 
                        @if ($errors->has('first-name'))
                            style="border-color:red;"
                        @endif>
                        @error('first-name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Last name:</label>
                        <input type="text" class="form-control" value="{{$member->last_name}}" id="last-name" name="last-name" 
                        @if ($errors->has('last-name'))
                            style="border-color:red;"
                        @endif>
                        @error('last-name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Address:</label>
                        <textarea name="address" id="address" cols="30" class="form-control" rows="10" @if ($errors->has('address'))
                            style="border-color:red;"
                        @endif>{{$member->address}}</textarea>
                        @error('address')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" value="{{$member->email}}" id="email" name="email" 
                        @if ($errors->has('email'))
                            style="border-color:red;"
                        @endif>
                        @error('email')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" 
                        @if ($errors->has('password'))
                            style="border-color:red;"
                        @endif>
                        @error('password')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-success btn-sm" value="Submit">
                </form>
            </div>     
        </div>
    </div>
</div>
@endsection