<?php

namespace App\Console\Commands\Cart;

use App\Core\Readable;
use App\Core\Cart;

class add extends Cart
{
    use Readable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:cart:add {product} {qty=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add item to cart';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setInventory();
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
        $inventory = $this->getInventory();
        $this->add($inventory);

    }
}
