<?php

namespace App\Console\Commands\Shop;

use App\Core\Billable;
use App\Core\Discountable;
use App\Core\Readable;
use Illuminate\Console\Command;

class Checkout extends Command
{
    use Discountable,Readable, Billable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'checkout your cart';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setCart();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $items = $this->getCartItems();
        if(count($items) == 0){

            $this->error('cart is empty!');
        }else{
            $this->checkout($items);
            $this->info('done');
        }
        return 0;
    }
}
