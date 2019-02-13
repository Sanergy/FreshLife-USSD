<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Fresh Life | USSD | Mobile Checkouts</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
  </head>
  <body> 
    <div class="container">
        <!--Start Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ url('/checkouts') }}">
                <img src="{{asset('images/Fresh_Life_Logo.png')}}" width="100" height="30" class="d-inline-block align-top" alt="Fresh Life">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/checkouts') }}">Checkouts <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/transactions') }}">Transactions</a>
                    </li>
                </ul>
               
                <form action="{{ url('checkouts/searchDate') }}" method="POST" role="search" class="form-inline my-2 my-lg-0">
                    @csrf                 
                    <input class="form-control mr-sm-2" name="search_by_date" type="date" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search by Date</button>
                </form>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;             
                <form action="{{ url('checkouts/search') }}" method="POST" role="search" class="form-inline my-2 my-lg-0">
                    @csrf                
                    <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search by phone/status" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav><!--End of navbar-->     
        <br />
        @if (\Session::has('success'))
            <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Status</th>
                <th>Phone Number</th>
                <th>Amount</th>
                <th>Transaction Recipient</th>
                <th>FLT Paid For</th>
                <th>Transaction Date</th>
                <th>Date Created</th>
                <th colspan="1">Action</th>
            </tr>
            </thead>
            <tbody>
            
            @foreach($checkouts as $checkout)
            <tr>
                <!--Reference table columns as shown below if you're using laravel models/migrations 
                <td>{{$checkout['id']}}</td>
                else reference table coulmns as shown below-->
                <td>{{$checkout->id}}</td>
                <td>{{$checkout->status}}</td>
                <td>{{$checkout->phoneNumber}}</td>
                <td>{{$checkout->Amount}}</td>
                <td>{{$checkout->transactionRecipient}}</td>
                <td>{{$checkout->FLTPaidFor}}</td>
                <td>{{date("Y-m-d H:i:s",strtotime($checkout->transactionDate))}}</td>
                <td>{{date("Y-m-d H:i:s",$checkout->date_created)}}</td>
                
                @if($checkout->status == "Completed" || $checkout->status== "completed" || $checkout->status == "Discarded") 
                    <td><a href="" class="btn btn-light disabled">Edit</a></td>
                @else
                    <td><a href="{{action('CheckoutController@edit', $checkout->id)}}" class="btn btn-warning">Edit</a></td>
                @endif
                <!--<td>
                <form action="{{action('CheckoutController@destroy', $checkout['id'])}}" method="post">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
                </td>-->
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>   
  </body>
</html>