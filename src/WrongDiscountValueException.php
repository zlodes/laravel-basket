<?php

namespace Zlodes\LaravelBasket;

use LogicException;
use Zlodes\LaravelBasket\Contracts\DiscountContract;

class WrongDiscountValueException extends LogicException {
	public function __construct(DiscountContract $discount) {
		$message = "Oops... There is wrong discount value: ".$discount->getValue();

		parent::__construct($message, 1, null);
	}

}
