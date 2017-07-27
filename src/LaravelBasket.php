<?php

namespace Zlodes\LaravelBasket;

use Illuminate\Support\Collection;
use LogicException;
use Zlodes\LaravelBasket\Contracts\DiscountContract;
use Zlodes\LaravelBasket\Contracts\ProductContract;
use Zlodes\LaravelBasket\StorageDrivers\AbstractStorageDriver;
use Zlodes\LaravelBasket\StorageDrivers\DatabaseStorage;
use Zlodes\LaravelBasket\StorageDrivers\SessionStorage;

class LaravelBasket {

	/**
	 * @var Collection
	 */
	private $items;

	/**
	 * @var DiscountContract|null
	 * */
	private $discount = null;

	/**
	 * @var AbstractStorageDriver
	 * */
	private $storage;

	public function __construct(array $config) {
		$this->items = new Collection();

		$storage_type = isset($config['storage']) ?: 'session';

		// Set storage
		switch ($storage_type) {
			case "database":
				$this->storage = new DatabaseStorage($this, $config);
				break;
			case "session":
				$this->storage = new SessionStorage($this, $config);
				break;

			default:
				throw new LogicException("Wrong basket storage type: ".$storage_type);
		}

		// Initialize basket (load basket data from storage)
		$this->storage->initialize();
	}

	public function getItems(): Collection {
		return $this->items;
	}

	public function getDiscount(): ?DiscountContract {
		return $this->discount;
	}

	public function setDiscount(DiscountContract $discount) {
		$this->discount = $discount;

		$this->update();
	}

	/**
	 * @return float
	 *
	 * @throws WrongDiscountValueException
	 */
	public function getTotalSum(): float {
		return is_null($this->discount)
			? $this->getOriginalProductsSum()
			: $this->discount->calculateBasketTotalSum();
	}

	public function getOriginalProductsSum(): float {
		return $this->items->reduce(function (float $acc, BasketItem $item) {
			return $acc + $item->getProduct()->getPrice() * $item->getQuantity();
		}, 0);
	}

	public function addItem(ProductContract $product, float $quantity) {
		$this->items->push(new BasketItem($this, $product, $quantity));

		$this->update();
	}

	/**
	 * Update external basket data via StorageDriver
	 *
	 * @todo: maybe use events?
	 *
	 * */
	public function update() {
		$this->storage->updateStorage();
	}

	public function removeDiscount() {
		$this->discount = null;
	}

	/**
	 * Remove all items from basket and remove discount
	 */
	public function clear() {
		$this->items = new Collection();

		$this->removeDiscount();
	}
}
