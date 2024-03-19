<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Domain\Order\Order;
use DateTimeInterface;

final class OrderResDto
{

	public int $id;

	public string $productid;

	public string $customerid;

	public string $orderstate;

	public string $price;

	public ?DateTimeInterface $lastLoggedAt = null;

	public static function from(Order $order): self
	{
		$self = new self();
		$self->id = $order->getId();
		$self->productid = $order->getProductId();
		$self->customerid = $order->getCustomerId();
		$self->orderstate = $order->getOrderState();
		$self->price = $order->getPrice();
		$self->lastLoggedAt = $order->getLastLoggedAt();

		return $self;
	}

}
