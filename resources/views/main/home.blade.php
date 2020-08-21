<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('page title', 'Ocularlens')</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
      <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Ocularlens') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="ss">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="/products" class="nav-link">Products</a></li>
                    <li class="nav-item"><a href="" class="nav-link">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                          {{Auth::guard('members')->user()->first_name ?? 'Member'}} <i class="far fa-user-circle"></i>
                        </a>
                        @if (Auth::guard('members')->check())
                            <div class="dropdown-menu">
                                @if (is_null(Auth::guard('members')->user()->email_verified_at))
                                    <a class="dropdown-item" href="/member/verify">Verify</a>
                                @endif
                                <a class="dropdown-item" href="/member/logout">Log out</a>
                            </div>
                        @else
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/login">Log in</a>
                                <a class="dropdown-item" href="/register">Register</a>
                            </div>
                        @endif
                    </li>
                    <li class="nav-item"><a href="" class="nav-link" data-toggle="modal" data-target="#myModal"><i class="fas fa-shopping-cart"></i></a></li>
                </ul>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content') 
    </main>
    </div>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Cart</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
      
            <!-- Modal body -->
            <div class="modal-body">
                @php
                    $products = Session::get('my-cart');  
                @endphp
                @if (is_null($products))
                    <h5>Items (0)</h5>
                @else
                    <h5>Items ({{count($products)}})</h5>
                    <table class="table table-borderless">
                        @foreach ($products as $product)
                            <tr>
                                <td>{{$product->name}}</td>
                                <td>&times; {{$product->qty}}</td>
                                <td>{{number_format($product->price * $product->qty, 2)}}</td>
                                @if ($product->qty ==1)
                                <td>
                                    <a href="/cart/remove/{{$product->id}}" class="btn"><i class="fas fa-trash-alt"></i></a>
                                </td>
                                @else
                                <td>
                                    <a href="/cart/remove/{{$product->id}}" class="btn"><i class="fas fa-trash-alt"></i></a>
                                    <a href="/cart/deduct/{{$product->id}}" class="btn"><i class="fas fa-minus"></i></a>
                                </td>
                                @endif
                                
                            </tr>
                        @endforeach
                    </table>  
                @endif
                <div class="row">
                    <div class="col-lg-4">
                       <a href="" class="btn btn-info form-control">CHECK OUT</a> 
                    </div>
                    <div class="col-lg-4">
                        <a href="/cart/view" class="btn btn-info form-control">VIEW CART</a> 
                     </div>
                    <div class="col-lg-4">
                        <a href="/cart/clear" class="btn btn-warning form-control">CLEAR CART</a> 
                    </div>
                </div>
            </div>
      
            <!-- Modal footer -->      
          </div>
        </div>
      </div>
</body>
</html>