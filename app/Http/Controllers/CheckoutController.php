<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkouts = Checkout::orderBy('transactionDate','desc')->get();
        return view('checkouts.index',compact('checkouts'));

        // $checkouts = Checkout::all();
        //$checkouts = \App\Checkout::paginate(15);
        //$checkouts = \App\Checkout::simplePaginate(15);
        // return view('checkouts.index',compact('checkouts'));
        //$checkouts = DB::select('select * from checkout ORDER BY transactionDate DESC');      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$checkout = Checkout::find($id);
        //return view('checkouts.show',compact('checkout','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $checkout = Checkout::find($id);
        return view('checkouts.edit',compact('checkout','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $checkout= Checkout::find($id);
        $checkout->status=$request->get('status');
        $checkout->phoneNumber=$request->get('phoneNumber');
        $checkout->Amount=$request->get('Amount');
        $checkout->save();
        return redirect('checkouts');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $checkout = Checkout::find($id);
        // $checkout->delete();
        // return redirect('checkouts.index')->with('success','Record has been deleted');        
    }

    /**
     * Search for records using phone number or status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function searchByPhoneOrStatus(Request $request)

    {       
        //Get the data from the search bar 
        $searchData = $request->input('search');
        
        $checkouts = Checkout::where('status','LIKE','%'.$searchData.'%')->orWhere('phoneNumber','LIKE','%'.$searchData.'%')->orderBy('transactionDate','desc')->get();

        if(count($checkouts) > 0)
            return view('checkouts.search',compact('checkouts'))->withDetails($checkouts)->withQuery ( $searchData );
        else 
            return view ('checkouts.search')->withMessage('No Details found. Try to search again !');        

        // $checkout = DB::select('SELECT * FROM checkout 
        //                         WHERE `status` LIKE ? 
        //                         OR `phoneNumber` LIKE ? 
        //                         ORDER BY transactionDate DESC' , 
        //                         ['%'.$searchData.'%', '%'.$searchData.'%']);     

    }
    
    /**
     * Search for records using date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function searchByDate(Request $request)

    {       
        //Get the date from the search bar 
        $date = $request->input('search_by_date');

        //Remove '/' from the date
        $date = str_replace("/","",$date); 

        //Get the start date
        $startDate = substr($date,0,8);

        //Get the end date
        $endDate = substr($date,11,18);

        // var_dump($date);
        // echo '<br/><br/>';

        // $checkouts = Checkout::where('transactionDate','LIKE','%'.$startDate.'%')->orWhere('transactionDate','LIKE','%'.$endDate.'%')->orderBy('transactionDate','desc')->get();
        $checkouts = Checkout::whereBetween('transactionDate',[$startDate,$endDate])->orderBy('transactionDate','desc')->get();        

        if(count($checkouts) > 0)
            return view('checkouts.search',compact('checkouts'))->withDetails($checkouts)->withQuery ( $date );
        else 
            return view ('checkouts.search')->withMessage('No Details found. Try to search again !');           

        // $checkout = DB::select('SELECT * FROM checkout 
        //                         WHERE transactionDate LIKE ? ORDER BY transactionDate DESC', 
        //                         ['%'.$date.'%']);
        
                //var_dump($date);


    }   
}
