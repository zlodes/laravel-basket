<?php

namespace Zlodes\LaravelBasket\DiscountTypes;

class PercentDiscount extends AbstractDiscountType {

	public function getDiscountType(): string {
		return static::DISCOUNT_TYPE_PERCENT;
	}

	public function calculateBasketTotalSum(): float {
		$original_sum = $this->basket->getOriginalProductsSum();

		return $original_sum * (1 - $this->value / 100);
	}

	public function validateValue(float $value): bool {
		return $value > 0 && $value <= 100;
	}
}
