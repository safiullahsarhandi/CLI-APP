<?php

namespace App\Console\Commands\Shop;

use App\Core\Billable;
use App\Core\Discountable;
use App\Core\Readable;
use Illuminate\Console\Command;

class Bill extends Command
{
    use Discountable,Readable, Billable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Bill details';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->setInventory();
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
        $bill = $this->getBill();
        $msg = 
        'Sub Total '.$bill->sub_total.
        ', discount: '.$bill->discount.
        ', total: '.$bill->total;
        $this->info($msg);
    }
}
