<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class renewalProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewal:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'renewal the products every day';

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
        $products = \App\Models\Product::whereDate('date_old_position', '<=', \Carbon\Carbon::today())->orderBy('position', 'desc')->get();
        $max_position = \App\Models\Product::where('category_id', $products->first()->category_id)->max('position');

        foreach ($products as $product) {
            $product->position = ++$max_position ;
            $product->update();
        }
    }
}
