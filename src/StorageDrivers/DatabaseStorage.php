<?php

namespace Zlodes\LaravelBasket\StorageDrivers;

use Zlodes\LaravelBasket\Contracts\UserContract;

class DatabaseStorage extends AbstractStorageDriver {

	/**
	 * @var UserContract
	 * */
	private $user;

	public function initialize(UserContract $user = null) {
		$this->user = $user;
	}

	public function updateStorage() {
		// Todo: add some code here...

		// Get basket by user
		// Get basket items by basket
		// Remove items
		// Remove basket

		// Add basket
		// Add items
	}

	public function serializeBasketItem(): array {
		return [
			'user_id' => $this->user->getId(),
			'discount_id' => $this->basket->getDiscount()->getId(),
		];
	}

	public function serializeDiscount(): array {
		return [
			'type' => $this->basket->getDiscount()->getDiscountType(),
			'value' => $this->basket->getDiscount()->getValue(),
		];
	}
}