<?php

namespace Zlodes\LaravelBasket\StorageDrivers;

use Zlodes\LaravelBasket\Contracts\UserContract;
use Zlodes\LaravelBasket\LaravelBasket;

abstract class AbstractStorageDriver {

	/**
	 * @var LaravelBasket
	 */
	protected $basket;

	/**
	 * @var array
	 */
	protected $config = [];

	public function __construct(LaravelBasket $basket, array $config) {
		$this->config = $config;
		$this->basket = $basket;
	}

	abstract public function initialize(UserContract $user = null);

	abstract public function updateStorage();

	abstract public function serializeBasketItem(): array;

	abstract public function serializeDiscount(): array;

}