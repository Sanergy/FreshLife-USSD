<?php
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use App\Http\Controllers\AirtimeController;

class SendAirtime extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'send:airtime';
 
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Sends Airtime";
 
  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }
 
  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
        //Create an  instance of Airtime
        $my_airtime  = new AirtimeController();

        //file_put_contents('filename.txt', print_r($sql1, true));

        //Send Airtime
        $send_airtime = $my_airtime->sendAirtime();
  }
}