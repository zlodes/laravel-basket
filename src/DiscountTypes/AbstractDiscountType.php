<?php

namespace Zlodes\LaravelBasket\DiscountTypes;

use Zlodes\LaravelBasket\Contracts\DiscountContract;
use Zlodes\LaravelBasket\LaravelBasket;
use Zlodes\LaravelBasket\WrongDiscountValueException;

abstract class AbstractDiscountType implements DiscountContract {

	/**
	 * Important for database storage driver
	 *
	 * @var int
	 */
	private $id;

	/**
	 * @var LaravelBasket
	 */
	protected $basket;

	/**
	 * @var float
	 */
	protected $value;


	/**
	 * AbstractDiscountType constructor.
	 *
	 * @todo: DO NOT PASS BASKET TO DISCOUNT CONSTRUCTOR
	 *
	 * @param LaravelBasket $basket
	 * @param float $value
	 */
	public function __construct(LaravelBasket $basket, float $value) {
		$this->basket = $basket;
		$this->value = $value;

		if ( ! $this->validateValue($value)) {
			throw new WrongDiscountValueException($this);
		}
	}

	public function getValue(): float {
		return $this->value;
	}

	public function getId(): int {
		return $this->id;
	}

}
