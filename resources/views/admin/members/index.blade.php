@extends('main.admin')
@section('page title', 'Ocularlens')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3 class="card-title">Members</h3>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Member's Name</th>
                            <th>Email Address</th>
                            <th>Date Registered</th>
                            <th>Actions</th>
                        </tr>            
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td>{{$member->first_name.' '.$member->last_name}}</td>
                                <td>{{$member->email}}</td>
                                <td>{{date_format($member->created_at, 'M d, Y H:i:s')}}</td>
                                <td>
                                    <a href="/admin/members/delete/{{$member->id}}" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection