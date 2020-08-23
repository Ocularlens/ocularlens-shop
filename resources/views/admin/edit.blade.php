@extends('main.admin')
@section('page title', 'Ocularlens')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="card-title">Edit Account</h3>
            <form action="/admin/edit" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">First name:</label>
                    <input type="text" class="form-control" value="{{Auth::guard('admins')->user()->first_name}}" id="first-name" name="first-name" 
                    @if ($errors->has('first-name'))
                        style="border-color:red;"
                    @endif>
                    @error('first-name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Last name:</label>
                    <input type="text" class="form-control" value="{{Auth::guard('admins')->user()->last_name}}" id="last-name" name="last-name" 
                    @if ($errors->has('last-name'))
                        style="border-color:red;"
                    @endif>
                    @error('last-name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Username:</label>
                    <input type="text" class="form-control" value="{{Auth::guard('admins')->user()->username}}" id="username" name="username" 
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
            </form>
        </div>
    </div>
</div>
@endsection