<?php

namespace Zlodes\LaravelBasket;

use Zlodes\LaravelBasket\Contracts\ProductContract;

class BasketItem {

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
	 * @var ProductContract
	 */
	private $product;

	/**
	 * @var float
	 */
	private $quantity;


	public function __construct(LaravelBasket $basket, ProductContract $product, float $quantity) {
		$this->basket = $basket;
		$this->product = $product;
		$this->quantity = $quantity;
	}

	public function getProduct(): ProductContract {
		return $this->product;
	}

	public function getQuantity(): float {
		return $this->quantity;
	}

	public function setQuantity(float $quantity) {
		$this->quantity = $quantity;

		$this->basket->update();
	}

	public function getId() {
		return $this->id;
	}

	public function getTotalPrice(): float {
		return $this->getProduct()->getPrice() * $this->getQuantity();
	}
}
