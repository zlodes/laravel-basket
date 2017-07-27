<?php

namespace Zlodes\LaravelBasket;

use Illuminate\Support\ServiceProvider;

class BasketServiceProvider extends ServiceProvider {

	public function register() {
		$this->app->singleton('LaravelBasket', function ($app) {
			$config = config('laravel-basket');
			$basket = new LaravelBasket($config);

			return $basket;
		});
	}

	public function provides() {
		return [LaravelBasket::class];
	}
}
