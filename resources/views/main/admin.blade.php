<!doctype html>
<html lang="en">
  <head>
  	<title>@yield('page title', 'Ocularlens')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
      <!--Side Nav-->
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
	  		<h1><a href="/admin" class="logo"><img src="https://www.google.com/imgres?imgurl=https%3A%2F%2Fimage.shutterstock.com%2Fimage-photo%2Fmountains-during-sunset-beautiful-natural-260nw-407021107.jpg&imgrefurl=https%3A%2F%2Fwww.shutterstock.com%2Fcategory%2Fnature&tbnid=wW5BhncqphFQ0M&vet=12ahUKEwjBpaPpg6frAhVgxIsBHeL-DJAQMygDegUIARDUAQ..i&docid=LlgDpz1LoiuznM&w=435&h=280&q=images&ved=2ahUKEwjBpaPpg6frAhVgxIsBHeL-DJAQMygDegUIARDUAQ" alt="">Ocularlens</a></h1>
        <ul class="list-unstyled components mb-5">
          <li class="{{Request::is('admin')? ' active' : ''}}">
            <a href="/admin"><span class="fa fa-tachometer"></span> Home</a>
          </li>
          <li class="{{Request::is('admin/products*')? ' active' : ''}}">
            <a href="/admin/products"><span class="fa fa-opencart"></span> Products</a>
          </li>
          <li class="{{Request::is('admin/members*')? ' active' : ''}}">
            <a href="/admin/members"><span class="	fa fa-users"></span> Members</a>
          </li>
          <li>
            <a href="/admin/logout"><span class="	fa fa-sign-out"></span> Logout</a>
          </li>
        </ul>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5" style="background: #e6e6e6">
          @yield('content') 
      </div>
		</div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
  </body>
</html>