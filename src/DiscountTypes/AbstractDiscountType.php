<?php

namespace Zlodes\LaravelBasket\DiscountTypes;

use Zlodes\LaravelBasket\Contracts\DiscountContract;
use Zlodes\LaravelBasket\WrongDiscountValueException;

abstract class AbstractDiscountType implements DiscountContract {

	/**
	 * Important for database storage driver
	 *
	 * @var int
	 */
	private $id;

	/**
	 * @var float
	 */
	protected $value;

	public function __construct(float $value) {
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
