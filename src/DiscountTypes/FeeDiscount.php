<?php

namespace Zlodes\LaravelBasket\DiscountTypes;

use Zlodes\LaravelBasket\WrongDiscountValueException;

class FeeDiscount extends AbstractDiscountType {

	public function getDiscountType(): string {
		return static::DISCOUNT_TYPE_FEE;
	}

	public function calculateBasketTotalSum(): float {
		$original_sum = $this->basket->getOriginalProductsSum();

		if ($this->value > $original_sum) {
			throw new WrongDiscountValueException($this);
		}

		return $original_sum - $this->value;
	}

	public function validateValue(float $value): bool {
		return $value > 0;
	}
}

