<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AfricasTalking\SDK\AfricasTalking;
use App\Transaction;
use NestedJsonFlattener\Flattener\Flattener;
use Mavinoo\LaravelBatch\LaravelBatchServiceProvider;

class TransactionController extends Controller
{
    /**
     * Display a listing of all the transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = DB::select('select * from vwUSSDTransactions ORDER BY TransactionDate DESC');

        return view('transactions.index',compact('transactions'));
        // foreach ($transactions as $transaction) {var_dump($transaction->id);}  
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
        // // Set your app credentials
        // $username = "csaussd";
        // $apiKey   = "9ef49c4e182c7ae7f282b4103c12b52b42197d2124465134a4f0df98b5866996";
        // //$username = "sandbox";
        // //$apiKey   = "b9d0b23772a378e6371741ee5fb42102aab40e3efee8f52af1890bb6b8e5104e";        

        // // Initialize the SDK
        // $AT  = new AfricasTalking($username, $apiKey);

        // // Get the payments service
        // $payments = $AT->payments();

        // //****************START FINDING MULTIPLE TRANSACTIONS***************************

        // // Set the name of your Africa's Talking payment product
        // $productName = "FreshLife";
        // //$productName = "Sanergy";        

        // // Set the pageNumber and count you'll be fetching from
        // $pageNumber  = 1;
        // $count       = 100;//50
        // //$startDate = '2018-12-21';
        // //$endDate = '2018-12-21';
        // //$category = 'MobileC2B';//$category = 'MobileCheckout;
        // //$status = 'Success';

        // // Set your fetch product transactions filters
        // $filters     = [
        //     "pageNumber" => $pageNumber,
        //     "count"      => $count
        //     //"startDate"  => $startDate,
        //     //"endDate"    => $endDate,
        //     //"category"   => $category
        // ];
        
        // try {
        //     // Fetch the product transactions
        //     $transactions = $payments->fetchProductTransactions([
        //         "productName" => $productName,
        //         "filters"     => $filters
        //     ]);
            
        //     $array1 = json_decode(json_encode($transactions["data"]),true);
        //     //Show no. of transactions fetched
        //     print_r(count($array1["responses"]));

        //     //create new array
        //     $d = array();
        //     $x = array();
        //     $flattener = new Flattener();
        //     for($i=0; $i < count($array1["responses"]); $i++){
        //         $flattener->setArrayData($array1["responses"][$i]);
        //         $flat = $flattener->getFlatData();
        //         $d[$i] = $flat ;
        //         $x[$i] = $d[$i][0];
        //     }

        //     $table = 'transactions';
        //     $columns = [
        //         'clientAccount',
        //         'source',
        //         'provider',
        //         'description',
        //         'providerChannel',
        //         'transactionFee',
        //         'providerRefId',
        //         'providerFee',
        //         'status',
        //         'firstName',
        //         'middleName',
        //         'lastName',
        //         'amount',
        //         'transactionDate',
        //         'transactionId',
        //         'creationTime',
        //         'category',
        //    ];  
           
        //    //Hold bulk transactions for insertion to the DB
        //    $bulkdata = array(); 

        //    //Process the records for inserting to DB in batches of 500 max & min of 100
        //    $batchSize = 500;             

        //     foreach($x as $value){                
        //         $row = array(@$value["clientAccount"] ?: "",
        //         @$value["source"] ?: "",
        //         @$value["provider"] ?: "",
        //         @$value["description"] ?: "",
        //         @$value["providerChannel"] ?: "",
        //         @$value["transactionFee"] ?: "",    
        //         @$value["providerRefId"] ?: "",
        //         @$value["providerFee"] ?: "",
        //         @$value["status"] ?: "",    
        //         @$value["providerMetadata.[Personal Details][First Name]"] ?: "",
        //         @$value["providerMetadata.[Personal Details][Middle Name]"] ?: "",
        //         @$value["providerMetadata.[Personal Details][Last Name]"] ?: "",                
        //         @$value["value"] ?: "",
        //         @$value["transactionDate"] ?: "",
        //         @$value["transactionId"] ?: "",
        //         @$value["creationTime"] ?: "",                
        //         @$value["category"] ?: ""
        //         );
                
        //         //Append each record to the main array for bulk insertion to the DB
        //         array_push($bulkdata,$row);         
        //     }

        //     //Insert Bulk data
        //     $result = \Batch::insert($table, $columns, $bulkdata, $batchSize);
                         
        // } catch(Exception $e) {
        //     echo "Error: ".$e->getMessage();
        // }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Search for records using Phone number/FLT/Client account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function searchByPhoneOrFLTOrClientAccount(Request $request)

    {       
        //Get the data from the search bar 
        $searchData = $request->input('search');

        $transactions = DB::select('SELECT * FROM vwUSSDTransactions 
                                    WHERE Source LIKE ? 
                                    OR ClientAccount LIKE ? 
                                    OR FLTPaidFor LIKE ? ORDER BY TransactionDate DESC' , 
                                    ['%'.$searchData.'%', '%'.$searchData.'%', '%'.$searchData.'%']);
        
        if(count($transactions) > 0)
            return view('transactions.search',compact('transactions'))->withDetails($transactions)->withQuery ( $searchData );
        else 
            return view ('transactions.search')->withMessage('No Details found. Try to search again !');
            
        //Uncomment below for debugging purposes
        //var_dump($searchData);
        //echo '<br/><br/>';
        //var_dump($transaction);
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

        //Remove '/' from the date and replace with '-'
        $date = str_replace("/","-",$date); 

        //Get the start date
        $startDate = substr($date,0,10);

        //Get the end date
        $endDate = substr($date,13,20);
        
        // var_dump($date);
        // echo '<br/><br/>';                      

        // $transaction = DB::select('SELECT * FROM vwUSSDTransactions 
        //                             WHERE TransactionDate LIKE ? ORDER BY TransactionDate DESC', 
        //                             ['%'.$date.'%']);

        $transaction = DB::select('SELECT * FROM vwUSSDTransactions 
                                    WHERE TransactionDate BETWEEN ? AND ? ORDER BY TransactionDate DESC', 
                                    [$startDate,$endDate]);       

        if(count($transaction) > 0)
            return view('transactions.search',compact('details'))->withDetails($transaction)->withQuery ( $date );
        else 
            return view ('transactions.search')->withMessage('No record(s) found. Search again !');
            // return redirect('transactions/searchByDate')->with('errorMessage', 'No record(s) found. Search again !');      

    }   

    /**
     * Write the AfricasTalking transactions to a CSV file.  *
     * 
     */
    public function writeAfricasTalkingTransactionsToCSV()
    {
        /* Set your app credentials
        $username = "csaussd";
        $apiKey   = "9ef49c4e182c7ae7f282b4103c12b52b42197d2124465134a4f0df98b5866996";
        //$username = "sandbox";
        //$apiKey   = "b9d0b23772a378e6371741ee5fb42102aab40e3efee8f52af1890bb6b8e5104e";        

        // Initialize the SDK
        $AT  = new AfricasTalking($username, $apiKey);

        // Get the payments service
        $payments = $AT->payments();

        //****************START FINDING MULTIPLE TRANSACTIONS***************************

        // Set the name of your Africa's Talking payment product
        $productName = "FreshLife";
        //$productName = "Sanergy";        

        // Set the pageNumber and count you'll be fetching from
        $pageNumber  = 1;
        $count       = 100;//50
        //$startDate = '2018-12-21';
        //$endDate = '2018-12-21';
        //$category = 'MobileC2B';//$category = 'MobileCheckout;
        //$status = 'Success';

        // Set your fetch product transactions filters
        $filters     = [
            "pageNumber" => $pageNumber,
            "count"      => $count
            //"startDate"  => $startDate,
            //"endDate"    => $endDate,
            //"category"   => $category
        ];
        
        try {
            // Fetch the product transactions
            $transactions = $payments->fetchProductTransactions([
                "productName" => $productName,
                "filters"     => $filters
            ]);
            
            $array1 = json_decode(json_encode($transactions["data"]),true);

            //create new array
            $d = array();
            $x = array();
            $flattener = new Flattener();
            for($i=0; $i < count($array1["responses"]); $i++){
                $flattener->setArrayData($array1["responses"][$i]);
                $flat = $flattener->getFlatData();
                $d[$i] = $flat ;
                $x[$i] = $d[$i][0];
            }

            //The name of the CSV file that will be downloaded by the user.
            //$fileName = "AFRICASTALKING_PAYMENT_TRANSACTIONS_" . date("d.m.Y") . ".csv";
            //$fileName = "Transactions.csv";

            //Set the Content-Type and Content-Disposition headers.
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');

            //A multi-dimensional array containing our CSV data.
            $data = array(
                //Our header (column names)
                array("CLIENT ACCOUNT", "SOURCE","PROVIDER", "DESCRIPTION",
                "PROVIDER CHANNEL","TRANSACTION FEE", "PROVIDER REF ID", "PROVIDER FEE", 
                "STATUS", "FIRST NAME", "MIDDLE NAME", "LAST NAME", "AMOUNT","TRANSACTION DATE", 
                "TRANSACTION ID", "CREATION TIME", "CATEGORY")
            );            
            
            //Open up a PHP output stream using the function fopen.
            $fp = fopen('php://output', 'w');

            //Loop through the array containing our CSV data.
            foreach ($data as $row) {
                //fputcsv formats the array into a CSV format.
                //It then writes the result to our output stream.
                fputcsv($fp, $row);
            }      

            foreach($x as $value){                
                $row = array(@$value["clientAccount"] ?: "",
                @$value["source"] ?: "",
                @$value["provider"] ?: "",
                @$value["description"] ?: "",
                @$value["providerChannel"] ?: "",
                @$value["transactionFee"] ?: "",    
                @$value["providerRefId"] ?: "",
                @$value["providerFee"] ?: "",
                @$value["status"] ?: "",    
                @$value["providerMetadata.[Personal Details][First Name]"] ?: "",
                @$value["providerMetadata.[Personal Details][Middle Name]"] ?: "",
                @$value["providerMetadata.[Personal Details][Last Name]"] ?: "",                
                @$value["value"] ?: "",
                @$value["transactionDate"] ?: "",
                @$value["transactionId"] ?: "",
                @$value["creationTime"] ?: "",                
                @$value["category"] ?: ""
                );                
                //Write the response on a CSV file
                fputcsv($fp, $row);                
            }                       
            
            //Close the file handle.
            fclose($fp);
                         
        } catch(Exception $e) {
            echo "Error: ".$e->getMessage();
        }*****************************************************************************/

        /****************START FINDING A SINGLE TRANSACTION****************************
        
            // Set the id of the transaction you want to find
            $transactionId = "ATPid_30277da5756d892ed3d0865747edb3e9";

            try {
                // Find the transaction
                $transaction = $payments->findTransaction([
                    "transactionId" => $transactionId
                ]);
                echo "<br/><br/><br/>"; 
                print_r('*---------------------------------------*'); 
                print_r('----<b>FOUND A SINGLE TRANSACTION</b>----');
                print_r('*---------------------------------------*');             
                echo "<br/><br/><br/>"; 
                print_r($transaction);
                //echo "<br/><br/><br/>";
                //print_r($transaction["status"]);

                //echo "<br/><br/><br/>";
                //print_r($transaction["data"]);
                
                //********************************************** 
                file_put_contents('AFRICASTALKING_TRANSACTIONS_ONE.txt', print_r($transaction , true));
                //********************************************** 

                $array = json_decode(json_encode($transaction),true);
                echo "<br/><br/><br/>";
                print_r('*--------------DECODED RESPONSE-------------------------*');
                echo "<br/><br/><br/>";    
                print_r($array);
                echo "<br/><br/><br/>";

                //Loop through the $array 
                foreach($array as $key => $value1)
                {
                    echo "Level 1 <br/><br/>";
                    print_r($key);
                    echo " : ";                                         
                    print_r($value1);
                    echo "<br/><br/>";                
                    //echo $key.": ".$value1."<br>";

                    //Check if the KEYS's value is an array an loop through the array if so
                    if(is_array($value1)){
                        foreach($value1 as $key => $value2)
                        {
                            echo "Level 2 <br/><br/>";
                            print_r($key);
                            echo " : ";                                        
                            print_r($value2);
                            echo "<br/><br/>";                        
                            //echo $key.": ".$value2."<br>";

                            //Check if the KEYS's value is an array an loop through the array if so
                            if(is_array($value2)){                        
                                foreach($value2 as $key => $value3){
                                    echo "Level 3 <br/><br/>";
                                    print_r($key);
                                    echo " : ";                                        
                                    print_r($value3);
                                    echo "<br/><br/>";                                
                                    //echo $key.": ".$value3."<br>";

                                    //Check if the KEYS's value is an array an loop through the array if so
                                    if(is_array($value3)){ 
                                        foreach($value3 as $key => $value4){
                                            echo "Level 4 <br/><br/>";
                                            print_r($key);
                                            echo " : ";                                         
                                            print_r($value4);
                                            echo "<br/><br/>";
                                            //echo $key.": ".$value4."<br>";

                                        }
                                    }//End if(is_array($value3))
                                }
                            }//End if(is_array($value2))                            
                        }
                    }//End if(is_array($value1))
                        echo "<br/><br/>";
                }                       
                //**********************************************             
                        
            } catch(Exception $e) {
                echo "Error: ".$e->getMessage();
            }        

        ************************END FINDING A SINGLE TRANSACTION***********************************************/
    }    
}
