<?php

namespace Zlodes\LaravelBasket\Contracts;

interface UserContract {

	public function getTableName(): string;

	public function getPrimaryKey(): string;

	public function getId(): int;
}