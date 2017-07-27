<?php

namespace Zlodes\LaravelBasket\Contracts;

use Zlodes\LaravelBasket\LaravelBasket;

interface DiscountContract {

	const DISCOUNT_TYPE_PERCENT = 'percent';
	const DISCOUNT_TYPE_FEE = 'fee';

	public function __construct(LaravelBasket $basket, float $value);

	public function getDiscountType(): string;

	public function calculateBasketTotalSum(): float;

	public function validateValue(float $value): bool;

	public function getValue(): float;
}
