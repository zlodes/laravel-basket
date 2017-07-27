<?php

namespace Zlodes\LaravelBasket\Contracts;

interface ProductContract {

	public function getPrice(): float;

	public function getName(): string;
}
