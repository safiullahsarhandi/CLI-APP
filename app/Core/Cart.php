<?php 

namespace App\Core;
use App\Core\Discountable;
use App\Core\Readable;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

abstract class Cart extends Command{
	
	use Discountable,Readable;

	public function add($products){
		 $product = $this->argument('product');
		 $qty = $this->argument('qty');
		 
		 $productName = $this->getProductName($products,$product);
		 $product = $this->filterProduct($products,$productName);
		 
		 $this->updateCart($productName,$product['price'],$qty);
		 
		 return $this->info('added '.$productName.' '.$qty);
	}
	private function filterProduct($products,$product){
		return Arr::first($products, function($item) use ($product) {
		 	return $item['name'] == $product;
		 });
	}
	private function getProductName($products,$product){
		$names = Arr::pluck($products,'name');
		if(!in_array($product,$names)):
	        	return $productName = $this->choice(
	                'list of available products?',
	                $names,
	                0
	            );
	    else:
	    	return $product;
	    endif;
	}
	public function remove(){}
}
?>