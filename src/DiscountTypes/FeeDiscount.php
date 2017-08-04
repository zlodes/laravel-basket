<?php

namespace Zlodes\LaravelBasket\DiscountTypes;

use Illuminate\Support\Collection;
use Zlodes\LaravelBasket\BasketItem;
use Zlodes\LaravelBasket\WrongDiscountValueException;

class FeeDiscount extends AbstractDiscountType {

	public function getDiscountType(): string {
		return static::DISCOUNT_TYPE_FEE;
	}

	public function calculateBasketTotalSum(Collection $items): float {
		// Todo: get rid of code duplication
		$original_sum = $items->reduce(function (float $acc, BasketItem $item) {
			return $acc + $item->getTotalPrice();
		}, 0);

		if ($this->value > $original_sum) {
			throw new WrongDiscountValueException($this);
		}

		return $original_sum - $this->value;
	}

	public function validateValue(float $value): bool {
		return $value > 0;
	}
}

