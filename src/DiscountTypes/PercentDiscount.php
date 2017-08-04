<?php

namespace Zlodes\LaravelBasket\DiscountTypes;

use Illuminate\Support\Collection;
use Zlodes\LaravelBasket\BasketItem;

class PercentDiscount extends AbstractDiscountType {

	public function getDiscountType(): string {
		return static::DISCOUNT_TYPE_PERCENT;
	}

	public function calculateBasketTotalSum(Collection $items): float {
		// Todo: get rid of code duplication
		$original_sum = $items->reduce(function (float $acc, BasketItem $item) {
			return $acc + $item->getTotalPrice();
		}, 0);

		return $original_sum * (1 - $this->value / 100);
	}

	public function validateValue(float $value): bool {
		return $value > 0 && $value <= 100;
	}
}
