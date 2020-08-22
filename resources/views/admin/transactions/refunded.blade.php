@extends('main.admin')
@section('page title', 'Ocularlens')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3 class="card-title">Refunded Transactions</h3>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Transaction id</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>            
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->id}}</td>
                                <td>PHP {{number_format($transaction->total, 2)}}</td>
                                <td>{{date_format($transaction->created_at, 'M d, Y H:i:s')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection