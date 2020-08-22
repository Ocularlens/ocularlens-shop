@extends('main.home')
@section('page title', 'Ocularlens')
@section('content')
<div class="container">
    <div class="row card">
        <div class="col-lg-12 card-body">
            <h1 class="card-title">Transactions</h1>
            <table class="table table-borderless">
                <tr>
                   <th>Transaction ID</th>
                   <th>Items</th>
                   <th>Total</th>
                   <th>Date</th>
                   <th>Action</th>
                </tr>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{$transaction->id}}</td>
                        <td>
                            <table> 
                            @foreach ($transaction->products as $product)
                            <tr>
                                <td>
                                    {{$product->name}} &times; {{$product->pivot->quantity}}
                                </td> 
                            </tr>    
                            @endforeach
                        </table>
                        </td>
                        <td>PHP {{number_format($transaction->total)}}</td>
                        <td>{{date_format($transaction->created_at,'M, d Y H:i:s')}}</td>
                        @if (!$transaction->request_refund)
                            <td>
                                <a href="/member/refund/{{$transaction->id}}" class="btn btn-warning">Request Refund</a>
                            </td>
                        @else 
                            <td>Already requested</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection