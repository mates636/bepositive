<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Domain\Product\Product;
use DateTimeInterface;

final class ProductResDto
{

	public int $id;

	public string $name;

	public string $value;

	public string $stockdesign;

	public ?DateTimeInterface $lastLoggedAt = null;

	public static function from(Product $product): self
	{
		$self = new self();
		$self->id = $product->getId();
		$self->name = $product->getName();
		$self->value = $product->getValue();
		$self->stockdesign = $product->getStockDesign();
		$self->lastLoggedAt = $product->getLastLoggedAt();

		return $self;
	}

}
