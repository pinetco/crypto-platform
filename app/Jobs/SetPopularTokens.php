<?php

namespace App\Jobs;

use App\Models\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetPopularTokens implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Token::whereIn('name', [
            'BTC', 'ETH', 'whETH', 'SOL', 'stSOL', 'mSOL', 'USDC', 'USDT', 'wUST', 'ORCA', 'SRM', 'RAY'
        ])->update(['is_popular' => true]);
    }
}
