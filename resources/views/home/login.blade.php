@extends('main.home')
@section('page title', 'Ocularlens')
@section('content')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-8 col-xs-12 card">
            <div class="card-body">
                <h4 class="card-title">Login</h4>
                @if (session('error'))
                    <div class="alert alert-danger">
                        Member not registered
                    </div>  
                @endif
                <form action="/login" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" value="{{old('email')}}" id="email" name="email" 
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
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                        <label class="custom-control-label" for="remember">Remember me</label>
                    </div><br>
                    <input type="submit" class="btn btn-success btn-sm" value="Submit">
                </form>
            </div>     
        </div>
    </div>
</div>
@endsection