<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class EndOfRenewalProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'end:renewal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'end renewal of products every day';

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
     * @return int
     */
    public function handle()
    {
        $products = \App\Models\Product::whereDate('date_old_position', '>', \Carbon\Carbon::today());

        foreach ($products->get() as $product) {
            $product->position = $product->old_position;
            $product->update();
        }


        $products->update([
            
            'date_old_position'     => null,
            'old_position'          => null

        ]);
    }
}
