<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Zlodes\LaravelBasket\Contracts\ProductContract;
use Zlodes\LaravelBasket\DiscountTypes\FeeDiscount;
use Zlodes\LaravelBasket\DiscountTypes\PercentDiscount;
use Zlodes\LaravelBasket\LaravelBasket;
use Zlodes\LaravelBasket\WrongDiscountValueException;

class ValidateDiscountValueTest extends TestCase {

	/**
	 * Create anonymous class whom implements ProductContract
	 *
	 * @todo: move to trait
	 *
	 * @param string $name
	 * @param float $price
	 * @return ProductContract
	 */
	public function createProduct(string $name, float $price) {
		return new class($price, $name) implements ProductContract {
			private $price;
			private $name;

			public function __construct(float $price, string $name) {
				$this->price = $price;
				$this->name = $name;
			}

			public function getPrice(): float {
				return $this->price;
			}

			public function getName(): string {
				return $this->name;
			}
		};
	}


	/**
	 * @expectedException WrongDiscountValueException
	 */
	public function testSetInvalidPercentValueMoreThen100() {
		$basket = new LaravelBasket([]);

		$this->expectException(WrongDiscountValueException::class);
		new PercentDiscount($basket, 120);
	}

	public function testSetInvalidPercentValueLessThen0() {
		$basket = new LaravelBasket([]);

		$this->expectException(WrongDiscountValueException::class);
		new PercentDiscount($basket, -20);
	}


	public function testSetInvalidFeeValueLessThen0() {
		$basket = new LaravelBasket([]);

		$this->expectException(WrongDiscountValueException::class);
		new FeeDiscount($basket, -10);
	}

	public function testAddFeeDiscountMoreThenSumOfBasketItems() {

		$basket = new LaravelBasket([]);

		$product1 = $this->createProduct("Banana", 100);
		$product2 = $this->createProduct("Apple", 200);

		$basket->addItem($product1, 2);
		$basket->addItem($product2, 1);

		$basket->setDiscount(new FeeDiscount($basket, 5000));

		$this->expectException(WrongDiscountValueException::class);
		$basket->getTotalSum();
	}

}
