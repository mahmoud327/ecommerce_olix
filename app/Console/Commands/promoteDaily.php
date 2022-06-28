<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class promoteDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promote:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'promote the products every day';

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
        $products = \App\Models\Product::whereDate('promote_to', '>', \Carbon\Carbon::today());
        $products->update([ 'promote_to' => null ]);
    }
}
