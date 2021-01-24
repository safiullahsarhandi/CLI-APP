<?php

namespace App\Core;

trait Readable {

	protected $file;
	public function setInventory() {
		$this->file = storage_path('app/public/Shop/inventory.csv');
	}
	public function setCart() {
		$this->cartFile = storage_path('app/public/Shop/cart.csv');
	}
	public function getInventory() {
		$row = 1;
		$products = [];
		if (($handle = fopen($this->file, "r")) !== FALSE) {
			while (($entity = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if ($row == 1) {
					$keys = $entity;
				} else {

					$product = array_combine($keys, $entity);

					array_push($products, $product);
				}
				$row++;
			}
			fclose($handle);
		}
		return $products;
	}

	public function updateCart($product, $price, $qty) {
		$row = 1;
		$has_offer = 0;
		$items = $offer_type = '';
		$status = '"first time"';
		$new = true;

		if (($handle = fopen($this->cartFile, "a+")) !== FALSE) {

			while (($entity = fgetcsv($handle, 1000, ",")) !== FALSE) {
				// checking if product already in cart
				if ($entity[0] == $product) {
					// checking if qty updated another time and don't have an offer
					if ($qty > 1):

						$remain = $qty % 2;
						$addOfferedQty = ($qty - $remain) / 2;
						$qty += $addOfferedQty;
						$entity[3] = 1;
					endif;
					// if quantity updated with 1 remove previous applied discount
					if ($qty == 1) {
						$entity[3] = 0;
						$entity[4] = $status;
					}

					$entity[2] = $qty;
					$items .= implode(',', $entity) . PHP_EOL;
					$new = false;
				} else {
					$items .= implode(',', $entity) . PHP_EOL;
				}
				$row++;
			}

			if ($new) {
				if ($qty > 1):

					$remain = $qty % 2;
					$addOfferedQty = ($qty - $remain) / 2;
					$qty += $addOfferedQty;
				endif;
				if ($qty % 2 === 0) {
					$qty++;
					$has_offer = 1;
				}
				$items .= "$product,$price,$qty,$has_offer,$status";
			}
			file_put_contents($this->cartFile, $items);
			fclose($handle);
		}

	}

	public function getCartItems() {
		$row = 1;
		$items = [];
		if (($handle = fopen($this->cartFile, "r")) !== FALSE) {
			while (($entity = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if ($row == 1) {
					$keys = $entity;
				} else {

					$product = array_combine($keys, $entity);

					array_push($items, $product);
				}
				$row++;
			}
			fclose($handle);
		}
		return $items;
	}

	public function checkout($items) {
		$newContent = '';
		foreach ($items as $key => $row) {
			if($key == 0){
				$newContent = implode(',',array_keys($row)).PHP_EOL;
			}
			if ($row['status'] == 'first time') {
				$row['status'] = 'purchased';
				$row['qty'] = 0;
				$newContent .= implode(',', $row) . PHP_EOL;
				// dd($newContent);
			}
		}
		file_put_contents($this->cartFile, $newContent);
	}
}
?>