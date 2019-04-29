<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AfricasTalking\SDK\AfricasTalking;
use App\Airtime;
use NestedJsonFlattener\Flattener\Flattener;
use Mavinoo\LaravelBatch\LaravelBatchServiceProvider;

class AirtimeController extends Controller
{
    /**
     * Send Airtime to FLO.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendAirtime()
    {
        // // Set your app credentials
        // $username = "csaussd";
        // $apiKey   = "9ef49c4e182c7ae7f282b4103c12b52b42197d2124465134a4f0df98b5866996";
        $username = "sandbox";
        $apiKey   = "b9d0b23772a378e6371741ee5fb42102aab40e3efee8f52af1890bb6b8e5104e";        

        //Initialize the SDK
        $AT  = new AfricasTalking($username, $apiKey);

        //file_put_contents('filename.txt', print_r($sql1, true));

        //AfricasTalking Airtime API
        $airtime_api = $AT->airtime();

        //The airtime table
        //use App\Airtime
        //Create an instance of the Airtime class
        $airtimeInstance = new Airtime;

        //The id that uniquely identifies each record in the airtime table
        $row_index = 'id';      
        
        //Sets the Phone numbers,Currency & airtime amount that each FLO should receive
        $phoneNumberList = array();

        //Once the $phoneNumberList array has been populated, all records will be appended to this array
        $airtime_recipients = array();

        //Holds bulk data for update to the DB
        $bulkdata = array();
        
        //Selects records from the 'airtime' table where sentAirtime = 0 AND id > 295
        $airtime = DB::select('SELECT id,phoneNumber,sentAirtime , amountToSend
                                    FROM airtime 
                                    WHERE sentAirtime = ? AND id > ?', [0, 295]);        
        
        try {

            //Loop through the response gotten from the airtime query
            foreach ($airtime as $user) {
                //echo $user->phoneNumber;                
                //Array for setting the Phone numbers,Currency & airtime amount that each FLO should receive
                $phoneNumberList["phoneNumber"] = "$user->phoneNumber";
                $phoneNumberList["currencyCode"] = "KES";
                $phoneNumberList["amount"] = "30";
    
                //Append each record to the $airtime_recipients array
                //in order to send airtime to FLOs in bulk
                array_push($airtime_recipients, $phoneNumberList);

            }// End foreach ($airtime as $user) 
    
            //Send Airtime in bulk to FLOs            
            $airtime_transactions = $airtime_api->send([
                "recipients" => $airtime_recipients
            ]);       
                
            //Display the AfricasTalking API response after having sent airtime
            print_r($airtime_transactions);
                
            //Decode the JSON response from AfricasTalking
            $array1 = json_decode(json_encode($airtime_transactions["data"]),true);
            
            //Show no. of airtime transactions fetched
            echo "</br></br>";
            echo "No. of Airtime Transactions = ";
            print_r(count($array1["responses"]));

            //Create new arrays
            $d = array();
            $x = array();

            //Flatten the API response we get from the AfricasTalking
            $flattener = new Flattener();
            for($i=0; $i < count($array1["responses"]); $i++){
                $flattener->setArrayData($array1["responses"][$i]);
                $flat = $flattener->getFlatData();
                $d[$i] = $flat ;
                $x[$i] = $d[$i][0];
            }

            //Loop through the response gotten from the airtime query
            foreach ($airtime as $user){

                // Loop through the now flattened API response we get from AfricasTalking
                // in order to get the respective values/data e.g [amount] => KES 30.0000                
                foreach($x as $value){

                    // Get Airtime amount sent from AfricasTalking API response i.e @$value["amount"]
                    //the value from the API response could be e.g KES 30.0000
                    $airtime_amount_sent = @$value["amount"];

                    //Airtime amount from AfricasTalking API repsonse comes in this format i.e [amount] => KES 30.0000
                    //Return the airtime amount in this format i.e KES 30 (return the sub string before the '.' )                    
                    $airtime_amount_sent = substr($airtime_amount_sent, 0, strpos($airtime_amount_sent, "."));

                    //Remove 'KES ' from the amount
                    //Return the airtime amount in this format i.e 30
                    $airtime_amount_sent = str_replace("KES ","",$airtime_amount_sent); 
                    
                    //var_dump($airtime_amount_sent);                    

                    //Setting the columns in our airtime table with values to update
                    $row = array(
                        'id' => $user->id,
                        'sentAirtime' => 1,
                        'amountToSend' => $airtime_amount_sent                        
                        //'phoneNumber' => @$value["phoneNumber"] ?: "",
                    );
                    
                    //Append each record to the main array for bulk update to the DB
                    array_push($bulkdata,$row);         
                }// End foreach($x as $value)

            }// End foreach ($airtime as $user)

            //Perform Bulk Update on the 'airtime' table
            \Batch::update($airtimeInstance, $bulkdata, $row_index);
            
        } catch(Exception $e) {
            echo "Error: ".$e->getMessage();
        }

    }

}
