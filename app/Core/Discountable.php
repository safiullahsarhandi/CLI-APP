<?php

namespace App\Core;

trait Discountable {

	public function applyDiscount() {}

	public function getDiscount($items) {
		$discount = 0;
		$newPrice = 0;
		foreach ($items as $key => $item) {
			$qty = $item['qty'];
			$freeQty = 0;
			$actualProducts = 0;
			$price = $item['price'];
			// apply discount on every third item
			$remain = $qty % 2;
			if ($qty % 2 == 0) {
				$remain = $qty - 1;
				$freeQty = $remain / 3;
			}else{
				$freeQty = $qty / 3;
			}
			$actualProducts = $qty - $freeQty;
			$newPrice = ($price * $freeQty);
			
			if ($item['status'] == 'purchased') {

				$remain = $actualProducts % 2;
				$actualProduct = ($actualProducts - $remain) / 2;
				$newPrice = ($price * $actualProduct) * 0.5;
			}	
				$discount += $newPrice;
		}
		return abs($discount);
	}
}

?>
