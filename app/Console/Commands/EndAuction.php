<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Item;
use App\User;
use App\Bid;

class EndAuction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ends auctions that have reached their end date';

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
        $today = Carbon::now()->toDateString();
        $endedAuctionsUsers = [];

        $endedAuctionsWithoutBids = Auction::where([['end_date', $today], ['status', 'active']]);
        $endedAuctionsWithoutBids = $endedAuctionsWithoutBids->whereDoesntHave('bids')->get();

        foreach($endedAuctionsWithoutBids as $endedAuctionWithoutBids) {
            $endedAuctionWithoutBids->status = 'expired';
            $endedAuctionWithoutBids->save();
        }

        $endedAuctions = Auction::where([['end_date', $today], ['status', 'active']]);
        $endedAuctions = $endedAuctions->whereHas('bids')->get();

        if(!$endedAuctions->isEmpty()) {
            foreach($endedAuctions as $endedAuction) {
                $endedAuction->status = 'sold';
                $endedAuction->save();

                foreach($endedAuction->bids as $endedAuctionBid) {
                    $endedAuctionsUsers[$endedAuction->id . '_' . $endedAuctionBid->user->id] = [
                        'user_id' => $endedAuctionBid->user->id,
                        'auction_id' => $endedAuction->id,
                        'latest_bid_id' => $endedAuctionBid->id, // Will get latest bid automatically
                    ];
                }
            }

            foreach($endedAuctionsUsers as $endedAuctionsUser) {
                $hasHighestBid = false;
                $userId = $endedAuctionsUser['user_id'];
                $auctionId = $endedAuctionsUser['auction_id'];
                $latestBidId = $endedAuctionsUser['latest_bid_id'];

                $userName = User::find($userId)->name;
                $auctionTitle = Auction::find($auctionId)->title;
                $latestBidPrice = Bid::find($latestBidId)->price;

                $highestBidId = Auction::find($auctionId)->bids->last()->id;

                if($latestBidId == $highestBidId) {
                    $hasHighestBid = true;
                }

                Mail::to(User::find($userId))->send(new AuctionEnded($userName, $auctionTitle, $latestBidPrice, $hasHighestBid));
            }
        }
    }
}
