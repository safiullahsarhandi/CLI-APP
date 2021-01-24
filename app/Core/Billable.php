<?php 

namespace App\Core;


trait Billable {
	public function getBill(){
		$items = $this->getCartItems();
		// dd($items)	;
		return (Object) $this->calculate($items);
	}

	public function calculate($items){
		$rows = [];
		$sub_total = $discount = 0;
		foreach ($items as $key => $item) {
			$sub_total += $item['price'] * $item['qty'];
		}
		$discount = $this->getDiscount($items);
		$total = $sub_total - $discount;

		return ['sub_total' => $sub_total,'total' => $total,'discount'=>$discount];
	}
}

?>