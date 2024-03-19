<?php declare(strict_types = 1);

namespace App\Domain\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateOrderReqDto
{
	public string $productid;

	public string $customerid;

	public string $orderstate;

	public string $price;
}
