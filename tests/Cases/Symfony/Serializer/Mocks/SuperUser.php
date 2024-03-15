<?php declare(strict_types = 1);

namespace Tests\Cases\Symfony\Serializer\Mocks;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

class SuperUser
{

	/** @var array<Order> */
	#[Groups(['user'])]
	#[SerializedName('orders1')]
	private array $userOrders = [];

	/** @var array<Order> */
	#[Groups(['admin'])]
	#[SerializedName('orders2')]
	private array $adminOrders = [];

	public function addUserOrder(Order $order): void
	{
		$this->userOrders[] = $order;
	}

	public function addAdminOrder(Order $order): void
	{
		$this->adminOrders[] = $order;
	}

	/**
	 * @return Order[]
	 */
	public function getUserOrders(): array
	{
		return $this->userOrders;
	}

	/**
	 * @return Order[]
	 */
	public function getAdminOrders(): array
	{
		return $this->adminOrders;
	}

}
