<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Zlodes\LaravelBasket\Contracts\ProductContract;
use Zlodes\LaravelBasket\DiscountTypes\FeeDiscount;
use Zlodes\LaravelBasket\DiscountTypes\PercentDiscount;
use Zlodes\LaravelBasket\LaravelBasket;

class BasketItemsTotalPriceTest extends TestCase {

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

	public function testBasketWithoutDiscounts() {
		$basket = new LaravelBasket([]);

		$product1 = $this->createProduct("Banana", 100);
		$product2 = $this->createProduct("Apple", 254.20);

		$basket->addItem($product1, 2);
		$basket->addItem($product2, 1);

		$basket_total_sum = $basket->getTotalSum();

		$this->assertEquals(100 * 2 + 254.20, $basket_total_sum);
	}

	public function testBasketWithPercentDiscount() {
		$basket = new LaravelBasket([]);

		$product1 = $this->createProduct("Banana", 100);
		$product2 = $this->createProduct("Apple", 200);

		$basket->addItem($product1, 2);
		$basket->addItem($product2, 1);

		$discount = new PercentDiscount($basket, 50);

		$basket->setDiscount($discount);

		$basket_total_sum = $basket->getTotalSum();

		$this->assertEquals(200, $basket_total_sum);
	}

	public function testBasketWithFeeDiscount() {
		$basket = new LaravelBasket([]);

		$product1 = $this->createProduct("Banana", 100);
		$product2 = $this->createProduct("Apple", 200);

		$basket->addItem($product1, 2);
		$basket->addItem($product2, 1);

		$discount = new FeeDiscount($basket, 100);

		$basket->setDiscount($discount);

		$basket_total_sum = $basket->getTotalSum();

		$this->assertEquals(300, $basket_total_sum);
	}

}
