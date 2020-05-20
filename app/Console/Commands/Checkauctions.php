<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Product;
use App\Bid;
use App\Purchase;
use DateTime;
class Checkauctions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auctioncheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check auctions';

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

            $auctions = Product::where('sold',0)->where('auction',true)->get();

            foreach ($auctions as $auction) {

              $ends =  new DateTime($auction->end_date);
              $now = new DateTime(date('Y-m-d H:i:s', time()));
              if ($ends < $now) {
                $lastbid = $auction->bids->where('value',$auction->bids->max('value'))->first();
                foreach ($auction->bids as $bid) {
                  if ($bid->id == $lastbid->id) {

                  } else {
                    $bid->user->balance += $bid->value;
                    $bid->user->save();
                  }
                }
                $auction->buyer_id = $lastbid->user->id;
                $auction->sold = true;
                $auction->save();

                $purchase = new Purchase;
                $purchase->uniqueid = 'PU'.str_random(28);
                $purchase->buyer_id = $lastbid->user->id;
                $purchase->seller_id = $auction->seller->id;
                $purchase->value = $lastbid->value;
                $purchase->product_id = $auction->id;
                $purchase->delivered = false;
                $purchase->save();
              }
            }
    }
}
