<?php

namespace Zlodes\LaravelBasket\Contracts;

use Illuminate\Support\Collection;

interface DiscountContract {

	const DISCOUNT_TYPE_PERCENT = 'percent';
	const DISCOUNT_TYPE_FEE = 'fee';

	public function __construct(float $value);

	public function getDiscountType(): string;

	public function calculateBasketTotalSum(Collection $basketItems): float;

	public function validateValue(float $value): bool;

	public function getValue(): float;
}
