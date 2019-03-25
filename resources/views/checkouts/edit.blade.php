<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Fresh Life | USSD | Mobile Checkouts | Edit</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
  </head>
  <body>
    <div class="container">
      <h2>Mobile Checkout | Edit</h2><br  />
        <form method="post" action="{{action('CheckoutController@update', $id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="status">Current status:</label>
            <input type="text" class="form-control" name="status" value="{{$checkout->status}}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="phoneNumber">Phone Number:</label>
              <input type="text" class="form-control" name="phoneNumber" value="{{$checkout->phoneNumber}}">
            </div>
          </div>
        <div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="Amount">Amount:</label>
              <input type="text" class="form-control" name="Amount" value="{{$checkout->Amount}}">
            </div>
          </div>
        <div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4" style="margin-left:38px">
                <label>New status</label>
                <select name="status">
                    @if($checkout->status == "pending")
                        <option value="Discarded"  @if($checkout->status=="pending") selected @endif>Discarded</option>
                    @elseif($checkout->status == "In progress")
                        <option value="pending"  @if($checkout->status=="In progress") selected @endif>Pending</option>
                        <option value="Discarded"  @if($checkout->status=="In progress") selected @endif>Discarded</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4" style="margin-top:60px">
            <button type="submit" class="btn btn-success btn-lg" style="margin-left:38px">UPDATE</button>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>