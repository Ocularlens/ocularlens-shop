@extends('main.admin')
@section('page title', 'Ocularlens')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 card">
            <div class="card-body">
                <h4 class="card-title">Admin</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <p>Name : {{Auth::guard('admins')->user()->first_name.' '.Auth::guard('admins')->user()->last_name}}</p>
                        <p>Username : {{Auth::guard('admins')->user()->username}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <a href="/admin/edit" class="btn btn-info btn-sm">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection