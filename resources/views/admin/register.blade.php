@extends('main.nav-less')
@section('page title', 'Ocularlens')
@section('content')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-8 col-xs-12 card">
            <div class="card-body">
                <h4 class="card-title">Register</h4>
                <form action="/admin/register" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">First name:</label>
                        <input type="text" class="form-control" value="{{old('first-name')}}" id="first-name" name="first-name" 
                        @if ($errors->has('first-name'))
                            style="border-color:red;"
                        @endif>
                        @error('first-name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Last name:</label>
                        <input type="text" class="form-control" value="{{old('last-name')}}" id="last-name" name="last-name" 
                        @if ($errors->has('last-name'))
                            style="border-color:red;"
                        @endif>
                        @error('last-name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Username:</label>
                        <input type="text" class="form-control" value="{{old('username')}}" id="username" name="username" 
                        @if ($errors->has('username'))
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
                    <a href="/admin/login" class="btn btn-info btn-sm">Back</a>
                </form>
            </div>     
        </div>
    </div>
</div>
@endsection