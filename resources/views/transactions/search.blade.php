<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Fresh Life | USSD | Transactions | Search</title>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <!-- Date Range Picker Libraries -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> 

    </head>
    <body> 
        <div class="container">
            <!--Start Navbar-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('images/Fresh_Life_Logo.png')}}" width="100" height="30" class="d-inline-block align-top" alt="Fresh Life">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/') }}">Transactions<span class="sr-only">(current)</span></a>
                        </li>                
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/checkouts') }}">Checkouts</a>
                        </li>
                    </ul>
                
                    <form action="{{ url('transactions/searchByDate') }}" method="POST" role="search" class="form-inline my-2 my-lg-0">
                        @csrf    
                        <input class="form-control mr-sm-2" name="search_by_date" type="text">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search by Date</button>
                    </form>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;             
                    <form action="{{ url('transactions/search') }}" method="POST" role="search" class="form-inline my-2 my-lg-0">
                        @csrf                
                        <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search by Phone/FLT" aria-label="Search">
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

            @if(isset($details))
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Client Account</th>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Transaction Fee</th>
                            <th>Provider Fee</th>
                            <th>Transaction Date</th>
                            <th>Category</th>
                            <th>FLT Paid For</th>
                            <th>Transaction Recipient</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details as $transaction)
                        <tr>     
                            <td>{{$transaction->id}}</td>
                            <td>{{$transaction->ClientAccount}}</td>
                            <td>{{$transaction->Source}}</td>
                            <td>{{$transaction->Amount}}</td>
                            <td>{{$transaction->TransactionFee}}</td>
                            <td>{{$transaction->ProviderFee}}</td>
                            <td>{{$transaction->TransactionDate}}</td>
                            <td>{{$transaction->Category}}</td>
                            <td>{{$transaction->FLTPaidFor}}</td>
                            <td>{{$transaction->transactionRecipient}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- JS function for handling date range picker -->
        <script>
            $(function() {
                $('input[name="search_by_date"]').daterangepicker({
                opens: 'left',
                drops: 'down',
                autoApply: true,
                linkedCalendars: true,
                autoUpdateInput: true
                });

                $('input[name="search_by_date"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
                });

            });
        </script>           
    </body>
</html>