@extends('main.admin')
@section('page title', 'Ocularlens')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3 class="card-title">Transactions</h3>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Transaction id</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>            
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->id}}</td>
                                <td>
                                    <table>
                                        @foreach ($transaction->products as $item)
                                            <tr>
                                                <td>{{$item->name}} &times; {{$item->pivot->quantity}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>PHP {{number_format($transaction->total, 2)}}</td>
                                <td>{{date_format($transaction->created_at, 'M d, Y H:i:s')}}</td>
                                @if ($transaction->request_refund)
                                <td>
                                    <a href="/admin/transactions/refund/{{$transaction->id}}" class="btn btn-danger btn-sm">Approve Refund</a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection